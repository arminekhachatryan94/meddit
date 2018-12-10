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
     * Test get comment
     * 
     * @test
     */
    public function test_get_comment()
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

                $get_comment = $this->commentService->getComment($comment->id);
                $this->assertEquals($get_comment->id, $comment->id);
                $this->assertEquals($get_comment->user_id, $comment->user_id);
                $this->assertEquals($get_comment->post_id, $comment->post_id);
                $this->assertEquals($get_comment->comment_id, $comment->comment_id);
                $this->assertEquals($get_comment->body, $comment->body);
                $this->assertEquals($get_comment->created_at, $comment->created_at);
                $this->assertEquals($get_comment->updated_at, $comment->updated_at);

            }
        }
    }

    /**
     * Test create comment.
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
     * Test edit comment.
     */
    public function test_edit_comment()
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

                $req = [
                    'body' => 'example body'
                ];

                $this->commentService->editComment($comment, $req['body']);

                $this->assertDatabaseHas('comments', [
                    'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'post_id' => $comment->post_id,
                    'comment_id' => $comment->comment_id,
                    'body' => $comment->body,
                    // 'created_at' => $new_comment->created_at,
                    // 'updated_at' => $new_comment->updated_at
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
