<!-- resources/views/components/event-card.blade.php -->
<a href="{{ route('profile') }}" class="text-decoration-none">
    <div class="card" id="event-card">
        <img src="{{ asset('images/login_illustration.jpg') }}" class="card-img-top" alt="Event card illustration">
        <div class="rsans card-body p-3">
            <h5 class="card-title fw-bold">Event #1</h5>
            <div class="card-text">
                <div class="row align-items-center">
                    <div class="col-1">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="col-10">
                        FKI BT 1
                    </div>
                    <div class="col-1"></div>
                </div>
                <div class="row align-items-center">
                    <div class="col-1">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="col-10">
                        FKI BT 1
                    </div>
                    <div class="col-1"></div>
                </div>
                <div class="row align-items-center">
                    <div class="col-1">
                        <i class="fa fa-university"></i>
                    </div>
                    <div class="col-10">
                        FKIKK
                    </div>
                    <div class="col-1"></div>
                </div>
            </div>
        </div>
    </div>
</a>
