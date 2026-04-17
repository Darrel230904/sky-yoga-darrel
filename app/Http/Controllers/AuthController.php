<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordOTP;
use Carbon\Carbon;


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
            'password' => 'Wrong password',
        ])->onlyInput('email'); // Tetap pertahankan isian email agar user tidak perlu mengetik ulang
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    public function showForgotPassword() {
        return view('auth.forgot-password');
    }

    // Proses Kirim Email & OTP
    public function processForgotPassword(Request $request) {
        $request->validate([
            'email' => ['required', 'email']
        ], [
            'email.required' => 'email is required',
            'email.email' => 'Invalid email format'
        ]);

        // Cek apakah email ada di database
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email not found in our system.']);
        }

        // Generate 4 Digit OTP
        $otp = rand(1000, 9999);

        // Simpan OTP ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $otp, 'created_at' => Carbon::now()]
        );

        // Kirim email (Akan error jika .env mail belum disetting)
        Mail::to($request->email)->send(new ResetPasswordOTP($otp));

        // Simpan email ke session untuk tahap verifikasi
        session(['reset_email' => $request->email]);

        return redirect()->route('verify.otp');
    }

    // 3. Tampilkan Halaman Input OTP
    public function showVerifyOtp() {
        if (!session('reset_email')) return redirect()->route('forgot.password');
        return view('auth.verify-otp');
    }

    // 4. Proses Verifikasi OTP
    public function processVerifyOtp(Request $request) {
        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;
        $email = session('reset_email');

        $record = DB::table('password_reset_tokens')->where('email', $email)->where('token', $otp)->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Invalid or expired verification code.']);
        }

        // OTP Benar, izinkan reset password
        session(['otp_verified' => true]);
        return redirect()->route('reset.password');
    }

    // 5. Tampilkan Halaman Input Password Baru
    public function showResetPassword() {
        if (!session('otp_verified')) return redirect()->route('forgot.password');
        return view('auth.reset-password');
    }

    // 6. Proses Update Password
    public function processResetPassword(Request $request) {
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed']
        ], [
            'password.required' => 'Password is required',
            'password.confirmed' => 'Passwords do not match',
        ]);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        // Validasi: Password baru tidak boleh sama dengan password lama
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'New password cannot be the same as your old password.']);
        }

        // Update ke database
        $user->password = Hash::make($request->password);
        $user->save();

        // Bersihkan token dan session
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('reset.success');
    }

    // 7. Tampilkan Halaman Success
    public function showResetSuccess() {
        return view('auth.reset-success');
    }
}