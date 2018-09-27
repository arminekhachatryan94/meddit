<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PostContract;

class PostsController extends Controller
{
    protected $postRetriever = null;

    public function __construct(PostContract $postRetriever){
        $this->postRetriever = $postRetriever;
    }

    public function posts() {
        return $this->postRetriever->getAllPosts();
    }

    public function post($id) {
        return $this->postRetriever->getOnePost($id);
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
