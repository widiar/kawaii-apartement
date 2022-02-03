<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        $cre = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($cre)) {
            if ($user && $user->role == 1) {
                return redirect()->route('admin.dashboard');
            }
        } else {
            return redirect()->route('login')->with('status', 'Email atau Password anda salah')->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
