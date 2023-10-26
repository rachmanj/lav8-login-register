<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Doktam;
use App\Models\Addoc;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Report2Controller extends Controller
{
    public function index()
    {
        $nama_report = 'List Invoice vs possibe doktams (doktams yg belum ada ivnoicesnya vs invoice dgn PO yg sama dgn PO di doktams).';

        return view('reports.report2.index', compact('nama_report'));
    }

    public function show($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        $doktams = Doktam::where('doktams_po_no', $invoice->po_no)
                        ->whereNull('invoices_id')
                        ->get();

        return view('reports.report2.show', compact('invoice', 'doktams'));
    }

    public function addto_invoice(Request $request, $id)
    {
        $doktam = Doktam::find($id);
        $inv_id = $request->invoice_id;
        $doktam->invoices_id = $inv_id;
        $doktam->update();

        // update data di table irr5_addoc jika ada
        $irr5_addoc = Addoc::where('doktams_id', $id)->first();
        if($irr5_addoc) {
            $irr5_addoc->inv_id = $inv_id;
            $irr5_addoc->update();
        }

        return redirect()->route('reports.report2.show', $inv_id);
    }

    // edit / menghilangkan invoices_id 
    public function removefrom_invoice(Request $request, $id)
    {
        $doktam = Doktam::find($id);
        $inv_id = $request->invoice_id;
        $doktam->invoices_id = null;
        $doktam->update();

        return redirect()->route('reports.report2.show', $inv_id);
    }

    public function destroy(Request $request)
    {
        // Clone record to new table and delete record from old table
        Doktam::query()
            ->where('id', $request->doktam_id)
            ->each(function ($oldRecord) {
                $newRecord = $oldRecord->replicate();
                $newRecord->setTable('arsip_doktams');
                $newRecord->save();
                $oldRecord->delete();
        });

        return redirect()->route('reports.report2.show', $request->invoice_id);
    }

    public function data()
    {
        $invoices = Invoice::whereHas('doktams_by_po', function ($query) {
                    $query->whereNull('invoices_id');
                })
                ->with('doktams_by_po')
                ->whereYear('receive_date', '>=', '2021-01-01')
                ->get();

        return datatables()->of($invoices)
                ->editColumn('inv_date', function ($invoices) {
                    return date('d-M-Y', strtotime($invoices->inv_date));
                })
                ->addColumn('amount', function ($invoices) {
                    return number_format($invoices->inv_nominal, 0);
                })
                ->addColumn('vendor', function ($invoices) {
                    return $invoices->vendor->vendor_name;
                })
                ->addColumn('project', function ($invoices) {
                    return $invoices->project->project_code;
                })
                ->addColumn('days', function ($invoices) {
                    $date   = Carbon::parse($invoices->inv_date);
                    $now    = Carbon::now();
                    return $date->diffInDays($now);
                })
                ->addIndexColumn()
                ->addColumn('action', 'reports.report2.action')
                ->rawColumns(['action'])
                ->toJson();
    }
}
