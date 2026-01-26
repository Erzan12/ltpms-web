<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Display the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|string|email',  // Ensure it’s an email
            'password' => 'required|string',
        ]);
    
        // Attempt to find the user by email
        $user = User::where('email', $request->email)->first();
    
        // If user does not exist or the password does not match, return an error
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['Invalid Credentials']);
        }
    
        // Log the user in and redirect to the root
        Auth::login($user);
        return redirect('/livestocks');
    }


    // API Login 
    public function apiLogin(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        // Attempt to find the user by email
        $user = User::where('email', $request->email)->first();
    
        // If user does not exist or the password does not match, return an error
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // If user is authenticated, create a token
        $token = $user->createToken('API Token')->plainTextToken;
    
        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }



    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/livestocks');
    }


    // Handle Forgot Password
    public function forgotPassword(){
        return view('emails.forgot');
    }

    // Send Email
    public function sendEmailPassword(Request $request) {
        $request->validate([
            'email' => ['email', 'exists:users,email']
        ]);

        $user = User::where('email', $request->email)->first();
        $password = Str::random(6);

        Mail::to($request->email)->send(new ForgotPasswordMail($request->email, $password));

        $user->update([
            'password' => Hash::make($password)
        ]);

        session()->flash('success', 'Email sent! Please check email.');
        return view('auth.passwords.reset');
    }


    // Handle Logout
    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
