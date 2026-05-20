@extends('app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Data Siswa</h5>
    </div>

<style>
    body {
        background: url('{{ asset('images/batikabu.jpg') }}') repeat;
        background-size: 350px;
        background-attachment: fixed;
        background-color: #e6e6e6;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 12px;
        backdrop-filter: blur(4px);
    }

    h1, h4 {
        color: #2c3e50;
        font-weight: 700;
    }

    table th {
        background-color: #2c3e50 !important;
        color: white !important;
    }

    .btn { 
        border-radius: 8px;
    }

    .alert {
        border-radius: 8px;
    }

    /* Foto kecil di tabel */
    .foto-siswa {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ccc;
    }
</style>

    <div class="card-body">

        <div class="mb-3 d-flex justify-content-between">
            <a href="{{ route('index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('siswa.create') }}" class="btn btn-success">Tambah Siswa</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th> <!-- ⬅️ Kolom baru -->
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Sekolah/Univ</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($siswas as $siswa)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <!-- FOTO PROFIL -->
                    <td>
                     @if($siswa->foto)
                     <img src="{{ asset('storage/' . $siswa->foto) }}" class="foto-siswa">
                    @else
                     <img src="{{ asset('images/puncak.jpeg') }}" class="foto-siswa">
                      @endif


                    </td>

                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->sekolah }}</td>

                    <td>
                        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data siswa</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
