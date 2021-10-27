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
        $date = '2021-01-01';

        $invoices = Invoice::whereYear('receive_date', '>=', $date)
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
                return date('d-M-Y', strtotime($invoices->inv_date));
            })
            ->addColumn('days', function ($list) {
                $date   = Carbon::parse($list->inv_date);
                $now    = Carbon::now();
                return $date->diffInDays($now);
            })
            ->addIndexColumn()
            ->addColumn('action', 'accounting.sent_invoice.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function cart_index_data()
    {
        $date = '2021-01-01';

        $invoices = Invoice::with('doktams')
                    // ->whereYear('receive_date', '>=', $date)
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
                return date('d-M-Y', strtotime($invoices->inv_date));
            })
            ->addColumn('days', function ($list) {
                $date   = Carbon::parse($list->inv_date);
                $now    = Carbon::now();
                return $date->diffInDays($now);
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
        ]);

        $savedSPI = Spi::create(array_merge($data_tosave, [
            'expedisi'          => $request->expedisi,
            'to_person'         => $request->to_person,
            'docsend_type'      => 'SPI',
            'created_by'        => Auth()->user()->username
        ]));

        $spis_id    = $savedSPI->id;

        if($request->to_projects_id == 6) {
            Invoice::where('sent_status', 'CART')->update([
                'spis_id' => $spis_id,
                'spi_jkt_date' => $request->date,
                'to_verify_date' => $request->date,
                'mailroom_bpn_date' => $request->date,
                'spi_id'    => $request->nomor,
                'inv_status' => 'SAP'
            ]);
        } else {
            Invoice::where('sent_status', 'CART')->update([
                'spis_id' => $spis_id,
                'to_verify_date' => $request->date,
                'mailroom_bpn_date' => $request->date,
                'spi_bpn_no' => $request->nomor,
                'inv_status' => 'SAP'
            ]);
        }
        

        Invoice::where('spis_id', $spis_id)->update(['sent_status'=>'SENT']);

        return redirect()->route('sent_index')->with('status', 'SPI successfully created!');
    }
}
