<?php

namespace App\Http\Controllers;

use App\Models\Doctype;
use App\Models\Doktam;
use App\Models\Invoice;
use App\Models\Recaddoc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                ->addColumn('action', 'reports.report2_action')
                ->rawColumns(['action'])
                ->toJson();
    }

    public function report3()
    {
        $nama_report = 'Cek Additional Docs di table irr5_rec_addoc, dan jika ada dicopy ke table doktams.';
        return view('reports.report3', compact('nama_report'));
    }

    public function report3_data()
    {
        $date = '2021-01-01';
       
        $list = DB::table('irr5_rec_addoc')
                ->join('irr5_doctype', 'irr5_rec_addoc.doctype', '=', 'irr5_doctype.doctype_id')
                ->select(
                    'irr5_rec_addoc.recaddoc_id',
                    'irr5_doctype.docdesc as typedoc',
                    'irr5_rec_addoc.addoc_no',
                    'irr5_rec_addoc.addoc_date',
                    'irr5_rec_addoc.addoc_recdate',
                    'irr5_rec_addoc.po_no',
                )
                ->whereYear('addoc_recdate', '>=', $date)
                ->where('copied', 0)
                ->orderby('addoc_recdate', 'desc')
                ->get();

        return datatables()->of($list)
                ->addColumn('receive_date', function ($list) {
                    return date('d-M-Y', strtotime($list->addoc_recdate));
                })
                ->addColumn('days', function ($list) {
                    $date   = Carbon::parse($list->addoc_recdate);
                    $now    = Carbon::now();
                    return $date->diffInDays($now);
                })
                ->addIndexColumn()
                ->addColumn('action', 'reports.report3_action')
                ->rawColumns(['action'])
                ->toJson();
    }

    public function report4()
    {
        $nama_report = 'Invoice dgn Additional Documents lengkap, namun belum di-SPI-kan.';
        return view('reports.report4', compact('nama_report'));
    }

    public function report4_data()
    {
            $invoices = Invoice::with('doktams_null')
                        ->withCount('doktams_null')
                        ->having('doktams_null_count', '=', 0)
                        ->with('doktams')
                        ->whereYear('receive_date', '>=', '2021-01-01')
                        ->where('inv_status', '!=', 'RETURN')
                        ->whereNull('mailroom_bpn_date')
                        ->whereNull('sent_status')
                        ->where('receive_place', 'BPN')
                        ->orderby('inv_date', 'asc')
                        ->get();

        return datatables()->of($invoices)
                ->editColumn('inv_date', function ($list) {
                    return date('d-M-Y', strtotime($list->inv_date));
                })
                ->addColumn('amount', function ($list) {
                    return number_format($list->inv_nominal, 0);
                })
                ->addColumn('days', function ($list) {
                    $date   = Carbon::parse($list->inv_date);
                    $now    = Carbon::now();
                    return $date->diffInDays($now);
                })
                ->addColumn('vendor', function ($list) {
                    return $list->vendor->vendor_name;
                })
                ->addColumn('project', function ($list) {
                    return $list->project->project_code;
                })
                // ->addColumn('action', 'reports.report4_action')
                ->addIndexColumn()
                ->toJson();
    }

    public function report5()
    {
        $nama_report = 'ITO tanpa nomor PO';
        return view('reports.report5.index', compact('nama_report'));
    }

    public function report5_edit($id)
    {
        $ito = Doktam::with('doctype')->find($id);
        return view('reports.report5.edit', compact('ito'));
    }

    public function report5_update(Request $request, $id)
    {
        $ito = Doktam::find($id);
        $ito->update([
            'doktams_po_no' => $request->doktams_po_no
        ]);
        return redirect()->route('reports.report5')->with('success', 'Document successfully updated');
    }

    public function report5_data()
    {
        $ito_type = Doctype::where('docdesc', 'ITO')->first()->doctype_id;
        $itos = Doktam::without('invoice', 'doctype')
                    ->whereNull('invoices_id')    //
                    ->whereNull('doktams_po_no')    //
                    ->where('doctypes_id', $ito_type)->get();

        return datatables()->of($itos)
                ->editColumn('receive_date', function ($itos) {
                    if($itos->receive_date) {
                        return date('d-M-Y', strtotime($itos->receive_date));
                    } else {
                        return null;
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', 'reports.report5.action')
                ->rawColumns(['action'])
                ->toJson();
    }
}
