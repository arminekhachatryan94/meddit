<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Contracts\PostContract;
use App\Services\PostService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;

class PostServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(){
        parent::setUp();
    }

    /**
     * Retrieve a post.
     *
     * @test
     */
    public function testGetPost()
    {
        $postService = new PostService();

        $user = (factory(User::class, 1)->create())->first();
        $posts = factory(Post::class, 5)->create(['user_id' => $user->id]);
    
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'username' => $user->username,
            'password' => $user->password,
            'remember_token' => $user->remember_token,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);

        foreach( $posts as $post ){
            
            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ]);

            $retrieve = $postService->getPost($post->id);
            $this->assertTrue($retrieve->title == $post->title);
            $this->assertTrue($retrieve->body == $post->body);
        }
    }
}
