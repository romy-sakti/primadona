<?php

namespace Database\Seeders;

use App\Models\Narasisidangkeliling;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NarasisidangkelilingSeeder extends Seeder
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

        Narasisidangkeliling::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'tahun' => Str::random(10),
				'narasi' => Str::random(10),
				'foto' => Str::random(10),
				'dokumen' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Narasisidangkeliling::insert($chunkData->toArray());
        }
    }
}
