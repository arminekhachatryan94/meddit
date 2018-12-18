<?php
namespace App\Contracts;
use App\UserRole;

interface UserRoleContract {
    public function createUserRole(int $id): UserRole;
    public function getUserRole(int $id): UserRole;
    public function updateUserRole(UserRole $user_role, int $new_role): bool;
}
?>