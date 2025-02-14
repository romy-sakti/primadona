<?php

namespace Database\Seeders;

use App\Models\Biayapermohonan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BiayapermohonanSeeder extends Seeder
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

        Biayapermohonan::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'biaya_pendaftaran' => Str::random(10),
				'biaya_atk_administrasi' => Str::random(10),
				'pnbp_panggilan' => Str::random(10),
				'materai' => Str::random(10),
				'redaksi' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Biayapermohonan::insert($chunkData->toArray());
        }
    }
}
