<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermohonanmasyarakatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('put')) {
            return [
				'nama_pemohon' => ["required"],
				'jenis_permohonan_id' => ["required"],
				'nomor_perkara' => ["required"],
				'status_permohonan' => ["required"],
				'keterangan' => ["required"],
				'dokumen_penetapan' => ["required"],
				'nomor_telepon' => ["required"],
				'alamat_pemohon' => ["required"],
				'tempat_lahir' => ["required"],
				'tanggal_lahir' => ["required"],

            ];
        }
        return [
			'nama_pemohon' => ["required"],
			'jenis_permohonan_id' => ["required"],
			'nomor_perkara' => ["required"],
			'status_permohonan' => ["required"],
			'keterangan' => ["required"],
			'dokumen_penetapan' => ["required"],
			'nomor_telepon' => ["required"],
			'alamat_pemohon' => ["required"],
			'tempat_lahir' => ["required"],
			'tanggal_lahir' => ["required"],

        ];
    }
}
