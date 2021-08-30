<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
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
}
