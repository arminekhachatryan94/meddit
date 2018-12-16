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
    
    public function getUser(int $id): User {
        return User::where('id', $id)->firstOrFail();
    }

    public function getUserWithEmail(String $email): User {
        return User::where('email', $email)->first();
    }

    public function getUsersExcept(int $id): Collection {
        return User::where('id', '!=', $id)->get();
    }

    public function updateUsername(User $user, String $username): bool {
        $user->username = $username;
        return $user->save();
    }

    public function existsUser(int $id): bool {
        return User::where('id', $id)->exists();
    }

    public function deleteUser(User $user): bool {
        return $user->delete();
    }
}
?>