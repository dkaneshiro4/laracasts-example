<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        // validate
        $validatedAttributes = request()->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'], // 'confirmed' can be used with email too. Looks for email_confirmation field
            'password' => ['required', Password::min(6), 'confirmed'], // 'confirmed' looks for a password_confirmation field in the request
        ]);

        // create the user
        $user = User::create($validatedAttributes);

        // log in
        Auth::login($user);

        // redirect somewhere
        return redirect('/jobs');
    }

}
