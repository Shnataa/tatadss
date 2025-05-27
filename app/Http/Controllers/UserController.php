<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Dashboard pengguna
    public function dashboard()
    {
        $user = Auth::user(); // Ambil data pengguna yang sedang login
        return view('user.dashboard', compact('user'));
    }

    // Halaman profil pengguna
    public function profile()
    {
        $user = Auth::user(); // Ambil data pengguna yang sedang login
        return view('user.profile', compact('user'));
    }

    // Update profil pengguna
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui');
    }

    // Halaman untuk mengubah password
    public function changePassword()
    {
        return view('user.change-password');
    }

    // Proses ubah password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('user.profile')->with('success', 'Password berhasil diubah');
    }
}
