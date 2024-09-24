<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\StudyPartnersSuggesterService;
use Tests\TestCase;

class StudyPartnersSuggesterServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculate_personality_scores(): void
    {
        $bfiData = [
            'reserved' => 4,
            'trusting' => 4,
            'lazy' => 3,
            'relaxed' => 2,
            'artistic' => 3,
            'outgoing' => 2,
            'fault-finding' => 2,
            'thorough' => 4,
            'nervous' => 4,
            'imaginative' => 3
        ];

        $spsService = new StudyPartnersSuggesterService();

        $personalityData = $spsService->calculatePersonalityScores($bfiData);

        $expectedData = [
            'extraversion' => (6 - 4) + 2,
            'agreeableness' => 4 + (6 - 2),
            'conscientiousness' => (6 - 3) + 4,
            'neuroticism' => (6 - 2) + 4,
            'openness' => (6 - 3) + 3,
        ];

        $this->assertEquals($expectedData, $personalityData);
    }
}
