<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // show register form
    public function create(){
        return view('users.register');
    }

    // store new user (with validation)
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required','min:3'],
            'email' => ['required','email',Rule::unique('users','email')],
            'password' => ['required','confirmed','min:3'],
        ]);
        
        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);
        
        auth()->login($user);

        return redirect('/')->with('message','User created successfully');
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','You have being logged out');
    }

    // show login form
    public function login(){
        return view('users.login');
    }

    // authenticate user
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);
        
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/')->with('message','You are logged in.');
        }

        return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');

    }
}




