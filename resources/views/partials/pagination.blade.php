@if($pagination && isset($pagination['last_visible_page']))
    @php
        $currentPage = request('page', 1);
        $lastPage = $pagination['last_visible_page'] ?? $pagination['pages'] ?? 1;
    @endphp
    
    @if($lastPage > 1)
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{-- Previous Button --}}
            @if($currentPage > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}" aria-label="Previous">
                        <span aria-hidden="true">&lt;&lt; Sebelumnya</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&lt;&lt; Sebelumnya</span>
                </li>
            @endif

            {{-- First Page --}}
            @if($currentPage > 3)
                <li class="page-item">
                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">1</a>
                </li>
                @if($currentPage > 4)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            {{-- Pages around current page --}}
            @for($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++)
                @if($i == $currentPage)
                    <li class="page-item active">
                        <span class="page-link">{{ $i }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            {{-- Last Page --}}
            @if($currentPage < $lastPage - 2)
                @if($currentPage < $lastPage - 3)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $lastPage]) }}">{{ $lastPage }}</a>
                </li>
            @endif

            {{-- Next Button --}}
            @if($currentPage < $lastPage)
                <li class="page-item">
                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}" aria-label="Next">
                        <span aria-hidden="true">Berikutnya &gt;&gt;</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Berikutnya &gt;&gt;</span>
                </li>
            @endif
        </ul>
    </nav>
    @endif
@else
    {{-- Fallback pagination when API doesn't provide pagination info --}}
    @php
        $currentPage = request('page', 1);
    @endphp
    
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{-- Previous Button --}}
            @if($currentPage > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}" aria-label="Previous">
                        <span aria-hidden="true">&lt;&lt; Sebelumnya</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&lt;&lt; Sebelumnya</span>
                </li>
            @endif

            {{-- Current Page --}}
            <li class="page-item active">
                <span class="page-link">{{ $currentPage }}</span>
            </li>

            {{-- Next Button --}}
            <li class="page-item">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}" aria-label="Next">
                    <span aria-hidden="true">Berikutnya &gt;&gt;</span>
                </a>
            </li>
        </ul>
    </nav>
@endif