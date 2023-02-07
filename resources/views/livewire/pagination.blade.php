

@if ($paginator->hasPages())
    <div class="d-flex justify-content-center">

        {{-- previous page --}}
        @if ($paginator->onFirstPage())
            <button class="btn  ml-1 " disabled style="background-color: #A10000; color:white">Prev</button>
        @else
            <button class="btn  ml-1" wire:click='previousPage' style="background-color: #A10000; color:white">Prev</button>
        @endif
        {{-- previous page end --}}

        {{-- use number paginator --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="btn btn-secondary ml-1"
                            wire:click='gotoPage({{ $page }})'>{{ $page }}</button>
                    @else
                        <button class="btn  ml-1"
                            wire:click='gotoPage({{ $page }})' style="background-color: #A10000; color:white">{{ $page }}</button>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- use number paginatorend --}}

        {{-- next page --}}
        @if ($paginator->hasMorePages())
            <button class="btn  ml-1" wire:click='nextPage' style="background-color: #A10000; color:white">Next</button>
        @else
            <button class="btn  ml-1" disabled style="background-color: #A10000; color:white">Next</button>
        @endif
        {{-- next page end --}}

    </div>

@endif
