<?php
namespace App\Contracts;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Post;

interface PostContract{
    public function createPost(Array $data): Post;
    public function getPost($id): Post;
    public function getAllPosts(): Collection;
    public function editPost(Post $post, $req): bool;
    public function deletePost(Post $post): bool;
    public function existsPost($id): bool;
}
?>