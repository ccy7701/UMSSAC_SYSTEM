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

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    <x-topnav/>
    <x-response-popup
        messageType="success"
        iconClass="text-success fa-regular fa-circle-check"
        title="Success!"/>
    <br>
    <main class="flex-grow-1">
        <form action="{{ route('committee-manage.edit-club-info.action') }}" method="POST">
            @csrf
            <input type="hidden" name="club_id" value="{{ $club->club_id }}">
            <!-- PAGE HEADER -->
            <div class="row-container">
                <!-- BREADCRUMB NAV -->
                <div id="club-breadcrumb" class="row pb-3">
                    <div id="club-breadcrumb" class="col-auto align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="rsans breadcrumb" style="--bs-breadcrumb-divider: '>';">
                                <li class="breadcrumb-item"><a href="{{ route('clubs-finder') }}">All Clubs</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}">{{ $club->club_name }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('committee-manage.manage-details', ['club_id' => $club->club_id]) }}">Manage Details</a></li>
                                <li class="breadcrumb-item active">Edit Club Info</li>
                            </ol>
                         </nav>
                    </div>
                </div>
            </div>
            <div class="row-container">
                <div class="align-items-center px-3">
                    <div class="section-header row w-100 m-0 py-2 d-flex align-items-center">
                        <div class="col-left-alt col-lg-6 col-md-4 col-12 mt-xl-2 mt-sm-0 mt-0">
                            <h3 class="rserif fw-bold w-100">Edit club info</h3>
                        </div>
                        <div class="col-right-alt col-lg-6 col-md-8 col-12 align-self-center mb-xl-0 mb-md-0 mb-sm-3 mb-3">
                            <a href="{{ route('committee-manage.manage-details', ['club_id' => $club->club_id]) }}" class="rsans text-decoration-none text-dark fw-bold px-3">Cancel</a>
                            <button type="submit" class="section-button-short rsans btn btn-primary fw-bold px-3">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            @if($errors->any())
                <br><br><br>
                <div class="rsans alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <i class="fa fa-circle-exclamation px-2"></i>
                        {{ $error }}
                        <br>
                    @endforeach
                </div>
            @endif
            <div class="d-flex justify-content-center align-items-center align-self-center py-3 w-100">
                <div class="container form-container px-3">
                    <div class="form-group mb-3">
                        <label for="club-name" class="rsans fw-bold form-label">Club name</label>
                        <input type="text" id="club-name" name="club_name" class="rsans form-control" value="{{ $club->club_name }}" viewonly>
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
                                <option value="FPKS" {{ $club->club_category == 'FPKS' ? 'selected' : '' }}>FPKS</option>
                                <option value="FPL" {{ $club->club_category == 'FPL' ? 'selected' : '' }}>FPL</option>
                                <option value="FPPS" {{ $club->club_category == 'FPPS' ? 'selected' : '' }}>FPPS</option>
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
    </main>
    <x-footer/>
</body>

</html>
