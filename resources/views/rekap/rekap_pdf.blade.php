<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi {{ $siswa->nama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h3>Rekap Absensi - {{ $siswa->nama }}</h3>
    <p><strong>NIS:</strong> {{ $siswa->nis }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $key => $a)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $a->jam_masuk ?? '-' }}</td>
                <td>{{ $a->jam_pulang ?? '-' }}</td>
                <td>{{ $a->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:20px;">Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
</body>
</html>
