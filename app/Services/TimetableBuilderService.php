<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TimetableBuilderService
{
    // Handle getting and updating the subject list JSON
    public function getAndUpdateSubjectList() {
        $url = env('ALL_SUBJECTS_DATA_FETCHER_URL', 'http://localhost:5001/all-subjects-data-fetcher');

        // Call the Python subjects list webservice
        try {
            $response = Http::post($url);

            return response()->json(['message' => 'Subjects data updated successfully!', 'output' => $response]);
        } catch (\Exception $e) {
            Log::error('ASDF connection error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to connect to all subjects data fetcher at port 5001.']);
        }
    }

    // Handle getting the subject details list
    public function getDetailsList($sourceLink) {
        $url = env('SUBJECT_DETAILS_FETCHER_URL', 'http://localhost:5002/subject-details-fetcher');

        try {
            return Http::post($url, [
                'source_link' => $sourceLink
            ]);
        } catch (\Exception $e) {
            Log::error('SDF connection error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to connect to subject details fetcher at port 5002.']);
        }
    }
}
