<style>
    /* Pagination container */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 16px;
        margin-bottom: 16px;
    }

    /* Pagination base style */
    .pagination-container .pagination {
        display: flex;
        list-style: none;
        padding: 0;
    }

    .pagination-container .pagination .page-item {
        margin: 0 2px;
    }

    .pagination-container .pagination .page-link {
        border-radius: 5px;
        padding: 5px 10px;
        min-width: 36px;
        text-align: center;
        border: 1px solid #ddd;
        text-decoration: none;
        color: #337ab7;
        background-color: #fff; /* Background color */
    }

    .pagination-container .pagination .page-link:hover {
        background-color: #eee;
    }

    .pagination-container .pagination .page-item.disabled .page-link,
    .pagination-container .pagination .page-item.active .page-link {
        color: #666;
        cursor: default;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .pagination-container .pagination .page-item.active .page-link {
        font-weight: bold;
        background-color: #007bff;
        color: white;
    }
</style>


@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination-container">
        <!-- Previous Page Link -->
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo; First</span></li>
            @else
                <li class="page-item"><a href="{{ $paginator->url(1) }}" class="page-link">&laquo; First</a></li>
            @endif

            <!-- Pagination Elements -->
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <!-- Next Page Link -->
            @if ($paginator->hasMorePages())
                <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link">Last &raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">Last &raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
