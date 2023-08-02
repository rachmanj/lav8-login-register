<?php

namespace App\Exports;

use App\Models\ReconcileDetail;
use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReconcileExport implements FromView
{
    private $reconcile_data;

    public function __construct($reconcile_data)
    {
        $this->reconcile_data = $reconcile_data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $reconciles = $this->reconcile_data;

        return view('reports.reconcile.export', compact('reconciles'));
    }
}
