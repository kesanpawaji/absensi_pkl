@extends('app')

@section('content')
@php
    // Deteksi apakah user menggunakan perangkat mobile
    $isMobile = preg_match('/(android|iphone|ipad|ipod|mobile)/i', $_SERVER['HTTP_USER_AGENT']);
@endphp

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
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Data Absensi</h1>
    <div>
        {{-- Tombol Kembali ke Admin --}}
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
            <i class="bi bi-house-door-fill"></i> Kembali ke Admin
        </a>
        <a href="{{ route('absensi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Manual
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@elseif(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex justify-content-center">
    <div class="card shadow-sm" style="width: 95%; max-width: 1000px; margin-right: 20px;">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Foto</th> {{--  ✅ Foto siswa --}}
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status</th>
                            <th>Alasan</th>
                            <th>Lokasi</th>
                            @unless($isMobile)
                                <th>Aksi</th>
                            @endunless
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($absensis as $i => $row)
                            <tr class="text-center">
                                <td>{{ $i + 1 }}</td>

                                {{-- FOTO SISWA --}}
                                <td>
                                    @if($row->siswa && $row->siswa->foto)
                                        <img src="{{ asset('storage/' . $row->siswa->foto) }}"
                                            style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                                    @else
                                        <img src="{{ asset('images/default.png') }}"
                                            style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                                    @endif
                                </td>

                                <td>{{ $row->siswa->nama ?? '-' }}</td>
                                <td>{{ $row->siswa->nis ?? '-' }}</td>

                                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>

                                <td>
                                    @if($row->jam_masuk)
                                        <span class="badge bg-success">{{ $row->jam_masuk }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    @if($row->jam_pulang)
                                        <span class="badge bg-primary">{{ $row->jam_pulang }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    @if($row->status === 'Hadir')
                                        <span class="badge bg-success">Hadir</span>
                                    @elseif($row->status === 'Izin')
                                        <span class="badge bg-warning text-dark">Izin</span>
                                    @elseif($row->status === 'Sakit')
                                        <span class="badge bg-info text-dark">Sakit</span>
                                    @else
                                        <span class="badge bg-danger">Alpha</span>
                                    @endif
                                </td>

                                <td>
                                    @if(in_array($row->status, ['Izin', 'Sakit']) && $row->alasan)
                                        {{ $row->alasan }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    @if($row->latitude && $row->longitude)
                                        <a href="https://maps.google.com/?q={{ $row->latitude }},{{ $row->longitude }}"
                                           target="_blank"
                                           class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-geo-alt-fill"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                @unless($isMobile)
                                    <td>
                                       <form action="{{ route('absensi.destroy', $row->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit"
            class="btn btn-warning btn-sm"
            onclick="return confirm('Pindahkan data ke arsip?')">
        <i class="bi bi-archive"></i> Arsip
    </button>
</form>

                                    </td>
                                @endunless
                            </tr>

                        @empty
                            <tr>
                                <td colspan="{{ $isMobile ? 10 : 11 }}" class="text-center text-muted py-3">
                                    <i class="bi bi-inbox"></i> Belum ada data absensi.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
