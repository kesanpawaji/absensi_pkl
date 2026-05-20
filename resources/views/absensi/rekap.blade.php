@extends('layouts.app')

@section('content')

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

    h1, h3, h4 {
        color: #2c3e50;
        font-weight: 700;
    }

    table th {
        background-color: #2c3e50 !important;
        color: white !important;
        text-align: center;
    }

    .btn {
        border-radius: 8px;
    }

    .alert {
        border-radius: 8px;
    }
</style>


<div class="d-flex justify-content-center mt-4">
    <div class="card shadow-sm" style="width: 95%; max-width: 1000px;">

        <div class="card-body">

            <h3>📋 Rekap Absensi {{ $siswa->nama }}</h3>
            <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
            <p><strong>Sekolah:</strong> {{ $siswa->sekolah }}</p>

            @if($siswa->absensis->isEmpty())
                <div class="alert alert-info mt-3">
                    Belum ada data absensi untuk siswa ini.
                </div>
            @else
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status</th>
                            <th>Alasan</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa->absensis as $i => $a)
                        <tr class="text-center">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $a->tanggal }}</td>
                            <td>{{ $a->jam_masuk ?? '-' }}</td>
                            <td>{{ $a->jam_pulang ?? '-' }}</td>

                            <td>
                                <span class="badge 
                                    @if($a->status == 'Hadir') bg-success 
                                    @elseif($a->status == 'Izin') bg-warning text-dark 
                                    @elseif($a->status == 'Sakit') bg-info text-dark 
                                    @else bg-danger 
                                    @endif">
                                    {{ $a->status }}
                                </span>
                            </td>

                            <td>{{ $a->alasan ?? '-' }}</td>

                            <td>
                                @if($a->latitude && $a->longitude)
                                    <a target="_blank"
                                       href="https://maps.google.com?q={{ $a->latitude }},{{ $a->longitude }}"
                                       class="btn btn-outline-info btn-sm">
                                       📍 Lihat
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <a href="{{ route('rekap.index') }}" class="btn btn-secondary mt-3">
                ⬅ Kembali
            </a>

        </div>
    </div>
</div>

@endsection
