<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\Spi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountingsentController extends Controller
{
    public function sent_index()
    {
        return view('accounting.sent_invoice.index');
    }

    public function tosent_index_data()
    {
        $date = Carbon::now();

        $invoices = Invoice::whereYear('receive_date', $date)
                    ->where('receive_place', 'BPN')
                    ->whereNull('mailroom_bpn_date')
                    ->where('inv_status', '!=', 'RETURN')
                    ->whereNull('sent_status')
                    ->get();
        
        return datatables()->of($invoices)
            ->addColumn('project', function ($invoices) {
                return $invoices->project->project_code;
            })
            ->addColumn('vendor', function ($invoices) {
                return $invoices->vendor->vendor_name;
            })
            ->editColumn('inv_date', function ($invoices) {
                return date('d-m-Y', strtotime($invoices->inv_date));
            })
            ->addIndexColumn()
            ->addColumn('action', 'accounting.sent_invoice.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function cart_index_data()
    {
        $date = Carbon::now();

        $invoices = Invoice::with('doktams')
                    ->whereYear('receive_date', $date)
                    ->where('sent_status', 'CART')
                    ->get();
        
        return datatables()->of($invoices)
            ->addColumn('project', function ($invoices) {
                return $invoices->project->project_code;
            })
            ->addColumn('vendor', function ($invoices) {
                return $invoices->vendor->vendor_name;
            })
            ->editColumn('inv_date', function ($invoices) {
                return date('d-m-Y', strtotime($invoices->inv_date));
            })
            ->addIndexColumn()
            ->addColumn('action', 'accounting.sent_invoice.cart_action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function add_tocart($id)
    {
        $invoice = Invoice::find($id);

        // return $invoice;
        $invoice->sent_status = 'CART';
        $invoice->update();

        return redirect()->route('sent_index');
    }

    public function remove_fromcart($id)
    {
        $invoice = Invoice::find($id);

        // return $invoice;
        $invoice->sent_status = null;
        $invoice->update();

        return redirect()->route('sent_index');
    }

    public function view_spi()
    {
        $invoices = Invoice::with('doktams')
                    ->where('sent_status', 'CART')
                    ->get();

        return view('accounting.sent_invoice.view_spi', compact('invoices'));
    }

    public function spi_pdf()
    {
        $invoices = Invoice::with('doktams')
                    ->where('sent_status', 'CART')
                    ->get();

        return view('accounting.sent_invoice.spi_pdf', compact('invoices'));
    }

    public function create_spi()
    {
        $projects = Project::orderBy('project_code', 'asc')->get();

        return view('accounting.sent_invoice.create_spi', compact('projects'));
    }

    public function store_spi(Request $request)
    {
        $data_tosave = $this->validate($request, [
            'nomor'             => ['required', 'unique:spis,nomor'],
            'date'              => ['required'],
            'to_projects_id'    => ['required'],
            'expedisi'          => '',
        ]);

        $savedSPI = Spi::create(array_merge($data_tosave, [
            'created_by'        => Auth()->user()->username
        ]));

        $spis_id    = $savedSPI->id;

        Invoice::where('sent_status', 'CART')->update([
            'spis_id' => $spis_id,
            'spi_jkt_date' => $request->date,
            'to_verify_date' => $request->date,
            'mailroom_bpn_date' => $request->date,
            'spi_id'    => $request->nomor,
            'spi_bpn_no' => $request->nomor,
        ]);

        Invoice::where('spis_id', $spis_id)->update(['sent_status'=>'SENT']);

        return redirect()->route('sent_index')->with('status', 'SPI successfully created!');
    }
}
