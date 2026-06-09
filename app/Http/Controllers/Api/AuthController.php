<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Book;
class AuthController extends Controller
{

////Register
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'author'
    ]);

    return response()->json([
        'status' => true,
        'message' => 'User registered successfully',
        'user' => $user
    ]);
}

//////login
public function login(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    $payload = [
        'user_id' => $user->id,
        'email' => $user->email,
        'role' => $user->role,
        'iat' => time(),
        'exp' => time() + (60 * 60 * 24)
    ];

    $token = JWT::encode(
        $payload,
        env('JWT_SECRET'),
        'HS256'
    );

    return response()->json([
        'status' => true,
        'token' => $token,
        'user' => $user
    ]);
}

//profile

 public function profile(Request $request)
{
    return response()->json([
        'status' => true,
        'user' => $request->auth_user
    ]);
}

///dashboard
public function dashboard(Request $request)
{
    $user = $request->auth_user;

    return response()->json([
        'status' => true,

        'total_books' => Book::where('user_id', $user->id)->count(),

        'draft_books' => Book::where('user_id', $user->id)
            ->where('status', 'draft')
            ->count(),

        'under_review_books' => Book::where('user_id', $user->id)
            ->where('status', 'under_review')
            ->count(),

        'approved_books' => Book::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count(),

        'published_books' => Book::where('user_id', $user->id)
            ->where('status', 'published')
            ->count(),
    ]);
}
}
