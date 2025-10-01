<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str; // ← هذا مهم

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account']) // 🔑 هذا يفرض اختيار الحساب
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Unable to login using Google. Please try again.');
        }

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(16)), // كلمة مرور عشوائية
            ]
        );

        Auth::login($user, true);
        if ($user->role === 'super_admin') {
            return redirect()->route('dashboard.super_admin');
        }



        Auth::login($user, true);

        return redirect()->route('dashboard.user');
    }
}
