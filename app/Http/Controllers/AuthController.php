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
        // 1. Validasi Input kosong & Format Email
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            // Kustomisasi pesan error sesuai permintaan Anda
            'email.required' => 'email is required',
            'email.email' => 'invalid email format',
            'password.required' => 'password is required',
        ]);

        // 2. Cek apakah email dan password cocok (Auth Attempt)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect ke halaman yang sesuai (misal home/landing page)
            return redirect()->intended('/');
        }

        // 3. Jika salah password / email tidak terdaftar
        return back()->withErrors([
            'password' => 'invalid credentials',
        ])->onlyInput('email'); // Tetap pertahankan isian email agar user tidak perlu mengetik ulang
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}