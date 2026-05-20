@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-5 text-center" style="background:rgba(255,255,255,0.95);">
        <h2 class="mb-3">Selamat Datang di Aplikasi Absensi PKL</h2>
        <p class="lead mb-4">
            Silakan gunakan menu di atas untuk mengelola data siswa dan absensi.<br>
            Semoga harimu menyenangkan!
        </p>
        <a href="{{ route('absensi.index') }}" class="btn btn-primary">
            Lihat Data Absensi
        </a>
    </div>
</div>
@endsection
