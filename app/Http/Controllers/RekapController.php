<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index()
    {
        // ambil semua siswa beserta absensinya
        $rekap = Siswa::with('absensis')->get();

        return view('rekap.index', compact('rekap'));
    }
}
