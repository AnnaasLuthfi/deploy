<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $roleUser = Roles::where('name', 'user')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleUser->id
        ]);

        $userRegis = User::with('Role')->where('email', $request['email'])->first();

        $token = JWTAuth::fromUser($user);

        return response()->json([
            "message" => "Register Berhasil",
            "user" => $userRegis,
            "token" => $token
        ]);
    }


    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$user = auth()->attempt($credentials)) {
            return response()->json(['message' => 'user invalid'], 401);
        }

        $userData = User::with('Role')->where('email', $request['email'])->first();
        $user = JWTAuth::fromUser($userData);

        return response()->json([
            "message" => "user berhasil login",
            "user" => $userData,
            "token" => $user,
        ]);
    }


    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Logout Berhasil']);
    }

    public function getUser()
    {
        $user = auth()->user();
        $currentUser = User::with('Role')->find($user->id);

        return response()->json([
            "message" => "berhasil get user",
            "user" => $currentUser
        ]);
    }
}
