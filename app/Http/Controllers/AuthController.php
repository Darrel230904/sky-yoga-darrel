<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register'); 
    }

    public function register(Request $request)
    {
        // Validasi Form: Nama, Email, Phone, Password [cite: 20]
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'member';
        
        User::create($data);
        return redirect()->route('login')->with('success', 'Registrasi berhasil!');
    }

    public function login(Request $request)
    {
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        $credentials = [
            $loginField => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return Auth::user()->role === 'admin' 
                ? redirect()->intended('/admin/members') 
                : redirect()->intended('/');
        }

        return back()->withErrors(['login' => 'Kredensial tidak cocok.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}