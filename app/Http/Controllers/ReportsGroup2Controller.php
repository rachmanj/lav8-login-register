<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReportsGroup2Controller extends Controller
{
    public function report7_index()
    {
        return view('reports.report7.index', [
            'nama_report' => 'Additional Docs (doktams table) Tanpa Nomor Invoice > 60 hari dan berstatus ACTIVE'
        ]);
    }

    public function report7_edit($id)
    {
        $doktam = Doktam::findOrFail($id);

        return view('reports.report7.edit', [
            'doktam' => $doktam,
        ]);
    }

    public function report7_update(Request $request, $id)
    {
        $doktam = Doktam::findOrFail($id);

        $doktam->update([
            'delete_reason' => $request->delete_reason,
        ]);

        $doktam->delete();

        return redirect()->route('reports.report7.index')->with('success', 'Record has been deleted');
    }

    public function report7_data()
    {
        $doktams = Doktam::whereNull('invoices_id')
            ->where('receive_date', '<', Carbon::now()->subDays(60))
            ->get();

        // return $doktams;
        return datatables()->of($doktams)
            ->editColumn('receive_date', function ($doktams) {
                return date('d-M-Y', strtotime($doktams->receive_date));
            })
            ->addColumn('doctype', function ($doktams) {
                return $doktams->doctype->docdesc;
            })
            ->addColumn('days', function ($doktams) {
                $date   = Carbon::parse($doktams->receive_date);
                $now    = Carbon::now();
                return $date->diffInDays($now);
            })
            ->addIndexColumn()
            ->addColumn('action', 'reports.report7.action')
            ->rawColumns(['action'])
            ->toJson();
        
    }

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
}
