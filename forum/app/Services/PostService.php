<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Contracts\PostContract;
use App\Post;
use Validator;

class PostService implements PostContract {

    public function createPost(Array $data): Post {
        return Post::create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'body' => $data['body'],
        ]);
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

    public function existsPost($id){
        return Post::where('id', $id)->exists();
    }
}
?>