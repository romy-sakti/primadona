<?php

namespace App\Repositories;

use App\Models\Jenispermohonan;

class JenispermohonanRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Jenispermohonan();
    }
}
