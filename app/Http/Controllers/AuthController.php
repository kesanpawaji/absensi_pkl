<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Username atau password salah!');
        }

        // Simpan session admin
        session([
            'admin_id' => $admin->id,
            'admin_username' => $admin->username,
        ]);

        return redirect()->route('index')->with('success', 'Berhasil login!');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.login')->with('success', 'Berhasil logout!');
    }


    // ============================================================
    // 🆕 REGISTER ADMIN (TAMBAHAN)
    // ============================================================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admins',
            'password' => 'required|min:6|confirmed',
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Akun berhasil dibuat! Silakan login.');
    }
}
