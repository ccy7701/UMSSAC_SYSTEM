<!-- resources/views/components/sort-modal.blade.php -->
@php
    $activeSort = request()->input('sort', '');
    $modalId = null;
    $ariaLabel = null;
    $sortFormId = null;
    $modalHeader = null;
    switch ($type) {
        case 'event':
            $modalId = 'event-sort-modal';
            $ariaLabel = 'eventSortModalLabel';
            $sortFormId = 'event-sort-form';
            $modalHeader = 'Sort Events';
            break;
        case 'club':
            $modalId = 'club-sort-modal';
            $ariaLabel = 'clubSortModalLabel';
            $sortFormId = 'club-sort-form';
            $modalHeader = 'Sort Clubs';
            break;
        case 'sysusers':
            $modalId = 'sysusers-sort-modal';
            $ariaLabel = 'systemUsersSortModalLabel';
            $sortFormId = 'sysusers-sort-form';
            $modalHeader = 'Sort System Users';
            break;
    }
@endphp
<div class="rsans modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $ariaLabel }}" aria-hidden="true">
    <div class="modal-sm modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0">
                    {{ $modalHeader }}
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ps-4">
                <form id="{{ $sortFormId }}">
                    <div class="form-check text-start">
                        <input class="form-check-input" type="radio" name="sortOption" id="sort-alphabetical-AZ" value="az"
                        {{ $activeSort === 'az' ? 'checked' : '' }}>
                        <label class="form-check-label" for="sort-alphabetical-AZ">Name (A-Z)</label>
                    </div>
                    <div class="form-check text-start">
                        <input class="form-check-input" type="radio" name="sortOption" id="sort-alphabetical-ZA" value="za"
                        {{ $activeSort === 'za' ? 'checked' : '' }}>
                        <label class="form-check-label" for="sort-alphabetical-ZA">Name (Z-A)</label>
                    </div>
                    @if ($type !== 'sysusers')
                        <div class="form-check text-start">
                            <input class="form-check-input" type="radio" name="sortOption" id="sort-oldest" value="oldest"
                            {{ $activeSort === 'oldest' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort-oldest">Date (Oldest)</label>
                        </div>
                        <div class="form-check text-start">
                            <input class="form-check-input" type="radio" name="sortOption" id="sort-newest" value="newest"
                            {{ $activeSort === 'newest' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort-newest">Date (Newest)</label>
                        </div>
                    @else
                        <div class="form-check text-start">
                            <input class="form-check-input" type="radio" name="sortOption" id="sort-fm" value="fm"
                            {{ $activeSort === 'fm' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort-fm">Role (faculty members first)</label>
                        </div>
                        <div class="form-check text-start">
                            <input class="form-check-input" type="radio" name="sortOption" id="sort-student" value="student"
                            {{ $activeSort === 'student' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sort-student">Role (students first)</label>
                        </div>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary fw-semibold me-1 w-30" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="{{ $sortFormId }}" class="btn btn-primary fw-semibold ms-1 w-30">Apply</button>
            </div>
        </div>
    </div>
</div>
