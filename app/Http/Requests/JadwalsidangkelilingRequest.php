<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalsidangkelilingRequest extends FormRequest
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
				'tanggal_sidang' => ["required"],
				'nama_pemohon' => ["required"],
				'tempat_sidang' => ["required"],
				'agenda_sidang' => ["required"],
				'hakim' => ["required"],
				'panitera_pengganti' => ["required"],
				'nomor_perkara' => ["required"],

            ];
        }
        return [
			'tanggal_sidang' => ["required"],
			'nama_pemohon' => ["required"],
			'tempat_sidang' => ["required"],
			'agenda_sidang' => ["required"],
			'hakim' => ["required"],
			'panitera_pengganti' => ["required"],
			'nomor_perkara' => ["required"],

        ];
    }
}
