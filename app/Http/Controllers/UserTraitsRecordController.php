<?php

namespace App\Http\Controllers;

use App\Services\StudyPartnersSuggesterService;
use Illuminate\Http\Request;

class UserTraitsRecordController extends Controller
{
    protected $studyPartnersSuggesterService;

    public function __construct(StudyPartnersSuggesterService $studyPartnersSuggesterService) {
        $this->studyPartnersSuggesterService = $studyPartnersSuggesterService;
    }

    public function submitSuggesterForm(Request $request) {
        $data = $this->studyPartnersSuggesterService->processSuggesterFormData($request);

        return redirect()->route('study-partners-suggester.suggester-form');
    }
}
