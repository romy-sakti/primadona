<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NarasisidangkelilingRequest extends FormRequest
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
                'tahun' => ["required"],
                'narasi' => ["required"],
                'foto.*' => ["nullable", "image", "max:2048"], // max 2MB
                'dokumen.*' => ["nullable", "mimes:pdf,doc,docx", "max:10240"], // max 10MB
            ];
        }
        return [
            'tahun' => ["required"],
            'narasi' => ["required"],
            'foto.*' => ["nullable", "image", "max:2048"],
            'dokumen.*' => ["nullable", "mimes:pdf,doc,docx", "max:10240"],
        ];
    }
}