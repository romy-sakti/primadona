<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\JadwalsidangkelilingRequest;
use App\Models\Jadwalsidangkeliling;
use App\Repositories\JadwalsidangkelilingRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\JsonResponse;
use App\Services\EmailService;
use App\Services\FileService;

class JadwalsidangkelilingController extends Controller
{
    /**
     * jadwalsidangkelilingRepository
     *
     * @var JadwalsidangkelilingRepository
     */
    private JadwalsidangkelilingRepository $jadwalsidangkelilingRepository;

    /**
     * NotificationRepository
     *
     * @var NotificationRepository
     */
    private NotificationRepository $NotificationRepository;

    /**
     * file service
     *
     * @var FileService
     */
    private FileService $fileService;

    /**
     * email service
     *
     * @var FileService
     */
    private EmailService $emailService;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->jadwalsidangkelilingRepository      = new JadwalsidangkelilingRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;

        $this->middleware('can:jadwal_sidang_keliling');
        $this->middleware('can:jadwal_sidang_keliling Tambah')->only(['create', 'store']);
        $this->middleware('can:jadwal_sidang_keliling Ubah')->only(['edit', 'update']);
        $this->middleware('can:jadwal_sidang_keliling Hapus')->only(['destroy']);
    }

    /**
     * get data as pagination
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->jadwalsidangkelilingRepository->getPaginate();
        $successMessage = successMessageLoadData("jadwal_sidang_keliling");
        return response200($data, $successMessage);
    }

    /**
     * get detail data
     *
     * @param Jadwalsidangkeliling $jadwalsidangkeliling
     * @return JsonResponse
     */
    public function show(Jadwalsidangkeliling $jadwalsidangkeliling)
    {
        $successMessage = successMessageLoadData("jadwal_sidang_keliling");
        return response200($jadwalsidangkeliling, $successMessage);
    }

    /**
     * save new data to db
     *
     * @param JadwalsidangkelilingRequest $request
     * @return JsonResponse
     */
    public function store(JadwalsidangkelilingRequest $request)
    {
        $data = $request->only([
			'tanggal_sidang',
			'nama_pemohon',
			'tempat_sidang',
			'agenda_sidang',
			'hakim',
			'panitera_pengganti',
			'nomor_perkara',
        ]);

        // bisa digunakan jika ada upload file dan ganti methodnya
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        // }

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // bisa digunakan jika ingim kirim email dan ganti methodnya
        // $this->emailService->methodName($params);

        $result = $this->jadwalsidangkelilingRepository->create($data);
        logCreate('jadwal_sidang_keliling', $result);

        $successMessage = successMessageCreate("jadwal_sidang_keliling");
        return response200($result, $successMessage);
    }

    /**
     * update data to db
     *
     * @param JadwalsidangkelilingRequest $request
     * @param Jadwalsidangkeliling $jadwalsidangkeliling
     * @return JsonResponse
     */
    public function update(JadwalsidangkelilingRequest $request, Jadwalsidangkeliling $jadwalsidangkeliling)
    {
        $data = $request->only([
			'tanggal_sidang',
			'nama_pemohon',
			'tempat_sidang',
			'agenda_sidang',
			'hakim',
			'panitera_pengganti',
			'nomor_perkara',
        ]);

        // bisa digunakan jika ada upload file dan ganti methodnya
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        // }

        $result = $this->jadwalsidangkelilingRepository->update($data, $jadwalsidangkeliling->id);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // bisa digunakan jika ingim kirim email dan ganti methodnya
        // $this->emailService->methodName($params);

        logUpdate('jadwal_sidang_keliling', $jadwalsidangkeliling, $result);

        $successMessage = successMessageUpdate("jadwal_sidang_keliling");
        return response200($result, $successMessage);
    }

    /**
     * delete data from db
     *
     * @param Jadwalsidangkeliling $jadwalsidangkeliling
     * @return JsonResponse
     */
    public function destroy(Jadwalsidangkeliling $jadwalsidangkeliling)
    {
        $deletedRow = $this->jadwalsidangkelilingRepository->delete($jadwalsidangkeliling->id);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // bisa digunakan jika ingim kirim email dan ganti methodnya
        // $this->emailService->methodName($params);

        logDelete('jadwal_sidang_keliling', $jadwalsidangkeliling);

        $successMessage = successMessageDelete("jadwal_sidang_keliling");
        return response200($deletedRow, $successMessage);
    }
}
