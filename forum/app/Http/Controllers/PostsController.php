<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Comment;
use App\UserRole;
use Validator;

use App\Contracts\PostContract;

class PostsController extends Controller
{
    protected $postRetriever = null;

    public function __construct(PostContract $postRetriever){
        $this->postRetriever = $postRetriever;
    }

    protected function comments(Comment $comment) {
        $comment->comments;
        $comment->user;
        if( count($comment->comments) ){
            foreach ($comment->comments as $comment1) {
                $this->comments($comment1);
            }
        }
    }

    public function posts() {
        $posts = Post::orderBy('created_at', 'desc')->get();
        foreach ( $posts as $post){
            $post->user;
            $post->comments;
            foreach ($post->comments as $comment ){
                $this->comments($comment);
            }
        }

        return response()->json([
            'posts' => $posts
        ], 201);
    }

    public function post($id) {
        $post = Post::where('id', $id)->first();
        if( !$post ){
            return response()->json([
                'errors' => [
                    'invalid' => 'Post does not exist'
                ]
            ], 401);
        } else {
            $post->comments;
            $post->user;
            foreach ($post->comments as $comment ){
                $this->comments($comment);
            }
            return response()->json([
                'post' => $post
            ], 201);
        }
    }

    public function create(Request $request) {
        $data = [
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title'),
            'body' => $request->input('body')
        ];
        
        return $this->postRetriever->createPost($data);
    }

    public function edit(Request $request, $id) {
        $data = [
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title'),
            'body' => $request->input('body')
        ];

        return $this->postRetriever->editPost($data, $id);
    }

    public function delete(Request $request, $id) {
        $data = [
            'user_id' => $request->input('user_id')
        ];

        return $this->postRetriever->deletePost($data, $id);
    }
}
