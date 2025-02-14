<?php

namespace App\Http\Controllers;

use App\Exports\BiayapermohonanExport;
use App\Http\Requests\BiayapermohonanRequest;
use App\Imports\BiayapermohonanImport;
use App\Models\Biayapermohonan;
use App\Repositories\BiayapermohonanRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class BiayapermohonanController extends Controller
{
    /**
     * biayapermohonanRepository
     *
     * @var BiayapermohonanRepository
     */
    private BiayapermohonanRepository $biayapermohonanRepository;

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
        $this->biayapermohonanRepository      = new BiayapermohonanRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:biaya_permohonan');
        $this->middleware('can:biaya_permohonan Tambah')->only(['create', 'store']);
        $this->middleware('can:biaya_permohonan Ubah')->only(['edit', 'update']);
        $this->middleware('can:biaya_permohonan Hapus')->only(['destroy']);
        $this->middleware('can:biaya_permohonan Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:biaya_permohonan Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.biayapermohonans.index', [
            'data'             => $this->biayapermohonanRepository->getLatest(),
            'canCreate'        => $user->can('biaya_permohonan Tambah'),
            'canUpdate'        => $user->can('biaya_permohonan Ubah'),
            'canDelete'        => $user->can('biaya_permohonan Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Biaya Permohonan'),
            'routeCreate'      => route('biayapermohonans.create'),
            'routePdf'         => route('biayapermohonans.pdf'),
            'routePrint'       => route('biayapermohonans.print'),
            'routeExcel'       => route('biayapermohonans.excel'),
            'routeCsv'         => route('biayapermohonans.csv'),
            'routeJson'        => route('biayapermohonans.json'),
            'routeImportExcel' => route('biayapermohonans.import-excel'),
            'excelExampleLink' => route('biayapermohonans.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.biayapermohonans.form', [
            'title'         => __('Biaya Permohonan'),
            'fullTitle'     => __('Tambah Biaya Permohonan'),
            'routeIndex'    => route('biayapermohonans.index'),
            'action'        => route('biayapermohonans.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param BiayapermohonanRequest $request
     * @return Response
     */
    public function store(BiayapermohonanRequest $request)
    {
        $data = $request->only([
            'biaya_pendaftaran',
            'biaya_atk_administrasi',
            'pnbp_panggilan',
            'materai',
            'redaksi',
        ]);

        // Hapus prefix "Rp" dan titik dari nilai input
        $data['biaya_pendaftaran'] = str_replace(['Rp', '.'], '', $data['biaya_pendaftaran']);
        $data['biaya_atk_administrasi'] = str_replace(['Rp', '.'], '', $data['biaya_atk_administrasi']);
        $data['pnbp_panggilan'] = str_replace(['Rp', '.'], '', $data['pnbp_panggilan']);
        $data['materai'] = str_replace(['Rp', '.'], '', $data['materai']);
        $data['redaksi'] = str_replace(['Rp', '.'], '', $data['redaksi']);

        $result = $this->biayapermohonanRepository->create($data);

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

        logCreate("biaya_permohonan", $result);

        $successMessage = successMessageCreate("Biaya Permohonan");
        return redirect()->route('biayapermohonans.index')->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Biayapermohonan $biayapermohonan
     * @return Response
     */
    public function edit(Biayapermohonan $biayapermohonan)
    {
        // Format nilai ke format Rupiah
        $biayapermohonan->biaya_pendaftaran = 'Rp' . number_format($biayapermohonan->biaya_pendaftaran, 0, ',', '.');
        $biayapermohonan->biaya_atk_administrasi = 'Rp' . number_format($biayapermohonan->biaya_atk_administrasi, 0, ',', '.');
        $biayapermohonan->pnbp_panggilan = 'Rp' . number_format($biayapermohonan->pnbp_panggilan, 0, ',', '.');
        $biayapermohonan->materai = 'Rp' . number_format($biayapermohonan->materai, 0, ',', '.');
        $biayapermohonan->redaksi = 'Rp' . number_format($biayapermohonan->redaksi, 0, ',', '.');

        return view('stisla.biayapermohonans.form', [
            'd'             => $biayapermohonan,
            'title'         => __('Biaya Permohonan'),
            'fullTitle'     => __('Ubah Biaya Permohonan'),
            'routeIndex'    => route('biayapermohonans.index'),
            'action'        => route('biayapermohonans.update', [$biayapermohonan->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param BiayapermohonanRequest $request
     * @param Biayapermohonan $biayapermohonan
     * @return Response
     */
    public function update(BiayapermohonanRequest $request, Biayapermohonan $biayapermohonan)
    {
        $data = $request->only([
            'biaya_pendaftaran',
            'biaya_atk_administrasi',
            'pnbp_panggilan',
            'materai',
            'redaksi',
        ]);

        // Hapus prefix "Rp" dan titik dari nilai input
        $data['biaya_pendaftaran'] = str_replace(['Rp', '.'], '', $data['biaya_pendaftaran']);
        $data['biaya_atk_administrasi'] = str_replace(['Rp', '.'], '', $data['biaya_atk_administrasi']);
        $data['pnbp_panggilan'] = str_replace(['Rp', '.'], '', $data['pnbp_panggilan']);
        $data['materai'] = str_replace(['Rp', '.'], '', $data['materai']);
        $data['redaksi'] = str_replace(['Rp', '.'], '', $data['redaksi']);

        $newData = $this->biayapermohonanRepository->update($data, $biayapermohonan->id);

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

        logUpdate("biaya_permohonan", $biayapermohonan, $newData);

        $successMessage = successMessageUpdate("Biaya Permohonan");
        return redirect()->route('biayapermohonans.index')->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Biayapermohonan $biayapermohonan
     * @return Response
     */
    public function destroy(Biayapermohonan $biayapermohonan)
    {
        // delete file from storage if exists
        // $this->fileService->methodName($biayapermohonan);

        // use this if you want to create notification data
        // $title = 'Notify Title';
        // $content = 'lorem ipsum dolor sit amet';
        // $userId = 2;
        // $notificationType = 'transaksi masuk';
        // $icon = 'bell'; // font awesome
        // $bgColor = 'primary'; // primary, danger, success, warning
        // $this->NotificationRepository->createNotif($title,  $content, $userId,  $notificationType, $icon, $bgColor);

        // gunakan jika mau kirim email
        // $this->emailService->methodName($biayapermohonan);

        $this->biayapermohonanRepository->delete($biayapermohonan->id);
        logDelete("biaya_permohonan", $biayapermohonan);

        $successMessage = successMessageDelete("biaya_permohonan");
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

        $data = $this->biayapermohonanRepository->getLatest();
        return Excel::download(new BiayapermohonanExport($data), 'biayapermohonans.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new BiayapermohonanImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("biaya_permohonan");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->biayapermohonanRepository->getLatest();
        return $this->fileService->downloadJson($data, 'biayapermohonans.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->biayapermohonanRepository->getLatest();
        return (new BiayapermohonanExport($data))->download('biayapermohonans.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->biayapermohonanRepository->getLatest();
        return (new BiayapermohonanExport($data))->download('biayapermohonans.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->biayapermohonanRepository->getLatest();
        return Pdf::setPaper('Letter', 'landscape')
            ->loadView('stisla.biayapermohonans.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('biayapermohonans.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->biayapermohonanRepository->getLatest();
        return view('stisla.biayapermohonans.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}