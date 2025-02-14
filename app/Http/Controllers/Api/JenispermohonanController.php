<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\JenispermohonanRequest;
use App\Models\Jenispermohonan;
use App\Repositories\JenispermohonanRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\JsonResponse;
use App\Services\EmailService;
use App\Services\FileService;

class JenispermohonanController extends Controller
{
    /**
     * jenispermohonanRepository
     *
     * @var JenispermohonanRepository
     */
    private JenispermohonanRepository $jenispermohonanRepository;

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
        $this->jenispermohonanRepository      = new JenispermohonanRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;

        $this->middleware('can:jenis_permohonan');
        $this->middleware('can:jenis_permohonan Tambah')->only(['create', 'store']);
        $this->middleware('can:jenis_permohonan Ubah')->only(['edit', 'update']);
        $this->middleware('can:jenis_permohonan Hapus')->only(['destroy']);
    }

    /**
     * get data as pagination
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->jenispermohonanRepository->getPaginate();
        $successMessage = successMessageLoadData("jenis_permohonan");
        return response200($data, $successMessage);
    }

    /**
     * get detail data
     *
     * @param Jenispermohonan $jenispermohonan
     * @return JsonResponse
     */
    public function show(Jenispermohonan $jenispermohonan)
    {
        $successMessage = successMessageLoadData("jenis_permohonan");
        return response200($jenispermohonan, $successMessage);
    }

    /**
     * save new data to db
     *
     * @param JenispermohonanRequest $request
     * @return JsonResponse
     */
    public function store(JenispermohonanRequest $request)
    {
        $data = $request->only([
			'nama_jenis',
			'deskripsi',
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

        $result = $this->jenispermohonanRepository->create($data);
        logCreate('jenis_permohonan', $result);

        $successMessage = successMessageCreate("jenis_permohonan");
        return response200($result, $successMessage);
    }

    /**
     * update data to db
     *
     * @param JenispermohonanRequest $request
     * @param Jenispermohonan $jenispermohonan
     * @return JsonResponse
     */
    public function update(JenispermohonanRequest $request, Jenispermohonan $jenispermohonan)
    {
        $data = $request->only([
			'nama_jenis',
			'deskripsi',
        ]);

        // bisa digunakan jika ada upload file dan ganti methodnya
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        // }

        $result = $this->jenispermohonanRepository->update($data, $jenispermohonan->id);

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

        logUpdate('jenis_permohonan', $jenispermohonan, $result);

        $successMessage = successMessageUpdate("jenis_permohonan");
        return response200($result, $successMessage);
    }

    /**
     * delete data from db
     *
     * @param Jenispermohonan $jenispermohonan
     * @return JsonResponse
     */
    public function destroy(Jenispermohonan $jenispermohonan)
    {
        $deletedRow = $this->jenispermohonanRepository->delete($jenispermohonan->id);

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

        logDelete('jenis_permohonan', $jenispermohonan);

        $successMessage = successMessageDelete("jenis_permohonan");
        return response200($deletedRow, $successMessage);
    }
}
