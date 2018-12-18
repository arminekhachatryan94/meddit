<?php
namespace App\Contracts;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Post;

interface PostContract{
    public function createPost(Array $data): Post;
    public function getPost(int $id): Post;
    public function getAllPosts(): Collection;
    public function editPost(Post $post, Array $req): bool;
    public function deletePost(Post $post): bool;
    public function existsPost(int $id): bool;
}
?>