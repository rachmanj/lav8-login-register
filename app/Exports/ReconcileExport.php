<?php

namespace App\Exports;

use App\Models\ReconcileDetail;
use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReconcileExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $reconciles = ReconcileDetail::orderBy('created_at', 'desc')
            ->where('user_id', auth()->user()->id)
            ->get();

        foreach ($reconciles as $reconcile) {
            $invoice = Invoice::where('inv_no', 'LIKE', '%' . $reconcile->invoice_no . '%')->first();

            if ($invoice) {
                $reconcile['invoice_irr'] = $invoice->inv_no;
                $reconcile['vendor'] = $invoice->vendor->vendor_name;
                $reconcile['receive_date'] = $invoice->receive_date;
                $reconcile['amount'] = $invoice->inv_nominal;
                $reconcile['spi_no'] = $invoice->spis_id ? $invoice->spi->nomor : null;
                $reconcile['spi_date'] = $invoice->spis_id ? $invoice->spi->date : null;
            } else {
                $reconcile['invoice_irr'] = null;
                $reconcile['receive_date'] = null;
                $reconcile['amount'] = null;
                $reconcile['spi_no'] = null;
                $reconcile['spi_date'] = null;
            }
        };

        return view('reports.reconcile.export', compact('reconciles'));
    }
}
