@extends('app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Edit Data Siswa</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $siswa->nama }}" required>
                </div>

                {{-- NIS --}}
                <div class="mb-3">
                    <label class="form-label">NIS/NIM</label>
                    <input type="text" name="nis" class="form-control" value="{{ $siswa->nis }}" required>
                </div>

                {{-- Sekolah --}}
                <div class="mb-3">
                    <label class="form-label">Sekolah/Univ</label>
                    <input type="text" name="sekolah" class="form-control" value="{{ $siswa->sekolah }}" required>
                </div>

                {{-- Foto Lama --}}
                <div class="mb-3">
                    <label class="form-label">Foto Saat Ini</label><br>
<img 
    src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : asset('images/puncak.jpeg') }}" 
    id="fotoLama"
    style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:2px solid #ddd;">


                </div>

                {{-- Upload Foto Baru --}}
                <div class="mb-3">
                    <label class="form-label">Ganti Foto (Opsional)</label>
                    <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
                </div>

                {{-- Preview Foto Baru --}}
                <div class="mb-3" id="previewBaru" style="display:none;">
                    <label class="form-label">Preview Foto Baru</label><br>
                    <img id="fotoBaru" 
                         style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:2px solid #4caf50;">
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

{{-- Preview Foto Baru --}}
<script>
document.getElementById('fotoInput').addEventListener('change', function(e) {
    let file = e.target.files[0];
    if (file) {
        let url = URL.createObjectURL(file);
        document.getElementById('fotoBaru').src = url;
        document.getElementById('previewBaru').style.display = "block";
    }
});
</script>

@endsection
