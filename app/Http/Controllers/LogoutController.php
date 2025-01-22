<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request) {
        session()->flush();
        return response()->json(["result"=> true], 200);
    }
}
