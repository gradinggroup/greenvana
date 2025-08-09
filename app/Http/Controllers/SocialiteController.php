<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\InvalidStateException;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            // Gunakan stateless kalau sering kena InvalidStateException
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cek user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update data user
                $user->update([
                    'name'      => $googleUser->getName(),
                    'client_id' => $googleUser->getId(),
                ]);
            } else {
                // Buat user baru
                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'client_id' => $googleUser->getId(),
                    'password'  => Hash::make(Str::random(16)), // Password random
                ]);
            }

            Auth::login($user);

            return redirect('/dashboard')->with([
                'message' => 'Anda Berhasil Login',
                'alert-type' => 'success'
            ]);

        } catch (InvalidStateException $e) {
            return redirect('/login')->with([
                'message' => 'Sesi login Google kadaluarsa, silakan coba lagi.',
                'alert-type' => 'error'
            ]);
        } catch (\Exception $e) {
            return redirect('/login')->with([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
}
