<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show register/create form
    public function create () {
        return view('users.register');
    }

    //store/register new user
    public function store (Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email'=> ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);

        auth()->login($user);

        return redirect('/')->with('message', 'User created...You are logged in');
    }

    //Log out user
    public function logout (Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
       
        return redirect('/')->with('message', 'You have been logged out');


    }

   //Show login form
    public function login () {
        return view('users.login');
    }

    //login user
    public function authenticate(Request $request) {
        $formFields = $request->validate([
           
            'email'=> ['required', 'email'],
            'password' => ['required']
        ]);

       if(auth()->attempt($formFields)) { 
        $request->session()->regenerate();

        return redirect('/')->with('message', 'You are logged In');
       }
       return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
       
        

    }
}
