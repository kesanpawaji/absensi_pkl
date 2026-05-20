<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi
   protected $fillable = [
    'nama',
    'nis',
    'sekolah',
    'foto',   // 🔥 WAJIB
];


    // 🔹 Relasi ke model Absensi (satu siswa punya banyak absensi)
    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    // 🔹 Helper untuk menghitung rekap absensi siswa
    public function getTotalHadirAttribute()
    {
        return $this->absensis()->where('status', 'Hadir')->count();
    }

    public function getTotalIzinAttribute()
    {
        return $this->absensis()->where('status', 'Izin')->count();
    }

    public function getTotalAlphaAttribute()
    {
        return $this->absensis()->where('status', 'Alpha')->count();
    }

    public function getTotalHariAttribute()
    {
        return $this->absensis()->count();
    }

    // 🔹 (Opsional) Tambahkan accessor untuk inisial
    public function getInisialAttribute()
    {
        $words = explode(' ', $this->nama);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials;
    }
    public function getTotalSakitAttribute()
    {

    return $this->absensis()->where('status', 'Sakit')->count();
    
    }


}
