<?php
namespace App\Contracts;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\User;

interface UserContract {
    public function createUser(Array $data): User;
    public function getUser(int $id): User;
    public function getUserWithEmail(String $email): User;
    public function getUsersExcept(int $id): Collection;
    public function updateUsername(User $user, String $username): bool;
    public function existsUser(int $id): bool;
    public function deleteUser(User $user): bool;
}
?>