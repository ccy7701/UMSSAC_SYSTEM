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
    @vite('resources/js/suggesterOperations.js')
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

                    <!-- Step 1: Willingness to Communicate (WTC) -->
                    <div id="form-step-wtc" class="form-step">
                        <div class="rserif row w-100 text-cente justify-content-center align-items-center">
                            <p class="fs-2 py-3">Rate each activity below based on how comfortable you would be with it.</p>
                        </div>
                        <x-wtc-radio-group
                            :label="'Presenting to a group of strangers'"
                            :name="'stranger_presenting'"/>
                        <x-wtc-radio-group
                            :label="'Talking with a colleague while standing in line'"
                            :name="'colleague_in_line'"/>
                        <x-wtc-radio-group
                            :label="'Talking in a large meeting of friends'"
                            :name="'friend_talking_large'"/>
                        <x-wtc-radio-group
                            :label="'Talking in a small group of strangers'"
                            :name="'stranger_talking_small'"/>
                        <x-wtc-radio-group
                            :label="'Talking with a friend while standing in line'"
                            :name="'friend_in_line'"/>
                        <x-wtc-radio-group
                            :label="'Talking in a large meeting of colleagues'"
                            :name="'colleague_talking_large'"/>
                        <x-wtc-radio-group
                            :label="'Talking with a stranger while standing in line'"
                            :name="'stranger_in_line'"/>
                        <x-wtc-radio-group
                            :label="'Presenting to a group of friends'"
                            :name="'friend_presenting'"/>
                        <x-wtc-radio-group
                            :label="'Talking in a small group of colleagues'"
                            :name="'colleague_talking_small'"/>
                        <x-wtc-radio-group
                            :label="'Talking in a large meeting of strangers'"
                            :name="'stranger_talking_large'"/>
                        <x-wtc-radio-group
                            :label="'Talking in a small group of friends'"
                            :name="'friend_talking_small'"/>
                        <x-wtc-radio-group
                            :label="'Presenting to a group of colleagues'"
                            :name="'colleague_presenting'"/>
                        <button type="button" id="previous-step-wtc" class="rsans fw-semibold btn btn-secondary w-20 me-1" disabled>Previous</button>
                        <button type="button" id="next-step-wtc" class="rsans fw-semibold btn btn-primary w-20 ms-1">Next</button>
                    </div>

                    <!-- Step 2: Personality (BFI-10) -->
                    <div id="form-step-bfi" class="form-step d-none">
                        <div class="rserif row w-100 text-center justify-content-center align-items-center">
                            <p class="fs-2 py-3">I see myself as someone who...</p>
                        </div>
                        <x-bfi-radio-group
                            :label="'Is reserved'"
                            :name="'reserved'"/>
                        <x-bfi-radio-group
                            :label="'Is generally trusting'"
                            :name="'trusting'"/>
                        <x-bfi-radio-group
                            :label="'Tends to be lazy'"
                            :name="'lazy'"/>
                        <x-bfi-radio-group
                            :label="'Is relaxed, handles stress well'"
                            :name="'relaxed'"/>
                        <x-bfi-radio-group
                            :label="'Is outgoing, sociable'"
                            :name="'outgoing'"/>
                        <x-bfi-radio-group
                            :label="'Tends to find fault with others'"
                            :name="'fault-finding'"/>
                        <x-bfi-radio-group
                            :label="'Does a thorough job'"
                            :name="'thorough'"/>
                        <x-bfi-radio-group
                            :label="'Gets nervous easily'"
                            :name="'nervous'"/>
                        <x-bfi-radio-group
                            :label="'Has an active imagination'"
                            :name="'imaginative'"/>
                        <button type="button" id="previous-step-bfi" class="rsans fw-semibold btn btn-secondary w-20 me-1">Previous</button>
                        <button type="button" id="next-step-bfi" class="rsans fw-semibold btn btn-primary w-20 ms-1" disabled>Next</button>
                    </div>

                </form>
                <!-- END OF SUGGESTER FORM -->

            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
