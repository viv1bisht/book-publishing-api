<?php

namespace App\Http\Middleware;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    try {

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Token missing'
            ], 401);
        }

        $decoded = JWT::decode(
            $token,
            new Key(env('JWT_SECRET'), 'HS256')
        );

        $user = User::find($decoded->user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 401);
        }

        $request->merge([
            'auth_user' => $user
        ]);

    } catch (Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Invalid token'
        ], 401);

    }

    return $next($request);
}
}
