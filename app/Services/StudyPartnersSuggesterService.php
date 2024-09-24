<?php

namespace App\Services;
use Illuminate\Http\Request;

class StudyPartnersSuggesterService
{
    public function processSuggesterFormData(Request $request) {
        // Personality portion of the form
        $bfiData = [
            $request->only([
                'reserved', 'trusting', 'lazy', 'relaxed', 'artistic',
                'outgoing', 'fault-finding', 'thorough', 'nervous', 'imaginative'
            ])
        ];
        $personalityData = $this->calculatePersonalityScores($bfiData);
    }

    // Calculate personality scores using the BFI-10 provided formulae
    public function calculatePersonalityScores($bfiData) {
        $extraversion = (6 - $bfiData['reserved']) + $bfiData['outgoing'];
        $agreeableness = $bfiData['trusting'] + (6 - $bfiData['fault-finding']);
        $conscientiousness = (6 - $bfiData['lazy']) + $bfiData['thorough'];
        $neuroticism = (6 - $bfiData['relaxed']) + $bfiData['nervous'];
        $openness = (6 - $bfiData['artistic']) + $bfiData['imaginative'];

        $personalityScores = [
            'extraversion' => $extraversion,
            'agreeableness' => $agreeableness,
            'conscientiousness' => $conscientiousness,
            'neuroticism' => $neuroticism,
            'openness' => $openness,
        ];

        return $personalityScores;
    }
}
