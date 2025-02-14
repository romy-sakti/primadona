<?php

namespace App\Repositories;

use App\Models\Biayapermohonan;

class BiayapermohonanRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Biayapermohonan();
    }
}
