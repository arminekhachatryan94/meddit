<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\UserContract;
use App\Contracts\UserRoleContract;
use App\UserRole;
use Validator;
use Mail;

class UserRolesController extends Controller
{
    protected $userService = null;
    protected $userRoleService = null;

    public function __construct(UserContract $userService, UserRoleContract $userRoleService){
        $this->userService = $userService;
        $this->userRoleService = $userRoleService;
    }
    
    public function users( $id ) {
        $user = $this->userService->getUser($id);
        if( $user->role == 1 ){
            $users = $this->userService->getUsersExcept($id);
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
        $user = $this->userService->getUser($id);

        if( $user && $user->role == 1 ){
            $errors = Validator::make($request->all(), [
                'user_id' => 'required',
                'role' => 'required'
            ])->errors();

            if( count($errors) == 0 && ($request->input('role') == 1 || $request->input('role') == 0) ){
                if( $request->input('user_id') != $id ){
                    $user_role = $this->userRoleService->getUserRole($request->input('user_id'));
                    if( $user_role ){
                        $this->userRoleService->updateUserRole($user_role, $request->input('role'));
                        return response()->json([
                            'message' => 'User with id of '. $user_role->user_id . ' is now ' . ($user_role->role == 1 ? 'an admin' : 'a user')
                        ], 201);
                    } else {
                        return response()->json([
                            'errors' => [
                                'invalid' => 'User does not exist'
                            ]
                        ], 401);
                    }
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

    public function delete( Request $request, $id ){
        $user = $this->userService->getUser($id);

        if( $user && $user->role == 1 ){
            $errors = Validator::make($request->all(), [
                'user_id' => 'required'
            ])->errors();

            if( count($errors) == 0 ){
                if( $request->input('user_id') != $id ){
                    $user2 = $this->userService->getUser($request->input('user_id'));

                    if( $user2 ){
                        $this->userService->deleteUser($user2);

                        Mail::send('emails.deletion', ['user' => $user2], function ($mail) use ($user2) {
                            $mail->from('info@meatlabs.com', 'MEAT Labs');
                
                            $mail->to($user2->email, $user2->name)->subject('Account was deleted!');
                        });
                
                        return response()->json([
                            'message' => 'User with id of '. $user2->id . ' has successfully been deleted'
                        ], 201);
                    } else {
                        return response()->json([
                            'errors' => [
                                'invalid' => 'User does not exist'
                            ]
                        ], 401);
                    }
                }
                else {
                    return response()->json([
                        'errors' => [
                            'invalid' => 'You do not have permission to delete your own account'
                        ]
                    ], 401);
                }
            } else {
                return response()->json([
                    'errors' => $errors
                ], 401);
            }
        } else {
            return response()->json([
                'invalid' => 'You do not have permission to delete this information'
            ], 401);
        }
    }
}
