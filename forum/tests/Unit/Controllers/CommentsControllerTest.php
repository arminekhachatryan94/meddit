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
     * Test get create comment on post successfully.
     *
     * @test
     */
    public function test_create_comment_on_post_successfully()
    {
        $user = factory(User::class, 1)->create()->first();
        $role = factory(UserRole::class, 1)->create(['user_id' => $user->id])->first();
        $bio = factory(Biography::class, 1)->create(['user_id' => $user->id])->first();
        $post = factory(Post::class, 1)->create(['user_id' => $user->id])->first();
        
        for($j = 0; $j <= 20; $j++) {
            $comment = factory(Comment::class, 1)->make(['user_id' => $user->id, 'post_id' => $post->id])->first();

            $response = $this->call('POST', '/api/posts/' . $post->id . '/new-comment', [
                'user_id' => $comment->user_id,
                'post_id' => $comment->post_id,
                'comment_id' => $comment->comment_id,
                'body' => $comment->body
            ]);

            $response->assertStatus(201);
            
            $response_comment = json_decode($response->content())->comment;
            $response_user = $response_comment->user;
            $response_comments = $response_comment->comments;

            $this->assertEquals($response_comment->user_id, $comment->user_id);
            $this->assertEquals($response_comment->post_id, $comment->post_id);
            $this->assertEquals($response_comment->comment_id, $comment->comment_id);
            $this->assertEquals($response_comment->body, $comment->body);

            $this->assertEquals($response_user->id, $user->id);
            $this->assertEquals($response_user->first_name, $user->first_name);
            $this->assertEquals($response_user->last_name, $user->last_name);
            $this->assertEquals($response_user->username, $user->username);
            $this->assertEquals($response_user->email, $user->email);
            $this->assertEquals($response_user->created_at, $user->created_at);
            $this->assertEquals($response_user->updated_at, $user->updated_at);

            $this->assertTrue(count($response_comments) == 0);

            $this->assertDatabaseHas('comments', [
                'user_id' => $comment->user_id,
                'post_id' => $comment->post_id,
                'comment_id' => NULL,
                'body' => $comment->body
            ]);
        }
    }
}
