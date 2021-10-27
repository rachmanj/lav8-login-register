<?php

namespace App\Http\Controllers;

use App\Models\Addoc;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function index011()
    {
        $project = '011C';
        $outsdocs = $this->outsdocs()->where('project', $project);

        return datatables()->of($outsdocs)
            ->editColumn('inv_date', function ($outsdocs) {
                return date('d-M-Y', strtotime($outsdocs->inv_date));
            })
            ->addIndexColumn()
            ->addColumn('action', 'outsdocs.011C.action')
            ->rawColumns(['action'])
            ->toJson();
    }
    
    public function index017()
    {
        $project = '017C';
        $outsdocs = $this->outsdocs()->where('project', $project);

        return datatables()->of($outsdocs)
            ->editColumn('inv_date', function ($outsdocs) {
                return date('d-M-Y', strtotime($outsdocs->inv_date));
            })
            ->addIndexColumn()
            ->addColumn('action', 'outsdocs.017C.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function indexAPS()
    {
        $project = 'APS';
        $outsdocs = $this->outsdocs()->where('project', $project);

        return datatables()->of($outsdocs)
            ->editColumn('inv_date', function ($outsdocs) {
                return date('d-M-Y', strtotime($outsdocs->inv_date));
            })
            ->addIndexColumn()
            ->addColumn('action', 'outsdocs.APS.action')
            ->rawColumns(['action'])
            ->toJson();
    }
    
    public function index000H()
    {
        $project = '000H';
        $outsdocs = $this->outsdocs()->where('project', $project);

        return datatables()->of($outsdocs)
            ->editColumn('inv_date', function ($outsdocs) {
                return date('d-M-Y', strtotime($outsdocs->inv_date));
            })
            ->addIndexColumn()
            ->addColumn('action', 'outsdocs.APS.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function index001H()
    {
        $project = '001H';
        $outsdocs = $this->outsdocs()->where('project', $project);

        return datatables()->of($outsdocs)
            ->editColumn('inv_date', function ($outsdocs) {
                return date('d-M-Y', strtotime($outsdocs->inv_date));
            })
            ->addIndexColumn()
            ->addColumn('action', 'outsdocs.APS.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function accountingIndex()
    {
        $outsdocs = $this->outsdocs();

        return datatables()->of($outsdocs)
            ->editColumn('inv_date', function ($outsdocs) {
                return date('d-M-Y', strtotime($outsdocs->inv_date));
            })
            ->addIndexColumn()
            ->addColumn('action', 'accounting.pending_docs.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function accountingInvoices()
    {
        $date = Carbon::now();

        $invoices = Invoice::whereYear('receive_date', $date)
                    ->where('receive_place', 'BPN')
                    ->whereNull('mailroom_bpn_date')
                    ->where('inv_status', '!=', 'RETURN')
                    // ->limit(40)
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
            ->addIndexColumn()
            ->addColumn('action', 'accounting.irr5_invoice.invoice_action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function outsdocs()
    {
        $date = Carbon::now();

        $list = DB::table('irr5_addoc')
                ->join('irr5_invoice', 'irr5_addoc.inv_id', '=', 'irr5_invoice.inv_id')
                ->join('irr5_doctype', 'irr5_addoc.doctype', '=', 'irr5_doctype.doctype_id')
                ->join('irr5_project', 'irr5_invoice.inv_project', '=', 'irr5_project.project_id')
                ->join('irr5_vendor', 'irr5_invoice.vendor_id', '=', 'irr5_vendor.vendor_id')
                ->select(
                    'irr5_addoc.addoc_id',
                    'irr5_addoc.docnum',
                    'irr5_doctype.docdesc as doctype',
                    'irr5_invoice.inv_no',
                    'irr5_invoice.inv_id',
                    'irr5_invoice.po_no',
                    'irr5_vendor.vendor_name as vendor',
                    'irr5_invoice.receive_date as inv_date', 
                    'irr5_project.project_code as project',
                    DB::raw("datediff(curdate(), irr5_invoice.receive_date) as days")
                )
                ->whereNull('docreceive')
                ->whereYear('inv_date', $date)
                // ->orderBy('doctype', 'asc')
                ->orderBy('days', 'desc')
                ->orderBy('project', 'asc')
                ->get();
                
 
                return $list;
    }

    public function addocsByInvoice($inv_id)
    {
        $addocs = Addoc::without('invoice')->where('inv_id', $inv_id)->get();

        return datatables()->of($addocs)
            ->editColumn('doctype', function ($addocs) {
                return $addocs->addoctype->docdesc;
            })
            ->editColumn('docreceive', function ($addocs) {
                if($addocs->docreceive) {
                    return date('d-M-Y', strtotime($addocs->docreceive));
                }
                return null;
            })
            ->addIndexColumn()
            ->addColumn('action', 'accounting.invoice_addoc_action')
            ->rawColumns(['action'])
            ->toJson();
    }
}
