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
        $account = Account::factory()->create(['account_role' => 1]);
        $profile = Profile::factory()->create(['account_id' => $account->account_id]);

        // Log in the user using the Account model
        $this->actingAs($account);

        // Simulate a POST request to initialise the form
        $response = $this->post(route('progress-tracker.initialise', ['profile_id' => $profile->profile_id]), [
            'profile_enrolment_session' => '2022/2023',
            'course_duration' => '10',
        ]);

        // Assert that the account-profile relationship is working as expected
        $this->assertEquals($profile->account_id, $account->account_id);

        // Assert that there are unique entries with the correct academic sessions and semesters
        for ($i = 1; $i <= 6; $i++) {
            $academicSession = match ($i) {
                1, 2 => '2022/2023',
                3, 4 => '2023/2024',
                5, 6 => '2024/2025',
                7, 8 => '2025/2026',
                8, 9 => '2026/2027',
            };
            $semester = ($i % 2 === 0) ? 2 : 1;

            $this->assertDatabaseHas('semester_progress_log', [
                'academic_session' => $academicSession,
                'semester' => $semester,
            ]);
        }

        // Assert that there are exactly N desired unique entries in total
        $this->assertEquals(10, SemesterProgressLog::count());

        // Assert that the response is a redirect
        $response->assertStatus(302);
    }
}
