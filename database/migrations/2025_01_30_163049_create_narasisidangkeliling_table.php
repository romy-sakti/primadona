<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNarasisidangkelilingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('narasisidangkelilings', function (Blueprint $table) {
            $table->id();
			$table->string('tahun', 191)->nullable();
			$table->string('narasi', 191)->nullable();
			$table->string('foto', 191)->nullable();
			$table->string('dokumen', 191)->nullable();
			$table->timestamps();
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('narasisidangkelilings');
    }
}
