<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Fungsi untuk registrasi pengguna baru.
     * Mengembalikan pesan sukses jika registrasi berhasil.
     */
    public function register(Request $request)
    {
        // Validasi input registrasi
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
        ]);

        // Menyiapkan data input untuk pembuatan user
        $input = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ];

        // Membuat user baru
        $user = User::create($input);

        // Mengembalikan respons sukses
        return response()->json(['message' => 'Pengguna berhasil dibuat'], 201);
    }

    /**
     * Fungsi untuk login pengguna.
     * Mengembalikan token jika login berhasil.
     */
    public function login(Request $request)
    {
        // Validasi input login
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Mengambil data user berdasarkan email
        $user = User::where('email', $validatedData['email'])->first();

        // Memeriksa apakah password cocok
        if ($user && Hash::check($validatedData['password'], $user->password)) {
            // Membuat token autentikasi
            $token = $user->createToken('auth_token')->plainTextToken;

            // Mengembalikan respons dengan token
            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
            ], 200);
        } else {
            // Mengembalikan respons error jika login gagal
            return response()->json(['message' => 'Email atau kata sandi salah'], 401);
        }
    }

    /**
     * Fungsi untuk logout pengguna.
     * Menghapus token yang digunakan untuk autentikasi.
     */
    public function logout(Request $request)
    {
        // Mengambil user yang saat ini terautentikasi
        $user = $request->user();

        // Menghapus token yang sedang digunakan
        $user->tokens->delete();

        // Mengembalikan respons sukses
        return response()->json(['message' => 'Logout berhasil'], 200);
    }
}
