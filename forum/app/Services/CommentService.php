<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Contracts\CommentContract;
use App\Comment;
use Validator;

class CommentService implements CommentContract {

    public function getComment($id){
        return Comment::where('id', $id)->first();
    }

    public function createComment(Array $data){
        if( $data['comment_id'] == NULL ){
            return Comment::create([
                'post_id' => $data['post_id'],
                'comment_id' => NULL,
                'user_id' => $data['user_id'],
                'body' => $data['body']
            ]);
        }
        else {
            return Comment::create([
                'post_id' => NULL,
                'comment_id' => $data['comment_id'],
                'user_id' => $data['user_id'],
                'body' => $data['body']
            ]);
        }
    }

    public function existsComment($id){
        return Comment::where('id', $id)->exists();
    }
}
?>