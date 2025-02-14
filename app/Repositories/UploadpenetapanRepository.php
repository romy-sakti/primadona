<?php

namespace App\Repositories;

use App\Models\Uploadpenetapan;

class UploadpenetapanRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Uploadpenetapan();
    }
}
