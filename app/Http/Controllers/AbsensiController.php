<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class AbsensiController extends Controller
{
    /** 🧾 Tampilkan daftar absensi */
    public function index()
    {
        $absensis = Absensi::with('siswa')
        ->where('is_archived', false)
        ->latest()
        ->get();
        return view('absensi.index', compact('absensis'));

    }

    /** ➕ Form absensi manual */
    public function create()
    {
        $siswas = Siswa::orderBy('nama')->get();
        return view('absensi.create', compact('siswas'));
    }

    /** 💾 Simpan absensi manual */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'status'   => 'required|string',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'alasan' => 'nullable|string|max:255',
        ]);

        $tanggal = date('Y-m-d');

        // Cegah absen ganda di hari yang sama
        $cek = Absensi::where('siswa_id', $request->siswa_id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($cek) {
            return redirect()->route('absensi.index')
                ->with('info', 'Siswa ini sudah melakukan absensi hari ini!');
        }

        Absensi::create([
            'siswa_id'  => $request->siswa_id,
            'tanggal'   => $tanggal,
            'jam_masuk' => date('H:i:s'),
            'status'    => $request->status,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'alasan'    => $request->alasan, 
        ]);

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil disimpan!');
    }

    /** 👁️ Detail absensi */
    public function show($id)
    {
        $absen = Absensi::with('siswa')->findOrFail($id);
        return view('absensi.show', compact('absen'));
    }

    /** ✏️ Edit absensi */
    public function edit($id)
    {
        $absen = Absensi::findOrFail($id);
        $siswas = Siswa::orderBy('nama')->get();
        return view('absensi.edit', compact('absen', 'siswas'));
    }

    /** 🔄 Update absensi */
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'status'   => 'required|string',
        ]);

        $absen = Absensi::findOrFail($id);

        $absen->update([
            'siswa_id'   => $request->siswa_id,
            'status'     => $request->status,
            'jam_masuk'  => $request->jam_masuk ?? $absen->jam_masuk,
            'jam_pulang' => $request->jam_pulang ?? $absen->jam_pulang,
            'latitude'   => $request->latitude ?? $absen->latitude,
            'longitude'  => $request->longitude ?? $absen->longitude,
        ]);

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil diperbarui!');
    }

    /** 🗑️ Archive (bukan delete) */
    public function destroy($id)
    {
        $absen = Absensi::findOrFail($id);

        // Arsipkan (tidak menghapus)
        $absen->update([
            'is_archived' => true
        ]);

        return redirect()->route('absensi.index')
            ->with('success', 'Data absensi berhasil diarsipkan!');
    }

    /** 🧾 Generate QR Code unik per siswa */
    public function qrcode()
    {
        $baseUrl = config('app.url');
        $siswas = Siswa::orderBy('nama')->get();

        $data = $siswas->map(function ($siswa) use ($baseUrl) {
            $urlMasuk  = $baseUrl . "/absensi/scan?siswa_id={$siswa->id}&type=masuk";
            $urlPulang = $baseUrl . "/absensi/scan?siswa_id={$siswa->id}&type=pulang";

            return [
                'siswa'     => $siswa,
                'qrMasuk'   => QrCode::size(200)->generate($urlMasuk),
                'qrPulang'  => QrCode::size(200)->generate($urlPulang),
            ];
        });

        return view('absensi.qrcode', compact('data'));
    }

    /** 📱 Halaman scan QR (ambil lokasi & tampilkan map GPS) */
    public function scan(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'type'     => 'required|in:masuk,pulang',
        ]);

        return view('absensi.scan', [
            'siswa_id' => $request->siswa_id,
            'type'     => $request->type,
        ]);
    }

    /** 🚀 Proses simpan hasil scan */
    public function storeScan(Request $request)
    {
        try {
            // Ambil semua data JSON
            $data = $request->json()->all();
            $request->merge($data);

            // Validasi
            $request->validate([
                'qr_data'   => 'nullable|string',
                'siswa_id'  => 'nullable|exists:siswas,id',
                'latitude'  => 'required',
                'longitude' => 'required',
                'type'      => 'required|in:masuk,pulang',
            ]);

            $siswaId = $request->siswa_id;

            // Ambil dari QR jika belum ada
            if (!$siswaId && $request->qr_data) {
                parse_str(parse_url($request->qr_data, PHP_URL_QUERY), $params);
                $siswaId = $params['siswa_id'] ?? null;
            }

            // QR tidak valid
            if (!$siswaId) {
                return response(view('absensi.popup', [
                    'status'      => 'danger',
                    'nama'        => '-',
                    'foto'        => 'default.png',
                    'keterangan'  => 'QR tidak valid',
                    'message'     => 'QR Code tidak dikenali atau rusak.',
                    'siswa'       => null,
                ]), 200);
            }

            // Ambil siswa
            $siswa = Siswa::find($siswaId);

            if (!$siswa) {
                return response(view('absensi.popup', [
                    'status'      => 'danger',
                    'nama'        => '-',
                    'foto'        => 'default.png',
                    'keterangan'  => 'Data tidak ditemukan',
                    'message'     => 'Siswa tidak terdaftar.',
                    'siswa'       => null,
                ]), 200);
            }

            $tanggal = now()->format('Y-m-d');
            $jamSekarang = now()->format('H:i:s');

            $absen = Absensi::where('siswa_id', $siswa->id)
                ->where('tanggal', $tanggal)
                ->first();

            // ======================
            // MASUK
            // ======================
            if ($request->type === 'masuk') {

                if ($absen) {
                    return response(view('absensi.popup', [
                        'status'      => 'info',
                        'nama'        => $siswa->nama,
                        'foto'        => $siswa->foto ?? 'default.png',
                        'keterangan'  => 'Sudah hadir',
                        'message'     => 'Anda sudah absen masuk hari ini.',
                        'siswa'       => $siswa,
                    ]), 200);
                }

                Absensi::create([
                    'siswa_id'  => $siswa->id,
                    'tanggal'   => $tanggal,
                    'jam_masuk' => $jamSekarang,
                    'status'    => 'Hadir',
                    'latitude'  => $request->latitude,
                    'longitude' => $request->longitude,
                ]);

                return response(view('absensi.popup', [
                    'status'      => 'success',
                    'nama'        => $siswa->nama,
                    'foto'        => $siswa->foto ?? 'default.png',
                    'keterangan'  => 'Hadir',
                    'message'     => 'Absensi masuk berhasil!',
                    'siswa'       => $siswa,
                ]), 200);
            }

            // ======================
            // PULANG
            // ======================
            if (!$absen) {
                return response(view('absensi.popup', [
                    'status'      => 'warning',
                    'nama'        => $siswa->nama,
                    'foto'        => $siswa->foto ?? 'default.png',
                    'keterangan'  => 'Belum absen masuk',
                    'message'     => 'Anda belum absen masuk hari ini.',
                    'siswa'       => $siswa,
                ]), 200);
            }

            if ($absen->jam_pulang) {
                return response(view('absensi.popup', [
                    'status'      => 'info',
                    'nama'        => $siswa->nama,
                    'foto'        => $siswa->foto ?? 'default.png',
                    'keterangan'  => 'Sudah pulang',
                    'message'     => 'Anda sudah absen pulang hari ini.',
                    'siswa'       => $siswa,
                ]), 200);
            }

            $absen->update([
                'jam_pulang' => $jamSekarang,
                'latitude'   => $request->latitude,
                'longitude'  => $request->longitude,
            ]);

            return response(view('absensi.popup', [
                'status'      => 'success',
                'nama'        => $siswa->nama,
                'foto'        => $siswa->foto ?? 'default.png',
                'keterangan'  => 'Pulang',
                'message'     => 'Absensi pulang berhasil!',
                'siswa'       => $siswa,
            ]), 200);

        } catch (\Exception $e) {
            return response(view('absensi.popup', [
                'status'      => 'danger',
                'nama'        => '-',
                'foto'        => 'default.png',
                'keterangan'  => 'Kesalahan',
                'message'     => 'Terjadi error: '.$e->getMessage(),
                'siswa'       => null,
            ]), 200);
        }
    }

    /** 📊 Rekap Absensi Per Siswa */
    public function rekap($id)
    {
        $siswa = Siswa::with('absensis')->findOrFail($id);
        return view('absensi.rekap', compact('siswa'));
    }

    /** 🧾 Cetak Rekap ke PDF */
    public function rekapPdf($id)
    {
        $siswa = Siswa::with('absensis')->findOrFail($id);
        $pdf = \PDF::loadView('absensi.rekap_pdf', compact('siswa'));
        return $pdf->download("Rekap_Absensi_{$siswa->nama}.pdf");
    }
        /** 📁 Tampilkan daftar data arsip */
    public function arsip()
    {
        $absensis = Absensi::with('siswa')
            ->where('is_archived', true)
            ->latest()
            ->get();

        return view('absensi.arsip', compact('absensis'));
    }

    /** ♻️ Pulihkan data dari arsip */
    public function restore($id)
    {
        $absen = Absensi::findOrFail($id);

        $absen->update([
            'is_archived' => false
        ]);

        return redirect()->route('absensi.arsip')
            ->with('success', 'Data berhasil dipulihkan!');
    }
}


