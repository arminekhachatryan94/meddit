<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Create a user.
     *
     * @test
     */
    public function test_create_user()
    {
        $userService = new UserService();

        $users = factory(User::class, 5)->make();
        
        foreach( $users as $user ){
            $this->assertDatabaseMissing('users', [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'username' => $user->username,
                'password' => $user->password,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]);

            $user = $userService->createUser(array(
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'username' => $user->username,
                'password' => $user->password,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ));

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
        }
    }
}
