<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Club Info</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    <x-topnav/>
    <x-success-message/>
    <br>
    <div class="container p-3">

        <!-- TOP SECTION -->
        <div class="d-flex align-items-center">
            <div class="row w-100">
                <div class="col-12 text-center">
                    <!-- BREADCRUMB NAV -->
                    <div class="row pb-3">
                        <div class="col-6 align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>';">
                                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs') }}">All Clubs</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}">Manage Details</a></li>
                                    <li class="breadcrumb-item active">Edit Club Info</li>
                                </ol>
                             </nav>
                        </div>
                        <div class="col-6"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BODY OF CONTENT -->
        <!-- EDIT CLUB INFO FORM -->
        <form action="{{ route('admin-manage.edit-club-info-action') }}" method="POST">
            <div class="d-flex align-items-center">
                <div class="section-header row w-100">
                    <div class="col-md-6 text-start">
                        <h3 class="rserif fw-bold w-100 py-2">Club info</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin-manage.manage-details', ['club_id' => $club->club_id]) }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                        <button type="submit" class="rsans btn btn-primary fw-bold px-3 mx-2 w-25">Save</button>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <br>
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {!! $error !!}
                        <br>
                    @endforeach
                </div>
            @endif
            <div class="d-flex justify-content-center align-items-center py-3 w-100 align-self-center">
                <div class="container px-3 w-75">
                    <div class="form-group mb-3">
                        <label for="club-name" class="rsans fw-bold form-label">Club name</label>
                        <input type="text" id="club-name" name="club_name" class="rsans form-control" value="{{ $club->club_name }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="club-faculty" name="club_faculty" class="rsans fw-bold form-label">Club faculty</label>
                        <select id="club-faculty" class="rsans form-select w-50" name="club_faculty">
                            <option selected disabled value="">Choose...</option>
                            <option value="ASTIF" {{ $club->club_faculty == 'ASTIF' ? 'selected' : '' }}>ASTIF</option>
                            <option value="FIS" {{ $club->club_faculty == 'FIS' ? 'selected' : '' }}>FIS</option>
                            <option value="FKAL" {{ $club->club_faculty == 'FKAL' ? 'selected' : '' }}>FKAL</option>
                            <option value="FKIKK" {{ $club->club_faculty == 'FKIKK' ? 'selected' : '' }}>FKIKK</option>
                            <option value="FKIKAL" {{ $club->club_faculty == 'FKIKAL' ? 'selected' : '' }}>FKIKAL</option>
                            <option value="FKJ" {{ $club->club_faculty == 'FKJ' ? 'selected' : '' }}>FKJ</option>
                            <option value="FPEP" {{ $club->club_faculty == 'FPEP' ? 'selected' : '' }}>FPEP</option>
                            <option value="FPL" {{ $club->club_faculty == 'FPL' ? 'selected' : '' }}>FPL</option>
                            <option value="FPP" {{ $club->club_faculty == 'FPP' ? 'selected' : '' }}>FPP</option>
                            <option value="FPSK" {{ $club->club_faculty == 'FPSK' ? 'selected' : '' }}>FPSK</option>
                            <option value="FPT" {{ $club->club_faculty == 'FPT' ? 'selected' : '' }}>FPT</option>
                            <option value="FSMP" {{ $club->club_faculty == 'FSMP' ? 'selected' : '' }}>FSMP</option>
                            <option value="FSSA" {{ $club->club_faculty == 'FSSA' ? 'selected' : '' }}>FSSA</option>
                            <option value="FSSK" {{ $club->club_faculty == 'FSSK' ? 'selected' : '' }}>FSSK</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="club-description" class="rsans fw-bold form-label">Club description</label>
                        <textarea id="club-description" name="club_description" class="rsans form-control" rows="5" style="resize: none;" maxlength="1024">{{ $club->club_description }}</textarea>
                    </div>
                </div>
            </div>
        </form>
        <!-- END EDIT CLUB INFO FORM -->

    </div>
    <x-footer/>
</body>

</html>
