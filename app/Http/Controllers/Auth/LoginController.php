<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Requests\LoginRequest;
use Auth;

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
    protected $redirectTo = '/admin/year';

    protected $maxLoginAttempts = 10;
    protected $lockoutTime = 300;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request) {
        $userdata = [
            'email' => $request->email,
            'password' => $request->password
        ];
        // echo '<pre>';
        // print_r(Auth::guard('admin'));

        if(Auth::attempt($userdata)) {

            $user = Auth::user()->toArray();

            if($user['role'] === 'admin') {
                return redirect()->route('year.index');
            } else if($user['role'] === 'member') {
                return redirect()->route('myaccount.index');
            }
            
        } else {
            return redirect()->route('login')->with([
                'flash_level'=>'error',
                'flash_message'=>'Wrong email or password'
            ]);
        }

        // echo '<pre>';
        // print_r(Auth::attempt($userdata));
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
