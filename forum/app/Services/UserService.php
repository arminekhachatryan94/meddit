<?php
namespace App\Services;

use App\Contracts\UserContract;
use App\User;
use Validator;

class UserService implements UserContract {
    public function getUser($id){
        return User::find($id);
    }
}
?>