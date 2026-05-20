<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        h3, p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

    <h3>📋 Rekap Absensi {{ $siswa->nama }}</h3>
    <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
    <p><strong>Sekolah:</strong> {{ $siswa->sekolah }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
                <th>Alasan</th> {{-- 🆕 tambahan --}}
            </tr>
        </thead>
        <tbody>
            @foreach($siswa->absensis as $i => $a)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $a->tanggal }}</td>
                <td>{{ $a->jam_masuk ?? '-' }}</td>
                <td>{{ $a->jam_pulang ?? '-' }}</td>
                <td>{{ $a->status }}</td>
                <td>{{ $a->alasan ?? '-' }}</td> {{-- tampilkan alasan --}}
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
