<?php
namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test login with valid data.
     *
     * @return void
     */
    public function testLoginSuccessfully()
    {
        $data = [
            'user_id'  => 'user123456',
            'password' => '123465',
        ];

        $response = $this->post('auth/login', $data);
        $response->seeStatusCode(200);
        $response->seeJsonStructure([['*'=>'auth_token']]);


    }

    /**
     * Test login with invalid data.
     *
     * @return void
     */
    public function testLoginFailsValidation()
    {
        $data = [
            'name' => 'user123456',
        ];

        $response = $this->post('auth/login', $data);

        $response->seeStatusCode(422);
        $response->seeJsonStructure(['errors','error_code']);
    }
}
