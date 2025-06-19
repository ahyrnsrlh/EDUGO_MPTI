<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{    public function googleLogin()
    {
        try {
            // Check if Google credentials are configured
            if (!config('services.google.client_id') || !config('services.google.client_secret')) {
                return redirect()->back()->with('error', 'Google OAuth tidak dikonfigurasi dengan benar.');
            }
            
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghubungkan ke Google: ' . $e->getMessage());
        }
    }    public function googleAuthentication()
    {
        try {
            // Log all request parameters for debugging
            Log::info('Google OAuth Callback received', [
                'query_params' => request()->all(),
                'url' => request()->fullUrl()
            ]);

            // Check if we have authorization code or if user denied access
            if (request()->has('error')) {
                $error = request('error');
                Log::warning('Google OAuth Error received: ' . $error);
                
                if ($error === 'access_denied') {
                    return redirect()->route('login')->with('error', 'Login dengan Google dibatalkan.');
                }
                return redirect()->route('login')->with('error', 'Google OAuth Error: ' . $error);
            }

            // Check if we have authorization code
            if (!request()->has('code')) {
                Log::error('No authorization code received from Google');
                return redirect()->route('login')->with('error', 'Tidak menerima kode otorisasi dari Google.');
            }

            // Get user from Google
            $googleUser = Socialite::driver('google')->user();
            
            Log::info('Google user data received', [
                'email' => $googleUser->email,
                'name' => $googleUser->name,
                'id' => $googleUser->id
            ]);

            // Check if user already exists
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,
                    'photo' => $googleUser->avatar,
                    'password' => Hash::make('password@123'),
                    'role' => 'user',
                ]);
                
                Log::info('New user created via Google OAuth: ' . $googleUser->email);
            } else {
                Log::info('Existing user logged in via Google OAuth: ' . $googleUser->email);
            }

            // Login user
            Auth::login($user);

            // Redirect to user dashboard
            return redirect()->route('user.dashboard')->with('success', 'Berhasil login dengan Google!');
            
        } catch (\Exception $e) {
            Log::error('Google OAuth Authentication Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }
}
