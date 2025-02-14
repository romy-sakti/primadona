<?php

namespace Database\Seeders;

use App\Models\Jenispermohonan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JenispermohonanSeeder extends Seeder
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

        Jenispermohonan::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'nama_jenis' => Str::random(10),
				'deskripsi' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Jenispermohonan::insert($chunkData->toArray());
        }
    }
}
