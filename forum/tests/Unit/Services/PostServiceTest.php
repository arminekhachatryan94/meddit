<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\PostService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;

class PostServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $postService = null;

    public function setUp()
    {
        parent::setUp();
        $this->postService = new PostService();
    }

    /**
     * Create a post.
     *
     * @test
     */
    public function test_create_post()
    {
        $user = factory(User::class, 1)->create()->first();
        $posts = factory(Post::class, 10)->make(['user_id' => $user->id]);

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

        foreach( $posts as $post ){
            $this->assertDatabaseMissing('posts', [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ]);

            $this->postService->createPost($post);
            
            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ]);
        }
    }

    /**
     * Retrieve a post.
     *
     * @test
     */
    public function test_get_post()
    {
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

            $retrieve = $this->postService->getPost($post->id);
            $this->assertTrue($retrieve->title == $post->title);
            $this->assertTrue($retrieve->body == $post->body);
        }
    }

    /**
     * Retrieve all posts.
     *
     * @test
     */
    public function test_get_all_posts()
    {
        $user = factory(User::class, 1)->create()->first();
        $posts = factory(Post::class, 10)->create(['user_id' => $user->id]);
        $posts = json_decode($posts);
        usort($posts, function($a, $b) { // sort posts array in descending order of created_at
            return strtotime($a->created_at) < strtotime($b->created_at);
        });

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

        $db_posts = $this->postService->getAllPosts();

        for( $i = 0; $i < count($posts); $i++ ){
            $this->assertDatabaseHas('posts', [
                'id' => $posts[$i]->id,
                'user_id' => $posts[$i]->user_id,
                'title' => $posts[$i]->title,
                'body' => $posts[$i]->body,
                'created_at' => $posts[$i]->created_at,
                'updated_at' => $posts[$i]->updated_at
            ]);

            $this->assertEquals($db_posts[$i]->id, $posts[$i]->id);
            $this->assertEquals($db_posts[$i]->user_id, $posts[$i]->user_id);
            $this->assertEquals($db_posts[$i]->title, $posts[$i]->title);
            $this->assertEquals($db_posts[$i]->body, $posts[$i]->body);

            if( $i > 0 ){
                $this->assertTrue(strtotime($posts[$i-1]->created_at) > strtotime($posts[$i]->created_at));
            }
        }
    }

    /**
     * Edit a post.
     *
     * @test
     */
    public function test_edit_post()
    {
        $user = factory(User::class, 1)->create()->first();
        $posts = factory(Post::class, 10)->create(['user_id' => $user->id]);

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

            $oldpost = Post::where('id', $post->id)->first();

            $req = [
                'title' => 'example title',
                'body' => 'example body'
            ];
            
            $this->postService->editPost($post, $req);

            $this->assertDatabaseMissing('posts', [
                'id' => $oldpost->id,
                'user_id' => $oldpost->user_id,
                'title' => $oldpost->title,
                'body' => $oldpost->body,
                'created_at' => $oldpost->created_at,
                'updated_at' => $oldpost->updated_at
            ]);
            
            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ]);
        }
    }

    /**
     * Delete a post.
     *
     * @test
     */
    public function test_delete_post()
    {
        $user = factory(User::class, 1)->create()->first();
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
        
        $posts = factory(Post::class, 10)->create(['user_id' => $user->id]);

        foreach( $posts as $post ){
            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ]);

            $this->postService->deletePost($post);

            $this->assertDatabaseMissing('posts', [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ]);
        }
    }

    /**
     * Test exists post.
     * 
     * @test
     */
    public function test_exists_post()
    {
        $user = factory(User::class, 1)->create()->first();
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

        $posts = factory(Post::class, 10)->make(['user_id' => $user->id]);

        foreach($posts as $post){
            $this->assertDatabaseMissing('posts', [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]);

            $exists = $this->postService->existsPost($post->id);
            $this->assertFalse($exists);

            $post->save();

            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ]);

            $exists = $this->postService->existsPost($post->id);
            $this->assertTrue($exists);
        }
    }
}
