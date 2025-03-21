<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\RedirectController;
use App\Models\User;
use GuzzleHttp\Psr7\Response;

class RegistrationController extends Controller
{
    public function registration(RegistrationRequest $request)
    {

        $validatedData = $request->validated();

        $newUser = User::create([
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'password' => $validatedData['password'],
        ]);

        return new UserResource($newUser);
    }
}
