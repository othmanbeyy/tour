<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    private const ADMIN_EMAIL = 'sharifbeyy@gmail.com';

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $user = User::where('email', $credentials['email'])->first();

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'message' => 'The provided credentials do not match our records.',
                ], 401);
            }

            if (!$user->is_admin && strtolower($user->email) === self::ADMIN_EMAIL) {
                $user->forceFill(['is_admin' => true])->save();
            }

            if (!$user->is_admin) {
                return response()->json([
                    'message' => 'This account does not have administrator access.',
                ], 403);
            }

            $token = Crypt::encryptString(json_encode([
                'user_id' => $user->id,
                'password_hash' => $user->password,
                'expires_at' => now()->addHours(12)->timestamp,
            ]));

            return response()->json([
                'message' => 'Logged in successfully',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => 'Administrator',
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=2d6a4f&color=fff',
                ],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Admin Login Error', ['exception' => $e]);

            return response()->json([
                'message' => 'Unable to login right now.',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        return response()->json(['message' => 'Logged out successfully']);
    }
}
