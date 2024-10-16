<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TimetableBuilderService
{
    // Handle getting and updating the subject list JSON
    public function getAndUpdateSubjectList() {
        // Call the Python subjects list webservice
        $response = Http::post('http://localhost:5001/all-subjects-list-fetcher');

        if ($response) {
            return response()->json(['message' => 'Subjects data updated successfully!', 'output' => $response]);
        } else {
            return response()->json(['message' => 'Failed to update subjects data.']);
        }
    }

    // Handle getting the subject details list
    public function getDetailsList($sourceLink) {
        // Call the Python subject details fetcher webservice and pass the data to it
        return Http::post('http://localhost:5002/subject-details-fetcher', [
            'source_link' => $sourceLink
        ]);
    }
}
