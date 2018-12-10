<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Contracts\UserContract;
use Illuminate\Support\Collection;
use App\User;
use Validator;

class UserService implements UserContract {
    public function createUser(Array $data): User {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    
    public function getUser($id): User {
        return User::where('id', $id)->first();
    }

    public function getUserWithEmail($email): User {
        return User::where('email', $email)->first();
    }

    public function getUsersExcept($id): Collection {
        return User::where('id', '!=', $id)->get();
    }

    public function existsUser($id): bool {
        return User::where('id', $id)->exists();
    }

    public function deleteUser(User $user): bool {
        return $user->delete();
    }
}
?>