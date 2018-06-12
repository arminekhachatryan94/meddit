<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Biography;

class SettingsController extends Controller
{
    public function settings( $id ) {
        $user = User::where('id', $id)->get();
        if( $user ){
            return response()->json([
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'errors' => [
                    'invalid' => 'User does not exist'
                ]
            ], 401);
        }
    }
}
