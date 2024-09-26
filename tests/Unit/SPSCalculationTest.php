<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use App\Services\StudyPartnersSuggesterService;

class SPSCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculate_wtc_scores(): void
    {
        $spsService = new StudyPartnersSuggesterService();
        $wtc = [
            'stranger_presenting' => 3,
            'colleague_in_line' => 3,
            'friend_talking_large' => 4,
            'stranger_talking_small' => 2,
            'friend_in_line' => 5,
            'colleague_talking_large' => 3,
            'stranger_in_line' => 1,
            'friend_presenting' => 5,
            'colleague_talking_small' => 3,
            'stranger_talking_large' => 1,
            'friend_talking_small' => 5,
            'colleague_presenting' => 3
        ];
        $wtcData = $spsService->calculateWTCScores($wtc);
        $expectedWtcData = [
            'group_discussion' => 3.33,
            'meetings' => 2.67,
            'interpersonal_conversation' => 3.00,
            'public_speaking' => 3.67,
            'stranger' => 1.75,
            'colleague' => 3.00,
            'friend' => 4.75,
            'wtcSum' => 3.17
        ];
        $this->assertEquals($expectedWtcData, $wtcData);
    }

    public function test_calculate_personality_scores(): void
    {
        $spsService = new StudyPartnersSuggesterService();
        $bfiData = [
            'reserved' => 4,
            'trusting' => 4,
            'lazy' => 3,
            'relaxed' => 2,
            'artistic' => 3,
            'outgoing' => 2,
            'fault_finding' => 2,
            'thorough' => 4,
            'nervous' => 4,
            'imaginative' => 3
        ];
        $personalityData = $spsService->calculatePersonalityScores($bfiData);
        $expectedPersonalityData = [
            'extraversion' => (6 - 4) + 2,
            'agreeableness' => 4 + (6 - 2),
            'conscientiousness' => (6 - 3) + 4,
            'neuroticism' => (6 - 2) + 4,
            'openness' => (6 - 3) + 3,
        ];
        $this->assertEquals($expectedPersonalityData, $personalityData);
    }
}
