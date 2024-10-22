<!-- resources/views/components/generic-filters-tab.blade.php -->
@php
    $filterRoute = null;
    $clearFilterRoute = null;
    if (currentAccount()->account_role != 3) {
        $filterRoute = 'clubs-finder.filter';
        $clearFilterRoute = 'clubs-finder.clear-filter';
    } else {
        $filterRoute = 'manage-clubs.filter';
        $clearFilterRoute = 'manage-clubs.clear-filter';
    }
@endphp
<div class="offcanvas offcanvas-start px-0" tabindex="-1" id="offcanvas-filter" aria-labelledby="offcanvas-filter-label">
    <div class="rsans offcanvas-header pb-0">
        <h5 class="offcanvas-title" id="offcanvas-navbar-label fw-bold">Search Filters</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="rsans offcanvas-body">
        <form id="filter-form" method="POST" action="{{ route($filterRoute) }}">
            @csrf
            @php
                $categories = [
                    'ASTIF', 'FIS', 'FKAL', 'FKIKK', 'FKIKAL',
                    'FKJ', 'FPEP', 'FPKS', 'FPL', 'FPPS', 'FPSK',
                    'FPT', 'FSMP', 'FSSA', 'FSSK', 'KKTF',
                    'KKTM', 'KKTPAR', 'KKAKF', 'KKUSIA', 'NR',
                    'General'
                ];
            @endphp
            <h5 class="rsans mb-2 text-start">Categories</h5>
            <div class="rsans row px-3">
                @foreach ($categories as $category)
                    <div class="col-6 mb-2 px-1">
                        <div class="p-2 border rounded">
                            <div class="form-check w-100 d-flex justify-content-start align-items-center">
                                <label class="form-check-label flex-grow-1 text-start" for="{{ strtolower($category) }}">
                                    <input class="form-check-input me-2" type="checkbox" id="{{ strtolower($category) }}" name="category_filter[]" value="{{ $category }}" {{ in_array($category, $categoryfilters) ? 'checked' : '' }}>
                                    {{ $category }}
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
        <form id="clear-filter-form" method="POST" action="{{ route($clearFilterRoute) }}" style="display: none;">
            @csrf
        </form>
        <div class="row p-3 d-flex justify-content-center">
            <span>
                <button type="submit" form="clear-filter-form" class="rsans btn btn-secondary fw-bold w-40 me-1">Clear all</button>
                <button type="submit" form="filter-form" class="rsans btn btn-primary fw-bold w-40 ms-1">Apply filters</button>
            </span>
        </div>
    </div>
</div>
