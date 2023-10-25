<?php

namespace App\Imports;

use App\Models\Doktam;
use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItoImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Doktam([
            'doctypes_id' => 9, // ITO
            'document_no' => $row['ito_no'],
            'document_date' => $this->convert_date($row['ito_date']),
            'grpo_no' => $row['grpo_no'],
            'grpo_date' => $this->convert_date($row['grpo_date']),
            'ito_created_date' => $this->convert_date($row['ito_created_date']),
            'doktams_po_no' => $row['po_no'],
            'from_warehouse' => $row['from_warehouse'],
            'to_warehouse' => $row['to_warehouse'],
            'remarks' => $row['remarks'],
            'created_by' => 'uploaded',
            'user_id' => auth()->user()->id,
            'project_id' => $this->getWarehouseProject($row['to_warehouse']),
            'delivery_date' => $this->convert_date($row['delivery_date']),
            'is_duplicate' => $this->checkDuplicate($row['ito_no']),
            'flag' => "UPLOAD-TEMP-" . auth()->user()->id,
            'need_receiveback' => 1
        ]);
    }

    public function getWarehouseProject($warehouse_code)
    {
        $warehouse = Warehouse::where('code', $warehouse_code)->first();

        if ($warehouse) {
            return $warehouse->project_id;
        } else {
            return 99;
        }
    }

    public function convert_date($date)
    {
        if ($date) {
            $year = substr($date, 6, 4);
            $month = substr($date, 3, 2);
            $day = substr($date, 0, 2);
            $new_date = $year . '-' . $month . '-' . $day;
            return $new_date;
        } else {
            return null;
        }
    }

    public function checkDuplicate($document_no)
    {
        $ito_count = Doktam::where('document_no', $document_no)
                    ->where('doctypes_id', 9)
                    ->count();

        if ($ito_count > 0) {
            return true;
        } else {
            return false;
        }
    }
}
