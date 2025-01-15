<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\RedirectController;
use App\Models\User;
use GuzzleHttp\Psr7\Response;

class RegistrationController extends Controller
{
    public function registration(Request $request)
    {

        $validatedData = $request->validate([
            'email' => ['required', 'unique:users', 'max:255'],
            'name' => ['required', 'max:64'],
            'password' => ['required', 'max:32']
        ]);

        $newUser = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => $request->password,
        ]);

        return new UserResource($newUser);
    }
}
