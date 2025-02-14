<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PeraturanRequest;
use App\Models\Peraturan;
use App\Repositories\PeraturanRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\JsonResponse;
use App\Services\EmailService;
use App\Services\FileService;

class PeraturanController extends Controller
{
    /**
     * peraturanRepository
     *
     * @var PeraturanRepository
     */
    private PeraturanRepository $peraturanRepository;

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
        $this->peraturanRepository      = new PeraturanRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;

        $this->middleware('can:peraturan');
        $this->middleware('can:peraturan Tambah')->only(['create', 'store']);
        $this->middleware('can:peraturan Ubah')->only(['edit', 'update']);
        $this->middleware('can:peraturan Hapus')->only(['destroy']);
    }

    /**
     * get data as pagination
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->peraturanRepository->getPaginate();
        $successMessage = successMessageLoadData("peraturan");
        return response200($data, $successMessage);
    }

    /**
     * get detail data
     *
     * @param Peraturan $peraturan
     * @return JsonResponse
     */
    public function show(Peraturan $peraturan)
    {
        $successMessage = successMessageLoadData("peraturan");
        return response200($peraturan, $successMessage);
    }

    /**
     * save new data to db
     *
     * @param PeraturanRequest $request
     * @return JsonResponse
     */
    public function store(PeraturanRequest $request)
    {
        $data = $request->only([
			'judul',
			'nomor_peraturan',
			'tahun',
			'keterangan',
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

        $result = $this->peraturanRepository->create($data);
        logCreate('peraturan', $result);

        $successMessage = successMessageCreate("peraturan");
        return response200($result, $successMessage);
    }

    /**
     * update data to db
     *
     * @param PeraturanRequest $request
     * @param Peraturan $peraturan
     * @return JsonResponse
     */
    public function update(PeraturanRequest $request, Peraturan $peraturan)
    {
        $data = $request->only([
			'judul',
			'nomor_peraturan',
			'tahun',
			'keterangan',
        ]);

        // bisa digunakan jika ada upload file dan ganti methodnya
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        // }

        $result = $this->peraturanRepository->update($data, $peraturan->id);

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

        logUpdate('peraturan', $peraturan, $result);

        $successMessage = successMessageUpdate("peraturan");
        return response200($result, $successMessage);
    }

    /**
     * delete data from db
     *
     * @param Peraturan $peraturan
     * @return JsonResponse
     */
    public function destroy(Peraturan $peraturan)
    {
        $deletedRow = $this->peraturanRepository->delete($peraturan->id);

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

        logDelete('peraturan', $peraturan);

        $successMessage = successMessageDelete("peraturan");
        return response200($deletedRow, $successMessage);
    }
}
