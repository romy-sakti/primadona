<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Jadwalsidangkeliling;
use App\Models\Narasisidangkeliling;
use App\Models\Permohonanmasyarakat;
use App\Models\Peraturan;
use App\Models\Biayapermohonan;
use App\Models\Uploadpenetapan;
use App\Models\Ketentuanpenetapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function sidarling()
    {
        $narasi = Narasisidangkeliling::orderBy('tahun', 'desc')
            ->paginate(2, ['*'], 'narasi_page')
            ->through(function ($item) {
                // Decode foto dan dokumen
                $item->foto = is_string($item->foto) ? json_decode($item->foto, true) : [];
            $item->dokumen = is_string($item->dokumen) ? json_decode($item->dokumen, true) : [];
            return $item;
            });

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
        $permohonan = Permohonanmasyarakat::orderBy('created_at', 'desc')->get();
        return view('frontend.permohonan-masyarakat.detail-permohonan', compact('permohonan'));
    }
    public function peraturan()
    {
        $peraturan = Peraturan::orderBy('created_at', 'desc')->get();
        return view('frontend.peraturan.peraturan', compact('peraturan'));
    }

    public function biaya()
    {
        $biaya = Biayapermohonan::first();
        return view('frontend.biaya.biaya', compact('biaya'));
    }

    // public function uploadPenetapan()
    // {
    //     $ketentuan = Ketentuanpenetapan::all();
    //     return view('frontend.upload-penetapan.index', compact('ketentuan'));
    // }
    public function uploadPenetapan()
    {
        $ketentuan = Ketentuanpenetapan::all();
        $penetapanFiles = Uploadpenetapan::where('user_id', auth()->id())->latest()->get();

        return view('frontend.upload-penetapan.index', compact('ketentuan', 'penetapanFiles'));
    }


    public function storePenetapan(Request $request)
    {
        $request->validate([
            'nomor_perkara' => 'required|string',
            'file_penetapan' => 'required|mimes:pdf|max:2048', // maksimal 2MB, format PDF
        ]);

        $file = $request->file('file_penetapan');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/penetapan'), $fileName);

        // Simpan data penetapan
        $penetapan = Uploadpenetapan::create([
            'nomor_perkara' => $request->nomor_perkara,
            'file_penetapan' => $fileName,
            'user_id' => Auth::id(),
        ]);

        try {
            // Inisialisasi repository yang diperlukan
            $userRepository = new \App\Repositories\UserRepository();
            $notificationRepository = new \App\Repositories\NotificationRepository();

            // Dapatkan semua user dengan role pntjt dan dukcapiltjt
            $users = $userRepository->getUsersByRoles(['pntjt', 'dukcapiltjt']);

            // Debug: Cek jumlah user yang ditemukan
            \Log::info('Users found: ' . $users->count());

            // Kirim notifikasi ke setiap user
            foreach ($users as $user) {
                try {
                    $title = 'Upload Penetapan Baru';
                    $content = "Penetapan baru telah diupload dengan nomor perkara: {$request->nomor_perkara}";
                    $notificationType = 'upload_penetapan';
                    $icon = 'file-upload';
                    $bgColor = 'primary';

                    $notification = $notificationRepository->createNotif(
                        $title,
                        $content,
                        $user->id,
                        $notificationType,
                        $icon,
                        $bgColor
                    );

                    // Debug: Log notifikasi yang dibuat
                    \Log::info('Notification created:', [
                        'user_id' => $user->id,
                        'notification' => $notification
                    ]);
                } catch (\Exception $e) {
                    // Debug: Log error jika terjadi
                    \Log::error('Error creating notification: ' . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error in notification process: ' . $e->getMessage());
            // Tetap lanjutkan proses meski ada error di notifikasi
        }

        return redirect()->back()->with('success', 'Penetapan berhasil diupload');
    }

}