<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BiayapermohonanRequest;
use App\Models\Biayapermohonan;
use App\Repositories\BiayapermohonanRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\JsonResponse;
use App\Services\EmailService;
use App\Services\FileService;

class BiayapermohonanController extends Controller
{
    /**
     * biayapermohonanRepository
     *
     * @var BiayapermohonanRepository
     */
    private BiayapermohonanRepository $biayapermohonanRepository;

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
        $this->biayapermohonanRepository      = new BiayapermohonanRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;

        $this->middleware('can:biaya_permohonan');
        $this->middleware('can:biaya_permohonan Tambah')->only(['create', 'store']);
        $this->middleware('can:biaya_permohonan Ubah')->only(['edit', 'update']);
        $this->middleware('can:biaya_permohonan Hapus')->only(['destroy']);
    }

    /**
     * get data as pagination
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->biayapermohonanRepository->getPaginate();
        $successMessage = successMessageLoadData("biaya_permohonan");
        return response200($data, $successMessage);
    }

    /**
     * get detail data
     *
     * @param Biayapermohonan $biayapermohonan
     * @return JsonResponse
     */
    public function show(Biayapermohonan $biayapermohonan)
    {
        $successMessage = successMessageLoadData("biaya_permohonan");
        return response200($biayapermohonan, $successMessage);
    }

    /**
     * save new data to db
     *
     * @param BiayapermohonanRequest $request
     * @return JsonResponse
     */
    public function store(BiayapermohonanRequest $request)
    {
        $data = $request->only([
			'biaya_pendaftaran',
			'biaya_atk_administrasi',
			'pnbp_panggilan',
			'materai',
			'redaksi',
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

        $result = $this->biayapermohonanRepository->create($data);
        logCreate('biaya_permohonan', $result);

        $successMessage = successMessageCreate("biaya_permohonan");
        return response200($result, $successMessage);
    }

    /**
     * update data to db
     *
     * @param BiayapermohonanRequest $request
     * @param Biayapermohonan $biayapermohonan
     * @return JsonResponse
     */
    public function update(BiayapermohonanRequest $request, Biayapermohonan $biayapermohonan)
    {
        $data = $request->only([
			'biaya_pendaftaran',
			'biaya_atk_administrasi',
			'pnbp_panggilan',
			'materai',
			'redaksi',
        ]);

        // bisa digunakan jika ada upload file dan ganti methodnya
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        // }

        $result = $this->biayapermohonanRepository->update($data, $biayapermohonan->id);

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

        logUpdate('biaya_permohonan', $biayapermohonan, $result);

        $successMessage = successMessageUpdate("biaya_permohonan");
        return response200($result, $successMessage);
    }

    /**
     * delete data from db
     *
     * @param Biayapermohonan $biayapermohonan
     * @return JsonResponse
     */
    public function destroy(Biayapermohonan $biayapermohonan)
    {
        $deletedRow = $this->biayapermohonanRepository->delete($biayapermohonan->id);

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

        logDelete('biaya_permohonan', $biayapermohonan);

        $successMessage = successMessageDelete("biaya_permohonan");
        return response200($deletedRow, $successMessage);
    }
}
