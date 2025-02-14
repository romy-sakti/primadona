<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\KetentuanpenetapanRequest;
use App\Models\Ketentuanpenetapan;
use App\Repositories\KetentuanpenetapanRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\JsonResponse;
use App\Services\EmailService;
use App\Services\FileService;

class KetentuanpenetapanController extends Controller
{
    /**
     * ketentuanpenetapanRepository
     *
     * @var KetentuanpenetapanRepository
     */
    private KetentuanpenetapanRepository $ketentuanpenetapanRepository;

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
        $this->ketentuanpenetapanRepository      = new KetentuanpenetapanRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;

        $this->middleware('can:ketentuanpenetapan');
        $this->middleware('can:ketentuanpenetapan Tambah')->only(['create', 'store']);
        $this->middleware('can:ketentuanpenetapan Ubah')->only(['edit', 'update']);
        $this->middleware('can:ketentuanpenetapan Hapus')->only(['destroy']);
    }

    /**
     * get data as pagination
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->ketentuanpenetapanRepository->getPaginate();
        $successMessage = successMessageLoadData("ketentuanpenetapan");
        return response200($data, $successMessage);
    }

    /**
     * get detail data
     *
     * @param Ketentuanpenetapan $ketentuanpenetapan
     * @return JsonResponse
     */
    public function show(Ketentuanpenetapan $ketentuanpenetapan)
    {
        $successMessage = successMessageLoadData("ketentuanpenetapan");
        return response200($ketentuanpenetapan, $successMessage);
    }

    /**
     * save new data to db
     *
     * @param KetentuanpenetapanRequest $request
     * @return JsonResponse
     */
    public function store(KetentuanpenetapanRequest $request)
    {
        $data = $request->only([
			'konten',
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

        $result = $this->ketentuanpenetapanRepository->create($data);
        logCreate('ketentuanpenetapan', $result);

        $successMessage = successMessageCreate("ketentuanpenetapan");
        return response200($result, $successMessage);
    }

    /**
     * update data to db
     *
     * @param KetentuanpenetapanRequest $request
     * @param Ketentuanpenetapan $ketentuanpenetapan
     * @return JsonResponse
     */
    public function update(KetentuanpenetapanRequest $request, Ketentuanpenetapan $ketentuanpenetapan)
    {
        $data = $request->only([
			'konten',
        ]);

        // bisa digunakan jika ada upload file dan ganti methodnya
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        // }

        $result = $this->ketentuanpenetapanRepository->update($data, $ketentuanpenetapan->id);

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

        logUpdate('ketentuanpenetapan', $ketentuanpenetapan, $result);

        $successMessage = successMessageUpdate("ketentuanpenetapan");
        return response200($result, $successMessage);
    }

    /**
     * delete data from db
     *
     * @param Ketentuanpenetapan $ketentuanpenetapan
     * @return JsonResponse
     */
    public function destroy(Ketentuanpenetapan $ketentuanpenetapan)
    {
        $deletedRow = $this->ketentuanpenetapanRepository->delete($ketentuanpenetapan->id);

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

        logDelete('ketentuanpenetapan', $ketentuanpenetapan);

        $successMessage = successMessageDelete("ketentuanpenetapan");
        return response200($deletedRow, $successMessage);
    }
}
