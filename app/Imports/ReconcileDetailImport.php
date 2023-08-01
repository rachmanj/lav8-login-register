<?php

namespace App\Imports;

use App\Models\ReconcileDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReconcileDetailImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $temp_flag = 'TEMP' . auth()->user()->id;

        return new ReconcileDetail([
            'invoice_no' => $row['invoice_no'],
            'user_id' => auth()->user()->id,
            'flag' => $temp_flag
        ]);
    }
}
