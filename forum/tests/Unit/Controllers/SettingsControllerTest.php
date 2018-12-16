<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use App\Biography;

class SettingsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test get settings successfully
     * 
     * @test
     */
    public function test_get_settings_successfully() {
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
}
