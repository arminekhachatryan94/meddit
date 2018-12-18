<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\UserRoleService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\UserRole;
use Faker\Factory;

class UserRoleServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $userRoleService = null;

    public function setUp()
    {
        $this->userRoleService = new UserRoleService();
        parent::setUp();
    }

    /**
     * Test create user role
     * 
     * @test
     */
    public function test_create_user_role()
    {
        for( $i = 0; $i < 10; $i++ ){
            $user = factory(User::class, 1)->create()->first();

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

            $userrole = $this->userRoleService->createUserRole($user->id);

            $this->assertDatabaseHas('user_roles', [
                'id' => $userrole->id,
                'user_id' => $userrole->user_id,
                'role' => 0,
                'created_at' => $userrole->created_at,
                'updated_at' => $userrole->updated_at
            ]);
        }
    }

    /**
     * Test create user role
     * 
     * @test
     */
    public function test_get_user_role()
    {
        for( $i = 0; $i < 10; $i++ ){
            $user = factory(User::class, 1)->create()->first();

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

            $role = factory(UserRole::class, 1)->create(['user_id' => $user->id])->first();

            $this->assertDatabaseHas('user_roles', [
                'id' => $role->id,
                'user_id' => $role->user_id,
                'role' => $role->role,
                'created_at' => $role->created_at,
                'updated_at' => $role->updated_at
            ]);

            $userrole = $this->userRoleService->getUserRole($user->id);

            $this->assertEquals($role->id, $userrole->id);
            $this->assertEquals($role->user_id, $userrole->id);
            $this->assertEquals($role->role, $userrole->role);
            $this->assertEquals($role->created_at, $userrole->created_at);
            $this->assertEquals($role->updated_at, $userrole->updated_at);
        }
    }

    /**
     * Test update user role
     * 
     * @test
     */
    public function test_update_user_role()
    {
        for( $i = 0; $i < 10; $i++ ){
            $user = factory(User::class, 1)->create()->first();

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

            $role = factory(UserRole::class, 1)->create(['user_id' => $user->id])->first();

            $this->assertDatabaseHas('user_roles', [
                'id' => $role->id,
                'user_id' => $role->user_id,
                'role' => $role->role,
                'created_at' => $role->created_at,
                'updated_at' => $role->updated_at
            ]);

            $rand_role = rand(0, 10)%2;
            $userrole = $this->userRoleService->updateUserRole($role, $rand_role);

            $this->assertTrue($userrole);
            $this->assertDatabaseHas('user_roles', [
                'id' => $role->id,
                'user_id' => $role->user_id,
                'role' => $rand_role,
                'created_at' => $role->created_at,
                'updated_at' => $role->updated_at
            ]);
        }
    }
}
