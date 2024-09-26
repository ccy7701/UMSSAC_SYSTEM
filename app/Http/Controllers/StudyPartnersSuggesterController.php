<?php

namespace App\Http\Controllers;

use App\Services\StudyPartnersSuggesterService;
use App\Models\UserTraitsRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudyPartnersSuggesterController extends Controller
{
    protected $studyPartnersSuggesterService;

    public function __construct(StudyPartnersSuggesterService $studyPartnersSuggesterService) {
        $this->studyPartnersSuggesterService = $studyPartnersSuggesterService;
    }

    public function initialiseSuggester() {
        // First determine if the student already has an existing UserTraitsRecord
        $userTraitsRecord = UserTraitsRecord::where('profile_id', profile()->profile_id)->first();

        // Redirect to the appropriate route based on result
        if (!$userTraitsRecord) {
            return redirect()->route('study-partners-suggester.suggester-form');
        } else {
            return redirect()->route('study-partners-suggester.suggester-results');
        }
    }

    public function submitSuggesterForm(Request $request) {
        $status = $this->studyPartnersSuggesterService->handleSuggesterFormData($request);

        return $status
            ? redirect()->route('study-partners-suggester.suggester-results')->with('success', 'Your details have been saved successfully!')
            : back()->withErrors(['error' => 'Failed to save details. Please try again.']);
    }

    public function getSuggestedStudyPartners() {
        // Call the service to get recommended study partners
        $recommendations = $this->studyPartnersSuggesterService->getStudyPartnerSuggestions();

        return 0;
    }
}
