<?php

namespace Database\Seeders;

use App\Models\Uploadpenetapan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UploadpenetapanSeeder extends Seeder
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

        Uploadpenetapan::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'nomor_perkara' => Str::random(10),
				'file_penetapan' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Uploadpenetapan::insert($chunkData->toArray());
        }
    }
}
