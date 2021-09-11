<?php

namespace App\Http\Controllers;

use App\Models\Addoc;
use App\Models\Doktam;
use App\Models\Invoice;
use App\Models\Invoicetype;
use App\Models\Project;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Psy\Command\EditCommand;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index');
    }

    public function create()
    {
        $vendors    = Vendor::orderBy('vendor_name', 'asc')->get();
        $categories = Invoicetype::orderBy('invtype_name', 'asc')->get();
        $projects   = Project::orderBy('project_code', 'asc')->get();

        return view('invoices.create', compact('vendors', 'categories', 'projects'));
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);

        return view('invoices.show', compact('invoice'));
    }

    public function index_data()
    {
        $date = Carbon::now();

        $invoices = Invoice::with('vendor')->whereYear('receive_date', '>=', $date)
            ->whereIn('inv_status', ['PENDING', 'SAP'])
            ->whereNull('mailroom_bpn_date')
            ->latest()
            ->get();

        // return $invoices;
        return datatables()->of($invoices)
                ->addColumn('vendor', function ($invoices) {
                    return $invoices->vendor->vendor_name;
                })
                ->addColumn('project', function ($invoices) {
                    return $invoices->project->project_code;
                })
                ->editColumn('inv_date', function ($invoices) {
                    return date('d-M-Y', strtotime($invoices->inv_date));
                })
                ->addColumn('amount', function($invoices) {
                    return number_format($invoices->inv_nominal, 0);
                })
                ->addIndexColumn()
                ->addColumn('action', 'invoices.index_action')
                ->rawColumns(['action'])
                ->toJson();

    }

    public function test()
    {

    }

    public function store(Request $request)
    {
        $data_tosave = $this->validate($request, [
            'vendor_id'         => ['required'],
            'vendor_branch'     => ['required'],
            'payment_place'     => ['required'],
            'inv_no'            => ['required'],
            'inv_date'          => ['required'],
            'receive_date'      => ['required'],
            'inv_type'          => ['required'],
            'inv_project'       => ['required'],
            'receive_place'     => ['required'],
            'inv_currency'      => ['required'],
            'inv_nominal'       => ['required'],
        ]);

        Invoice::create(array_merge($data_tosave, [
            'po_no'             => $request->po_no,
            'remarks'           => $request->remarks,
            'inv_status'        => 'PENDING',
            'creator'           => Auth()->user()->username,
        ]));

        return redirect()->route('invoices.index')->with('success', 'Invoice successfully added!');
    }

    public function edit($id)
    {
        $invoice    = Invoice::find($id);
        $vendors    = Vendor::orderBy('vendor_name', 'asc')->get();
        $categories = Invoicetype::orderBy('invtype_name', 'asc')->get();
        $projects   = Project::orderBy('project_code', 'asc')->get();

        return view('invoices.edit', compact('invoice', 'vendors', 'categories', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $data_tosave = $this->validate($request, [
            'vendor_id'         => ['required'],
            'vendor_branch'     => ['required'],
            'payment_place'     => ['required'],
            'inv_no'            => ['required'],
            'inv_date'          => ['required'],
            'receive_date'      => ['required'],
            'inv_type'          => ['required'],
            'inv_project'       => ['required'],
            'receive_place'     => ['required'],
            'inv_currency'      => ['required'],
            'inv_nominal'       => ['required'],
        ]);

        $invoice = Invoice::find($id);

        $invoice->update(array_merge($data_tosave, [
            'po_no'             => $request->po_no,
            'remarks'           => $request->remarks,
            'inv_status'        => $request->inv_status,
        ]));

        return redirect()->route('invoices.index')->with('success', 'Invoice successfully updated!');
    }

    public function add_doktams($inv_id)
    {
        $invoice = Invoice::find($inv_id);
        $doktams = Doktam::where('po_no', $invoice->po_no)
                        ->whereNull('invoices_id')
                        ->get();

        return view('invoices.add_doktams', compact('invoice', 'doktams'));
    }

    
    // mengupdate field invoices_id 
    public function addto_invoice(Request $request, $id)
    {
        $doktam = Doktam::find($id);
        $inv_id = $request->invoices_id;
        $doktam->invoices_id = $inv_id;
        $doktam->update();

        // update data di table irr5_addoc jika ada
        $irr5_addoc = Addoc::where('doktams_id', $id)->first();
        if($irr5_addoc) {
            $irr5_addoc->inv_id = $inv_id;
            $irr5_addoc->update();
        }

        return redirect()->route('invoices.add_doktams', $inv_id);
    }

    // edit / menghilangkan invoices_id 
    public function removefrom_invoice(Request $request, $id)
    {
        $doktam = Doktam::find($id);
        $inv_id = $request->invoices_id;
        $doktam->invoices_id = null;
        $doktam->update();

        return redirect()->route('invoices.add_doktams', $inv_id);
    }

    /* public function possible_doktams_data($inv_id)
    {
        $invoice = Invoice::find($inv_id);
        $po_no = $invoice->po_no;

        $doktams = Doktam::where('po_no', $po_no)
                    ->whereNull('invoices_id')
                    ->get();

        // return $doktams;
        return datatables()->of($doktams)
            ->editColumn('receive_date', function ($doktams) {
                return date('d-M-Y', strtotime($doktams->receive_date));
            })
            ->editColumn('doctype', function($doktams) {
                return $doktams->doctype->docdesc;
            })
            ->addIndexColumn()
            ->addColumn('action', 'invoices.add_doktam_action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function doktams_of_invoice_data($inv_id)
    {
        $doktams = Doktam::where('invoices_id', $inv_id)->get();

        return datatables()->of($doktams)
                ->editColumn('receive_date', function ($doktams) {
                    return date('d-M-Y', strtotime($doktams->receive_date));
                })
                ->editColumn('doctype', function($doktams) {
                    return $doktams->doctype->docdesc;
                })
                ->addIndexColumn()
                ->addColumn('action', 'invoices.remove_doktam_action')
                ->rawColumns(['action'])
                ->toJson();
    } */
}
