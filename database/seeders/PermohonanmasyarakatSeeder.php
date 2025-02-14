<?php

namespace Database\Seeders;

use App\Models\Permohonanmasyarakat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermohonanmasyarakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data  = [];
        $faker = \Faker\Factory::create('id_ID');
        $now   = date('Y-m-d H:i:s');

        Permohonanmasyarakat::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'nama_pemohon' => Str::random(10),
				'jenis_permohonan_id' => Str::random(10),
				'nomor_perkara' => Str::random(10),
				'status_permohonan' => Str::random(10),
				'keterangan' => Str::random(10),
				'dokumen_penetapan' => Str::random(10),
				'nomor_telepon' => Str::random(10),
				'alamat_pemohon' => $faker->numberBetween(0,1000), // ganti method fakernya sesuai kebutuhan
				'tempat_lahir' => Str::random(10),
				'tanggal_lahir' => $faker->date("Y-m-d", $max = date("Y-m-d")), // ganti method fakernya sesuai kebutuhan
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Permohonanmasyarakat::insert($chunkData->toArray());
        }
    }
}
