@extends('app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header text-white" 
         style="background: #243447;">
        <h5 class="mb-0"><i class="bi bi-archive me-2"></i> Data Arsip Absensi</h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle"
                   style="border-radius: 12px; overflow: hidden;">
                <thead style="background:#243447; color:white;">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-center">Restore</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($absensis as $index => $absen)
                        <tr style="background: #f8f9fa;">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $absen->siswa->nama }}</td>
                            <td>{{ $absen->tanggal }}</td>
                            <td>
                                <span class="badge 
                                    @if($absen->status == 'Hadir') bg-success
                                    @elseif($absen->status == 'Izin') bg-warning text-dark
                                    @elseif($absen->status == 'Sakit') bg-info text-dark
                                    @else bg-danger
                                    @endif">
                                    {{ $absen->status }}
                                </span>
                            </td>

                            <td class="text-center">
                                <form action="{{ route('absensi.restore', $absen->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-arrow-counterclockwise"></i> Restore
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>
@endsection
