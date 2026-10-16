<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $header = (string) $request->bearerToken();

        if ($header === '') {
            return response()->json([
                'message' => '未提供 Bearer Token',
            ], 401);
        }

        $user = User::query()->where('api_token', hash('sha256', $header))->first();

        if (! $user) {
            return response()->json([
                'message' => 'Token 無效',
            ], 401);
        }

        auth()->login($user);

        return $next($request);
    }
}
