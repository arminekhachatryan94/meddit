<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserRolesController extends Controller
{
    public function users( $id ) {
        $user = User::where('id', $id)->first();
        if( $user->role == 1 ){
            $users = User::where('id', '!=', $id)->get();
            return response()->json([
                'users' => $users
            ], 201);
        } else {
            return response()->json([
                'invalid' => 'You do not have permission to view this page'
            ], 401);
        }
    }
}
