<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class GuruAccountController extends Controller
{
    public function edit(Request $request): View
    {
        return view('guru.account', [
            'user' => $request->user(),
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = $request->user();
        $user->update([
            'password' => $data['password'],
            'password_changed_at' => now(),
            'password_changed_by' => $user->id,
        ]);

        return redirect()->route('guru.account.edit')->with('success', 'Password berhasil diperbarui.');
    }
}
