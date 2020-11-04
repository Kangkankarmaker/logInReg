<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successful'
        ], 201);
    }


    public function login(Request $request)
    {
        $login_validation= $request->validate([
            'email'=>'email|required',
            'password'=>'required'
        ]);

        if (!auth()->attempt($login_validation))
        {
            return response(['message'=>'failure']);
        }

        //$accessToken=auth()->user()->createToken('authToken')->accessToken;

        return response([
            'message'=>'Successful',
            'id'=>auth()->id()]);
    }
}
