<?php

namespace App\Http\Controllers;

use App\Exports\PeraturanExport;
use App\Http\Requests\PeraturanRequest;
use App\Imports\PeraturanImport;
use App\Models\Peraturan;
use App\Repositories\PeraturanRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

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
        $this->peraturanRepository      = new PeraturanRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:peraturan');
        $this->middleware('can:peraturan Tambah')->only(['create', 'store']);
        $this->middleware('can:peraturan Ubah')->only(['edit', 'update']);
        $this->middleware('can:peraturan Hapus')->only(['destroy']);
        $this->middleware('can:peraturan Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:peraturan Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.peraturans.index', [
            'data'             => $this->peraturanRepository->getLatest(),
            'canCreate'        => $user->can('peraturan Tambah'),
            'canUpdate'        => $user->can('peraturan Ubah'),
            'canDelete'        => $user->can('peraturan Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Peraturan'),
            'routeCreate'      => route('peraturans.create'),
            'routePdf'         => route('peraturans.pdf'),
            'routePrint'       => route('peraturans.print'),
            'routeExcel'       => route('peraturans.excel'),
            'routeCsv'         => route('peraturans.csv'),
            'routeJson'        => route('peraturans.json'),
            'routeImportExcel' => route('peraturans.import-excel'),
            'excelExampleLink' => route('peraturans.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.peraturans.form', [
            'title'         => __('Peraturan'),
            'fullTitle'     => __('Tambah Peraturan'),
            'routeIndex'    => route('peraturans.index'),
            'action'        => route('peraturans.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param PeraturanRequest $request
     * @return Response
     */
    public function store(PeraturanRequest $request)
    {
        $data = $request->only([
            'judul',
            'nomor_peraturan',
            'tahun',
            'keterangan',
        ]);

        if ($request->hasFile('file_peraturan')) {
            $file = $request->file('file_peraturan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/peraturan', $filename);
            $data['file_peraturan'] = $filename;
        }

        $result = $this->peraturanRepository->create($data);

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

        logCreate("peraturan", $result);

        $successMessage = successMessageCreate("peraturan");
        return redirect()->route('peraturans.index')->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Peraturan $peraturan
     * @return Response
     */
    public function edit(Peraturan $peraturan)
    {
        return view('stisla.peraturans.form', [
            'd'             => $peraturan,
            'title'         => __('Peraturan'),
            'fullTitle'     => __('Ubah Peraturan'),
            'routeIndex'    => route('peraturans.index'),
            'action'        => route('peraturans.update', [$peraturan->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param PeraturanRequest $request
     * @param Peraturan $peraturan
     * @return Response
     */
    public function update(PeraturanRequest $request, Peraturan $peraturan)
    {
        $data = $request->only([
            'judul',
            'nomor_peraturan',
            'tahun',
            'keterangan',
        ]);

        if ($request->hasFile('file_peraturan')) {
            // Hapus file lama jika ada
            if ($peraturan->file_peraturan) {
                Storage::delete('public/peraturan/' . $peraturan->file_peraturan);
            }

            $file = $request->file('file_peraturan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/peraturan', $filename);
            $data['file_peraturan'] = $filename;
        }

        $newData = $this->peraturanRepository->update($data, $peraturan->id);

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

        logUpdate("peraturan", $peraturan, $newData);

        $successMessage = successMessageUpdate("peraturan");
        return redirect()->route('peraturans.index')->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Peraturan $peraturan
     * @return Response
     */
    public function destroy(Peraturan $peraturan)
    {
        // Hapus file jika ada
        if ($peraturan->file_peraturan) {
            Storage::delete('public/peraturan/' . $peraturan->file_peraturan);
        }

        $this->peraturanRepository->delete($peraturan->id);
        logDelete("peraturan", $peraturan);

        $successMessage = successMessageDelete("peraturan");
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

        $data = $this->peraturanRepository->getLatest();
        return Excel::download(new PeraturanExport($data), 'peraturans.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new PeraturanImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("peraturan");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->peraturanRepository->getLatest();
        return $this->fileService->downloadJson($data, 'peraturans.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->peraturanRepository->getLatest();
        return (new PeraturanExport($data))->download('peraturans.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->peraturanRepository->getLatest();
        return (new PeraturanExport($data))->download('peraturans.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->peraturanRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.peraturans.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('peraturans.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->peraturanRepository->getLatest();
        return view('stisla.peraturans.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}