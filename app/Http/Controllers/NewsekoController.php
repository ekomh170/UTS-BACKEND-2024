<?php

namespace App\Http\Controllers;

use App\Models\Newseko;
use Illuminate\Http\Request;

class NewsekoController extends Controller
{
    /**
     * Menampilkan semua berita yang ada di database.
     * Hanya bisa diakses oleh pengguna yang sudah login.
     * Mengembalikan data berita dalam format JSON dengan status 200 (OK).
     */
    public function index()
    {
        $news = Newseko::all();
        // \dd($news);
        return response()->json($news, 200);
    }

    /**
     * Menyimpan data berita baru.
     * Hanya bisa diakses oleh pengguna yang sudah login.
     * Mengembalikan data berita yang baru dibuat dan pesan sukses dengan status 201 (Created).
     */
    public function store(Request $request)
    {
        $validatedDataEko = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'content' => 'required',
            'url' => 'required',
            'url_image' => 'nullable',
            'published_at' => 'required|date',
            'category' => 'required|string|max:255',
        ]);

        $newseko = Newseko::create($validatedDataEko);
        return response()->json(['message' => 'Berita berhasil dibuat', 'data' => $newseko], 201);
    }

    /**
     * Menampilkan berita tertentu berdasarkan ID.
     * Hanya bisa diakses oleh pengguna yang sudah login.
     * Mengembalikan data berita yang diminta dalam format JSON dengan status 200 (OK).
     */
    public function show(Newseko $newseko)
    {
        return response()->json($newseko, 200);
    }

    /**
     * Memperbarui data berita yang sudah ada berdasarkan ID.
     * Hanya bisa diakses oleh pengguna yang sudah login.
     * Data yang diterima harus melalui proses validasi terlebih dahulu.
     * Mengembalikan data berita yang telah diperbarui dan pesan sukses dengan status 200 (OK).
     */
    public function update(Request $request, Newseko $newseko)
    {
        $validatedDataEko = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'content' => 'required',
            'url' => 'required',
            'url_image' => 'nullable',
            'published_at' => 'required|date',
            'category' => 'required|string|max:255',
        ]);

        $newseko->update($validatedDataEko);
        return response()->json(['message' => 'Berita berhasil diperbarui', 'data' => $newseko], 200);
    }

    /**
     * Menghapus berita tertentu berdasarkan ID.
     * Hanya bisa diakses oleh pengguna yang sudah login.
     * Mengembalikan pesan sukses dengan status 200 (OK) setelah berita dihapus.
     */
    public function destroy(Newseko $newseko)
    {
        $newseko->delete();
        return response()->json(['message' => 'Berita berhasil dihapus'], 200);
    }

    /**
     * Mencari berita berdasarkan judul.
     * Mencari berita yang judulnya mengandung kata kunci tertentu.
     * Hanya bisa diakses oleh pengguna yang sudah login.
     * Mengembalikan daftar berita yang cocok dalam format JSON dengan status 200 (OK).
     */
    public function search($title)
    {
        // Menggunakan scope searchTitle untuk mencari berdasarkan judul
        $news = Newseko::searchTitle($title)->get();
        return response()->json($news, 200);
    }

    /**
     * Mendapatkan semua berita dengan kategori tertentu.
     * Kategori bisa berupa 'sport', 'finance', atau 'automotive'.
     * Hanya bisa diakses oleh pengguna yang sudah login.
     * Mengembalikan daftar berita dengan kategori tersebut dalam format JSON dengan status 200 (OK).
     */
    public function getByCategory($category)
    {
        // Menggunakan scope category untuk filter berdasarkan kategori
        $news = Newseko::category($category)->get();
        return response()->json($news, 200);
    }
}
