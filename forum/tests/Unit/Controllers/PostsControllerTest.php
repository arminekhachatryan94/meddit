<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use App\Http\Controllers\PostsController;
use App\Contracts\PostContract;
use App\Contracts\UserContract;
use App\Post;
use App\User;
use App\Biography;
use App\UserRole;
use Mockery;

class PostControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $postService = null;
    protected $userService = null;
    protected $postsController = null;

    public function setUp()
    {
        parent::setUp();
        $this->postService = Mockery::spy(PostContract::class);
        $this->userService = Mockery::spy(UserContract::class);
        $this->postsController = new PostsController($this->postService, $this->userService);
    }

    /**
     * Test get all posts.
     *
     * @test
     */
    public function test_get_all_posts()
    {
        $user = factory(User::class, 1)->create()->first();
        $bio = factory(Biography::class, 1)->create(['user_id' => $user->id])->first();
        $role = factory(UserRole::class, 1)->create(['user_id' => $user->id])->first();

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

        $factory_posts = factory(Post::class, 1)->create(['user_id' => $user->id]);
        foreach($factory_posts as $post) {
            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ]);
        }

        $response = $this->call('GET', '/api/posts');
        $response->assertStatus(200);
    }
}
