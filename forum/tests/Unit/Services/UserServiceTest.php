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

    public function test_get_users_except()
    {
        $userService = new UserService();

        $user = factory(User::class, 1)->create()->first();
        $users = factory(User::class, 5)->create();

        $getUsers = $userService->getUsersExcept($user->id);

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

        for( $i = 0; $i < count($users); $i++ ){
            $this->assertDatabaseHas('users', [
                'id' => $users[$i]->id,
                'first_name' => $users[$i]->first_name,
                'last_name' => $users[$i]->last_name,
                'email' => $users[$i]->email,
                'username' => $users[$i]->username,
                'password' => $users[$i]->password,
                'created_at' => $users[$i]->created_at,
                'updated_at' => $users[$i]->updated_at
            ]);

            $this->assertEquals($users[$i]->id, $getUsers[$i]->id);
            $this->assertEquals($users[$i]->first_name, $getUsers[$i]->first_name);
            $this->assertEquals($users[$i]->last_name, $getUsers[$i]->last_name);
            $this->assertEquals($users[$i]->email, $getUsers[$i]->email);
            $this->assertEquals($users[$i]->username, $getUsers[$i]->username);
            $this->assertEquals($users[$i]->password, $getUsers[$i]->password);
            $this->assertEquals($users[$i]->created_at, $getUsers[$i]->created_at);
            $this->assertEquals($users[$i]->updated_at, $getUsers[$i]->updated_at);

            $this->assertFalse($user->id == $getUsers[$i]->id);
            $this->assertFalse($user->first_name == $getUsers[$i]->first_name);
            $this->assertFalse($user->last_name == $getUsers[$i]->last_name);
            $this->assertFalse($user->email == $getUsers[$i]->email);
            $this->assertFalse($user->username == $getUsers[$i]->username);
            $this->assertFalse($user->password == $getUsers[$i]->password);
            $this->assertFalse($user->created_at == $getUsers[$i]->created_at);
        }
    }
}
