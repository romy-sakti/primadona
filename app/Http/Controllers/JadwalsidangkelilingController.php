<?php

namespace App\Http\Controllers;

use App\Exports\JadwalsidangkelilingExport;
use App\Http\Requests\JadwalsidangkelilingRequest;
use App\Imports\JadwalsidangkelilingImport;
use App\Models\Jadwalsidangkeliling;
use App\Repositories\JadwalsidangkelilingRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

class JadwalsidangkelilingController extends Controller
{
    /**
     * jadwalsidangkelilingRepository
     *
     * @var JadwalsidangkelilingRepository
     */
    private JadwalsidangkelilingRepository $jadwalsidangkelilingRepository;

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
        $this->jadwalsidangkelilingRepository      = new JadwalsidangkelilingRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:jadwal_sidang_keliling');
        $this->middleware('can:jadwal_sidang_keliling Tambah')->only(['create', 'store']);
        $this->middleware('can:jadwal_sidang_keliling Ubah')->only(['edit', 'update']);
        $this->middleware('can:jadwal_sidang_keliling Hapus')->only(['destroy']);
        $this->middleware('can:jadwal_sidang_keliling Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:jadwal_sidang_keliling Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.jadwalsidangkelilings.index', [
            'data'             => $this->jadwalsidangkelilingRepository->getLatest(),
            'canCreate'        => $user->can('jadwal_sidang_keliling Tambah'),
            'canUpdate'        => $user->can('jadwal_sidang_keliling Ubah'),
            'canDelete'        => $user->can('jadwal_sidang_keliling Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Jadwal Sidang Keliling'),
            'routeCreate'      => route('jadwalsidangkelilings.create'),
            'routePdf'         => route('jadwalsidangkelilings.pdf'),
            'routePrint'       => route('jadwalsidangkelilings.print'),
            'routeExcel'       => route('jadwalsidangkelilings.excel'),
            'routeCsv'         => route('jadwalsidangkelilings.csv'),
            'routeJson'        => route('jadwalsidangkelilings.json'),
            'routeImportExcel' => route('jadwalsidangkelilings.import-excel'),
            'excelExampleLink' => route('jadwalsidangkelilings.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.jadwalsidangkelilings.form', [
            'title'         => __('Jadwal Sidang Keliling'),
            'fullTitle'     => __('Tambah Jadwal Sidang Keliling'),
            'routeIndex'    => route('jadwalsidangkelilings.index'),
            'action'        => route('jadwalsidangkelilings.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param JadwalsidangkelilingRequest $request
     * @return Response
     */
    public function store(JadwalsidangkelilingRequest $request)
    {
        $data = $request->only([
			'tanggal_sidang',
			'nama_pemohon',
			'tempat_sidang',
			'agenda_sidang',
			'hakim',
			'panitera_pengganti',
			'nomor_perkara',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->jadwalsidangkelilingRepository->create($data);

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

        logCreate("jadwal_sidang_keliling", $result);

        $successMessage = successMessageCreate("jadwal_sidang_keliling");
        return redirect()->route('jadwalsidangkelilings.index')->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Jadwalsidangkeliling $jadwalsidangkeliling
     * @return Response
     */
    public function edit(Jadwalsidangkeliling $jadwalsidangkeliling)
    {
        return view('stisla.jadwalsidangkelilings.form', [
            'd'             => $jadwalsidangkeliling,
            'title'         => __('Jadwal Sidang Keliling'),
            'fullTitle'     => __('Ubah Jadwal Sidang Keliling'),
            'routeIndex'    => route('jadwalsidangkelilings.index'),
            'action'        => route('jadwalsidangkelilings.update', [$jadwalsidangkeliling->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param JadwalsidangkelilingRequest $request
     * @param Jadwalsidangkeliling $jadwalsidangkeliling
     * @return Response
     */
    public function update(JadwalsidangkelilingRequest $request, Jadwalsidangkeliling $jadwalsidangkeliling)
    {
        $data = $request->only([
			'tanggal_sidang',
			'nama_pemohon',
			'tempat_sidang',
			'agenda_sidang',
			'hakim',
			'panitera_pengganti',
			'nomor_perkara',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->jadwalsidangkelilingRepository->update($data, $jadwalsidangkeliling->id);

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

        logUpdate("jadwal_sidang_keliling", $jadwalsidangkeliling, $newData);

        $successMessage = successMessageUpdate("jadwal_sidang_keliling");
        return redirect()->route('jadwalsidangkelilings.index')->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Jadwalsidangkeliling $jadwalsidangkeliling
     * @return Response
     */
    public function destroy(Jadwalsidangkeliling $jadwalsidangkeliling)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($jadwalsidangkeliling);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($jadwalsidangkeliling);

        $this->jadwalsidangkelilingRepository->delete($jadwalsidangkeliling->id);
        logDelete("jadwal_sidang_keliling", $jadwalsidangkeliling);

        $successMessage = successMessageDelete("jadwal_sidang_keliling");
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

        $data = $this->jadwalsidangkelilingRepository->getLatest();
        return Excel::download(new JadwalsidangkelilingExport($data), 'jadwalsidangkelilings.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new JadwalsidangkelilingImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("jadwal_sidang_keliling");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->jadwalsidangkelilingRepository->getLatest();
        return $this->fileService->downloadJson($data, 'jadwalsidangkelilings.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->jadwalsidangkelilingRepository->getLatest();
        return (new JadwalsidangkelilingExport($data))->download('jadwalsidangkelilings.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->jadwalsidangkelilingRepository->getLatest();
        return (new JadwalsidangkelilingExport($data))->download('jadwalsidangkelilings.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->jadwalsidangkelilingRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.jadwalsidangkelilings.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('jadwalsidangkelilings.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->jadwalsidangkelilingRepository->getLatest();
        return view('stisla.jadwalsidangkelilings.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}