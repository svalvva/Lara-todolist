<?php

namespace App\Http\Controllers;

// Import kelas-kelas yang diperlukan
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form register
     * Method ini akan merender view auth.register
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses data registrasi user baru
     * @param Request $request berisi semua data form
     */
    public function register(Request $request)
    {
        // Validasi data input dari form
        $validatedData = $request->validate([
            'nama' => 'required|max:255', // Nama wajib diisi, maksimal 255 karakter
            'username' => [
                'required',  // Username wajib diisi
                'min:3',     // Minimal 3 karakter
                'max:255',   // Maksimal 255 karakter
                'unique:users' // Harus unik di tabel users
            ],
            'email' => 'required|email|unique:users', // Email wajib diisi, format email, dan unik
            'password' => 'required|min:6|max:255|confirmed' // Password wajib diisi, min 6 karakter, dan harus dikonfirmasi
        ], [
            // Pesan error kustom untuk setiap validasi
            'nama.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        // Hash password sebelum disimpan ke database
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Buat user baru dengan data yang sudah divalidasi
        User::create($validatedData);

        // Redirect ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Registrasi Berhasil! Silahkan Login');
    }

    /**
     * Menampilkan form login
     * Method ini akan merender view auth.login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses login user
     * @param Request $request berisi credentials login
     */
    public function login(Request $request)
    {
        // Validasi input login
        $validatedData = $request->validate([
            'email' => 'required|email', // Email wajib diisi dan format harus valid
            'password' => 'required'     // Password wajib diisi
        ], [
            // Pesan error kustom
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi'
        ]);

        // Coba melakukan autentikasi
        if (Auth::attempt($validatedData)) {
            // Jika berhasil, regenerate session untuk keamanan
            $request->session()->regenerate();
            
            // Redirect ke halaman yang dituju sebelumnya atau ke dashboard
            return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah'
        ])->withInput($request->only('email'));
    }

    /**
     * Proses logout user
     * @param Request $request untuk akses session
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Invalidate session
        $request->session()->regenerateToken(); // Regenerate CSRF token
        return redirect('login')->with('success', 'Anda telah berhasil logout');
    }
}
