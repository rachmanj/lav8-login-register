<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\Spi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountinglpdController extends Controller
{
    public function index()
    {
        return view('accounting.lpds.index');
    }

    public function create()
    {
        $projects = Project::orderBy('project_code', 'asc')->get();

        return view('accounting.lpds.create', compact('projects'));
    }

    public function invoice_cart()
    {
        return view('accounting.lpds.cart');
    }

    public function addto_cart($inv_id)
    {
        $invoice = Invoice::find($inv_id);
        $cart_flag = 'LPDCART' . auth()->id();
        // return $invoice;
        $invoice->sent_status = $cart_flag;
        $invoice->update();

        return redirect()->route('accounting.lpd.invoice_cart');
    }

    public function removefrom_cart($inv_id)
    {
        $invoice = Invoice::find($inv_id);

        // return $invoice;
        $invoice->sent_status = null;
        $invoice->update();

        return redirect()->route('accounting.lpd.invoice_cart');
    }

    public function view_cart_detail()
    {
        $cart_flag = 'LPDCART' . auth()->id();
        $invoices = Invoice::with('doktams')
                    ->where('sent_status', $cart_flag)
                    ->get();

        return view('accounting.lpds.view_cart_detail', compact('invoices'));
    }

    public function store(Request $request)
    {
        $data_tosave = $this->validate($request, [
            'nomor'             => ['required', 'unique:spis,nomor'],
            'date'              => ['required'],
            'to_projects_id'    => ['required'],
        ]);

        $savedLPD = Spi::create(array_merge($data_tosave, [
            'expedisi'          => $request->expedisi,
            'to_person'         => $request->to_person,
            'docsend_type'      => 'LPD',
            'created_by'        => Auth()->user()->username
        ]));

        $spis_id    = $savedLPD->id;
        $cart_flag = 'LPDCART' . auth()->id();

        if($request->to_projects_id == 6) {
            Invoice::where('sent_status', $cart_flag)->update([
                'spis_id' => $spis_id,
                'spi_jkt_date' => $request->date,
                'to_verify_date' => $request->date,
                'mailroom_bpn_date' => $request->date,
                'spi_id'    => $request->nomor,
                'inv_status' => 'SAP'
            ]);
        } else {
            Invoice::where('sent_status', $cart_flag)->update([
                'spis_id' => $spis_id,
                'to_verify_date' => $request->date,
                'mailroom_bpn_date' => $request->date,
                'spi_bpn_no' => $request->nomor,
                'inv_status' => 'SAP'
            ]);
        }

        Invoice::where('spis_id', $spis_id)->update(['sent_status'=>'SENT']);

        return redirect()->route('accounting.lpd.index')->with('status', 'LPD successfully created!');
    }

    public function lpd_detail($id)
    {
        $lpd = Spi::with('invoices.doktams')->find($id);
        
        // return $spi;
        return view('accounting.lpds.lpd_detail', compact('lpd'));
    }

    public function lpd_view_pdf($id)
    {
        $lpd = Spi::with('invoices.doktams')->find($id);

        return view('accounting.lpds.lpd_view_pdf', compact('lpd'));
    }

    public function index_data()
    {
        $lpds = Spi::where('docsend_type','LPD')
                ->orderBy('date', 'desc')
                ->orderBy('nomor', 'desc')
                ->get();

        return datatables()->of($lpds)
                ->editColumn('date', function ($lpds) {
                    return date('d-M-Y', strtotime($lpds->date));
                })
                ->addColumn('to_project', function ($lpds) {
                    return $lpds->to_project->project_code;
                })
                ->addIndexColumn()
                ->addColumn('action', 'accounting.lpds.index_action')
                ->rawColumns(['action'])
                ->toJson();
                    
    }

    public function tosend_data()
    {
        $date = '2021-01-01';

        $invoices = Invoice::whereYear('receive_date', '>=', $date)
                    ->where('receive_place', 'JKT')
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
            ->addIndexColumn()
            ->addColumn('action', 'accounting.lpds.addtocart_action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function incart_data()
    {
        $cart_flag = 'LPDCART' . auth()->id();

        $invoices = Invoice::where('sent_status', $cart_flag)
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
            ->addIndexColumn()
            ->addColumn('action', 'accounting.lpds.removefromcart_action')
            ->rawColumns(['action'])
            ->toJson();
    }
}
