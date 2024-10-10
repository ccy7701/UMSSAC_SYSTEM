<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\StudyPartner;
use Illuminate\Http\Request;
use App\Models\UserTraitsRecord;
use App\Services\BookmarkService;
use App\Services\StudyPartnersSuggesterService;

class StudyPartnersSuggesterController extends Controller
{
    protected $studyPartnersSuggesterService;
    protected $bookmarkService;

    public function __construct(StudyPartnersSuggesterService $studyPartnersSuggesterService, BookmarkService $bookmarkService) {
        $this->bookmarkService = $bookmarkService;
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
        $suggestedStudyPartners = $this->studyPartnersSuggesterService->getStudyPartnerSuggestions();

        return response()->json([
            'success' => true,
            'suggestedStudyPartners' => $suggestedStudyPartners
        ]);
    }

    public function toggleStudyPartnerBookmark(Request $request) {
        $route = route('study-partners-suggester.suggester-results');

        // Check if the event bookmark exists
        $bookmark = $this->studyPartnersSuggesterService->checkIfBookmarkExists($request->study_partner_profile_id);

        if ($bookmark) {
            // If the bookmark exists, delete it
            StudyPartner::where('profile_id', profile()->profile_id)
                ->where('study_partner_profile_id', $request->study_partner_profile_id)
                ->where('connection_type', 1)
                ->delete();
            return redirect($route)->with('bookmark-delete', 'Study partner bookmark deleted successfully.');
        } else {
            // If the bookmark does not exist, create it
            StudyPartner::create([
                'profile_id' => profile()->profile_id,
                'study_partner_profile_id' => $request->study_partner_profile_id,
                'connection_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return redirect($route)->with('bookmark-create', 'Study partner bookmark created successfully.');
        }
    }

    public function fetchUserStudyPartnerBookmarks(Request $request) {
        $search = $request->input('search', '');

        return $this->bookmarkService->prepareAndRenderBookmarksView(
            'study_partners',
            profile()->profile_id,
            'study-partners-suggester.bookmarks',
            $search
        );
    }
}
