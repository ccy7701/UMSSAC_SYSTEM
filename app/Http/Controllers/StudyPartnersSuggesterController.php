<?php

namespace App\Http\Controllers;

use App\Services\StudyPartnersSuggesterService;
use App\Models\UserTraitsRecord;
use Illuminate\Http\Request;

class StudyPartnersSuggesterController extends Controller
{
    protected $studyPartnersSuggesterService;

    public function __construct(StudyPartnersSuggesterService $studyPartnersSuggesterService) {
        $this->studyPartnersSuggesterService = $studyPartnersSuggesterService;
    }

    public function initialiseSuggester(Request $request) {
        // First determine if the student already has an existing UserTraitsRecord
        $userTraitsRecord = UserTraitsRecord::where('profile_id', profile()->profile_id)->first();

        // Redirect to the appropriate route based on result
        if ($userTraitsRecord) {
            dump("userTraitsRecord FOUND!");
            dump($userTraitsRecord);
            dd("ENTER --> study-partners-suggester.suggester-results");
            return redirect()->route('study-partners-suggester.suggester-results');
        } else {
            dump("NO userTraitsRecord FOUND!");
            dd("ENTER --> study-partners-suggester.suggester-form");
            return redirect()->route('study-partners-suggester.suggester-form');
        }
    }

    public function submitSuggesterForm(Request $request) {
        $this->studyPartnersSuggesterService->handleSuggesterFormData($request);
    }
}
