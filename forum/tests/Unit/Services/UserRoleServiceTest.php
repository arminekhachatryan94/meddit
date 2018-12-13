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
}
