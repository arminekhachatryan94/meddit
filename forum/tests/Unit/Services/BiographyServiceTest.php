<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\BiographyService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Biography;
use App\User;

class BiographyServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $biographyService = null;

    public function setUp()
    {
        $this->biographyService = new BiographyService();
        parent::setUp();
    }

    /**
     * Test get biography
     * 
     * @test
     */
    public function test_get_biography()
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

            $biography = factory(Biography::class, 1)->create(['user_id' => $user->id])->first();

            $this->assertDatabaseHas('biographies', [
                'id' => $biography->id,
                'user_id' => $biography->user_id,
                'description' => $biography->description,
                'created_at' => $biography->created_at,
                'updated_at' => $biography->updated_at
            ]);
        }
    }
}
