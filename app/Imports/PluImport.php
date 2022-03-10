<?php

namespace App\Imports;

use App\ImportPlu;
use Maatwebsite\Excel\Concerns\ToModel;

class PluImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ImportPlu([
            'kodeplu' => $row[0],
        ]);
    }
}
