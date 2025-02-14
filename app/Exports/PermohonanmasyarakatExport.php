<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PermohonanmasyarakatExport implements FromView
{
    use Exportable;

    /**
     * data
     *
     * @var Collection
     */
    private Collection $data;

    /**
     * constructor method
     *
     * @param Collection $data
     * @return void
     */
    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    /**
     * export from view
     *
     * @return View
     */
    public function view(): View
    {
        if ($this->data->count() === 0) {
            $columns = [
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
            ];
            $data = [];

            foreach (range(1, 10) as $i) {
                array_push($data, (object) array_combine($columns, $columns));
            }

            $this->data = collect($data);
        }
        return view('stisla.permohonanmasyarakats.export-excel-example', [
            'data'     => $this->data,
            'isExport' => true
        ]);
    }
}
