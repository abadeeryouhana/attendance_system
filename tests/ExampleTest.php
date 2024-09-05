<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Attendance;
use Carbon\Carbon;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function test_that_base_endpoint_returns_a_successful_response()
    // {
    //     $this->get('/');

    //     $this->assertEquals(
    //         $this->app->version(), $this->response->getContent()
    //     );
    // }

    public function testCheckInStoresCorrectTimestamp()
    {
        // Arrange: Set a mock user (Assume user with ID 1 exists)
        $userId = 1;

        // Set the current time to a specific value for consistency in testing
        $checkInTime = Carbon::now();
        Carbon::setTestNow($checkInTime); // Freeze the time

        // Act: Simulate a POST request to the check-in endpoint
        $response = $this->post('/attend/check_in', ['user_id' => $userId]);

        // Assert: Check if the response status is 200 (or appropriate success code)
        $response->seeStatusCode(200);

        // Assert: Check if the database has an entry for this check-in with the correct timestamp
        $this->seeInDatabase('attendances', [
            'user_id' => $userId,
            'check_in_time' => $checkInTime->toDateTimeString(),
        ]);
    }

}
