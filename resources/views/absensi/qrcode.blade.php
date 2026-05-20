@extends('app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white text-center">
        <h5 class="mb-0">QR Code Absensi</h5>
    </div>

    <div class="card-body">
        <p class="text-center mb-4">
            Scan QR code untuk membuka Form Absensi. Setelah discan, sistem akan otomatis mencatat lokasi siswa.
        </p>

        {{-- Jika controller mengirimkan single $qrCode --}}
        @if(isset($qrCode))
            <div class="text-center mb-3">
                <div id="qrContainer" class="d-inline-block p-3 border rounded shadow-sm bg-white">
                    {!! $qrCode !!}
                </div>

                <div class="mt-3">
                    <button id="downloadQR" class="btn btn-success">
                        <i class="bi bi-download"></i> Download QR Code
                    </button>
                    <a href="{{ route('absensi.create') }}" class="btn btn-primary">
                        <i class="bi bi-box-arrow-up-right"></i> Buka Form Absensi Manual
                    </a>
                </div>
            </div>
        @endif

        {{-- Jika controller mengirimkan $data (banyak siswa) --}}
        @if(isset($data))
            <div class="row">
                @foreach ($data as $item)
                    <div class="col-md-4 mb-4">
                        <div class="border rounded shadow-sm p-3 text-center bg-white">
                            <h6 class="fw-bold mb-2">{{ $item['siswa']->nama }}</h6>

                            <div class="mb-3">
                                <p class="text-muted small mb-1">Masuk</p>
                                <div id="qrMasuk-{{ $item['siswa']->id }}" class="d-inline-block p-2 bg-light">
                                    {!! $item['qrMasuk'] !!}
                                </div>
                                <br>
                                <button class="btn btn-success btn-sm mt-2 download-btn"
                                        data-target="qrMasuk-{{ $item['siswa']->id }}"
                                        data-name="qr-masuk-{{ \Illuminate\Support\Str::slug($item['siswa']->nama) }}">
                                    <i class="bi bi-download"></i> Download Masuk
                                </button>
                            </div>

                            <div>
                                <p class="text-muted small mb-1">Pulang</p>
                                <div id="qrPulang-{{ $item['siswa']->id }}" class="d-inline-block p-2 bg-light">
                                    {!! $item['qrPulang'] !!}
                                </div>
                                <br>
                                <button class="btn btn-primary btn-sm mt-2 download-btn"
                                        data-target="qrPulang-{{ $item['siswa']->id }}"
                                        data-name="qr-pulang-{{ \Illuminate\Support\Str::slug($item['siswa']->nama) }}">
                                    <i class="bi bi-download"></i> Download Pulang
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(!isset($qrCode) && !isset($data))
            <div class="alert alert-warning text-center">Tidak ada QR untuk ditampilkan.</div>
        @endif
    </div>
</div>

{{-- Script download yang bekerja untuk single atau multiple QR --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    // for single QR
    const btnSingle = document.getElementById("downloadQR");
    if (btnSingle) {
        btnSingle.addEventListener("click", function() {
            const svg = document.querySelector("#qrContainer svg");
            if (!svg) return alert("QR Code tidak ditemukan!");
            downloadSvgAsPng(svg, "qr-absensi");
        });
    }

    // for many QR
    document.querySelectorAll(".download-btn").forEach(btn => {
        btn.addEventListener("click", function() {
            const target = this.dataset.target;
            const name = this.dataset.name || "qr";
            const svg = document.querySelector(`#${target} svg`);
            if (!svg) return alert("QR Code tidak ditemukan!");
            downloadSvgAsPng(svg, name);
        });
    });

    function downloadSvgAsPng(svg, fileName) {
        const svgData = new XMLSerializer().serializeToString(svg);
        const svgBlob = new Blob([svgData], { type: "image/svg+xml;charset=utf-8" });
        const url = URL.createObjectURL(svgBlob);
        const img = new Image();
        img.onload = function() {
            const canvas = document.createElement("canvas");
            canvas.width = img.width;
            canvas.height = img.height;
            const ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);
            URL.revokeObjectURL(url);
            const pngUrl = canvas.toDataURL("image/png");
            const link = document.createElement("a");
            link.href = pngUrl;
            link.download = fileName + ".png";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };
        img.src = url;
    }
});
</script>
@endsection
