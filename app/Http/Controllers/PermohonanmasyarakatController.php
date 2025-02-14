<?php

namespace App\Http\Controllers;

use App\Exports\PermohonanmasyarakatExport;
use App\Http\Requests\PermohonanmasyarakatRequest;
use App\Imports\PermohonanmasyarakatImport;
use App\Models\Permohonanmasyarakat;
use App\Models\Jenispermohonan;
use App\Repositories\PermohonanmasyarakatRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

class PermohonanmasyarakatController extends Controller
{
    /**
     * permohonanmasyarakatRepository
     *
     * @var PermohonanmasyarakatRepository
     */
    private PermohonanmasyarakatRepository $permohonanmasyarakatRepository;

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
        $this->permohonanmasyarakatRepository      = new PermohonanmasyarakatRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:permohonan_masyarakat');
        $this->middleware('can:permohonan_masyarakat Tambah')->only(['create', 'store']);
        $this->middleware('can:permohonan_masyarakat Ubah')->only(['edit', 'update']);
        $this->middleware('can:permohonan_masyarakat Hapus')->only(['destroy']);
        $this->middleware('can:permohonan_masyarakat Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:permohonan_masyarakat Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.permohonanmasyarakats.index', [
            'data'             => $this->permohonanmasyarakatRepository->getLatest(),
            'canCreate'        => $user->can('permohonan_masyarakat Tambah'),
            'canUpdate'        => $user->can('permohonan_masyarakat Ubah'),
            'canDelete'        => $user->can('permohonan_masyarakat Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Permohonan Masyarakat'),
            'routeCreate'      => route('permohonanmasyarakats.create'),
            'routePdf'         => route('permohonanmasyarakats.pdf'),
            'routePrint'       => route('permohonanmasyarakats.print'),
            'routeExcel'       => route('permohonanmasyarakats.excel'),
            'routeCsv'         => route('permohonanmasyarakats.csv'),
            'routeJson'        => route('permohonanmasyarakats.json'),
            'routeImportExcel' => route('permohonanmasyarakats.import-excel'),
            'excelExampleLink' => route('permohonanmasyarakats.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        $jenisPermohonans = Jenispermohonan::all();
        return view('stisla.permohonanmasyarakats.form', [
            'title'             => __('Permohonan Masyarakat'),
            'fullTitle'         => __('Tambah Permohonan Masyarakat'),
            'routeIndex'        => route('permohonanmasyarakats.index'),
            'action'            => route('permohonanmasyarakats.store'),
            'jenisPermohonans'  => $jenisPermohonans
        ]);
    }

    /**
     * save new data to db
     *
     * @param PermohonanmasyarakatRequest $request
     * @return Response
     */
    public function store(PermohonanmasyarakatRequest $request)
    {
        $data = $request->only([
			'nama_pemohon',
			'jenis_permohonan_id',
			'nomor_perkara',
			'status_permohonan',
			'keterangan',
			'dokumen_penetapan',
			'nomor_telepon',
			'alamat_pemohon',
			'tempat_lahir',
			'tanggal_lahir',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->permohonanmasyarakatRepository->create($data);

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

        logCreate("permohonan_masyarakat", $result);

        $successMessage = successMessageCreate("permohonan_masyarakat");
        return redirect()->route('permohonanmasyarakats.index')->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Permohonanmasyarakat $permohonanmasyarakat
     * @return Response
     */
    public function edit(Permohonanmasyarakat $permohonanmasyarakat)
    {
        $jenisPermohonans = Jenispermohonan::all();
        return view('stisla.permohonanmasyarakats.form', [
            'd'                 => $permohonanmasyarakat,
            'title'             => __('Permohonan Masyarakat'),
            'fullTitle'         => __('Ubah Permohonan Masyarakat'),
            'routeIndex'        => route('permohonanmasyarakats.index'),
            'action'            => route('permohonanmasyarakats.update', [$permohonanmasyarakat->id]),
            'jenisPermohonans'  => $jenisPermohonans
        ]);
    }

    /**
     * update data to db
     *
     * @param PermohonanmasyarakatRequest $request
     * @param Permohonanmasyarakat $permohonanmasyarakat
     * @return Response
     */
    public function update(PermohonanmasyarakatRequest $request, Permohonanmasyarakat $permohonanmasyarakat)
    {
        $data = $request->only([
			'nama_pemohon',
			'jenis_permohonan_id',
			'nomor_perkara',
			'status_permohonan',
			'keterangan',
			'dokumen_penetapan',
			'nomor_telepon',
			'alamat_pemohon',
			'tempat_lahir',
			'tanggal_lahir',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->permohonanmasyarakatRepository->update($data, $permohonanmasyarakat->id);

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

        logUpdate("permohonan_masyarakat", $permohonanmasyarakat, $newData);

        $successMessage = successMessageUpdate("permohonan_masyarakat");
        return redirect()->route('permohonanmasyarakats.index')->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Permohonanmasyarakat $permohonanmasyarakat
     * @return Response
     */
    public function destroy(Permohonanmasyarakat $permohonanmasyarakat)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($permohonanmasyarakat);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($permohonanmasyarakat);

        $this->permohonanmasyarakatRepository->delete($permohonanmasyarakat->id);
        logDelete("permohonan_masyarakat", $permohonanmasyarakat);

        $successMessage = successMessageDelete("permohonan_masyarakat");
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

        $data = $this->permohonanmasyarakatRepository->getLatest();
        return Excel::download(new PermohonanmasyarakatExport($data), 'permohonanmasyarakats.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new PermohonanmasyarakatImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("permohonan_masyarakat");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->permohonanmasyarakatRepository->getLatest();
        return $this->fileService->downloadJson($data, 'permohonanmasyarakats.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->permohonanmasyarakatRepository->getLatest();
        return (new PermohonanmasyarakatExport($data))->download('permohonanmasyarakats.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->permohonanmasyarakatRepository->getLatest();
        return (new PermohonanmasyarakatExport($data))->download('permohonanmasyarakats.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->permohonanmasyarakatRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.permohonanmasyarakats.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('permohonanmasyarakats.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->permohonanmasyarakatRepository->getLatest();
        return view('stisla.permohonanmasyarakats.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}