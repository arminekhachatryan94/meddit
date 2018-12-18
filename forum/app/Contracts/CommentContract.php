<?php
namespace App\Contracts;
use Illuminate\Http\Request;
use App\Comment;

interface CommentContract {
    public function getComment(int $id): Comment;
    public function createComment(Array $data): Comment;
    public function editComment(Comment $comment, string $body): bool;
    public function deleteComment(Comment $comment): bool;
    public function existsComment(int $id): bool;
}
?>