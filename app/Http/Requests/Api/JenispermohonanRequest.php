<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class JenispermohonanRequest extends FormRequest
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
				'nama_jenis' => ["required"],
				'deskripsi' => ["required"],

            ];
        }
        return [
			'nama_jenis' => ["required"],
			'deskripsi' => ["required"],

        ];
    }
}
