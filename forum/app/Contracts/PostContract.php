<?php
namespace App\Contracts;

interface PostContract{
    public function createPost($postData);
    public function editPost($postData, $id);
    public function deletePost($postData, $id);
}
?>