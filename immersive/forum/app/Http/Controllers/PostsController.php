<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Validator;

class PostsController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'required|string|max:255',
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

    public function posts() {
        return response()->json([
            'posts' => Post::all()
        ]);
    }

    public function create(Request $request) {
        $errors = $this->validator($request->all())->errors();
        if( count($errors) == 0 ){
            $post = $this->save($request->all());
            return response()->json([ 'post' => $post ], 201);
        } else {
            return response()->json([ 'errors' => $errors ], 401);
        };
    }
}
