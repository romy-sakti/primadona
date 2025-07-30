<?php

namespace App\Http\Controllers;

use App\Exports\JenispermohonanExport;
use App\Http\Requests\JenispermohonanRequest;
use App\Imports\JenispermohonanImport;
use App\Models\Jenispermohonan;
use App\Repositories\JenispermohonanRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

class JenispermohonanController extends Controller
{
    /**
     * jenispermohonanRepository
     *
     * @var JenispermohonanRepository
     */
    private JenispermohonanRepository $jenispermohonanRepository;

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
        $this->jenispermohonanRepository      = new JenispermohonanRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:jenis_permohonan');
        $this->middleware('can:jenis_permohonan Tambah')->only(['create', 'store']);
        $this->middleware('can:jenis_permohonan Ubah')->only(['edit', 'update']);
        $this->middleware('can:jenis_permohonan Hapus')->only(['destroy']);
        $this->middleware('can:jenis_permohonan Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:jenis_permohonan Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.jenispermohonans.index', [
            'data'             => $this->jenispermohonanRepository->getLatest(),
            'canCreate'        => $user->can('jenis_permohonan Tambah'),
            'canUpdate'        => $user->can('jenis_permohonan Ubah'),
            'canDelete'        => $user->can('jenis_permohonan Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Jenis Permohonan'),
            'routeCreate'      => route('jenispermohonans.create'),
            'routePdf'         => route('jenispermohonans.pdf'),
            'routePrint'       => route('jenispermohonans.print'),
            'routeExcel'       => route('jenispermohonans.excel'),
            'routeCsv'         => route('jenispermohonans.csv'),
            'routeJson'        => route('jenispermohonans.json'),
            'routeImportExcel' => route('jenispermohonans.import-excel'),
            'excelExampleLink' => route('jenispermohonans.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.jenispermohonans.form', [
            'title'         => __('Jenis Permohonan'),
            'fullTitle'     => __('Tambah Jenis Permohonan'),
            'routeIndex'    => route('jenispermohonans.index'),
            'action'        => route('jenispermohonans.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param JenispermohonanRequest $request
     * @return Response
     */
    public function store(JenispermohonanRequest $request)
    {
        $data = $request->only([
			'nama_jenis',
			'deskripsi',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $result = $this->jenispermohonanRepository->create($data);

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

        logCreate("jenis_permohonan", $result);

        $successMessage = successMessageCreate("jenis_permohonan");
        return redirect()->route('jenispermohonans.index')->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Jenispermohonan $jenispermohonan
     * @return Response
     */
    public function edit(Jenispermohonan $jenispermohonan)
    {
        return view('stisla.jenispermohonans.form', [
            'd'             => $jenispermohonan,
            'title'         => __('Jenis Permohonan'),
            'fullTitle'     => __('Ubah Jenis Permohonan'),
            'routeIndex'    => route('jenispermohonans.index'),
            'action'        => route('jenispermohonans.update', [$jenispermohonan->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param JenispermohonanRequest $request
     * @param Jenispermohonan $jenispermohonan
     * @return Response
     */
    public function update(JenispermohonanRequest $request, Jenispermohonan $jenispermohonan)
    {
        $data = $request->only([
			'nama_jenis',
			'deskripsi',
        ]);

        // gunakan jika ada file
        // if ($request->hasFile('file')) {
        //     $data['file'] = $this->fileService->methodName($request->file('file'));
        // }

        $newData = $this->jenispermohonanRepository->update($data, $jenispermohonan->id);

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

        logUpdate("jenis_permohonan", $jenispermohonan, $newData);

        $successMessage = successMessageUpdate("jenis_permohonan");
        return redirect()->route('jenispermohonans.index')->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Jenispermohonan $jenispermohonan
     * @return Response
     */
    public function destroy(Jenispermohonan $jenispermohonan)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($jenispermohonan);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($jenispermohonan);

        $this->jenispermohonanRepository->delete($jenispermohonan->id);
        logDelete("jenis_permohonan", $jenispermohonan);

        $successMessage = successMessageDelete("jenis_permohonan");
        return redirect()->route('jenispermohonans.index')->with('successMessage', $successMessage);
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

        $data = $this->jenispermohonanRepository->getLatest();
        return Excel::download(new JenispermohonanExport($data), 'jenispermohonans.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new JenispermohonanImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("jenis_permohonan");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->jenispermohonanRepository->getLatest();
        return $this->fileService->downloadJson($data, 'jenispermohonans.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->jenispermohonanRepository->getLatest();
        return (new JenispermohonanExport($data))->download('jenispermohonans.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->jenispermohonanRepository->getLatest();
        return (new JenispermohonanExport($data))->download('jenispermohonans.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->jenispermohonanRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.jenispermohonans.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('jenispermohonans.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->jenispermohonanRepository->getLatest();
        return view('stisla.jenispermohonans.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}