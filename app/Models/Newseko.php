<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newseko extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel yang digunakan oleh model.
     * Secara default, Laravel akan mengasumsikan nama tabel adalah bentuk jamak dari nama model ('newsekos').
     */
    protected $table = 'news';

    /**
     * Tentukan kolom-kolom yang bisa diisi secara massal (mass assignment).
     * Hanya kolom yang ada di dalam array ini yang bisa diisi untuk mencegah pengisian data yang tidak diinginkan.
     */
    protected $fillable = [
        'title',
        'author',
        'description',
        'content',
        'url',
        'url_image',
        'published_at',
        'category'
    ];

    /**
     * Tentukan cast untuk kolom tertentu agar tipe data sesuai.
     * Ini memastikan kolom 'published_at' diubah menjadi format DateTime ketika diambil dari database.
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Fungsi Scope untuk memfilter berita berdasarkan kategori.
     * Dengan menggunakan scope, kode untuk filter kategori bisa lebih clean.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Fungsi Scope untuk mencari berita berdasarkan judul.
     * Ini memudahkan pencarian berita dengan judul yang mengandung kata kunci tertentu.
     */
    public function scopeSearchTitle($query, $title)
    {
        return $query->where('title', 'LIKE', "%{$title}%");
    }
}
