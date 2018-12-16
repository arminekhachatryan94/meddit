<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\UserContract;
use App\Contracts\BiographyContract;
use Validator;

class SettingsController extends Controller
{
    protected $userService = null;
    protected $biographyService = null;

    public function __construct(UserContract $userService, BiographyContract $biographyService){
        $this->userService = $userService;
        $this->biographyService = $biographyService;
    }

    public function settings( $id ) {
        try {
            $user = $this->userService->getUser($id);
            return response()->json([
                'user' => $user
            ], 201);
        } catch(ModelNotFoundException $e) {
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
                $user = $this->userService->getUser($id);
                $this->userService->updateUsername($user, $request->input('username'));
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
                $bio = $this->biographyService->getBiography($id);
                $this->biographyService->saveBiography($bio, $request->input('biography'));
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
