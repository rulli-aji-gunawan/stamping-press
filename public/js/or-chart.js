window.initORDashboardChart = function (orData, currentFY) {
    const monthNames = ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"];

    // Fungsi untuk mengkonversi format FY2024-6 menjadi FY24-6
    function formatFiscalPeriod(fy_n) {
        const [year, month] = fy_n.split('-');
        return 'FY' + year.slice(-2) + '-' + month;
    }

    // Fungsi untuk menghasilkan nilai pengurutan berdasarkan tahun fiskal dan bulan
    function getFiscalSortValue(fiscalPeriod) {
        const [fy, month] = fiscalPeriod.split('-');
        const year = parseInt(fy.replace('FY', ''), 10);
        const monthNum = parseInt(month, 10);
        return (year * 100) + monthNum;
    }

    // Fungsi untuk mendapatkan indeks bulan dari fy_n (1-12)
    function getMonthFromFYN(fy_n) {
        return parseInt(fy_n.split('-')[1], 10);
    }

    // Fungsi untuk mendapatkan nama bulan dari fy_n
    function getMonthNameFromFYN(fy_n) {
        const monthIndex = (parseInt(fy_n.split('-')[1], 10) - 1) % 12;
        return monthNames[monthIndex];
    }

    // Fungsi update chart dengan semua filter
    window.updateORDashboardChart = function (selectedFY, selectedModel, selectedItem, selectedMonth,
        selectedDate, selectedShift, selectedLine, selectedGroup) {
        let filtered = orData;

        // Filter berdasarkan semua parameter
        if (selectedFY !== 'all') {
            filtered = filtered.filter(d => ('FY' + d.fy_n.split('-')[0].slice(-2)) === selectedFY);
        }

        if (selectedModel !== 'all') {
            filtered = filtered.filter(d => d.model === selectedModel);
        }

        if (selectedItem !== 'all') {
            filtered = filtered.filter(d => d.item_name === selectedItem);
        }

        if (selectedMonth !== 'all') {
            const monthNum = parseInt(selectedMonth, 10);
            filtered = filtered.filter(d => getMonthFromFYN(d.fy_n) === monthNum);
        }

        if (selectedDate) {
            filtered = filtered.filter(d => d.date === selectedDate);
        }

        if (selectedShift !== 'all') {
            filtered = filtered.filter(d => d.shift === selectedShift);
        }

        if (selectedLine !== 'all') {
            filtered = filtered.filter(d => d.line === selectedLine);
        }

        if (selectedGroup !== 'all') {
            filtered = filtered.filter(d => d.group === selectedGroup);
        }

        // Gunakan pengurutan dinamis
        filtered.sort((a, b) => {
            const keyA = formatFiscalPeriod(a.fy_n);
            const keyB = formatFiscalPeriod(b.fy_n);
            return getFiscalSortValue(keyA) - getFiscalSortValue(keyB);
        });

        let chartData = [];
        // Lakukan grouping jika diperlukan
        if (selectedModel === 'all' || selectedItem === 'all' || selectedShift === 'all' ||
            selectedLine === 'all' || selectedGroup === 'all' || !selectedDate) {

            const grouped = {};
            filtered.forEach(d => {
                const key = d.fy_n;
                if (!grouped[key]) {
                    grouped[key] = {
                        fy_n: d.fy_n,
                        effective_minutes: 0,
                        press_time: 0
                    };
                }
                grouped[key].effective_minutes += d.effective_minutes;
                grouped[key].press_time += d.press_time; // Gunakan press_time yang sudah dihitung di controller
            });

            // Konversi kembali menjadi array dan hitung OR dengan benar
            chartData = Object.values(grouped).map(item => {
                return {
                    fy_n: item.fy_n,
                    effective_or: item.effective_minutes > 0 ? (item.press_time / item.effective_minutes) : 2
                };
            });
        } else {
            chartData = filtered.map(d => ({
                fy_n: d.fy_n,
                effective_or: d.effective_or || 2
            }));
        }

        // Jika tidak ada data setelah filter
        if (chartData.length === 0) {
            orChart.data.labels = [];
            orChart.data.datasets[0].data = [];
            orChart.update();
            return;
        }

        const bulanLabels = chartData.map(d => getMonthNameFromFYN(d.fy_n));
        const fyLabels = chartData.map(d => 'FY' + d.fy_n.split('-')[0].slice(-2));
        const data = chartData.map(d => d.effective_or);

        // Hitung nilai maksimum 120%
        const maxValue = 1.2;

        orChart.data.labels = fyLabels;
        orChart.data.datasets[0].data = data;
        orChart.options.scales.y.max = maxValue;

        // Atur ticks callback untuk menampilkan nama bulan dan tahun fiskal
        orChart.options.scales.x.ticks.callback = function (value, index) {
            const monthLabel = bulanLabels[index];
            let fyLabel = '';
            const currentFY = fyLabels[index];

            if (index === 0 || fyLabels[index - 1] !== currentFY) {
                fyLabel = currentFY;
            }

            return [monthLabel, fyLabel];
        };

        orChart.update();
    }

    // Pengurutan data awal
    orData.sort((a, b) => {
        const keyA = formatFiscalPeriod(a.fy_n);
        const keyB = formatFiscalPeriod(b.fy_n);
        return getFiscalSortValue(keyA) - getFiscalSortValue(keyB);
    });

    const ctx = document.getElementById('orChart').getContext('2d');
    const bulanLabels = orData.map(d => {
        const monthIndex = (parseInt(d.fy_n.split('-')[1], 10) - 1) % 12;
        return monthNames[monthIndex];
    });
    const fyLabels = orData.map(d => formatFiscalPeriod(d.fy_n));
    const data = orData.map(d => d.effective_or);

    // Hitung nilai maksimum awal
    const initialMaxValue = 1.2;

    window.orChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: fyLabels,
            datasets: [{
                label: 'OR (Operating Ratio)',
                data: data,
                backgroundColor: 'rgb(35, 155, 167, 0.35)',
                borderColor: 'rgb(35, 155, 167, 1)',
                borderWidth: 2,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            layout: {
                padding: {
                    top: 0,
                    right: 10,
                    bottom: 1,
                    left: 10
                }
            },
            plugins: {
                legend: {
                    display: true,
                    align: 'start',
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        boxHeight: 12,
                    },
                },
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    color: 'rgb(35, 155, 167, 1)',
                    font: { weight: 'bold' },
                    formatter: function (value) {
                        return (value * 100).toFixed(1) + '%';
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        callback: function (value, index) {
                            const monthLabel = bulanLabels[index];
                            let fyLabel = '';
                            const currentFY = fyLabels[index];

                            if (index === 0 || fyLabels[index - 1] !== currentFY) {
                                fyLabel = currentFY.split('-')[0];
                            }

                            return [monthLabel, fyLabel];
                        }
                    }
                },
                y: {
                    display: false,
                    grid: { display: false },
                    beginAtZero: true,
                    max: initialMaxValue,
                    ticks: { color: 'rgba(0, 0, 0, 0.45)' }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const originalDraw = window.orChart.draw;
    window.orChart.draw = function () {
        originalDraw.apply(this, arguments);
    };

    // Inisialisasi chart pertama kali
    window.updateORDashboardChart(currentFY, 'all', 'all', 'all', '', 'all', 'all', 'all');
};