<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use Validator;

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

    public function edit( Request $request, $id ) {
        $user = User::where('id', $id)->first();

        if( $user && $user->role == 1 ){
            $errors = Validator::make($request->all(), [
                'user_id' => 'required',
                'role' => 'required'
            ])->errors();

            if( count($errors) == 0 && ($request->input('role') == 1 || $request->input('role') == 0) ){
                if( $request->input('user_id') != $id ){
                    $user_role = UserRole::where('id', $request->input('user_id'))->first();
                    $user_role->role = $request->input('role');
                    $user_role->save();
                    return response()->json([
                        'message' => 'User with id of '. $user_role->user_id . ' is now ' . ($user_role->role == 1 ? 'an admin' : 'a user')
                    ], 201);
                }
                else {
                    return response()->json([
                        'errors' => [
                            'invalid' => 'You do not have permission to change your own role'
                        ]
                    ], 401);
                }
            } else if( $request->input('role') == 1 || $request->input('role') == 0 ) {
                return response()->json([
                    'errors' => [
                        'role' => 'Invalid data for role'
                    ]
                ], 401);
            } else {
                return response()->json([
                    'errors' => $errors
                ], 401);
            }
        } else {
            return response()->json([
                'invalid' => 'You do not have permission to edit this information'
            ], 401);
        }
    }
}
