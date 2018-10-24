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
    

    /**
     * Get a user.
     *
     * @test
     */
    public function test_get_user()
    {
        $userService = new UserService();

        $users = factory(User::class, 5)->create();

        foreach( $users as $user ){
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

            $getUser = $userService->getUser($user->id);
            $this->assertEquals($user->id, $getUser->id);
            $this->assertEquals($user->first_name, $getUser->first_name);
            $this->assertEquals($user->last_name, $getUser->last_name);
            $this->assertEquals($user->email, $getUser->email);
            $this->assertEquals($user->username, $getUser->username);
            $this->assertEquals($user->password, $getUser->password);
            $this->assertEquals($user->created_at, $getUser->created_at);
            $this->assertEquals($user->updated_at, $getUser->updated_at);
        }
    }

    public function test_get_user_with_email()
    {
        $userService = new UserService();

        $users = factory(User::class, 5)->create();

        foreach( $users as $user ){
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

            $getUser = $userService->getUserWithEmail($user->email);
            $this->assertEquals($user->id, $getUser->id);
            $this->assertEquals($user->first_name, $getUser->first_name);
            $this->assertEquals($user->last_name, $getUser->last_name);
            $this->assertEquals($user->email, $getUser->email);
            $this->assertEquals($user->username, $getUser->username);
            $this->assertEquals($user->password, $getUser->password);
            $this->assertEquals($user->created_at, $getUser->created_at);
            $this->assertEquals($user->updated_at, $getUser->updated_at);
        }
    }
}
