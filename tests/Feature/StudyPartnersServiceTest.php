<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Account;
use App\Models\Profile;
use Tests\TestCase;
use App\Models\UserTraitsRecord;
use Illuminate\Support\Facades\Http;

class StudyPartnersServiceTest extends TestCase
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

    /**
     *
     * Test that the system can redirect the user to the correct page
     * based on whether or not they have filled the suggester form before.
     *
     * @return void
     */
    public function test_suggester_redirection(): void
    {
        /** @var \App\Models\Account $account */
        $account = Account::factory()->create(['account_role' => 1]);
        $profile = Profile::factory()->create(['account_id' => $account->account_id]);
        $this->actingAs($account);

        // Scenario 1: No UserTraitsRecord exists
        $response = $this->get(route('study-partners-suggester'));
        $response->assertRedirect(route('study-partners-suggester.suggester-form'));

        // Scenario 2: UserTraitsRecord exists; create the record then test redirection
        $this->createUserTraitsRecord($profile->profile_id);
        $response = $this->get(route('study-partners-suggester'));
        $response->assertRedirect(route('study-partners-suggester.suggester-results'));
    }

    /**
     * Test that the system can pass data to the ML model and receive data from it.
     *
     * @return void
     */
    public function test_call_and_run_ml_model(): void
    {
        // Create a UserTraitsRecord object which acts as the data of the logged in student
        /** @var \App\Models\Account $account */
        $account = Account::factory()->create(['account_role' => 1]);
        $profile = Profile::factory()->create(['account_id' => $account->account_id]);
        $this->actingAs($account);
        $ownTraitsRecord = $this->createUserTraitsRecord($profile->profile_id);

        // Create another UserTraitsRecord item which acts as data of another student for testing
        $otherStudentRecord = $this->createUserTraitsRecord();

        // Assert that both records exist in the database
        $this->assertDatabaseHas('user_traits_record', [
            'profile_id' => $ownTraitsRecord->profile_id
        ]);
        $this->assertDatabaseHas('user_traits_record', [
            'profile_id' => $otherStudentRecord->profile_id
        ]);

        Http::fake([
            'http://localhost:5000/recommendation-engine' => function () {
                return Http::response([
                    [
                        'profile_id' => 5,      // Mocked profile_id
                        'similarity' => 0.85,   // Mocked similarity score
                    ]
                ], 200);
            },
        ]);

        // Call the method that triggers the recommendation process
        $response = $this->get(route('study-partners-suggester.suggester-results'));

        // Assert that the HTTP request was sent with correct data
        Http::assertSent(function ($request) use ($ownTraitsRecord) {
            $sentData = $request->data();

            return $request->url() === 'http://localhost:5000/recommendation-engine' &&
            $sentData['user_traits_record']['profile_id'] === $ownTraitsRecord->profile_id &&
            isset($sentData['other_students_traits_records']) &&
            count($sentData['other_students_traits_records']) > 0;
        });

        // Assert the response
        $response->assertViewIs('study-partners-suggester.suggester-results');
        $response->assertViewHas('suggestions');
    }

    /**
     * Create a UserTraitsRecord object for testing.
     *
     * @return UserTraitsRecord
     */
    private function createUserTraitsRecord($profileId = null)
    {
        if ($profileId == null) {
            /** @var \App\Models\Account $account */
            $account = Account::factory()->create(['account_role' => 1]);
            $profile = Profile::factory()->create(['account_id' => $account->account_id]);
            $profileId = $profile->profile_id;
        }

        // Create a UserTraitsRecords item for testing
        return UserTraitsRecord::factory()->create([
            'profile_id' => $profileId,
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
    }
}
