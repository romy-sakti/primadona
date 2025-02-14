<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BiayapermohonanRequest extends FormRequest
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
				'biaya_pendaftaran' => ["required"],
				'biaya_atk_administrasi' => ["required"],
				'pnbp_panggilan' => ["required"],
				'materai' => ["required"],
				'redaksi' => ["required"],

            ];
        }
        return [
			'biaya_pendaftaran' => ["required"],
			'biaya_atk_administrasi' => ["required"],
			'pnbp_panggilan' => ["required"],
			'materai' => ["required"],
			'redaksi' => ["required"],

        ];
    }
}
