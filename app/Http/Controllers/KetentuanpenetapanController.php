<?php

namespace App\Http\Controllers;

use App\Exports\KetentuanpenetapanExport;
use App\Http\Requests\KetentuanpenetapanRequest;
use App\Imports\KetentuanpenetapanImport;
use App\Models\Ketentuanpenetapan;
use App\Repositories\KetentuanpenetapanRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

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
        $this->ketentuanpenetapanRepository      = new KetentuanpenetapanRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:ketentuanpenetapan');
        $this->middleware('can:ketentuanpenetapan Tambah')->only(['create', 'store']);
        $this->middleware('can:ketentuanpenetapan Ubah')->only(['edit', 'update']);
        $this->middleware('can:ketentuanpenetapan Hapus')->only(['destroy']);
        $this->middleware('can:ketentuanpenetapan Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:ketentuanpenetapan Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.ketentuanpenetapans.index', [
            'data'             => $this->ketentuanpenetapanRepository->getLatest(),
            'canCreate'        => $user->can('ketentuanpenetapan Tambah'),
            'canUpdate'        => $user->can('ketentuanpenetapan Ubah'),
            'canDelete'        => $user->can('ketentuanpenetapan Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Persyaratan Penetapan'),
            'routeCreate'      => route('ketentuanpenetapans.create'),
            'routePdf'         => route('ketentuanpenetapans.pdf'),
            'routePrint'       => route('ketentuanpenetapans.print'),
            'routeExcel'       => route('ketentuanpenetapans.excel'),
            'routeCsv'         => route('ketentuanpenetapans.csv'),
            'routeJson'        => route('ketentuanpenetapans.json'),
            'routeImportExcel' => route('ketentuanpenetapans.import-excel'),
            'excelExampleLink' => route('ketentuanpenetapans.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.ketentuanpenetapans.form', [
            'title'         => __('Persyaratan Penetapan'),
            'fullTitle'     => __('Tambah Persyaratan Penetapan'),
            'routeIndex'    => route('ketentuanpenetapans.index'),
            'action'        => route('ketentuanpenetapans.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param KetentuanpenetapanRequest $request
     * @return Response
     */
    public function store(KetentuanpenetapanRequest $request)
    {
        $data = $request->only([
			'konten',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->ketentuanpenetapanRepository->create($data);

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

        logCreate("ketentuanpenetapan", $result);

        $successMessage = successMessageCreate("Ketentuan Penetapan");
        return redirect()->route('ketentuanpenetapans.index')->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Ketentuanpenetapan $ketentuanpenetapan
     * @return Response
     */
    public function edit(Ketentuanpenetapan $ketentuanpenetapan)
    {
        return view('stisla.ketentuanpenetapans.form', [
            'd'             => $ketentuanpenetapan,
            'title'         => __('Persyaratan Penetapan'),
            'fullTitle'     => __('Ubah Persyaratan Penetapan'),
            'routeIndex'    => route('ketentuanpenetapans.index'),
            'action'        => route('ketentuanpenetapans.update', [$ketentuanpenetapan->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param KetentuanpenetapanRequest $request
     * @param Ketentuanpenetapan $ketentuanpenetapan
     * @return Response
     */
    public function update(KetentuanpenetapanRequest $request, Ketentuanpenetapan $ketentuanpenetapan)
    {
        $data = $request->only([
			'konten',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->ketentuanpenetapanRepository->update($data, $ketentuanpenetapan->id);

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

        logUpdate("ketentuanpenetapan", $ketentuanpenetapan, $newData);

        $successMessage = successMessageUpdate("Ketentuan Penetapan");
        return redirect()->route('ketentuanpenetapans.index')->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Ketentuanpenetapan $ketentuanpenetapan
     * @return Response
     */
    public function destroy(Ketentuanpenetapan $ketentuanpenetapan)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($ketentuanpenetapan);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($ketentuanpenetapan);

        $this->ketentuanpenetapanRepository->delete($ketentuanpenetapan->id);
        logDelete("ketentuanpenetapan", $ketentuanpenetapan);

        $successMessage = successMessageDelete("Ketentuan Penetapan");
        return redirect()->route('ketentuanpenetapans.index')->with('successMessage', $successMessage);
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

        $data = $this->ketentuanpenetapanRepository->getLatest();
        return Excel::download(new KetentuanpenetapanExport($data), 'ketentuanpenetapans.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new KetentuanpenetapanImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Ketentuan Penetapan");
        return redirect()->route('ketentuanpenetapans.index')->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->ketentuanpenetapanRepository->getLatest();
        return $this->fileService->downloadJson($data, 'ketentuanpenetapans.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->ketentuanpenetapanRepository->getLatest();
        return (new KetentuanpenetapanExport($data))->download('ketentuanpenetapans.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->ketentuanpenetapanRepository->getLatest();
        return (new KetentuanpenetapanExport($data))->download('ketentuanpenetapans.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->ketentuanpenetapanRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.ketentuanpenetapans.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('ketentuanpenetapans.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->ketentuanpenetapanRepository->getLatest();
        return view('stisla.ketentuanpenetapans.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}