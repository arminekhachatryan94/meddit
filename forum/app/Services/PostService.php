<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Contracts\PostContract;
use App\Post;
use Validator;

class PostService implements PostContract {

    public function createPost(Post $post){
        return $post->save();
    }

    public function getPost($id){
        return Post::find($id);
    }

    public function getAllPosts(){
        return Post::orderBy('created_at', 'desc')->get();
    }
    
    public function editPost(Post $post, $req){
        $post->title = $req['title'];	
        $post->body = $req['body'];
        return $post->save();
    }

    public function deletePost(Post $post){
        return $post->delete();
    }
}
?>