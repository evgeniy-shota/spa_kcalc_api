<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authentificate(Request $request) 
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();

            return response()->json([
                $credentials
            ]);
        }

        return response()->json([
            'fuckinh laravel'
        ]);
    }

    // public function authentificate(Request $request): RedirectResponse
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     if (Auth::attempt($credentials)){
    //         $request->session()->regenerate();

    //         return redirect()->intended('http://localhost:5173/');
    //     }

    //     return back()->withErrors([
    //         'email' => 'Предоставленные учетные данные не действительны!'
    //     ])->onlyInput('email');
    // }
}
