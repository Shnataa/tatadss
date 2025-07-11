<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function loginPage()
    {
        // Jika sudah login, alihkan ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');  
        }
        
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        // Cek kredensial dan login
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        // Jika gagal login
        return back()->withErrors(['message' => 'Invalid credentials'])->withInput();
    }

    // Proses logout
    public function logout(Request $request)
    {
        // Logout user dan invalidate session
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect()->route('login'); 
    }

    // Halaman registrasi
    public function index()
    {
        return view('registrasi.index');}
    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
    
}

