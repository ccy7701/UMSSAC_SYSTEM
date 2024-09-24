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
                <form action="{{ route('study-partners-suggester.suggester-form.submit') }}" id="suggester-multipart-form" class="px-3 justify-content-center align-items-center w-100 text-center" method="POST">
                    @csrf
                    <input type="hidden" id="profile-id" name="profile_id" value="{{ profile()->profile_id }}">
                    <!-- Step 1: Willingness to Communicate (WTC) -->
                    <div id="form-step-wtc" class="form-step">
                        <div class="rserif row w-100 text-cente justify-content-center align-items-center">
                            <p class="fs-2 py-3">I am comfortable with...</p>
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
                            :label="'Does not have many artistic interests'"
                            :name="'artistic'"/>
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
                    <!-- Step 3: Skills -->
                    <div id="form-step-skills" class="form-step d-none">
                        <div class="rserif row w-100 text-center justify-content-center align-items-center">
                            <p class="fs-2 py-3">I believe that I...</p>
                        </div>
                        <x-skills-radio-group
                            :label="'Can work with people from different fields of study'"
                            :name="'interdisciplinary_collaboration'"/>
                        <x-skills-radio-group
                            :label="'Am good at communicating online'"
                            :name="'online_communication'"/>
                        <x-skills-radio-group
                            :label="'Am good at solving disagreements'"
                            :name="'conflict_resolution'"/>
                        <x-skills-radio-group
                            :label="'Am organised; good at planning and arranging things'"
                            :name="'organised'"/>
                        <x-skills-radio-group
                            :label="'Am good at problem-solving'"
                            :name="'problem_solving'"/>
                        <x-skills-radio-group
                            :label="'Am tech-savvy'"
                            :name="'tech_proficiency'"/>
                        <x-skills-radio-group
                            :label="'Am creative'"
                            :name="'creativity'"/>
                        <x-skills-radio-group
                            :label="'Am flexible to change'"
                            :name="'adaptability'"/>
                        <x-skills-radio-group
                            :label="'Possess leadership skills - can lead a team'"
                            :name="'leadership'"/>
                        <x-skills-radio-group
                            :label="'Possess teaching skills - can teach things to others'"
                            :name="'teaching_ability'"/>
                        <button type="button" id="previous-step-skills" class="rsans fw-semibold btn btn-secondary w-20 me-1" disabled>Previous</button>
                        <button type="button" id="next-step-skills" class="rsans fw-semibold btn btn-primary w-20 ms-1">Next</button>
                    </div>
                    <!-- Step 4: Learning style -->
                    <div id="form-step-learning-style" class="form-step d-none">
                        <div class="rserif row w-100 text-center justify-content-center align-items-center">
                            <p class="fs-2 py-3">I prefer receiving and processing information by...</p>
                            <x-learning-style-radio-group
                                :label="'Using diagrams, charts and videos. It is easier to remember details when they are presented to me visually.'"
                                :type="'visual'"
                                :value="'1'"/>
                            <x-learning-style-radio-group
                                :label="'Listening. Lectures, discussions and recordings are effective for me to absorb information.'"
                                :type="'auditory'"
                                :value="'2'"/>
                            <x-learning-style-radio-group
                                :label="'Using written text. I prefer learning new information through reading and writing things.'"
                                :type="'reading_writing'"
                                :value="'3'"/>
                            <x-learning-style-radio-group
                                :label="'Hands-on activities. I learn best when I can physically engage with the learning materials.'"
                                :type="'kinesthetic'"
                                :value="'4'"/>
                            <button type="button" id="previous-step-learning-style" class="rsans fw-semibold btn btn-secondary w-20 me-1">Previous</button>
                            <button type="submit" id="suggester-form-submit" class="rsans fw-semibold btn btn-primary w-20 ms-1">Submit</button>
                        </div>
                    </div>
                </form>
                <!-- END OF SUGGESTER FORM -->

            </div>
        </div>
    </main>
    <x-footer/>
</body>

</html>
