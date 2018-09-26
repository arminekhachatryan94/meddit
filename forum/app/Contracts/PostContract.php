<?php
namespace App\Contracts;

interface PostContract{
    public function editPost($postData, $id);
    public function deletePost($request, $id);
}
?>