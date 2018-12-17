<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Faker;
use App\Post;
use App\User;
use App\Comment;
use App\Biography;
use App\UserRole;

class CommentsControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker = null;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker\Factory::create();
    }

    /**
     * Test get all posts with comments.
     *
     * @test
     */
    public function test_get_all_posts_with_comments()
    {
        $this->assertTrue(true);
    }
}
