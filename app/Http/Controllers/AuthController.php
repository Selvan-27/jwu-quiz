<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function splash()
    {
        
        if(Auth::user()){
            $route = $this->redirectDash();
            return redirect($route);
        }else{

            return view('auth.login');        
        }
        
    
    }
    
     public function showLogin()
    {
        
        if(Auth::user()){
            $route = $this->redirectDash();
            return redirect($route);
        }
        
        return view('auth.login');
    }
    

    public function login(Request $request)
    {
        
        $user = User::where('email', $request->email)->first();

    if (!$user) {
    return redirect()->route('register')
        ->with('error', 'You are not registered yet. Please create an account.');
    }

if (! Hash::check($request->password, $user->password)) {
    return back()->with('error', 'Incorrect password.');
}

// 🔐 Login with Remember Me (persistent login)
Auth::login($user, true);

// 🔁 Prevent session fixation
$request->session()->regenerate();


return redirect()->intended($this->redirectDash());
     
    }


 public function redirectDash()
    {
        $redirect = '';
         if(auth()->user()->is_admin==1){
            $redirect = '/admin';
        }else if(Auth::user()){
            $redirect = '/home/';
        }else{
            $redirect = '/login/';
        }

        return $redirect;
    }
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->first();

if ($user) {
    return redirect()->route('login')
        ->with('error', 'This mobile number is already registered. Please login.');
}

// Validation for new user
$request->validate(
    [
        'name'     => 'required|string|max:255',
        'mobile'   => 'required|digits:10',
        'password' => 'required|string|min:4|confirmed',
    ],
    [
        'mobile.required' => 'Mobile number is required.',
        'mobile.digits'   => 'Mobile number must be exactly 10 digits.',
    ]
);



        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->mobile,
            'pwd' =>$request->password,
            'password' => Hash::make($request->password),
        ]);


// 🔐 Login with Remember Me (persistent login)
Auth::login($user, true);

        // Auth::login($user);

        return redirect('/home');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
