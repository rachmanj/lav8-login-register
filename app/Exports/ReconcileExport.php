<?php

namespace App\Exports;

use App\Models\ReconcileDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReconcileExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $reconciles = ReconcileDetail::where('user_id', auth()->user()->id)->get();

        return view('reports.reconcile.export', compact('reconciles'));
    }
}
