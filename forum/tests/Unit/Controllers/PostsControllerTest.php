<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Faker;
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
    protected $faker = null;

    public function setUp()
    {
        parent::setUp();
        $this->postService = Mockery::spy(PostContract::class);
        $this->userService = Mockery::spy(UserContract::class);
        $this->postsController = new PostsController($this->postService, $this->userService);
        $this->faker = Faker\Factory::create();
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

        $factory_posts = factory(Post::class, 10)->create(['user_id' => $user->id]);
        $factory_posts = json_decode($factory_posts);
        usort($factory_posts, function($a, $b) {
            return strtotime($a->created_at) < strtotime($b->created_at);
        });

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

        $posts = json_decode($response->content())->posts;

        $this->assertEquals(count($factory_posts), count($posts));

        for($i = 0; $i < count($posts); $i++) {
            $this->assertEquals($factory_posts[$i]->id, $posts[$i]->id);
            $this->assertEquals($factory_posts[$i]->user_id, $posts[$i]->user_id);
            $this->assertEquals($factory_posts[$i]->title, $posts[$i]->title);
            $this->assertEquals($factory_posts[$i]->body, $posts[$i]->body);
            $this->assertEquals($factory_posts[$i]->created_at, $posts[$i]->created_at);
            $this->assertEquals($factory_posts[$i]->updated_at, $posts[$i]->updated_at);
        }
    }

    /**
     * Test get one post if posts exist.
     *
     * @test
     */
    public function test_get_one_post_if_posts_exist()
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

        $factory_posts = factory(Post::class, 10)->create(['user_id' => $user->id]);

        foreach($factory_posts as $factory_post) {
            $this->assertDatabaseHas('posts', [
                'id' => $factory_post->id,
                'user_id' => $factory_post->user_id,
                'title' => $factory_post->title,
                'body' => $factory_post->body,
                'created_at' => $factory_post->created_at,
                'updated_at' => $factory_post->updated_at
            ]);

            $response = $this->call('GET', '/api/posts/' . $factory_post->id);
            $response->assertStatus(200);

            $post = json_decode($response->content())->post;
        
            $this->assertEquals($factory_post->id, $post->id);
            $this->assertEquals($factory_post->user_id, $post->user_id);
            $this->assertEquals($factory_post->title, $post->title);
            $this->assertEquals($factory_post->body, $post->body);
            $this->assertEquals($factory_post->created_at, $post->created_at);
            $this->assertEquals($factory_post->updated_at, $post->updated_at);
        }
    }

    /**
     * Test get one post if posts exist.
     *
     * @test
     */
    public function test_get_one_post_if_posts_do_not_exist() {
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

        for($i = 11; $i <= 20; $i++) {
            $response = $this->call('GET', '/api/posts/' . $i);
            $response->assertStatus(404);
            $errors = json_decode($response->content());
            $response->assertJson([
                'errors' => [
                    'invalid' => "Post does not exist"
                ]
            ]);
        }
    }

    /**
     * Test create post successfully.
     *
     * @test
     */
    public function test_create_post_successfully()
    {
        $user = factory(User::class, 1)->create()->first();
        $bio = factory(Biography::class, 1)->create(['user_id' => $user->id])->first();
        $role = factory(UserRole::class, 1)->create(['user_id' => $user->id])->first();

        for($i = 0; $i < 20; $i++) {
            $post = factory(Post::class, 1)->make(['user_id' => $user->id])->first();
            $title = $this->faker->sentence;
            $body = $this->faker->sentence;

            $this->assertDatabaseMissing('posts', [
                'user_id' => $user->id,
                'title' => $title,
                'body' => $body,
            ]);
            $response = $this->json('POST', '/api/new-post', [
                'user_id' => $user->id,
                'title' => $title,
                'body' => $body
            ]);
            $response->assertStatus(201);
            $new_post = json_decode($response->content())->post;

            $this->assertDatabaseHas('posts', [
                'id' => $new_post->id,
                'user_id' => $user->id,
                'title' => $title,
                'body' => $body,
                'created_at' => $new_post->created_at,
                'updated_at' => $new_post->updated_at
            ]);
        }
    }


    /**
     * Test create post with errors in request.
     *
     * @test
     */
    public function test_create_post_with_errors_in_request()
    {
        $user = factory(User::class, 1)->create()->first();
        $bio = factory(Biography::class, 1)->create(['user_id' => $user->id])->first();
        $role = factory(UserRole::class, 1)->create(['user_id' => $user->id])->first();

        for($i = 0; $i < 20; $i++) {
            $userid_rand = rand(0, 1);
            $title_rand = rand(0, 1);
            $body_rand = rand(0, 1);

            $user_id = "";
            $title = "";
            $body = "";

            if($userid_rand) {
                $user_id = $user->id;
            }

            if($title_rand) {
                $title = $this->faker->sentence;
            }

            if($body_rand) {
                $body = $this->faker->sentence;
            }
            
            $this->assertDatabaseMissing('posts', [
                'user_id' => $user_id,
                'title' => $title,
                'body' => $body,
            ]);

            $response = $this->json('POST', '/api/new-post', [
                'user_id' => $user_id,
                'title' => $title,
                'body' => $body
            ]);

            if($userid_rand && $title_rand && $body_rand) {
                $response->assertStatus(201);
            } else {
                $response->assertStatus(400);
                $errors = json_decode($response->content())->errors;
                if(!$userid_rand) {
                    $userid_error = $errors->user_id[0];
                    $this->assertEquals($userid_error, 'The user id field is required.');
                }
                if(!$title_rand) {
                    $title_error = $errors->title[0];
                    $this->assertEquals($title_error, 'The title field is required.');
                }
                if(!$body_rand) {
                    $body_error = $errors->body[0];
                    $this->assertEquals($body_error, 'The body field is required.');
                }
            }
        }
    }
}
