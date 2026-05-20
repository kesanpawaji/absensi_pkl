@extends('app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Form Tambah Siswa</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">NIS/NIM</label>
                <input type="text" name="nis" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Sekolah/Univ</label>
                <input type="text" name="sekolah" class="form-control" required>
            </div>

            <!-- 🎯 Tambahan: Upload Foto -->
            <div class="mb-3">
                <label class="form-label">Foto Profil <small class="text-muted">(opsional)</small></label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-success">Simpan
            </button>
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
