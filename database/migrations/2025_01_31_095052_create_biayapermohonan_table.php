<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiayapermohonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biayapermohonans', function (Blueprint $table) {
            $table->id();
			$table->string('biaya_pendaftaran', 191)->nullable();
			$table->string('biaya_atk_administrasi', 191);
			$table->string('pnbp_panggilan', 191)->nullable();
			$table->string('materai', 191);
			$table->string('redaksi', 191)->nullable();
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
        Schema::dropIfExists('biayapermohonans');
    }
}
