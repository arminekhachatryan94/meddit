<?php
namespace App\Contracts;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\User;

interface UserContract {
    public function createUser(Array $data): User;
    public function getUser($id): User;
    public function getUserWithEmail($email): User;
    public function getUsersExcept($id): Collection;
    public function existsUser($id): bool;
    public function deleteUser(User $user): bool;
}
?>