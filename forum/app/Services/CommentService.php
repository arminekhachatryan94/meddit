<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Contracts\CommentContract;
use App\Comment;
use Validator;

class CommentService implements CommentContract {

    public function getComment(int $id): Comment {
        return Comment::where('id', $id)->first();
    }

    public function createComment(Array $data): Comment {
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

    public function editComment(Comment $comment, string $body): bool {
        $comment->body = $body;
        return $comment->save();
    }

    public function deleteComment(Comment $comment): bool {
        return $comment->delete();
    }

    public function existsComment(int $id): bool {
        return Comment::where('id', $id)->exists();
    }
}
?>