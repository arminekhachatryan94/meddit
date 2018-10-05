<?php
namespace App\Contracts;
use App\Post;

interface PostContract{
    public function getPost($id);
    public function editPost($postData, $id);
    public function deletePost(Post $post);
}
?>