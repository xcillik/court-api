<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Response;

use function PHPUnit\Framework\returnSelf;

class AuthController extends Controller {
    public function __construct() {
        $this->middleware("auth:api", [
            "except" => [
                "login",
                "register"
            ]
        ]);
    }

    public function login(Request $request) {
        if (Auth::check())
            return response()->json(["error" => "409 Conflict"], Response::HTTP_CONFLICT);

        $request->validate([
            "email" => "required|string|email",
            "password" => "required|string",
        ]);

        $credentials = $request->only("email", "password");
        $token = Auth::attempt($credentials);

        if (!$token)
            return response()->json(["error" => "401 Unauthorized (Wrong Credentials)"], Response::HTTP_UNAUTHORIZED);

        $user = Auth::user();

        return response()->json([
            "action" => "login",
            "status" => "success",
            "response" => [
                "token" => $token,
                "type" => "bearer",
            ]
        ]);
    }

    public function register(Request $request){
        if (Auth::check())
            return response()->json(["error" => "409 Conflict"], Response::HTTP_CONFLICT);

        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:6",
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return response()->json([
            "action" => "register",
            "status" => "success",
            "response" => [
                "token" => $token,
                "type" => "bearer",
            ]
        ], Response::HTTP_CREATED);
    }

    public function logout() {
        Auth::logout();

        return response()->json([
            "action" => "logout",
            "status" => "success"
        ]);
    }

    public function refresh() {
        return response()->json([
            "action" => "refresh",
            "status" => "success",
            "response" => [
                "token" => Auth::refresh(),
                "type" => "bearer",
            ]
        ]);
    }
}
