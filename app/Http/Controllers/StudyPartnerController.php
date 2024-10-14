<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTraitsRecord;
use App\Services\BookmarkService;
use App\Services\StudyPartnerService;

class StudyPartnerController extends Controller
{
    protected $studyPartnerService;
    protected $bookmarkService;

    public function __construct(StudyPartnerService $studyPartnerService, BookmarkService $bookmarkService) {
        $this->bookmarkService = $bookmarkService;
        $this->studyPartnerService = $studyPartnerService;
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
        $status = $this->studyPartnerService->handleSuggesterFormData($request);

        return $status
            ? redirect()->route('study-partners-suggester.suggester-results')->with('success', 'Your details have been saved successfully!')
            : back()->withErrors(['error' => 'Failed to save details. Please try again.']);
    }

    public function getSuggestedStudyPartners() {
        // Call the service to get recommended study partners
        $suggestedStudyPartners = $this->studyPartnerService->getStudyPartnerSuggestions();

        return response()->json([
            'success' => true,
            'suggestedStudyPartners' => $suggestedStudyPartners
        ]);
    }

    public function fetchUserStudyPartnerBookmarks(Request $request) {
        $search = $request->input('search', '');

        return $this->bookmarkService->prepareAndRenderSPBookmarksView(
            profile()->profile_id,
            'study-partners-suggester.bookmarks',
            $search
        );
    }

    public function toggleStudyPartnerBookmark(Request $request) {
        return $this->bookmarkService->handleToggleStudyPartnerBookmark(
            $request->operation_page_source,
            profile()->profile_id,
            $request->study_partner_profile_id
        );
    }

    public function addToStudyPartnersList(Request $request) {
        return $this->bookmarkService->updateSPBookmarkToAdd(
            $request->operation_page_source,
            profile()->profile_id,
            $request->study_partner_profile_id
        );
    }

    public function deleteFromStudyPartnersList(Request $request) {
        return $this->studyPartnerService->handleDeleteStudyPartner(
            profile()->profile_id,
            $request->study_partner_profile_id
        );
    }

    public function fetchUserAddedStudyPartners(Request $request) {
        $search = $request->input('search', '');

        return $this->studyPartnerService->prepareAndRenderAddedListView(
            profile()->profile_id,
            'study-partners-suggester.added-list',
            $search
        );
    }
}
