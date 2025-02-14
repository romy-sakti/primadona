<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Jadwalsidangkeliling;
use App\Models\Narasisidangkeliling;
use App\Models\Permohonanmasyarakat;
use App\Models\Peraturan;
use App\Models\Biayapermohonan;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function sidarling()
    {
        $narasi = Narasisidangkeliling::orderBy('tahun', 'desc')
            ->paginate(2, ['*'], 'narasi_page');

        $jadwal = Jadwalsidangkeliling::orderBy('tanggal_sidang', 'desc')
            ->take(4)
            ->get();

        return view('frontend.info-sidarling.detail-sidarling', compact('narasi', 'jadwal'));
    }

    public function allJadwalSidarling()
    {
        $jadwal = Jadwalsidangkeliling::orderBy('tanggal_sidang', 'desc')
            ->paginate(10);

        return view('frontend.info-sidarling.all-jadwal', compact('jadwal'));
    }
    public function detailJadwalSidarling($id)
    {
        $jadwal = Jadwalsidangkeliling::findOrFail($id);
        return view('frontend.info-sidarling.detail-jadwal', compact('jadwal'));
    }

    public function permohonanMasyarakat()
    {
        $permohonan = Permohonanmasyarakat::all();
        return view('frontend.permohonan-masyarakat.detail-permohonan', compact('permohonan'));
    }
    public function peraturan()
    {
        $peraturan = Peraturan::all();
        return view('frontend.peraturan.peraturan', compact('peraturan'));
    }

    public function biaya()
    {
        $biaya = Biayapermohonan::first();
        return view('frontend.biaya.biaya', compact('biaya'));
    }


}