<nav class="bg-primary text-white vh-100 d-flex flex-column align-items-center py-4 shadow-sm" 
     style="width: 240px; position: fixed;">

    <!-- 🟦 Logo Taspen -->
    <div class="mb-3">
        <div class="bg-white rounded-3 shadow-sm p-2 d-flex align-items-center justify-content-center" 
             style="width: 100px; height: 100px;">
            <img src="{{ asset('images/taspenlogo.jpg') }}" 
                 alt="Taspen Logo" 
                 style="max-width: 85px; max-height: 85px; object-fit: contain;">
        </div>
    </div>

    <!-- Judul Aplikasi -->
    <h5 class="text-center fw-semibold mb-4 mt-2">Absensi PKL</h5>

    <!-- Navigasi -->
    <ul class="nav flex-column w-100 px-3">

        <li class="nav-item mb-2">
            <a href="{{ route('index') }}" 
               class="nav-link d-flex align-items-center 
                      {{ request()->routeIs('index') ? 'active' : '' }}">
                <span class="active-line"></span>
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('absensi.index') }}"
               class="nav-link d-flex align-items-center 
                      {{ request()->routeIs('absensi.index*') ? 'active' : '' }}">
                <span class="active-line"></span>
                <i class="bi bi-clock-history me-2"></i> Data Absensi
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('siswa.index') }}"
               class="nav-link d-flex align-items-center 
                      {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                <span class="active-line"></span>
                <i class="bi bi-people me-2"></i> Data Siswa
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('absensi.qrcode') }}"
               class="nav-link d-flex align-items-center 
                      {{ request()->routeIs('absensi.qrcode') ? 'active' : '' }}">
                <span class="active-line"></span>
                <i class="bi bi-qr-code me-2"></i> QR Code
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('rekap.index') }}"
               class="nav-link d-flex align-items-center 
                      {{ request()->routeIs('rekap.*') ? 'active' : '' }}">
                <span class="active-line"></span>
                <i class="bi bi-bar-chart-line me-2"></i> Rekap Absensi
            </a>
        </li>
        <li class="nav-item mb-2">
        <a href="{{ route('absensi.arsip') }}"
         class="nav-link d-flex align-items-center 
              {{ request()->routeIs('absensi.arsip') ? 'active' : '' }}">
        <span class="active-line"></span>
        <i class="bi bi-archive me-2"></i> Arsip Absensi
             </a>
             </li>


        {{-- Logout paling bawah --}}
        <li class="nav-item mt-4">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </li>

    </ul>

    <!-- Footer kecil -->
    <div class="mt-auto text-center small text-light opacity-75">
        <hr class="border-light w-75 mx-auto">
        <p class="mb-0">© {{ date('Y') }} Taspen</p>
    </div>
</nav>

<style>
    /* Garis kiri saat menu aktif */
    .nav-link {
        position: relative;
        color: #ffffff;
        padding-left: 15px;
        border-radius: 8px;
        transition: background 0.25s, padding-left 0.2s;
    }

    .nav-link .active-line {
        position: absolute;
        left: -12px;
        width: 5px;
        height: 0;
        background: #fff;
        border-radius: 10px;
        transition: height 0.25s;
    }

    /* Efek hover */
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.20);
        padding-left: 20px;
    }

    /* Menu aktif */
    .nav-link.active {
        background: rgba(255, 255, 255, 0.30);
        font-weight: 600;
        padding-left: 20px;
    }

    .nav-link.active .active-line {
        height: 100%;
    }
</style>
