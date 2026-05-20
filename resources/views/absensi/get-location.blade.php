@extends('app')

@section('content')
<div class="card shadow-sm text-center p-4">
    <h5 class="mb-3 text-success">📍 Sedang Mendapatkan Lokasi Anda...</h5>
    <p class="text-muted">Mohon izinkan akses lokasi agar sistem bisa mencatat kehadiran Anda.</p>

    <div id="map" style="width:100%; height:300px; border-radius:10px; margin-top:15px; display:none;"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const siswaId = "{{ request('siswa_id') }}";
    const type = "{{ request('type') }}";
    const mapDiv = document.getElementById('map');

    // ✅ Deteksi perangkat
    const isMobile = /Mobi|Android/i.test(navigator.userAgent);
    if (!isMobile) {
        mapDiv.innerHTML = `<p class="text-warning mt-3">⚠️ Absensi hanya bisa dilakukan dari HP agar lokasi akurat.</p>`;
        return;
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;

                mapDiv.style.display = 'block';
                mapDiv.innerHTML = `
                    <iframe 
                        width="100%" height="300" style="border:0; border-radius:10px;"
                        loading="lazy" allowfullscreen
                        src="https://www.google.com/maps?q=${lat},${lng}&hl=id&z=17&output=embed">
                    </iframe>
                `;

                setTimeout(() => {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/absensi/scan?siswa_id=${siswaId}&type=${type}`;

                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';
                    form.appendChild(token);

                    const latInput = document.createElement('input');
                    latInput.type = 'hidden';
                    latInput.name = 'latitude';
                    latInput.value = lat;
                    form.appendChild(latInput);

                    const lngInput = document.createElement('input');
                    lngInput.type = 'hidden';
                    lngInput.name = 'longitude';
                    lngInput.value = lng;
                    form.appendChild(lngInput);

                    document.body.appendChild(form);
                    form.submit();
                }, 2000);
            },
            function(err) {
                alert("⚠️ Gagal mendeteksi lokasi. Aktifkan GPS & izinkan akses lokasi di browser Anda.");
                mapDiv.innerHTML = '<p class="text-danger">❌ Tidak dapat memuat peta.</p>';
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    } else {
        alert("Browser Anda tidak mendukung fitur lokasi.");
    }
});

</script>
@endsection
