<?php

namespace App\Repositories;

use App\Models\Narasisidangkeliling;

class NarasisidangkelilingRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Narasisidangkeliling();
    }
}
