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
        // 1. Validasi Data
        $data = $request->validate([
            // Alphabet, spasi, titik, strip, petik tunggal, min 1, max 50
            'name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-zA-Z\s\.\-\']+$/'],
            
            // Format email standar, min 6, max 100, wajib unik (belum terdaftar)
            'email' => ['required', 'string', 'email', 'min:6', 'max:100', 'unique:users'],
            
            // Angka saja, min 6, max 15, wajib unik di tabel users kolom phone_number
            'phone_number' => ['required', 'string', 'min:6', 'max:15', 'regex:/^[0-9]+$/', 'unique:users,phone_number'],
            
            // Min 8, max 20, dan wajib sama dengan password_confirmation
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
        ], [
            // Kustomisasi pesan error (Opsional agar bahasa lebih enak dibaca)
            'name.regex' => 'Format nama hanya boleh berisi huruf, spasi, titik (.), strip (-), dan petik (\').',
            'phone_number.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'phone_number.min' => 'Nomor telepon minimal 6 angka.',
            'phone_number.max' => 'Nomor telepon maksimal 15 angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // 2. Hash password dan set role
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'member';
        
        // 3. Simpan ke database
        User::create($data);
        
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
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