<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReportsGroup2Controller extends Controller
{
    // Report 8 is All invoice
    public function report8_index()
    {
        return view('reports.report8.index', [
            'nama_report' => 'All Invoices (limited to 3 years back)'
        ]);
    }

    public function report8_show($id)
    {
        $invoice = Invoice::find($id);

        return view('reports.report8.show', compact('invoice'));
    }

    public function report8_data()
    {
        $limit = Carbon::now()->subYears(3);
        $invoices = Invoice::with('project', 'vendor', 'vendorbranch')
                    ->where('receive_date', '>', $limit)
                    ->orderBy('receive_date', 'desc')
                    ->get();
        
        return datatables()->of($invoices)
            ->editColumn('receive_date', function ($invoices) {
                return date('d-M-Y', strtotime($invoices->receive_date));
            })
            ->editColumn('inv_date', function ($invoices) {
                return date('d-M-Y', strtotime($invoices->inv_date));
            })
            ->addColumn('vendor', function ($invoices) {
                return $invoices->vendor->vendor_name;
            })
            // ->addColumn('branch', function ($invoices) {
            //     return $invoices->vendor_branch ? $invoices->vendorbranch->branch : null;
            // })
            ->addColumn('project', function ($invoices) {
                return $invoices->project->project_code;
            })
            ->addColumn('amount', function ($invoices) {
                return number_format($invoices->inv_nominal, 0);
            })
            ->addIndexColumn()
            ->addColumn('action', 'reports.report8.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    // report 9
    public function report9_index()
    {
        return view('reports.report9.index', [
            'nama_report' => 'Invoice by Month of receive, order by Days of completion & status'
        ]);
    }

    public function report9_display(Request $request)
    {
        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);
        
        $invoices = Invoice::whereYear('receive_date', $year)
                    ->whereMonth('receive_date', $month)
                    ->where('receive_place', $request->receive_place)
                    ->select('inv_id', 'inv_no', 'inv_date', 'po_no', 'receive_date', 'inv_nominal', 'sent_status', 'vendor_id', 'inv_project', 'mailroom_bpn_date')
                    ->selectRaw('datediff(mailroom_bpn_date, receive_date) as days')
                    ->selectRaw('datediff(now(), receive_date) as days_out')
                    ->orderBy('days', 'desc')
                    ->get();

        return view('reports.report9.display', [
            'date' => $request->date,
            'report_name' => 'Invoice by Month of receive, Days of completion & status (receive at ' . $request->receive_place . ')',
            'receive_place' => $request->receive_place,
            'invoices' => $invoices,
        ]);
    }
    
}
