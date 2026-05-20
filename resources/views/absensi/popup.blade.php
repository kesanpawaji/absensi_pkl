<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .popup-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
        }
        .foto-siswa {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ddd;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="popup-card">

    {{-- 🔥 FOTO SISWA DI POP-UP --}}
    <img 
        src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : asset('images/puncak.jpeg') }}"
        class="foto-siswa"
    >

    @if ($status === 'success')
        <div class="text-success fs-1 mb-3">✅</div>
    @elseif ($status === 'warning')
        <div class="text-warning fs-1 mb-3">⚠️</div>
    @else
        <div class="text-info fs-1 mb-3">ℹ️</div>
    @endif

    <h5 class="mb-2">{{ $nama }}</h5>
    <p class="mb-3">Keterangan: <b>{{ $keterangan }}</b></p>
    <h6 class="mb-4">{{ $message }}</h6>

    <button class="btn btn-primary w-100" onclick="window.close()">Tutup</button>
</div>


<script>
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        fetch("{{ route('absensi.scan') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                siswa_id: "{{ request('siswa_id') }}",
                type: "{{ request('type') }}",
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            })
        });
    });
}
</script>

</body>
</html>
