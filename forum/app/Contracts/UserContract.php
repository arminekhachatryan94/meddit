<?php
namespace App\Contracts;
use Illuminate\Http\Request;
use App\User;

interface UserContract {
    public function createUser(array $data);
    public function getUser($id);
    public function getUserWithEmail($email);
    public function getUsersExcept($id);
    public function existsUser($id);
    public function deleteUser(User $user);
}
?>