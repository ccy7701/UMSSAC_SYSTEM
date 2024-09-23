<!DOCTYPE html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Partners Suggester Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/sass/app.scss')
</head>

<body class="d-flex flex-column min-vh-100">
    @vite('resources/js/app.js')
    @vite('resources/js/suggesterForm.js')
    <x-topnav/>
    <br>
    <main class="flex-grow-1">
        <div class="container p-3">
            <div class="d-flex align-items-center">
                <!-- TOP SECTION -->
                <div class="section-header row w-100">
                    <div class="col-12 text-center">
                        <h3 class="rserif fw-bold w-100 mb-1">Suggest me study partners!</h3>
                        <p class="rserif fs-4 w-100 mt-0">
                            Fill in the details below and we’ll suggest study partners suitable for you.
                        </p>
                    </div>
                </div>
            </div>
            <!-- BODY OF CONTENT -->
            <div class="rsans d-flex justify-content-center align-items-center py-3 w-100 align-self-center">

                <!-- START OF SUGGESTER FORM -->
                <form id="suggester-multipart-form" class="px-3 justify-content-center align-items-center w-100 text-center">

                    <div class="rserif row w-100 text-center justify-content-center align-items-center">
                        <p class="fs-2 py-3">I see myself as someone who...</p>
                    </div>
                    
                    <x-custom-radio-group :label="'Is reserved'" :name="'reserved'"/>
                    <x-custom-radio-group :label="'Is generally trusting'" :name="'trusting'"/>
                    <x-custom-radio-group :label="'Tends to be lazy'" :name="'lazy'"/>
                    <x-custom-radio-group :label="'Is relaxed, handles stress well'" :name="'relaxed'"/>
                    <x-custom-radio-group :label="'Is outgoing, sociable'" :name="'outgoing'"/>
                    <x-custom-radio-group :label="'Tends to find fault with others'" :name="'fault-finding'"/>
                    <x-custom-radio-group :label="'Does a thorough job'" :name="'thorough'"/>
                    <x-custom-radio-group :label="'Gets nervous easily'" :name="'nervous'"/>
                    <x-custom-radio-group :label="'Has an active imagination'" :name="'imaginative'"/>

                </form>
                <!-- END OF SUGGESTER FORM -->


            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
