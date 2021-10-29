<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;

class PaymentDetailController extends Controller
{
    public function create()
    {
        return view('payment_details.create');
    }

    public function add_tocart($inv_id)
    {
        $invoice = Invoice::find($inv_id);
        $payment_flag = 'PYMNT'. auth()->id();
        $invoice->sent_status = $payment_flag;
        $invoice->update();

        return redirect()->route('payment_details.create');
    }

    public function remove_fromcart($inv_id)
    {
        $invoice = Invoice::find($inv_id);
        $invoice->sent_status = null;
        $invoice->update();

        return redirect()->route('payment_details.create');
    }

    public function invoice_topay_data()
    {
        $date = '2020-01-01';

        if(auth()->user()->role === 'SUPERADMIN') {
            $invoices = Invoice::whereNotNull('mailroom_bpn_date')
                        ->where('inv_date', '>', $date)
                        ->where('inv_status', 'SAP')
                        ->whereNull('payment_date')
                        ->whereNull('sent_status')
                        ->orWhere('sent_status', 'SENT')
                        ->orderBy('inv_date', 'asc')
                        ->get();
        } else {
            if(auth()->user()->projects_id === Project::where('project_code', '000H')->first()->project_id) {
                $payment_place = 'BPN';
            } else {
                $payment_place = 'JKT';
            }
            $invoices = Invoice::whereNotNull('mailroom_bpn_date')
                        ->where('inv_date', '>', $date)
                        ->where('inv_status', 'SAP')
                        ->whereNull('payment_date')
                        ->whereNull('sent_status')
                        ->where('payment_place', $payment_place)
                        ->orderBy('inv_date', 'asc')
                        ->get();
        }

        return datatables()->of($invoices)
                ->editColumn('inv_date', function ($invoices) {
                    return date('d-M-Y', strtotime($invoices->inv_date));
                })
                ->editColumn('vendor', function ($invoices) {
                    return $invoices->vendor->vendor_name;
                })
                ->addColumn('nominal', function ($invoices) {
                    return number_format($invoices->inv_nominal, 0);
                })
                ->editColumn('project', function ($invoices) {
                    return $invoices->project->project_code;
                })
                ->addIndexColumn()
                ->addColumn('action', 'payment_details.add_tocart_action')
                ->rawColumns(['action'])
                ->toJson();

    }

    public function invoice_incart_data()
    {
        $payment_flag = 'PYMNT'. auth()->id();
        $invoices = Invoice::where('sent_status', $payment_flag)
                    ->orderBy('inv_date', 'asc')
                    ->get();

        return datatables()->of($invoices)
                ->editColumn('inv_date', function ($invoices) {
                    return date('d-M-Y', strtotime($invoices->inv_date));
                })
                ->editColumn('vendor', function ($invoices) {
                    return $invoices->vendor->vendor_name;
                })
                ->addColumn('nominal', function ($invoices) {
                    return number_format($invoices->inv_nominal, 0);
                })
                ->editColumn('project', function ($invoices) {
                    return $invoices->project->project_code;
                })
                ->addIndexColumn()
                ->addColumn('action', 'payment_details.remove_fromcart_action')
                ->rawColumns(['action'])
                ->toJson();
    }

}
