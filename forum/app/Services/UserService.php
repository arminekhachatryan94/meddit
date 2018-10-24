<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Contracts\UserContract;
use App\User;
use Validator;

class UserService implements UserContract {
    public function createUser(array $data){
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    
    public function getUser($id){
        return User::where('id', $id)->first();
    }

    public function getUserWithEmail($email){
        return User::where('email', $email)->first();
    }

    public function getUsersExcept($id){
        return User::where('id', '!=', $id)->get();
    }

    public function existsUser($id){
        return User::where('id', $id)->exists();
    }

    public function deleteUser(User $user){
        return $user->delete();
    }
}
?>