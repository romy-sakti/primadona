<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UploadpenetapanRequest;
use App\Models\Uploadpenetapan;
use App\Repositories\UploadpenetapanRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\JsonResponse;
use App\Services\EmailService;
use App\Services\FileService;

class UploadpenetapanController extends Controller
{
    /**
     * uploadpenetapanRepository
     *
     * @var UploadpenetapanRepository
     */
    private UploadpenetapanRepository $uploadpenetapanRepository;

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
        $this->uploadpenetapanRepository      = new UploadpenetapanRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;

        $this->middleware('can:uploadpenetapan');
        $this->middleware('can:uploadpenetapan Tambah')->only(['create', 'store']);
        $this->middleware('can:uploadpenetapan Ubah')->only(['edit', 'update']);
        $this->middleware('can:uploadpenetapan Hapus')->only(['destroy']);
    }

    /**
     * get data as pagination
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->uploadpenetapanRepository->getPaginate();
        $successMessage = successMessageLoadData("uploadpenetapan");
        return response200($data, $successMessage);
    }

    /**
     * get detail data
     *
     * @param Uploadpenetapan $uploadpenetapan
     * @return JsonResponse
     */
    public function show(Uploadpenetapan $uploadpenetapan)
    {
        $successMessage = successMessageLoadData("uploadpenetapan");
        return response200($uploadpenetapan, $successMessage);
    }

    /**
     * save new data to db
     *
     * @param UploadpenetapanRequest $request
     * @return JsonResponse
     */
    public function store(UploadpenetapanRequest $request)
    {
        $data = $request->only([
			'nomor_perkara',
			'file_penetapan',
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

        $result = $this->uploadpenetapanRepository->create($data);
        logCreate('uploadpenetapan', $result);

        $successMessage = successMessageCreate("uploadpenetapan");
        return response200($result, $successMessage);
    }

    /**
     * update data to db
     *
     * @param UploadpenetapanRequest $request
     * @param Uploadpenetapan $uploadpenetapan
     * @return JsonResponse
     */
    public function update(UploadpenetapanRequest $request, Uploadpenetapan $uploadpenetapan)
    {
        $data = $request->only([
			'nomor_perkara',
			'file_penetapan',
        ]);

        // bisa digunakan jika ada upload file dan ganti methodnya
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        // }

        $result = $this->uploadpenetapanRepository->update($data, $uploadpenetapan->id);

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

        logUpdate('uploadpenetapan', $uploadpenetapan, $result);

        $successMessage = successMessageUpdate("uploadpenetapan");
        return response200($result, $successMessage);
    }

    /**
     * delete data from db
     *
     * @param Uploadpenetapan $uploadpenetapan
     * @return JsonResponse
     */
    public function destroy(Uploadpenetapan $uploadpenetapan)
    {
        $deletedRow = $this->uploadpenetapanRepository->delete($uploadpenetapan->id);

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

        logDelete('uploadpenetapan', $uploadpenetapan);

        $successMessage = successMessageDelete("uploadpenetapan");
        return response200($deletedRow, $successMessage);
    }
}
