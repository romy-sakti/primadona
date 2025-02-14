<?php

namespace Database\Seeders;

use App\Models\Peraturan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PeraturanSeeder extends Seeder
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

        Peraturan::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'judul' => Str::random(10),
				'nomor_peraturan' => Str::random(10),
				'tahun' => Str::random(10),
				'keterangan' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Peraturan::insert($chunkData->toArray());
        }
    }
}
