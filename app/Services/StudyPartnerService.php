<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\UserTraitsRecord;
use App\Models\StudyPartner;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class StudyPartnerService
{
    public function handleSuggesterFormData(Request $request) {
        // WTC portion of the form
        $wtc = $request->only('stranger_presenting', 'colleague_in_line', 'friend_talking_large',
            'stranger_talking_small', 'friend_in_line', 'colleague_talking_large',
            'stranger_in_line', 'friend_presenting', 'colleague_talking_small',
            'stranger_talking_large', 'friend_talking_small', 'colleague_presenting'
        );
        $wtcData = $this->calculateWTCScores($wtc);

        // Personality portion of the form
        $bfiData = $request->only(
            'reserved', 'trusting', 'lazy', 'relaxed', 'artistic',
            'outgoing', 'fault_finding', 'thorough', 'nervous', 'imaginative'
        );
        $personalityData = $this->calculatePersonalityScores($bfiData);

        // Skills portion of the form
        $skillsData = $request->only(
            'interdisciplinary_collaboration', 'online_communication',
            'conflict_resolution', 'organised',
            'problem_solving', 'tech_proficiency',
            'creativity', 'adaptability',
            'leadership', 'teaching_ability'
        );
        $skillsData = array_map('intval', $skillsData);

        // Learning style portion of the form
        $learningStyle = $request->input('learning_style');

        // Package the processed data into the proper formats
        $data = [
            'profile_id' => $request->profile_id,
            'wtc_data' => json_encode($wtcData),
            'personality_data' => json_encode($personalityData),
            'skills_data' => json_encode($skillsData),
            'learning_style' => $learningStyle
        ];

        return $this->submitUserTraitsRecord($data);
    }

    // Calculate Willingnes to Communicate (WTC) scores using the WTC provided formulae
    public function calculateWTCScores(array $wtc) {
        $groupDiscussion = number_format(($wtc['stranger_talking_small'] + $wtc['colleague_talking_small'] + $wtc['friend_talking_small']) / 3, 2);
        $meetings = number_format(($wtc['friend_talking_large'] + $wtc['colleague_talking_large'] + $wtc['stranger_talking_large']) / 3, 2);
        $interpersonalConversation = number_format(($wtc['colleague_in_line'] + $wtc['friend_in_line'] + $wtc['stranger_in_line']) / 3, 2);
        $publicSpeaking = number_format(($wtc['stranger_presenting'] + $wtc['friend_presenting'] + $wtc['colleague_presenting']) / 3, 2);
        
        $stranger = number_format(($wtc['stranger_presenting'] + $wtc['stranger_talking_small'] + $wtc['stranger_in_line'] + $wtc['stranger_talking_large']) / 4, 2);
        $colleague = number_format(($wtc['colleague_in_line'] + $wtc['colleague_talking_large'] + $wtc['colleague_talking_small'] + $wtc['colleague_presenting']) / 4, 2);
        $friend = number_format(($wtc['friend_talking_large'] + $wtc['friend_in_line'] + $wtc['friend_presenting'] + $wtc['friend_talking_small']) / 4, 2);

        $wtcSum = number_format(($stranger + $colleague + $friend) / 3, 2);

        return [
            'group_discussion' => floatval($groupDiscussion),
            'meetings' => floatval($meetings),
            'interpersonal_conversation' => floatval($interpersonalConversation),
            'public_speaking' => floatval($publicSpeaking),
            'stranger' => floatval($stranger),
            'colleague' => floatval($colleague),
            'friend' => floatval($friend),
            'wtc_sum' => floatval($wtcSum),
        ];
    }

    // Calculate personality scores using the BFI-10 provided formulae
    public function calculatePersonalityScores(array $bfiData) {
        $extraversion = (6 - $bfiData['reserved']) + $bfiData['outgoing'];
        $agreeableness = $bfiData['trusting'] + (6 - $bfiData['fault_finding']);
        $conscientiousness = (6 - $bfiData['lazy']) + $bfiData['thorough'];
        $neuroticism = (6 - $bfiData['relaxed']) + $bfiData['nervous'];
        $openness = (6 - $bfiData['artistic']) + $bfiData['imaginative'];

        return [
            'extraversion' => $extraversion,
            'agreeableness' => $agreeableness,
            'conscientiousness' => $conscientiousness,
            'neuroticism' => $neuroticism,
            'openness' => $openness,
        ];
    }

    public function submitUserTraitsRecord($data) {
        $profileId = $data['profile_id'];

        $userTraitsRecord = UserTraitsRecord::where('profile_id', $profileId)->first();

        if ($userTraitsRecord) {
            // If a record exists, update it
            return $userTraitsRecord->update([
                'wtc_data' => $data['wtc_data'],
                'personality_data' => $data['personality_data'],
                'skills_data' => $data['skills_data'],
                'learning_style' => $data['learning_style'],
                'updated_at' => Carbon::now()
            ]);
        } else {
            // If no record exists, create a new one
            return UserTraitsRecord::create([
                'profile_id' => $profileId,
                'wtc_data' => $data['wtc_data'],
                'personality_data' => $data['personality_data'],
                'skills_data' => $data['skills_data'],
                'learning_style' => $data['learning_style'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    // Handle getting the study partners suggestions
    public function getStudyPartnerSuggestions() {
        // Fetch this student's UserTraitsRecord
        $ownTraitsRecord = UserTraitsRecord::where('profile_id', profile()->profile_id)->first();

        // Get the UserTraitsRecords of other students to compare against
        $otherStudentsTraitsRecords = UserTraitsRecord::where('profile_id', '!=', $ownTraitsRecord->profile_id)->get();

        // Call the Python RE here and pass the data to it
        $recommendations = $this->callRecommenderEngine($ownTraitsRecord, $otherStudentsTraitsRecords);
        
        // Sort the recommendations by similarity score in descending order
        usort($recommendations, function ($first, $second) {
            return $first['similarity'] <=> $second['similarity'];
        });

        // Combine the profiles with the similarity scores, then return the recommendations
        return $this->combineProfilesWithSimilarity($recommendations);
    }

    // Call the Python RE webservice
    private function callRecommenderEngine($ownTraitsRecord, $otherStudentsTraitsRecords) {
        $otherStudentsTraitsRecordsArray = $otherStudentsTraitsRecords->map(function ($record) {
            return [
                'profile_id' => $record->profile_id,
                'wtc_data' => json_decode($record->wtc_data, true),
                'personality_data' => json_decode($record->personality_data, true),
                'skills_data' => json_decode($record->skills_data, true),
                'learning_style' => $record->learning_style,
            ];
        })->toArray();

        $response = Http::post('http://localhost:5000/recommendation-engine', [
            'user_traits_record' => [
                'profile_id' => $ownTraitsRecord->profile_id,
                'wtc_data' => json_decode($ownTraitsRecord->wtc_data, true),
                'personality_data' => json_decode($ownTraitsRecord->personality_data, true),
                'skills_data' => json_decode($ownTraitsRecord->skills_data, true),
                'learning_style' => $ownTraitsRecord->learning_style
            ],
            'other_students_traits_records' => $otherStudentsTraitsRecordsArray
        ]);

        return $response->json();
    }

    // Combine the profiles with the similarity scores
    private function combineProfilesWithSimilarity($recommendations) {
        // Retrieve the profiles associated with the recommendations
        $profileIdArray = array_column($recommendations, 'profile_id');
        $profiles = Profile::whereIn('profile_id', $profileIdArray)->get();

        // Map the recommendations to their profile IDs
        $recommendationMap = [];
        foreach($recommendations as $recommendation) {
            $recommendationMap[$recommendation['profile_id']] = $recommendation['similarity'];
        }

        // Process the data before return
        $combinedResults = $profiles->map(function($profile) use ($recommendationMap) {
            $profile->profile_picture_filepath = $profile->profile_picture_filepath
                ? Storage::url($profile->profile_picture_filepath)
                : asset('images/no_club_images_default.png');

            $profile->account_full_name = $profile->account->account_full_name;

            $profile->profile_nickname = $profile->profile_nickname
                ? $profile->profile_nickname
                : 'No nickname';

            $profile->profile_faculty = $profile->faculty
                ? $profile->faculty
                : 'Unspecified';

            $profile->account_matric_number = $profile->account->account_matric_number;

            $profile->account_email_address = $profile->account->account_email_address;

            $profile->profile_personal_desc = $profile->profile_personal_desc
                ? $profile->profile_personal_desc
                : 'No personal description written yet';

            return [
                'profile' => $profile,
                'similarity' => $recommendationMap[$profile->profile_id] ?? null,
                'connectionType' => $this->checkForConnectionType($profile->profile_id)
            ];
        });

        // Sort the combined data, then return it
        return $combinedResults->sortByDesc('similarity')->values();
    }

    // Check if a study partner exists, and if it does, check if it is a bookmark or has been added
    private function checkForConnectionType($studyPartnerProfileId) {
        $bookmark = StudyPartner::where('profile_id', profile()->profile_id)
            ->where('study_partner_profile_id', $studyPartnerProfileId)
            ->first();

        return $bookmark ? $bookmark->connection_type : 0;
    }
}
