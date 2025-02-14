<?php

namespace App\Repositories;

use App\Models\Jadwalsidangkeliling;

class JadwalsidangkelilingRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Jadwalsidangkeliling();
    }
}
