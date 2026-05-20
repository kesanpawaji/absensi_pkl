<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Absensi extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi
   protected $fillable = [
    'siswa_id',
    'tanggal',
    'jam_masuk',
    'jam_pulang',
    'status',
    'alasan', 
    'latitude',
    'longitude',
    'is_archived',
];


    // Relasi: Absensi milik satu siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // 🔹 Accessor untuk format tanggal jadi lebih rapi (opsional)
    public function getTanggalFormattedAttribute()
    {
        return Carbon::parse($this->tanggal)->translatedFormat('d F Y');
    }

    // 🔹 Scope untuk mempermudah query berdasarkan status
    public function scopeHadir($query)
    {
        return $query->where('status', 'Hadir');
    }

    public function scopeIzin($query)
    {
        return $query->where('status', 'Izin');
    }

    public function scopeAlpha($query)
    {
        return $query->where('status', 'Alpha');
    }

    // 🔹 Helper untuk hitung total durasi kehadiran (kalau jam masuk & pulang ada)
    public function getDurasiAttribute()
    {
        if (!$this->jam_masuk || !$this->jam_pulang) {
            return null;
        }

        $masuk = Carbon::parse($this->jam_masuk);
        $pulang = Carbon::parse($this->jam_pulang);
        return $masuk->diffInHours($pulang) . ' jam';
    }
}
