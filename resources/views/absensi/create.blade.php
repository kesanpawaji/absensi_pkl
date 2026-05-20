@extends('app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Form Absensi</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('absensi.store') }}" method="POST" id="formAbsensi">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <select name="siswa_id" class="form-select" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $siswa)
                        <option 
                            value="{{ $siswa->id }}"
                            data-foto="{{ asset('storage/' . ($siswa->foto ?? 'default.png')) }}"
                        >
                            {{ $siswa->nama }} ({{ $siswa->nis }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 📌 Preview Foto Siswa --}}
            <div id="fotoPreview" style="margin-bottom: 15px; display:none;">
                <img id="fotoImg" 
                     src="" 
                     style="width:70px; height:70px; border-radius:50%; object-fit:cover; border:2px solid #ddd;">
            </div>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Alfa">Alfa</option>
                </select>
            </div>

            {{-- Kolom alasan --}}
            <div class="mb-3" id="alasan-group" style="display:none;">
                <label class="form-label">Alasan</label>
                <textarea name="alasan" id="alasan" class="form-control" rows="3" placeholder="Masukkan alasan izin/sakit..."></textarea>
            </div>

            <button type="submit" class="btn btn-success">Simpan Absensi</button>
            <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // === Preview foto siswa ===
    const selectSiswa = document.querySelector('select[name="siswa_id"]');
    const fotoPreview = document.getElementById('fotoPreview');
    const fotoImg = document.getElementById('fotoImg');

    selectSiswa.addEventListener('change', function () {
        let selected = this.options[this.selectedIndex];
        let foto = selected.getAttribute('data-foto');

        if (foto) {
            fotoImg.src = foto;
            fotoPreview.style.display = "block";
        } else {
            fotoPreview.style.display = "none";
        }
    });

    // === GPS Realtime ===
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(
            function(position) {
                const lat = position.coords.latitude.toFixed(6);
                const lng = position.coords.longitude.toFixed(6);
                const accuracy = position.coords.accuracy.toFixed(2);

                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;

                console.log(`Lokasi realtime: ${lat}, ${lng} (Akurasi: ±${accuracy} m)`);

                if (accuracy > 50) {
                    alert(`⚠️ Lokasi kurang akurat (±${accuracy} m). Coba nyalakan GPS atau pindah ke area terbuka.`);
                }
            },
            function(error) {
                alert("❌ Gagal mendapatkan lokasi: " + error.message);
            },
            {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            }
        );
    } else {
        alert("Browser tidak mendukung geolocation.");
    }

    // === Munculkan kolom alasan kalau status Izin / Sakit ===
    const statusSelect = document.getElementById("status");
    const alasanGroup = document.getElementById("alasan-group");
    const alasanInput = document.getElementById("alasan");

    statusSelect.addEventListener("change", function() {
        const selected = this.value;
        if (selected === "Izin" || selected === "Sakit") {
            alasanGroup.style.display = "block";
        } else {
            alasanGroup.style.display = "none";
            alasanInput.value = "";
        }
    });
});
</script>
@endsection
