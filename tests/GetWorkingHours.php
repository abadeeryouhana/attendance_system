<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GetWorkingHours extends TestCase
{
    // If your test involves database transactions, you can use DatabaseMigrations
    // or DatabaseTransactions traits for a clean slate before each test.

    public function testGetWorkingHours()
    {
        // Send a GET request to the /items route
        $response = $this->get('attend/get_working_hours');

        // Assert that the response status is 200 OK
        $response->assertResponseStatus(200);

        // Optionally, assert the structure or content of the response
        $response->seeJsonStructure([
            '*' => [
                'status',
                'message',
                'total_number_of_hours'

            ]
        ]);
    }
}
