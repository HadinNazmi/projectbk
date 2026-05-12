<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(?string $role = null): View
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()
            ->where(function ($query) use ($credentials) {
                $query->where('username', $credentials['username'])
                    ->orWhere('email', $credentials['username']);
            })
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withInput($request->only('username'))->with('error', 'Username atau password salah.');
        }

        if ($user->status !== 'active') {
            return back()->withInput($request->only('username'))->with('error', 'Akun belum aktif. Hubungi administrator.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route(match ($user->role) {
            'super-admin' => 'super-admin.dashboard',
            'admin' => 'admin.dashboard',
            default => 'guru.input-jurnal',
        });
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
