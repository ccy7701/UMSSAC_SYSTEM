<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\UserTraitsRecord;
use Illuminate\Http\Request;

class StudyPartnersSuggesterService
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

        // Learning style portion of the form
        $learningStyle = $request->input('learning_style');

        // Package the processed data into the proper formats
        $data = [
            'wtc_data' => json_encode($wtcData),
            'personality_data' => json_encode($personalityData),
            'skills_data' => json_encode($skillsData),
            'learning_style' => $learningStyle
        ];

        return $this->submitUserTraitsRecord($data);
    }

    
    public function submitUserTraitsRecord($data) {
        $profileId = profile()->profile_id;

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
            'group_discussion' => $groupDiscussion,
            'meetings' => $meetings,
            'interpersonal_conversation' => $interpersonalConversation,
            'public_speaking' => $publicSpeaking,
            'stranger' => $stranger,
            'colleague' => $colleague,
            'friend' => $friend,
            'wtcSum' => $wtcSum,
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
}
