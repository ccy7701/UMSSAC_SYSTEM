<!-- resources/views/components/members-carousel.blade.php -->
@php
    $perRowCount = null;
    switch ($carouselid) {
        case 'carousel-inner-lg': $perRowCount = 4; break;
        case 'carousel-inner-md': $perRowCount = 3; break;
        case 'carousel-inner-sm': $perRowCount = 2; break;
        default: $perRowCount = 2; break;
    }
@endphp

<div id="{{ $carouselid }}-container" class="carousel slide">
    <div id="{{ $carouselid }}" class="carousel-inner px-2">
        @foreach ($members as $index => $member)
            @if ($index % $perRowCount === 0)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="row">
            @endif
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 py-2 px-2">
                <x-member-card :member="$member" />
            </div>
            @if ($index % $perRowCount === $perRowCount - 1 || $index === $loop->count - 1)
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <!-- Carousel Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselid }}-container" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselid }}-container" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
