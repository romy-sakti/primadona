<?php

namespace App\Repositories;

use App\Models\Permohonanmasyarakat;

class PermohonanmasyarakatRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Permohonanmasyarakat();
    }
}
