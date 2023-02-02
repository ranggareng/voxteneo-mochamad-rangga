<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_render_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registered_user_can_login()
    {
        $email = $this->faker->email;

        \Http::post(env('APP_API_URL').'/api/v1/users', [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $email,
            'password' => 'Secret123!',
            'repeatPassword' => 'Secret123!' 
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $email,
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect('/home');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_error_all_empty()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => '',
            'password' => ''
        ]);

        $response->assertRedirect('/login');
        $response->assertInvalid([
            'email',
            'password',
        ]);
    }
}
