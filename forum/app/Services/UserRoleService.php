<?php
namespace App\Services;

use App\Contracts\UserRoleContract;
use App\UserRole;

class UserRoleService implements UserRoleContract {
    public function createUserRole(int $id): UserRole {
        return UserRole::create([
            'user_id' => $id,
            'role' => 0
        ]);
    }
}
?>