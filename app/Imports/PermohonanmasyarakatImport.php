<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PermohonanmasyarakatImport implements ToCollection, WithHeadingRow
{

    /**
     * To collection
     *
     * @return void
     */
    public function collection(Collection $rows)
    {
        $dateTime = date('Y-m-d H:i:s');
        foreach ($rows->chunk(30) as $chunkData) {
            $insertData = $chunkData->transform(function ($item) use ($dateTime) {
                $item->put('created_at', $dateTime);
                $item->put('updated_at', $dateTime);
                return $item;
            })->toArray();
            \App\Models\Permohonanmasyarakat::insert($insertData);
        }
    }
}
