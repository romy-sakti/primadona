<?php

namespace Database\Seeders;

use App\Models\Jadwalsidangkeliling;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JadwalsidangkelilingSeeder extends Seeder
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

        Jadwalsidangkeliling::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'tanggal_sidang' => $faker->date("Y-m-d", $max = date("Y-m-d")), // ganti method fakernya sesuai kebutuhan
				'nama_pemohon' => Str::random(10),
				'tempat_sidang' => Str::random(10),
				'agenda_sidang' => Str::random(10),
				'hakim' => Str::random(10),
				'panitera_pengganti' => Str::random(10),
				'nomor_perkara' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Jadwalsidangkeliling::insert($chunkData->toArray());
        }
    }
}
