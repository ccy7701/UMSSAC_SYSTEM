<?php

namespace App\Http\Controllers;

use App\Services\StudyPartnerSuggesterService;
use Illuminate\Http\Request;

class UserTraitsRecordController extends Controller
{
    protected $studyPartnerSuggesterService;

    public function __construct(StudyPartnerSuggesterService $studyPartnerSuggesterService) {
        $this->studyPartnerSuggesterService = $studyPartnerSuggesterService;
    }

    public function submitSuggesterForm(Request $request) {
        dump($request);
    }
}
