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
            // WTC form data
            'stranger_presenting' => 5,
            'colleague_in_line' => 4,
            'friend_talking_large' => 3,
            'stranger_talking_small' => 2,
            'friend_in_line' => 4,
            'colleague_talking_large' => 5,
            'stranger_in_line' => 3,
            'friend_presenting' => 4,
            'colleague_talking_small' => 2,
            'stranger_talking_large' => 5,
            'friend_talking_small' => 3,
            'colleague_presenting' => 5,
            // BFI personality data
            'reserved' => 4,
            'trusting' => 3,
            'lazy' => 2,
            'relaxed' => 4,
            'artistic' => 5,
            'outgoing' => 4,
            'fault_finding' => 2,
            'thorough' => 5,
            'nervous' => 3,
            'imaginative' => 5,
            // Skills form data
            'interdisciplinary_collaboration' => 1,
            'online_communication' => 1,
            'conflict_resolution' => 1,
            'organised' => 1,
            'problem_solving' => 1,
            'tech_proficiency' => 1,
            'creativity' => 1,
            'adaptability' => 1,
            'leadership' => 1,
            'teaching_ability' => 1,
            // Learning style
            'learning_style' => 2,
        ]);

        $this->assertDatabaseHas('user_traits_record', [
            'profile_id' => $profile->profile_id,
            'learning_style' => 2,
        ]);

        $response->assertStatus(302);
    }
}
