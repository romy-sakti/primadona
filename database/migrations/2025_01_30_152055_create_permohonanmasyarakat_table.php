<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanmasyarakatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonanmasyarakats', function (Blueprint $table) {
            $table->id();
			$table->string('nama_pemohon', 191)->nullable();
			$table->string('jenis_permohonan_id', 191)->nullable();
			$table->string('nomor_perkara', 191)->nullable();
			$table->string('status_permohonan', 191)->nullable();
			$table->string('keterangan', 191)->nullable();
			$table->string('dokumen_penetapan', 191)->nullable();
			$table->string('nomor_telepon', 191)->nullable();
			$table->text('alamat_pemohon')->nullable();
			$table->string('tempat_lahir', 191)->nullable();
			$table->date('tanggal_lahir')->nullable();
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
        Schema::dropIfExists('permohonanmasyarakats');
    }
}
