<?php
namespace App\Contracts;
use Illuminate\Http\Request;
use App\Comment;

interface CommentContract {
    public function getComment($id);
    public function createComment(Array $data);
    public function editComment(Comment $comment);
    public function deleteComment(Comment $comment);
    public function existsComment($id);
}
?>