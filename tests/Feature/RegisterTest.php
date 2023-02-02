<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_render_page()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_register()
    {
        $response = $this->from('/register')->post('/register', [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => 'Secret123!',
            'repeatPassword' => 'Secret123!' 
        ]);

        $response->assertRedirect('/register');
        $response->assertValid();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_error_all_empty()
    {
        $response = $this->from('/register')->post('/register', [
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'password' => '',
            'repeatPassword' => '' 
        ]);

        $response->assertRedirect('/register');
        $response->assertInvalid([
            'firstName',
            'lastName',
            'email',
            'password',
            'repeatPassword'
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_error_duplicate_email()
    {
        $email = $this->faker->email;

        \Http::post(env('APP_API_URL').'/api/v1/users', [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $email,
            'password' => 'Secret123!',
            'repeatPassword' => 'Secret123!' 
        ]);

        $response = $this->from('/register')->post('/register', [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $email,
            'password' => 'Secret123!',
            'repeatPassword' => 'Secret123!' 
        ]);

        $response->assertRedirect('/register');
        $response->assertInvalid([
            'email'
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_error_wrong_password_format()
    {
        $response = $this->from('/register')->post('/register', [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => 'secret',
            'repeatPassword' => 'secret' 
        ]);

        $response->assertRedirect('/register');
        $response->assertInvalid([
            'password'
        ]);
    }

     /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_error_different_password()
    {
        $response = $this->from('/register')->post('/register', [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => 'Secret1!',
            'repeatPassword' => 'Secret2!'
        ]);

        $response->assertRedirect('/register');
        $response->assertInvalid([
            'repeatPassword'
        ]);
    }
}
