<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PermohonanmasyarakatRequest;
use App\Models\Permohonanmasyarakat;
use App\Repositories\PermohonanmasyarakatRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\JsonResponse;
use App\Services\EmailService;
use App\Services\FileService;

class PermohonanmasyarakatController extends Controller
{
    /**
     * permohonanmasyarakatRepository
     *
     * @var PermohonanmasyarakatRepository
     */
    private PermohonanmasyarakatRepository $permohonanmasyarakatRepository;

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
        $this->permohonanmasyarakatRepository      = new PermohonanmasyarakatRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;

        $this->middleware('can:permohonan_masyarakat');
        $this->middleware('can:permohonan_masyarakat Tambah')->only(['create', 'store']);
        $this->middleware('can:permohonan_masyarakat Ubah')->only(['edit', 'update']);
        $this->middleware('can:permohonan_masyarakat Hapus')->only(['destroy']);
    }

    /**
     * get data as pagination
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->permohonanmasyarakatRepository->getPaginate();
        $successMessage = successMessageLoadData("permohonan_masyarakat");
        return response200($data, $successMessage);
    }

    /**
     * get detail data
     *
     * @param Permohonanmasyarakat $permohonanmasyarakat
     * @return JsonResponse
     */
    public function show(Permohonanmasyarakat $permohonanmasyarakat)
    {
        $successMessage = successMessageLoadData("permohonan_masyarakat");
        return response200($permohonanmasyarakat, $successMessage);
    }

    /**
     * save new data to db
     *
     * @param PermohonanmasyarakatRequest $request
     * @return JsonResponse
     */
    public function store(PermohonanmasyarakatRequest $request)
    {
        $data = $request->only([
			'nama_pemohon',
			'jenis_permohonan_id',
			'nomor_perkara',
			'status_permohonan',
			'keterangan',
			'dokumen_penetapan',
			'nomor_telepon',
			'alamat_pemohon',
			'tempat_lahir',
			'tanggal_lahir',
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

        $result = $this->permohonanmasyarakatRepository->create($data);
        logCreate('permohonan_masyarakat', $result);

        $successMessage = successMessageCreate("permohonan_masyarakat");
        return response200($result, $successMessage);
    }

    /**
     * update data to db
     *
     * @param PermohonanmasyarakatRequest $request
     * @param Permohonanmasyarakat $permohonanmasyarakat
     * @return JsonResponse
     */
    public function update(PermohonanmasyarakatRequest $request, Permohonanmasyarakat $permohonanmasyarakat)
    {
        $data = $request->only([
			'nama_pemohon',
			'jenis_permohonan_id',
			'nomor_perkara',
			'status_permohonan',
			'keterangan',
			'dokumen_penetapan',
			'nomor_telepon',
			'alamat_pemohon',
			'tempat_lahir',
			'tanggal_lahir',
        ]);

        // bisa digunakan jika ada upload file dan ganti methodnya
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        // }

        $result = $this->permohonanmasyarakatRepository->update($data, $permohonanmasyarakat->id);

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

        logUpdate('permohonan_masyarakat', $permohonanmasyarakat, $result);

        $successMessage = successMessageUpdate("permohonan_masyarakat");
        return response200($result, $successMessage);
    }

    /**
     * delete data from db
     *
     * @param Permohonanmasyarakat $permohonanmasyarakat
     * @return JsonResponse
     */
    public function destroy(Permohonanmasyarakat $permohonanmasyarakat)
    {
        $deletedRow = $this->permohonanmasyarakatRepository->delete($permohonanmasyarakat->id);

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

        logDelete('permohonan_masyarakat', $permohonanmasyarakat);

        $successMessage = successMessageDelete("permohonan_masyarakat");
        return response200($deletedRow, $successMessage);
    }
}
