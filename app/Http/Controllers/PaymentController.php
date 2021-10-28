<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payments.index');
    }

    public function create()
    {
        $payment_flag = 'PYMNT'. auth()->id();
        $invoices = Invoice::where('sent_status', $payment_flag);
        $jumlah_invoices = $invoices->count();
        $nominal_invoices = $invoices->sum('inv_nominal');
        return view('payments.create', compact('jumlah_invoices', 'nominal_invoices'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required'
        ]);

        $payment_flag = 'PYMNT'. auth()->id();
        $invoices = Invoice::where('sent_status', $payment_flag);
        $invoices_total = $invoices->sum('inv_nominal');

        $payment = Payment::create([
            'date' => $request->date,
            'remarks' => $request->remarks,
            'invoices_total' => $invoices_total
        ]);

        $invoice_list = $invoices->get();
        foreach ($invoice_list as $invoice) {
            PaymentDetail::create([
                'payment_id' => $payment->id,
                'invoice_id' => $invoice->inv_id
            ]);
        }

        $invoices->update([
            'sent_status' => null,
            'payment_date' => $payment->date
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment successfullt added');
    }

    public function show($id)
    {
        $payment = Payment::with('payment_details.invoice')->find($id);
        return $payment;
    }

    public function index_data()
    {
        if(auth()->user()->role == 'SUPERADMIN') {
            $payments = Payment::orderBy('date', 'desc')->get();
        } else {
            $payments = Payment::where('created_by', auth()->user()->id)->orderBy('date', 'desc')->get();
        }

        return datatables()->of($payments)
                ->addColumn('creator', function ($payments) {
                    return $payments->creator->username;
                })
                ->editColumn('date', function ($payments) {
                    // $date   = Carbon::parse($payments->date);
                    // return $date->diffForHumans();
                    return date('d-M-Y', strtotime($payments->date));
                })
                ->addColumn('count_inv', function ($payments) {
                    return PaymentDetail::where('payment_id', $payments->id)->count();
                })
                ->editColumn('invoices_total', function ($payments) {
                    return number_format($payments->invoices_total, 0);
                })
                ->addIndexColumn()
                ->addColumn('action', 'payments.action')
                ->rawColumns(['action'])
                ->toJson();
    }
}
