<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Account;
use App\Models\Profile;
use Tests\TestCase;

class StudyPartnersSuggesterServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the form submission for the study partners suggester works.
     *
     * @return void
     */
    public function test_submit_user_traits_record(): void
    {
        /** @var \App\Models\Account $account */
        $account = Account::factory()->create(['account_role' => 1]);
        $profile = Profile::factory()->create(['account_id' => $account->account_id]);
        $this->actingAs($account);

        $response = $this->post(route('study-partners-suggester.suggester-form.submit'), [
            '_token' => csrf_token(),
            'profile_id' => $profile->profile_id,
            // WTC traits
            'stranger_presenting' => 3,
            'colleague_in_line' => 3,
            'friend_talking_large' => 3,
            'stranger_talking_small' => 2,
            'friend_in_line' => 4,
            'colleague_talking_large' => 3,
            'stranger_in_line' => 1,
            'friend_presenting' => 4,
            'colleague_talking_small' => 3,
            'stranger_talking_large' => 3,
            'friend_talking_small' => 4,
            'colleague_presenting' => 4,
            // Personality traits
            'reserved' => 5,
            'trusting' => 4,
            'lazy' => 2,
            'relaxed' => 4,
            'artistic' => 4,
            'outgoing' => 2,
            'fault_finding' => 2,
            'thorough' => 4,
            'nervous' => 3,
            'imaginative' => 4,
            // Skills
            'interdisciplinary_collaboration' => 6,
            'online_communication' => 4,
            'conflict_resolution' => 5,
            'organised' => 5,
            'problem_solving' => 5,
            'tech_proficiency' => 5,
            'creativity' => 5,
            'adaptability' => 6,
            'leadership' => 4,
            'teaching_ability' => 5,
            // Learning style
            'learning_style' => 4,
        ]);

        $this->assertDatabaseHas('user_traits_record', [
            'profile_id' => $profile->profile_id,
            'wtc_data' => json_encode([
                'group_discussion' => 3.00,
                'meetings' => 3.00,
                'interpersonal_conversation' => 2.67,
                'public_speaking' => 3.67,
                'stranger' => 2.25,
                'colleague' => 3.25,
                'friend' => 3.75,
                'wtc_sum' => 3.08
            ]),
            'personality_data' => json_encode([
                'extraversion' => 3,
                'agreeableness' => 8,
                'conscientiousness' => 8,
                'neuroticism' => 5,
                'openness' => 6
            ]),
            'skills_data' => json_encode([
                'interdisciplinary_collaboration' => 6,
                'online_communication' => 4,
                'conflict_resolution' => 5,
                'organised' => 5,
                'problem_solving' => 5,
                'tech_proficiency' => 5,
                'creativity' => 5,
                'adaptability' => 6,
                'leadership' => 4,
                'teaching_ability' => 5,
            ]),
            'learning_style' => 4
        ]);

        $response->assertStatus(302);
    }
}
