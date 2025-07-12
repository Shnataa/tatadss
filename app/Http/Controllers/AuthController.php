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
        {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->intended('/dashboard');
    }

    return back()->with('error', 'Email atau password salah.');
}
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
        $user = User::all();
        return view('registrasi.index', compact('user'));
    }
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
        return redirect()->route('registrasi.index')->with('success', 'Registrasi berhasil. Silakan login.');

        
    }

    // GET /registrasi/{id}
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('registrasi.show', compact('user'));
    }

    // GET /registrasi/{id}/edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('registrasi.edit', compact('user'));
    }

    // PUT/PATCH /registrasi/{id}
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$id",
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('registrasi.index')->with('success', 'Data berhasil diperbarui.');
    }

    // DELETE /registrasi/{id}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('registrasi.index')->with('success', 'User berhasil dihapus.');
    }
    
}

