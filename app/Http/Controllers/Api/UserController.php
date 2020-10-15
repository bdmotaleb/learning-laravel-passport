<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return response(['users' => User::all()]);
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string'
        ]);

        Auth::attempt($validate);

        $token = Auth::user()->createToken('access_token')->accessToken;

        return response([
            'user'         => Auth::user(),
            'access_token' => $token
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string',
                'email'    => 'required|string',
                'password' => 'required|string',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $token = $user->createToken('access_token')->accessToken;

            return response([
                'user'         => $user,
                'access_token' => $token
            ]);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        return response(['user' => User::find($id)]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
