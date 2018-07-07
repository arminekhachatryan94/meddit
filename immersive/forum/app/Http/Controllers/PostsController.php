<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Comment;
use App\UserRole;
use Validator;

class PostsController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'required|max:255',
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255'
        ]);
    }
    
    protected function save(array $data)
    {
        return Post::create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'body' => $data['body']
        ]);
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
        $errors = $this->validator($request->all())->errors();
        if( count($errors) == 0 ){
            $post = User::where('id', $request->input('user_id'))->exists();
            if( $post ){
                $newpost = $this->save($request->all());
                $newpost->comments;
                $newpost->user;
                return response()->json([ 'post' => $newpost ], 201);
            } else {
                return response()->json([
                    'errors' => [
                        'invalid' => 'User does not exist'
                    ]
                ], 401);
            }
        } else {
            return response()->json([ 'errors' => $errors ], 401);
        };
    }

    public function edit(Request $request, $id) {
        $req = [
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title'),
            'body' => $request->input('body')
        ];

        $post = Post::find($id);
        if( $post ){
            $errors = $this->validator($request->all())->errors();
            if( count($errors) ) {
                return response()->json([
                    'errors' => $errors
                ], 401);
            } else {
                if( $post->user_id == $request->input('user_id') ){
                    $post->title = $request->input('title');
                    $post->body = $request->input('body');
                    $post->save();
                    return response()->json(['post' => $post], 201);
                } else {
                    return response()->json(['errors' => ['invalid' => 'You do not have permission to edit this post']], 401);
                }
            }
        } else {
            return response()->json([
                'errors' => [
                    'invalid' => 'Post not found'
                ]
            ], 401);
        }
    }

    public function delete(Request $request, $id) {
        $post = Post::find($id);

        if( $post ){
            $user = User::where('id', $request->input('user_id'))->get();
            if( ($post->user_id == $request->input('user_id')) || ($user[0]->role == 1) ){
                $post->delete();
                return response()->json([
                    'message' => 'Post was successfully deleted',
                    'post' => $id
                ], 201);
            } else {
                return response()->json([
                    'errors' => [
                        'invalid' => 'You do not have permission to delete this post'
                    ]
                ], 401);
            }
        } else {
            return response()->json([
                'errors' => [
                    'invalid' => 'Post does not exist'
                ]
            ], 401);
        }
    }
}
