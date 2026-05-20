@extends('layouts.app')

@section('content')
<style>
    body {
        background: url('{{ asset('images/batikabu.jpg') }}') repeat;
        background-size: 350px;
        background-attachment: fixed;
        background-color: #e6e6e6; /* warna dasar abu elegan */
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9); /* semi transparan biar batik kelihatan lembut */
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
    </style>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📊 Rekap Absensi Siswa</h3>
        <a href="{{ route('absensi.index') }}" class="btn btn-secondary">
            ⬅ Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
               <thead class="table-primary text-center">
    <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>NIS</th>
        <th>Hadir</th>
        <th>Izin</th>
        <th>Sakit</th>
        <th>Alpha</th>
        <th>Total Hari</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    @foreach ($rekap as $key => $siswa)
    <tr class="text-center">
        <td>{{ $key + 1 }}</td>
        <td>{{ $siswa->nama }}</td>
        <td>{{ $siswa->nis }}</td>
        <td><span class="badge bg-success">{{ $siswa->total_hadir }}</span></td>
        <td><span class="badge bg-warning text-dark">{{ $siswa->total_izin }}</span></td>
        <td><span class="badge bg-info text-dark">{{ $siswa->total_sakit }}</span></td>
        <td><span class="badge bg-danger">{{ $siswa->total_alpha }}</span></td>
        <td>{{ $siswa->total_hari }}</td>
        <td>
            <a href="{{ route('absensi.rekap', $siswa->id) }}" class="btn btn-sm btn-primary">Detail</a>
            <a href="{{ route('absensi.rekap.pdf', $siswa->id) }}" class="btn btn-sm btn-danger">PDF</a>
        </td>
    </tr>
    @endforeach
</tbody>


            </table>
        </div>
    </div>
</div>
@endsection
