<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Contracts\PostContract;
use App\Post;
use Validator;

class PostService implements PostContract {

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'required|max:255',
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255'
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
}
?>