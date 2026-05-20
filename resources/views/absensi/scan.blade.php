<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scan QR Absensi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">

<div class="text-center">
  <h5 class="mb-3">Tunggu sebentar...</h5>
  <p>Sistem sedang mengambil lokasi GPS Anda.</p>
  <button class="btn btn-secondary mt-3" onclick="history.back()">Kembali</button>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  if (!navigator.geolocation) {
    alert("❌ Browser tidak mendukung GPS.");
    return;
  }

  navigator.geolocation.getCurrentPosition(
    async function (position) {
      const data = {
        siswa_id: "{{ $siswa_id }}",
        type: "{{ $type }}",
        latitude: position.coords.latitude,
        longitude: position.coords.longitude,
      };

      // 🧠 Ganti URL sesuai domain ngrok kamu
      const apiUrl = "/absensi/storeScan";

      console.log("📡 Mengirim data ke:", apiUrl, data);

      try {
        const res = await fetch(apiUrl, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json", // tambahkan ini penting untuk Laravel
          },
          body: JSON.stringify(data),
        });

        if (!res.ok) {
          const text = await res.text();
          throw new Error(`Server error (${res.status}): ${text}`);
        }

        // Jika backend return HTML (misal redirect ke halaman sukses)
        const html = await res.text();
        document.body.innerHTML = html;
      } catch (err) {
        alert("❌ Gagal kirim data ke server: " + err.message);
        console.error("Fetch error:", err);
      }
    },
    function (error) {
      let msg = "";
      switch (error.code) {
        case error.PERMISSION_DENIED:
          msg = "Izin lokasi ditolak oleh pengguna.";
          break;
        case error.POSITION_UNAVAILABLE:
          msg = "Lokasi tidak tersedia (mungkin GPS mati).";
          break;
        case error.TIMEOUT:
          msg = "Waktu tunggu lokasi habis.";
          break;
        default:
          msg = "Terjadi kesalahan saat mendapatkan lokasi.";
      }
      alert("⚠️ " + msg);
    },
    { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
  );
});
</script>

</body>
</html>
