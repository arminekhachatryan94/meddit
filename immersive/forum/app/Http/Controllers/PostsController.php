<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    public function posts() {
        return response()->json([
            'posts' => Post::all()
        ]);
    }
}
