<?php

namespace App\Http\Controllers;

use App\Exports\NarasisidangkelilingExport;
use App\Http\Requests\NarasisidangkelilingRequest;
use App\Imports\NarasisidangkelilingImport;
use App\Models\Narasisidangkeliling;
use App\Repositories\NarasisidangkelilingRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Services\EmailService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade as PDF;

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
        $this->narasisidangkelilingRepository      = new NarasisidangkelilingRepository;
        $this->fileService            = new FileService;
        $this->emailService           = new EmailService;
        $this->NotificationRepository = new NotificationRepository;
        $this->UserRepository         = new UserRepository;

        $this->middleware('can:narasi_sidang_keliling');
        $this->middleware('can:narasi_sidang_keliling Tambah')->only(['create', 'store']);
        $this->middleware('can:narasi_sidang_keliling Ubah')->only(['edit', 'update']);
        $this->middleware('can:narasi_sidang_keliling Hapus')->only(['destroy']);
        $this->middleware('can:narasi_sidang_keliling Ekspor')->only(['json', 'excel', 'csv', 'pdf']);
        $this->middleware('can:narasi_sidang_keliling Impor Excel')->only(['importExcel', 'importExcelExample']);
    }

    /**
     * showing data page
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('stisla.narasisidangkelilings.index', [
            'data'             => $this->narasisidangkelilingRepository->getLatest(),
            'canCreate'        => $user->can('narasi_sidang_keliling Tambah'),
            'canUpdate'        => $user->can('narasi_sidang_keliling Ubah'),
            'canDelete'        => $user->can('narasi_sidang_keliling Hapus'),
            'canImportExcel'   => $user->can('Order Impor Excel') && $this->importable,
            'canExport'        => $user->can('Order Ekspor') && $this->exportable,
            'title'            => __('Narasi Sidang Keliling'),
            'routeCreate'      => route('narasisidangkelilings.create'),
            'routePdf'         => route('narasisidangkelilings.pdf'),
            'routePrint'       => route('narasisidangkelilings.print'),
            'routeExcel'       => route('narasisidangkelilings.excel'),
            'routeCsv'         => route('narasisidangkelilings.csv'),
            'routeJson'        => route('narasisidangkelilings.json'),
            'routeImportExcel' => route('narasisidangkelilings.import-excel'),
            'excelExampleLink' => route('narasisidangkelilings.import-excel-example'),
        ]);
    }

    /**
     * showing add new data form page
     *
     * @return Response
     */
    public function create()
    {
        return view('stisla.narasisidangkelilings.form', [
            'title'         => __('Narasi Sidang Keliling'),
            'fullTitle'     => __('Tambah Narasi Sidang Keliling'),
            'routeIndex'    => route('narasisidangkelilings.index'),
            'action'        => route('narasisidangkelilings.store')
        ]);
    }

    /**
     * save new data to db
     *
     * @param NarasisidangkelilingRequest $request
     * @return Response
     */
    public function store(NarasisidangkelilingRequest $request)
    {
        $data = $request->only([
            'tahun',
            'narasi',
        ]);

        // Handle multiple foto
        if ($request->hasFile('foto')) {
            $fotos = [];
            foreach($request->file('foto') as $foto) {
                $filename = time() . '_' . $foto->getClientOriginalName();
                $foto->storeAs('public/narasisidangkeliling/foto', $filename);
                $fotos[] = $filename;
            }
            $data['foto'] = json_encode($fotos);
        }

        // Handle multiple dokumen
        if ($request->hasFile('dokumen')) {
            $dokumens = [];
            foreach($request->file('dokumen') as $dokumen) {
                $filename = time() . '_' . $dokumen->getClientOriginalName();
                $dokumen->storeAs('public/narasisidangkeliling/dokumen', $filename);
                $dokumens[] = $filename;
            }
            $data['dokumen'] = json_encode($dokumens);
        }

        $result = $this->narasisidangkelilingRepository->create($data);

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

        logCreate("narasi_sidang_keliling", $result);

        $successMessage = successMessageCreate("narasi_sidang_keliling");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit page
     *
     * @param Narasisidangkeliling $narasisidangkeliling
     * @return Response
     */
    public function edit(Narasisidangkeliling $narasisidangkeliling)
    {
        return view('stisla.narasisidangkelilings.form', [
            'd'             => $narasisidangkeliling,
            'title'         => __('Narasi Sidang Keliling'),
            'fullTitle'     => __('Ubah Narasi Sidang Keliling'),
            'routeIndex'    => route('narasisidangkelilings.index'),
            'action'        => route('narasisidangkelilings.update', [$narasisidangkeliling->id])
        ]);
    }

    /**
     * update data to db
     *
     * @param NarasisidangkelilingRequest $request
     * @param Narasisidangkeliling $narasisidangkeliling
     * @return Response
     */
    public function update(NarasisidangkelilingRequest $request, Narasisidangkeliling $narasisidangkeliling)
    {
        $data = $request->only([
            'tahun',
            'narasi',
        ]);

        // Handle foto
        $fotos = [];
        // Simpan foto lama yang tidak dihapus
        if ($request->has('foto_lama')) {
            $fotos = $request->foto_lama;
        }
        // Tambah foto baru jika ada
        if ($request->hasFile('foto')) {
            foreach($request->file('foto') as $foto) {
                $filename = time() . '_' . $foto->getClientOriginalName();
                $foto->storeAs('public/narasisidangkeliling/foto', $filename);
                $fotos[] = $filename;
            }
        }
        $data['foto'] = json_encode($fotos);

        // Handle dokumen
        $dokumens = [];
        // Simpan dokumen lama yang tidak dihapus
        if ($request->has('dokumen_lama')) {
            $dokumens = $request->dokumen_lama;
        }
        // Tambah dokumen baru jika ada
        if ($request->hasFile('dokumen')) {
            foreach($request->file('dokumen') as $dokumen) {
                $filename = time() . '_' . $dokumen->getClientOriginalName();
                $dokumen->storeAs('public/narasisidangkeliling/dokumen', $filename);
                $dokumens[] = $filename;
            }
        }
        $data['dokumen'] = json_encode($dokumens);

        $newData = $this->narasisidangkelilingRepository->update($data, $narasisidangkeliling->id);

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

        logUpdate("narasi_sidang_keliling", $narasisidangkeliling, $newData);

        $successMessage = successMessageUpdate("Narasi Sidang Keliling");
        return redirect()->route('narasisidangkelilings.index')->with('successMessage', $successMessage);
    }

    /**
     * delete user from db
     *
     * @param Narasisidangkeliling $narasisidangkeliling
     * @return Response
     */
    public function destroy(Narasisidangkeliling $narasisidangkeliling)
    {
        // Hapus file foto dari storage jika ada
        if ($narasisidangkeliling->foto) {
            $fotos = is_string($narasisidangkeliling->foto) ?
                json_decode($narasisidangkeliling->foto, true) :
                $narasisidangkeliling->foto;

            if (is_array($fotos)) {
                foreach ($fotos as $foto) {
                    $fotoPath = 'public/narasisidangkeliling/foto/' . $foto;
                    if (Storage::exists($fotoPath)) {
                        Storage::delete($fotoPath);
                    }
                }
            }
        }

        // Hapus file dokumen dari storage jika ada
        if ($narasisidangkeliling->dokumen) {
            $dokumens = is_string($narasisidangkeliling->dokumen) ?
                json_decode($narasisidangkeliling->dokumen, true) :
                $narasisidangkeliling->dokumen;

            if (is_array($dokumens)) {
                foreach ($dokumens as $dokumen) {
                    $dokumenPath = 'public/narasisidangkeliling/dokumen/' . $dokumen;
                    if (Storage::exists($dokumenPath)) {
                        Storage::delete($dokumenPath);
                    }
                }
            }
        }

        // Hapus data dari database
        $this->narasisidangkelilingRepository->delete($narasisidangkeliling->id);
        logDelete("narasi_sidang_keliling", $narasisidangkeliling);

        $successMessage = successMessageDelete("Narasi Sidang Keliling");
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

        $data = $this->narasisidangkelilingRepository->getLatest();
        return Excel::download(new NarasisidangkelilingExport($data), 'narasisidangkelilings.xlsx');
    }

    /**
     * import excel file to db
     *
     * @param \App\Http\Requests\ImportExcelRequest $request
     * @return Response
     */
    public function importExcel(\App\Http\Requests\ImportExcelRequest $request)
    {
        Excel::import(new NarasisidangkelilingImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("narasi_sidang_keliling");
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return Response
     */
    public function json()
    {
        $data = $this->narasisidangkelilingRepository->getLatest();
        return $this->fileService->downloadJson($data, 'narasisidangkelilings.json');
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel()
    {
        $data = $this->narasisidangkelilingRepository->getLatest();
        return (new NarasisidangkelilingExport($data))->download('narasisidangkelilings.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv()
    {
        $data = $this->narasisidangkelilingRepository->getLatest();
        return (new NarasisidangkelilingExport($data))->download('narasisidangkelilings.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf()
    {
        $data = $this->narasisidangkelilingRepository->getLatest();
        return PDF::setPaper('Letter', 'landscape')
            ->loadView('stisla.narasisidangkelilings.export-pdf', [
                'data'    => $data,
                'isPrint' => false
            ])
            ->download('narasisidangkelilings.pdf');
    }

    /**
     * export data to print html
     *
     * @return Response
     */
    public function exportPrint()
    {
        $data = $this->narasisidangkelilingRepository->getLatest();
        return view('stisla.narasisidangkelilings.export-pdf', [
            'data'    => $data,
            'isPrint' => true
        ]);
    }
}
