<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Biography;
use App\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $biography = Biography::create([
            'user_id' => $user->id,
            'description' => ''
        ]);

        $role = UserRole::create([
            'user_id' => $user->id,
            'role' => 0
        ]);

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
