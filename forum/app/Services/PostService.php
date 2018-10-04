<?php
namespace App\Services;

use App\Contracts\PostContract;
use App\Post;
use App\User;
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
    
    public function editPost($postData, $id){
        $post = Post::find($id);
        if( $post ){
            $errors = $this->validator($postData)->errors();
            if( count($errors) ) {
                return response()->json([
                    'errors' => $errors
                ], 401);
            } else {
                if( $post->user_id == $postData['user_id'] ){
                    $post->title = $postData['title'];
                    $post->body = $postData['body'];
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

    public function deletePost(Post $post){
        return $post->delete();
    }
}
?>