<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /** 📋 Tampilkan semua siswa */
    public function index()
    {
        $siswas = Siswa::all();
        return view('siswa.index', compact('siswas'));
    }

    /** ➕ Form tambah siswa */
    public function create()
    {
        return view('siswa.create');
    }

    /** 💾 Simpan data siswa baru */
    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'nis'     => 'required|string|max:50|unique:siswas,nis',
            'sekolah' => 'required|string|max:100',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;

        // Upload foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_siswa', 'public');
        }

        // Simpan database
        Siswa::create([
            'nama'    => $request->nama,
            'nis'     => $request->nis,
            'sekolah' => $request->sekolah,
            'foto'    => $path,
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    /** ✏️ Form edit siswa */
    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    /** 🔄 Update data siswa */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'nis'     => 'required|string|max:50|unique:siswas,nis,' . $siswa->id,
            'sekolah' => 'required|string|max:100',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $siswa->foto;

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // hapus foto lama jika ada
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }

            // upload foto baru
            $path = $request->file('foto')->store('foto_siswa', 'public');
        }

        // Update data
        $siswa->update([
            'nama'    => $request->nama,
            'nis'     => $request->nis,
            'sekolah' => $request->sekolah,
            'foto'    => $path,
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    /** 🗑️ Hapus siswa */
    public function destroy(Siswa $siswa)
    {
        // hapus foto jika ada
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }
}
