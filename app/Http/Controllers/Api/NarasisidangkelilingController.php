<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NarasisidangkelilingRequest;
use App\Models\Narasisidangkeliling;
use App\Repositories\NarasisidangkelilingRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\JsonResponse;
use App\Services\EmailService;
use App\Services\FileService;

class NarasisidangkelilingController extends Controller
{
    /**
     * narasisidangkelilingRepository
     *
     * @var NarasisidangkelilingRepository
     */
    private NarasisidangkelilingRepository $narasisidangkelilingRepository;

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
        $this->narasisidangkelilingRepository      = new NarasisidangkelilingRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;

        $this->middleware('can:narasi_sidang_keliling');
        $this->middleware('can:narasi_sidang_keliling Tambah')->only(['create', 'store']);
        $this->middleware('can:narasi_sidang_keliling Ubah')->only(['edit', 'update']);
        $this->middleware('can:narasi_sidang_keliling Hapus')->only(['destroy']);
    }

    /**
     * get data as pagination
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->narasisidangkelilingRepository->getPaginate();
        $successMessage = successMessageLoadData("narasi_sidang_keliling");
        return response200($data, $successMessage);
    }

    /**
     * get detail data
     *
     * @param Narasisidangkeliling $narasisidangkeliling
     * @return JsonResponse
     */
    public function show(Narasisidangkeliling $narasisidangkeliling)
    {
        $successMessage = successMessageLoadData("narasi_sidang_keliling");
        return response200($narasisidangkeliling, $successMessage);
    }

    /**
     * save new data to db
     *
     * @param NarasisidangkelilingRequest $request
     * @return JsonResponse
     */
    public function store(NarasisidangkelilingRequest $request)
    {
        $data = $request->only([
			'tahun',
			'narasi',
			'foto',
			'dokumen',
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

        $result = $this->narasisidangkelilingRepository->create($data);
        logCreate('narasi_sidang_keliling', $result);

        $successMessage = successMessageCreate("narasi_sidang_keliling");
        return response200($result, $successMessage);
    }

    /**
     * update data to db
     *
     * @param NarasisidangkelilingRequest $request
     * @param Narasisidangkeliling $narasisidangkeliling
     * @return JsonResponse
     */
    public function update(NarasisidangkelilingRequest $request, Narasisidangkeliling $narasisidangkeliling)
    {
        $data = $request->only([
			'tahun',
			'narasi',
			'foto',
			'dokumen',
        ]);

        // bisa digunakan jika ada upload file dan ganti methodnya
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->uploadCrudExampleFile($request->file('file'));
        // }

        $result = $this->narasisidangkelilingRepository->update($data, $narasisidangkeliling->id);

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

        logUpdate('narasi_sidang_keliling', $narasisidangkeliling, $result);

        $successMessage = successMessageUpdate("narasi_sidang_keliling");
        return response200($result, $successMessage);
    }

    /**
     * delete data from db
     *
     * @param Narasisidangkeliling $narasisidangkeliling
     * @return JsonResponse
     */
    public function destroy(Narasisidangkeliling $narasisidangkeliling)
    {
        $deletedRow = $this->narasisidangkelilingRepository->delete($narasisidangkeliling->id);

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

        logDelete('narasi_sidang_keliling', $narasisidangkeliling);

        $successMessage = successMessageDelete("narasi_sidang_keliling");
        return response200($deletedRow, $successMessage);
    }
}
