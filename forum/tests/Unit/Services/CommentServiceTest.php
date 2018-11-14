<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CommentService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;
use App\Comment;

class CommentServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $commentService = null;

    public function setUp()
    {
        parent::setUp();
        $this->commentService = new CommentService();
    }

    /**
     * Create a comment.
     *
     * @test
     */
    public function test_create_comment()
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

            $comments = factory(Comment::class, 10)->make(['user_id' => $user->id]);
            foreach( $comments as $comment ){
                $this->assertDatabaseMissing('comments', [
                    'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'post_id' => $comment->post_id,
                    'comment_id' => $comment->comment_id,
                    'body' => $comment->body,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at
                ]);

                $this->commentService->createComment(array(
                    'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'post_id' => $comment->post_id,
                    'comment_id' => $comment->comment_id,
                    'body' => $comment->body,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at
                ));

                $this->assertDatabaseHas('comments', [
                    // 'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'post_id' => $comment->post_id,
                    'comment_id' => $comment->comment_id,
                    'body' => $comment->body,
                    // 'created_at' => $comment->created_at,
                    // 'updated_at' => $comment->updated_at
                ]);
            }
        }
    }

    /**
     * Test delete comment.
     * 
     * @test
     */
    public function test_delete_comment()
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

            $comments = factory(Comment::class, 10)->create(['user_id' => $user->id]);
            foreach( $comments as $comment ){                
                $this->assertDatabaseHas('comments', [
                    'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'post_id' => $comment->post_id,
                    'comment_id' => $comment->comment_id,
                    'body' => $comment->body,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at
                ]);

                $this->commentService->deleteComment($comment);

                $this->assertDatabaseMissing('comments', [
                    'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'post_id' => $comment->post_id,
                    'comment_id' => $comment->comment_id,
                    'body' => $comment->body,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at
                ]);
            }
        }
    }

    /**
     * Test exists comment.
     * 
     * @test
     */
    public function test_exists_comment()
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

            $comments = factory(Comment::class, 10)->create(['user_id' => $user->id]);
            foreach( $comments as $comment ){
                $this->assertTrue($this->commentService->existsComment($comment->id));
                
                $this->assertDatabaseHas('comments', [
                    'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'post_id' => $comment->post_id,
                    'comment_id' => $comment->comment_id,
                    'body' => $comment->body,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at
                ]);
            }
        }
    }
}
