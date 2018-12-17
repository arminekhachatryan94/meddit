<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Faker;
use App\User;
use App\Biography;
use App\UserRole;

class PostControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker = null;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker\Factory::create();
    }

    /**
     * Test login with empty request
     * 
     * @test
     */
    public function test_login_with_empty_request()
    {
        for($i = 0; $i < 20; $i++) {
            $response = $this->call('POST', '/api/login', [
                'email' => '',
                'password' => ''
            ]);
            $response->assertStatus(401);

            $errors = json_decode($response->content())->errors;
            $email_error = $errors->email[0];
            $password_error = $errors->password[0];

            $this->assertEquals($email_error, "The email field is required.");
            $this->assertEquals($password_error, "The password field is required.");
        }
    }

    /**
     * Test login with invalid credentials
     * 
     * @test
     */
    public function test_login_with_invalid_credentials()
    {
        for($i = 0; $i < 20; $i++) {
            $email = $this->faker->email;
            $password = $this->faker->password;

            $response = $this->call('POST', '/api/login', [
                'email' => $email,
                'password' => $password
            ]);
            $response->assertStatus(404);

            $errors = json_decode($response->content())->errors;

            $this->assertEquals($errors->invalid, "Invalid credentials. Please try again.");
        }
    }
}
