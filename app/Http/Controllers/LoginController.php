<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authentificate(loginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();
            session()->regenerate();

            return new UserResource(Auth::user());
        }

        return response()->json([
            'errors' => ['name' => ["Логин или пароль не верный"], 'password' => ["Логин или пароль не верный"]]
        ], 401);
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
