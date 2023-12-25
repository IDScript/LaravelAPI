<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class APIAuthMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $token = $request->header('Authorization');
        $authencate = true;

        if (!$token) {
            $authencate = false;
        }

        $user = User::where('token', $token)->first();

        if (!$user) {
            $authencate = false;
        } else {
            Auth::login($user);
        }

        if ($authencate) {
            return $next($request);
        } else {
            return response()->json([
                "errors" => [
                    "message" => "Unautorized"
                ]
            ])->setStatusCode(401);
        }
    }
}
