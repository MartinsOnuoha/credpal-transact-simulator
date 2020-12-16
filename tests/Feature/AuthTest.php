<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testlandingPage()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testRegisterValidation()
    {
        $response = $this->postJson('/auth/register', []);
        $response->assertStatus(422);
    }
    // add every other params correctly except email
    public function testRegisterEmailRequired()
    {

        $response = $this->postJson('/auth/register', [
            'fullname' => 'my full name',
            'password' => 'mypassword',
            'password_confirmation' => 'mypassword'
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "message" => 'The given data was invalid.',
                "errors" => [
                    "email" => [
                        "The email field is required."
                    ]
                ]
            ]);
    }
    // add every other params correctly except password
    public function testRegisterPasswordRequired()
    {
        $response = $this->postJson('/auth/register', [
            'fullname' => 'my full name',
            'email' => 'mars@app.com',
            'password_confirmation' => 'mypassword'
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "message" => 'The given data was invalid.',
                "errors" => [
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ]);
    }
    // add every other params correctly except fullname
    public function testRegisterFullnameRequired()
    {
        $response = $this->postJson('/auth/register', [
            'email' => 'mars@app.com',
            'password' => 'mypassword',
            'password_confirmation' => 'mypassword'
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "message" => 'The given data was invalid.',
                "errors" => [
                    "fullname" => [
                        "The fullname field is required."
                    ]
                ]
            ]);
    }
    // add every other params correctly except password confirmation
    public function testPasswordMustBeConfirmed()
    {
        $response = $this->postJson('/auth/register', [
            'email' => 'mars@app.com',
            'fullname' => 'my full name',
            'password' => 'mypassword',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                "message" => 'The given data was invalid.',
                "errors" => [
                    "password" => [
                        "The password confirmation does not match."
                    ]
                ]
            ]);
    }

    public function testAccountIsCreated()
    {
        $response = $this->postJson('/auth/register', [
            'email' => 'mars@app.com',
            'fullname' => 'my full name',
            'password' => 'mypassword',
            'password_confirmation' => 'mypassword'
        ]);

        $response->assertStatus(201);
    }

    public function testLoginEmailRequired()
    {
        $response = $this->postJson('/auth/login', [
            'password' => 'qqqqqq'
        ]);

        $response->assertStatus(422)
            ->assertJson([
                "message" => 'The given data was invalid.',
                "errors" => [
                    "email" => [
                        "The email field is required."
                    ]
                ]
            ]);
    }

    public function testLoginPasswordRequired()
    {
        $response = $this->postJson('/auth/login', [
            'email' => 'mars@app.com'
        ]);

        $response->assertStatus(422)
            ->assertJson([
                "message" => 'The given data was invalid.',
                "errors" => [
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ]);
    }

}
