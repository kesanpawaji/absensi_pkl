@extends('app')

@section('content')
<style>
    body {
        background: url('{{ asset('images/batikabu.jpg') }}') repeat;
        background-size: 300px;
        background-color: #f0f0f0;
    }

    .dashboard-header {
        background: #0d6efd;
        color: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dashboard-header h2 {
        margin: 0;
        font-weight: 700;
    }

    /* Quick Content */
    .dashboard-content-box {
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        backdrop-filter: blur(4px);
    }

    /* Quick Action Card */
    .quick-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        padding: 18px;
        text-align: center;
        transition: 0.2s ease;
        cursor: pointer;
    }

    .quick-card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .quick-icon {
        font-size: 35px;
        color: #0d6efd;
        margin-bottom: 10px;
    }

    .logout-wrapper {
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 9999;
    }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const options = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
        document.getElementById('jamSekarang').innerText = now.toLocaleTimeString('id-ID', options);
    }
    setInterval(updateClock, 1000);
    window.onload = updateClock;
</script>

<div class="d-flex justify-content-between align-items-center p-3 bg-primary text-white">
    
    <div class="d-flex align-items-center gap-3">

        {{-- FOTO ADMIN --}}
        <img src="{{ asset('images/puncak.jpeg') }}" 
             class="rounded-circle border"
             style="width: 55px; height: 55px; object-fit: cover;">

        <div>
            <h5 class="mb-0">Good Morning, Admin!</h5>
            <small>Welcome to Aplikasi Absensi PKL</small>
        </div>

    </div>

    {{-- JAM --}}
    <div class="fs-4" id="jamSekarang">05.53.30</div>


</div>


    {{-- Quick Action --}}
    <div class="dashboard-content-box">

        <h4 class="mb-3 fw-bold">Quick Actions</h4>

        <div class="row g-3">

            <div class="col-md-3">
                <a href="{{ route('siswa.index') }}" style="text-decoration:none; color:inherit;">
                    <div class="quick-card">
                        <div class="quick-icon"><i class="bi bi-people-fill"></i></div>
                        <div>Kelola Siswa</div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('absensi.index') }}" style="text-decoration:none; color:inherit;">
                    <div class="quick-card">
                        <div class="quick-icon"><i class="bi bi-calendar-check-fill"></i></div>
                        <div>Kelola Absensi</div>
                    </div>
                </a>
            </div>

             <div class="col-md-3">
                <a href="{{ route('absensi.qrcode') }}" style="text-decoration:none; color:inherit;">
                    <div class="quick-card">
                  <div class="quick-icon"><i class="bi bi-qr-code-scan"></i></div>
                  <div>Qrcode Absensi</div>
                    </div>
                </a>
            </div>

                <div class="col-md-3">
                <a href="{{ route('rekap.index') }}" style="text-decoration:none; color:inherit;">
                    <div class="quick-card">
                  <div class="quick-icon"><i class="bi bi-bar-chart-fill"></i></div>
                  <div>Rekap Absensi</div>
                    </div>
                </a>
            </div>

        </div>

    </div>

</div>

@endsection
