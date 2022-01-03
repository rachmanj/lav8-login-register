<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoktamdataController extends Controller
{
    public function doktam_invoices()
    {
        $date = '2021-01-01';

        $invoices = Invoice::with('doktams')
                    ->whereYear('receive_date', '>=', $date)
                    ->whereNull('mailroom_bpn_date')
                    ->where('inv_status', '!=', 'RETURN')
                    ->get();
        
        return datatables()->of($invoices)
            ->addColumn('project', function ($invoices) {
                return $invoices->project->project_code;
            })
            ->addColumn('vendor', function ($invoices) {
                return $invoices->vendor->vendor_name;
            })
            ->addColumn('amount', function ($invoices) {
                return number_format($invoices->inv_nominal, 0);
            })
            ->editColumn('inv_date', function ($invoices) {
                return date('d-M-Y', strtotime($invoices->inv_date));
            })
            ->addIndexColumn()
            ->addColumn('action', 'accounting.doktams.invoice_action')
            ->rawColumns(['action'])
            ->toJson();
    }

}
