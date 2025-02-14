<?php

namespace App\Http\Controllers;

use App\Exports\UploadpenetapanExport;
use App\Http\Requests\UploadpenetapanRequest;
use App\Imports\UploadpenetapanImport;
use App\Models\Uploadpenetapan;
use App\Repositories\UploadpenetapanRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

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
     * UserRepository
     *
     * @var UserRepository
     */
    private UserRepository $UserRepository;

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
     * exportable
     *
     * @var bool
     */
    private bool $exportable = false;

    /**
     * importable
     *
     * @var bool
     */
    private bool $importable = false;

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
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:uploadpenetapan');
        $this->middleware('can:uploadpenetapan Tambah')->only(['create', 'store']);
        $this->middleware('can:uploadpenetapan Ubah')->only(['edit', 'update']);
        $this->middleware('can:uploadpenetapan Hapus')->only(['destroy']);
        $this->middleware('can:uploadpenetapan Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:uploadpenetapan Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.uploadpenetapans.index', [
            'data'             => $this->uploadpenetapanRepository->getLatest(),
            'canCreate'        => $user->can('uploadpenetapan Tambah'),
            'canUpdate'        => $user->can('uploadpenetapan Ubah'),
            'canDelete'        => $user->can('uploadpenetapan Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('uploadpenetapan'),
            'routeCreate'      => route('uploadpenetapans.create'),
            'routePdf'         => route('uploadpenetapans.pdf'),
            'routePrint'       => route('uploadpenetapans.print'),
            'routeExcel'       => route('uploadpenetapans.excel'),
            'routeCsv'         => route('uploadpenetapans.csv'),
            'routeJson'        => route('uploadpenetapans.json'),
            'routeImportExcel' => route('uploadpenetapans.import-excel'),
            'excelExampleLink' => route('uploadpenetapans.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.uploadpenetapans.form', [
            'title'         => __('uploadpenetapan'),
            'fullTitle'     => __('Tambah uploadpenetapan'),
            'routeIndex'    => route('uploadpenetapans.index'),
            'action'        => route('uploadpenetapans.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param UploadpenetapanRequest $request
     * @return Response
     */
    public function store(UploadpenetapanRequest $request)
    {
        $data = $request->only([
			'nomor_perkara',
			'file_penetapan',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->uploadpenetapanRepository->create($data);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($result);

        logCreate("uploadpenetapan", $result);

        $successMessage = successMessageCreate("uploadpenetapan");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Uploadpenetapan $uploadpenetapan
     * @return Response
     */
    public function edit(Uploadpenetapan $uploadpenetapan)
    {
        return view('stisla.uploadpenetapans.form', [
            'd'             => $uploadpenetapan,
            'title'         => __('uploadpenetapan'),
            'fullTitle'     => __('Ubah uploadpenetapan'),
            'routeIndex'    => route('uploadpenetapans.index'),
            'action'        => route('uploadpenetapans.update', [$uploadpenetapan->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param UploadpenetapanRequest $request
     * @param Uploadpenetapan $uploadpenetapan
     * @return Response
     */
    public function update(UploadpenetapanRequest $request, Uploadpenetapan $uploadpenetapan)
    {
        $data = $request->only([
			'nomor_perkara',
			'file_penetapan',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->uploadpenetapanRepository->update($data, $uploadpenetapan->id);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($newData);

        logUpdate("uploadpenetapan", $uploadpenetapan, $newData);

        $successMessage = successMessageUpdate("uploadpenetapan");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Uploadpenetapan $uploadpenetapan
     * @return Response
     */
    public function destroy(Uploadpenetapan $uploadpenetapan)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($uploadpenetapan);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($uploadpenetapan);

        $this->uploadpenetapanRepository->delete($uploadpenetapan->id);
        logDelete("uploadpenetapan", $uploadpenetapan);

        $successMessage = successMessageDelete("uploadpenetapan");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download import example
     *
     * @return BinaryFileResponse
     */
    public function importExcelExample(): BinaryFileResponse
    {
        // bisa gunakan file excel langsung sebagai contoh
        // $filepath = public_path('example.xlsx');
        // return response()->download($filepath);

        $data = $this->uploadpenetapanRepository->getLatest();
        return Excel::download(new UploadpenetapanExport($data), 'uploadpenetapans.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new UploadpenetapanImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("uploadpenetapan");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->uploadpenetapanRepository->getLatest();
        return $this->fileService->downloadJson($data, 'uploadpenetapans.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->uploadpenetapanRepository->getLatest();
        return (new UploadpenetapanExport($data))->download('uploadpenetapans.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->uploadpenetapanRepository->getLatest();
        return (new UploadpenetapanExport($data))->download('uploadpenetapans.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->uploadpenetapanRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.uploadpenetapans.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('uploadpenetapans.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->uploadpenetapanRepository->getLatest();
        return view('stisla.uploadpenetapans.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}
