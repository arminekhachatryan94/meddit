<?php
namespace App\Contracts;

interface UserContract {
    public function createUser(array $data);
    public function getUser($id);
    public function getUserWithEmail($email);
    public function existsUser($id);
}
?>