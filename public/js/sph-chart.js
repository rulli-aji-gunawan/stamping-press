window.initSPHDashboardChart = function (sphData, currentFY) {
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
    window.updateSPHDashboardChart = function (selectedFY, selectedModel, selectedItem, selectedMonth,
        selectedDate, selectedShift, selectedLine, selectedGroup) {
        let filtered = sphData;

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
                        total_stroke: 0,
                        effective_hours: 0
                    };
                }
                grouped[key].total_stroke += d.total_stroke;
                grouped[key].effective_hours += d.effective_hours;
            });

            // Konversi kembali menjadi array dan hitung SPH dengan benar
            chartData = Object.values(grouped).map(item => {
                return {
                    fy_n: item.fy_n,
                    // Hitung SPH dari total stroke dan total hours
                    sph: item.effective_hours > 0 ? Math.round((item.total_stroke / item.effective_hours) * 100) / 100 : 0
                };
            });
        } else {
            chartData = filtered;
        }

        // Jika tidak ada data setelah filter
        if (chartData.length === 0) {
            sphChart.data.labels = [];
            sphChart.data.datasets[0].data = [];
            sphChart.update();
            return;
        }

        const bulanLabels = chartData.map(d => getMonthNameFromFYN(d.fy_n));
        const fyLabels = chartData.map(d => 'FY' + d.fy_n.split('-')[0].slice(-2));
        const data = chartData.map(d => d.sph);

        // Hitung nilai maksimum, bulatkan ke atas dengan kelipatan 20, dan tambahkan 40
        const maxValue = Math.ceil(Math.max(...data) / 20) * 20 + 50;

        sphChart.data.labels = fyLabels;
        sphChart.data.datasets[0].data = data;
        sphChart.options.scales.y.max = maxValue;

        // Atur ticks callback untuk menampilkan nama bulan dan tahun fiskal
        sphChart.options.scales.x.ticks.callback = function (value, index) {
            const monthLabel = bulanLabels[index];
            let fyLabel = '';
            const currentFY = fyLabels[index];

            if (index === 0 || fyLabels[index - 1] !== currentFY) {
                fyLabel = currentFY;
            }

            return [monthLabel, fyLabel];
        };

        sphChart.update();
    }

    // Pengurutan data awal
    sphData.sort((a, b) => {
        const keyA = formatFiscalPeriod(a.fy_n);
        const keyB = formatFiscalPeriod(b.fy_n);
        return getFiscalSortValue(keyA) - getFiscalSortValue(keyB);
    });

    const ctx = document.getElementById('sphChart').getContext('2d');
    const bulanLabels = sphData.map(d => {
        const monthIndex = (parseInt(d.fy_n.split('-')[1], 10) - 1) % 12;
        return monthNames[monthIndex];
    });
    const fyLabels = sphData.map(d => formatFiscalPeriod(d.fy_n));
    const data = sphData.map(d => d.sph);

    // Hitung nilai maksimum awal
    const initialMaxValue = Math.ceil(Math.max(...data) / 20) * 20 + 40;

    window.sphChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: fyLabels,
            datasets: [{
                label: 'SPH (Stroke Per Hour)',
                data: data,
                backgroundColor: 'rgb(122, 218, 165, 0.45)',
                borderColor: 'rgb(122, 218, 165, 1)',
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
                    color: 'rgb(56, 102, 65, 1)',
                    font: { weight: 'bold' },
                    formatter: function (value) {
                        return Math.round(value);
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

    const originalDraw = window.sphChart.draw;
    window.sphChart.draw = function () {
        originalDraw.apply(this, arguments);
    };

    // Inisialisasi chart pertama kali
    window.updateSPHDashboardChart(currentFY, 'all', 'all', 'all', '', 'all', 'all', 'all');
};