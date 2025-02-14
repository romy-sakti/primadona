<?php

namespace App\Repositories;

use App\Models\Peraturan;

class PeraturanRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Peraturan();
    }
}
