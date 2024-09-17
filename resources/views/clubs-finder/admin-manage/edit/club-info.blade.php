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
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
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
        <form action="{{ route('admin-manage.edit-club-info.action') }}" method="POST">
            @csrf
            <input type="hidden" name="club_id" value="{{ $club->club_id }}">
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
                        <input type="text" id="club-name" name="club_name" class="rsans form-control" value="{{ $club->club_name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="club-category" name="club_category" class="rsans fw-bold form-label">Category</label>
                        <select id="club-category" class="rsans form-select w-50" name="club_category">
                            <option selected disabled value="">Choose...</option>
                            <optgroup label="Faculty">
                                <option value="ASTIF" {{ $club->club_category == 'ASTIF' ? 'selected' : '' }}>ASTIF</option>
                                <option value="FIS" {{ $club->club_category == 'FIS' ? 'selected' : '' }}>FIS</option>
                                <option value="FKAL" {{ $club->club_category == 'FKAL' ? 'selected' : '' }}>FKAL</option>
                                <option value="FKIKK" {{ $club->club_category == 'FKIKK' ? 'selected' : '' }}>FKIKK</option>
                                <option value="FKIKAL" {{ $club->club_category == 'FKIKAL' ? 'selected' : '' }}>FKIKAL</option>
                                <option value="FKJ" {{ $club->club_category == 'FKJ' ? 'selected' : '' }}>FKJ</option>
                                <option value="FPEP" {{ $club->club_category == 'FPEP' ? 'selected' : '' }}>FPEP</option>
                                <option value="FPL" {{ $club->club_category == 'FPL' ? 'selected' : '' }}>FPL</option>
                                <option value="FPP" {{ $club->club_category == 'FPP' ? 'selected' : '' }}>FPP</option>
                                <option value="FPSK" {{ $club->club_category == 'FPSK' ? 'selected' : '' }}>FPSK</option>
                                <option value="FPT" {{ $club->club_category == 'FPT' ? 'selected' : '' }}>FPT</option>
                                <option value="FSMP" {{ $club->club_category == 'FSMP' ? 'selected' : '' }}>FSMP</option>
                                <option value="FSSA" {{ $club->club_category == 'FSSA' ? 'selected' : '' }}>FSSA</option>
                                <option value="FSSK" {{ $club->club_category == 'FSSK' ? 'selected' : '' }}>FSSK</option>
                            </optgroup>
                            <optgroup label="Residential College">
                                <option value="KKTF" {{ $club->club_category == 'KKTF' ? 'selected' : '' }}>KKTF</option>
                                <option value="KKTM" {{ $club->club_category == 'KKTM' ? 'selected' : '' }}>KKTM</option>
                                <option value="KKTPAR" {{ $club->club_category == 'KKTPAR' ? 'selected' : '' }}>KKTPAR</option>
                                <option value="KKAKF" {{ $club->club_category == 'KKAKF' ? 'selected' : '' }}>KKAKF</option>
                                <option value="KKUSIA" {{ $club->club_category == 'KK USIA' ? 'selected' : '' }}>KKUSIA</option>
                                <option value="NR" {{ $club->club_category == 'NR' ? 'selected' : '' }}>NR</option>
                            </optgroup>
                            <optgroup label="Others">
                                <option value="GENERAL" {{ $club->category == 'GENERAL' ? 'selected' : '' }}>General</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="club-description" class="rsans fw-bold form-label">Description</label>
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
