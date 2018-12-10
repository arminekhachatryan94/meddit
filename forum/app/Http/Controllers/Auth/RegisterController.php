<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\BiographyContract;
use App\Contracts\UserContract;
use App\Contracts\UserRoleContract;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * User Service
     */

    protected $userService = null;
    protected $userRoleService = null;
    protected $biographyService = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserContract $userService,
        UserRoleContract $userRoleService,
        BiographyContract $biographyService
    ) {
        $this->userService = $userService;
        $this->userRoleService = $userRoleService;
        $this->biographyService = $biographyService;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = $this->userService->createUser($data);

        $biography = $this->biographyService->createBiography($user->id);

        $role = $this->userRoleService->createUserRole($user->id);

        Mail::send('emails.registration', ['user' => $user], function ($mail) use ($user) {
            $mail->from('info@meatlabs.com', 'MEAT Labs');

            $mail->to($user->email, $user->name)->subject('Thanks for registering!');
        });

        return $user;
    }

    public function register(Request $request ){
        $errors = $this->validator($request->all())->errors();
        if( count($errors) == 0 ){
            $user = $this->create($request->all());
            return response()->json([
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'errors' => $errors
            ], 401);
        }
    }
}
