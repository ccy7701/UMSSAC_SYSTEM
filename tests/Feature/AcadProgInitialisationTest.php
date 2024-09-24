<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Account;
use App\Models\Profile;
use App\Models\SemesterProgressLog;
use Tests\TestCase;

class AcadProgInitialisationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the initialisation form submission for the progress tracker view works.
     *
     * @return void
     */
    public function test_progress_tracker_initialisation(): void
    {
        // Simulate creating an account and related profile
        /** @var \App\Models\Account $account */
        $account = Account::factory()->create();
        $profile = Profile::factory()->create(['account_id' => $account->account_id]);

        // Log in the user using the Account model
        $this->actingAs($account);

        // Simulate a POST request to initialise the form
        $response = $this->post(route('progress-tracker.initialise', ['profile_id' => $profile->profile_id]), [
            'profile_enrolment_session' => '2023/2024',
            'course_duration' => '8',
        ]);

        // Assert that the account-profile relationship is working as expected
        $this->assertEquals($profile->account_id, $account->account_id);

        // Assert that the SemesterProgressLogs have been created
        $this->assertEquals(8, SemesterProgressLog::where('profile_id', $profile->profile_id)->count());

        // Assert that the SemesterProgressLogs have the correct academic sessions
        $this->assertEquals(2, SemesterProgressLog::where('academic_session', '2023/2024')->count());
        $this->assertEquals(2, SemesterProgressLog::where('academic_session', '2024/2025')->count());
        $this->assertEquals(2, SemesterProgressLog::where('academic_session', '2025/2026')->count());
        $this->assertEquals(2, SemesterProgressLog::where('academic_session', '2026/2027')->count());

        // Assert that the response is a redirect
        $response->assertStatus(302);
    }
}
