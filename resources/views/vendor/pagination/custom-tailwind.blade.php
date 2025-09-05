@if ($paginator->hasPages())
    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
        {{-- Informasi Hasil --}}
        <div style="font-size: 0.875rem; color: #666; margin-bottom: 0.5rem;">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>

        <nav style="display: flex; align-items: center; gap: 0.5rem;">
            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <span style="font-size: 1.0rem; color: #9ca3af; padding: 0.25rem 0.75rem; cursor: not-allowed;">⟪</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    style="color: #4b5563; padding: 0.25rem 0.75rem; border-radius: 0.25rem; text-decoration: none;"
                    onmouseover="this.style.backgroundColor='rgba(28, 109, 63, 0.5)'; this.style.transition='background-color 0.3s';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.transition='background-color 0.3s';">⟪</a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span
                        style="background-color: #1c6d3f; color: white; padding: 0.25rem 0.75rem; border-radius: 0.25rem;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                        style="border: 1px solid #e5e7eb; border-radius: 0.25rem; color: #4b5563; padding: 0.25rem 0.75rem;border-radius: 0.25rem; text-decoration: none;"
                        onmouseover="this.style.backgroundColor='rgba(28, 109, 63, 0.5)'; this.style.transition='background-color 0.3s';"
                        onmouseout="this.style.backgroundColor='transparent'; this.style.transition='background-color 0.3s';">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    style="color: #4b5563; padding: 0.25rem 0.75rem; border-radius: 0.25rem; text-decoration: none;"
                    onmouseover="this.style.backgroundColor='rgba(28, 109, 63, 0.5)'; this.style.transition='background-color 0.3s';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.transition='background-color 0.3s';">⟫</a>
            @else
                <span style="color: #9ca3af; padding: 0.25rem 0.75rem; cursor: not-allowed;">⟫</span>
            @endif
        </nav>
    </div>
@endif
