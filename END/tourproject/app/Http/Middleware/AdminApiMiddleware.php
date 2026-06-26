<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

/**
 * Stateless admin authentication middleware for API requests.
 */
class AdminApiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return $this->unauthorized('Missing admin bearer token.');
        }

        try {
            $payload = json_decode(Crypt::decryptString($token), true);
        } catch (\Throwable $e) {
            Log::warning('Invalid admin bearer token', ['exception' => $e]);

            return $this->unauthorized('Invalid or expired admin token.');
        }

        if (
            !is_array($payload) ||
            empty($payload['user_id']) ||
            empty($payload['password_hash']) ||
            empty($payload['expires_at']) ||
            $payload['expires_at'] < now()->timestamp
        ) {
            return $this->unauthorized('Invalid or expired admin token.');
        }

        $user = User::find($payload['user_id']);

        if (
            !$user ||
            !$user->is_admin ||
            !hash_equals($user->password, $payload['password_hash'])
        ) {
            return $this->unauthorized('Unauthorized. Admin access required.');
        }

        auth()->setUser($user);

        return $next($request);
    }

    private function unauthorized(string $message)
    {
        return response()->json([
            'message' => $message,
            'hint' => 'Please login via POST /api/admin/login to obtain an access token.',
        ], 401);
    }
}
