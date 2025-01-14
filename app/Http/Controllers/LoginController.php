<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authentificate(Request $request): RedirectResponse
    {
        dump($request);
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('http://localhost:5173/');
        }

        return back()->withErrors([
            'email' => 'Предоставленные учетные данные не действительны!'
        ])->onlyInput('email');
    }
}
