<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\BiographyService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Biography;
use App\User;
use Faker\Factory;

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
     * Test create biography
     * 
     * @test
     */
    public function test_create_biography()
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

            $biography = $this->biographyService->createBiography($user->id);

            $this->assertDatabaseHas('biographies', [
                'id' => $biography->id,
                'user_id' => $user->id,
                'description' => '',
                'created_at' => $biography->created_at,
                'updated_at' => $biography->updated_at
            ]);
        }
    }

    /*
     * Test get biography
     * 
     * @test
     */
    public function test_get_biography() {
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

            $get_bio = $this->biographyService->getBiography($user->id);

            $this->assertEquals($biography->id, $get_bio->id);
            $this->assertEquals($biography->user_id, $get_bio->user_id);
            $this->assertEquals($biography->description, $get_bio->description);
            $this->assertEquals($biography->created_at, $get_bio->created_at);
            $this->assertEquals($biography->updated_at, $get_bio->updated_at);
        }
    }

    /**
     * Test save biography
     * 
     * @test
     */
    public function test_save_biography() {
        for( $i = 0; $i < 10; $i++ ){
            $faker = Factory::create();
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

            $description = $faker->sentence;
            $this->biographyService->saveBiography($biography, $description);

            $this->assertDatabaseHas('biographies', [
                'id' => $biography->id,
                'user_id' => $biography->user_id,
                'description' => $description,
                'created_at' => $biography->created_at,
                'updated_at' => $biography->updated_at
            ]);
        }
    }
}
