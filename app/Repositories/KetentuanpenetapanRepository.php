<?php

namespace App\Repositories;

use App\Models\Ketentuanpenetapan;

class KetentuanpenetapanRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Ketentuanpenetapan();
    }
}
