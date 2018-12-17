<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use App\Biography;
use Faker;

class SettingsControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker = null;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker\Factory::create();
    }

    /**
     * Test get settings successfully
     * 
     * @test
     */
    public function test_get_settings_successfully()
    {
        for($i = 0; $i < 20; $i++) {
            $user = factory(User::class, 1)->create()->first();
            $role = factory(UserRole::class, 1)->create(['user_id' => $user->id])->first();
            $bio = factory(Biography::class, 1)->create(['user_id' => $user->id])->first();

            $this->assertDatabaseHas('users', [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'username' => $user->username,
                'password' => $user->password,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]);

            $this->assertDatabaseHas('biographies', [
                'id' => $bio->id,
                'user_id' => $bio->user_id,
                'description' => $bio->description,
                'created_at' => $bio->created_at,
                'updated_at' => $bio->updated_at
            ]);

            $response = $this->call('GET', '/api/' . $user->id . '/settings');
            $response->assertStatus(201);
            $response_user = json_decode($response->content())->user;

            $this->assertEquals($user->id, $response_user->id);
            $this->assertEquals($user->first_name, $response_user->first_name);
            $this->assertEquals($user->last_name, $response_user->last_name);
            $this->assertEquals($user->email, $response_user->email);
            $this->assertEquals($user->username, $response_user->username);
            $this->assertEquals($user->created_at, $response_user->created_at);
            $this->assertEquals($user->updated_at, $response_user->updated_at);
        }
    }

    /**
     * Test get settings if user does not exist
     * 
     * @test
     */
    public function test_get_settings_if_user_does_not_exist()
    {
        for($i = 0; $i < 20; $i++) {
            $response = $this->call('GET', '/api/' . $i . '/settings');
            $response->assertStatus(404);
            $errors = json_decode($response->content())->errors;
            $this->assertEquals($errors->invalid, "User does not exist");
        }
    }

    /**
     * Test update username with empty request
     * 
     * @test
     */
    public function test_update_username_with_empty_request()
    {
        for($i = 0; $i < 20; $i++) {
            $user = factory(User::class, 1)->create()->first();
            $role = factory(UserRole::class, 1)->create(['user_id' => $user->id])->first();
            $bio = factory(Biography::class, 1)->create(['user_id' => $user->id])->first();

            $response = $this->call('PUT', '/api/' . $user->id . '/settings/username', [
                'username' => '',
                'password' => ''
            ]);
            $response->assertStatus(401);
            $errors = json_decode($response->content())->errors;
            $username_error = $errors->username[0];
            $password_error = $errors->password[0];
            $this->assertEquals($username_error, "The username field is required.");
            $this->assertEquals($password_error, "The password field is required.");
        }
    }

    /**
     * Test update username with invalid credentials
     * 
     * @test
     */
    public function test_update_username_with_invalid_credentials() {
        for($i = 1; $i <= 20; $i++) {
            $response = $this->call('PUT', '/api/' . $i . '/settings/username', [
                'username' => $this->faker->username,
                'password' => $this->faker->sentence
            ]);
            $response->assertStatus(401);
            $invalid = json_decode($response->content())->invalid;
            $this->assertEquals($invalid, "Invalid credentials");
        }
    }
}
