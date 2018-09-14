<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Biography;
use Validator;

class SettingsController extends Controller
{
    public function settings( $id ) {
        $user = User::where('id', $id)->first();
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

    public function username( Request $request, $id ) {
        $errors = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string'
        ])->errors();

        if( count($errors) == 0 ){
            $req = [
                'id' => $id,
                'password' => $request->input('password')
            ];
            if( auth()->attempt( $req ) ){
                $user = User::where('id', $id)->first();
                $user->username = $request->input('username');
                $user->save();
                return response()->json([
                    'message' => 'Successfully changed username'
                ], 201);
            } else {
                return response()->json([
                    'invalid' => 'Invalid credentials'
                ], 401);
            }
        }
        else {
            return response()->json([
                'errors' => $errors
            ], 401);
        }
    }

    public function biography( Request $request, $id ) {
        $errors = Validator::make($request->all(), [
            'biography' => 'required|string|max:255',
            'password' => 'required|string'
        ])->errors();

        if( count($errors) == 0 ){
            $req = [
                'id' => $id,
                'password' => $request->input('password')
            ];
            if( auth()->attempt( $req ) ){
                $user = Biography::where('user_id', $id)->first();
                $user->description = $request->input('biography');
                $user->save();
                return response()->json([
                    'message' => 'Successfully updated biography'
                ], 201);
            } else {
                return response()->json([
                    'invalid' => 'Invalid credentials'
                ], 401);
            }
        }
        else {
            return response()->json([
                'errors' => $errors
            ], 401);
        }
    }
}
