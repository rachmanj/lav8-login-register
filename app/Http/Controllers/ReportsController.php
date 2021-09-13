<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }
     
    public function report1() // 
    {
        $nama_report = 'List Additional Documents (tabel doktam) yg belum ada invoicenya / belum terhubung dgn invoice (tabel irr5_invoice).';
        return view('reports.report1', compact('nama_report'));
    }

    public function report1_data()
    {
        $doktams = Doktam::whereNull('invoices_id')->get();

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
            ->toJson();
        
    }

    public function report2()
    {
        $nama_report = 'List Invoice vs possibe doktams (doktams yg belum ada ivnoicesnya vs invoice dgn PO yg sama dgn PO di doktams).';
        return view('reports.report2', compact('nama_report'));
    }

    public function report2_data()
    {
        $invoices = Invoice::whereHas('doktams_by_po', function ($query) {
                    $query->whereNull('invoices_id');
                })
                ->with('doktams_by_po')
                ->whereYear('receive_date', '>=', Carbon::now())
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
                ->addColumn('action', 'reports.report2_action')
                ->rawColumns(['action'])
                ->toJson();
    }
}
