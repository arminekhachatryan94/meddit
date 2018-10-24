<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Contracts\UserContract;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $userService = null;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserContract $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $errors = $this->validator($request->all())->errors();
        if( count($errors) == 0 ){
            if( !auth()->attempt(request(['email', 'password'])) ){
                return response()->json([
                    'errors' => [
                        'invalid' => 'Invalid credentials. Please try again.'
                    ]
                ], 401);
            } else {
                $user = $this->userService->getUserWithEmail($request->input('email'));
                return response()->json([
                    'user' => $user
                ], 201);
            }
        } else {
            return response()->json([
                'errors' => $errors
            ], 401);
        }
    }
}
