<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsidangkelilingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwalsidangkelilings', function (Blueprint $table) {
            $table->id();
			$table->date('tanggal_sidang')->nullable();
			$table->string('nama_pemohon', 191)->nullable();
			$table->string('tempat_sidang', 191)->nullable();
			$table->string('agenda_sidang', 191)->nullable();
			$table->string('hakim', 191)->nullable();
			$table->string('panitera_pengganti', 191)->nullable();
			$table->string('nomor_perkara', 191)->nullable();
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
        Schema::dropIfExists('jadwalsidangkelilings');
    }
}
