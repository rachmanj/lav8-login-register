<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Addoc;
use App\Models\Doktam;
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
        $invoices = Invoice::where('flag', $payment_flag);
        $jumlah_invoices = $invoices->count();
        $nominal_invoices = $invoices->sum('inv_nominal');
        return view('payments.create', compact('jumlah_invoices', 'nominal_invoices'));
    }

    public function store(Request $request)
    {
        $payment_flag = 'PYMNT'. auth()->id();
        $invoices = Invoice::where('flag', $payment_flag);
        $invoices_total = $invoices->sum('inv_nominal');

        // create Payment record
        $payment = Payment::create([
            'date' => $request->date === null ? Carbon::now()->format('Y-m-d') : $request->date,
            'remarks' => $request->remarks,
            'invoices_total' => $invoices_total,
        ]);
     
        $invoice_list = $invoices->get();
        // get additional document records id of those invoices from Doktam
        $doktam_ids = array();
        foreach ($invoice_list as $invoice) {
            $additional_docs = Doktam::where('invoices_id', $invoice->inv_id)->whereNull('receive_date')->get();
            foreach ($additional_docs as $additional_doc) {
                array_push($doktam_ids, $additional_doc->id);
            }
        }

        // update receive_date those additional document records
        if (!empty($doktam_ids)) {
            foreach ($doktam_ids as $doktam_id) {
                Doktam::where('id', $doktam_id)->update([
                    'receive_date' => $payment->date
                ]);
            }
        }

        // get additional document records id of those invoices from Addoc
        $addoc_ids = array();
        foreach ($invoice_list as $invoice) {
            $additional_docs = Addoc::where('inv_id', $invoice->inv_id)->whereNull('docreceive')->get();
            foreach ($additional_docs as $additional_doc) {
                array_push($addoc_ids, $additional_doc->addoc_id);
            }
        }

        // update receive_date those additional document records
        if (!empty($addoc_ids)) {
            foreach ($addoc_ids as $addoc_id) {
                Addoc::where('addoc_id', $addoc_id)->update([
                    'docreceive' => $payment->date
                ]);
            }
        }

        // create payment details
        foreach ($invoice_list as $invoice) {
            PaymentDetail::create([
                'payment_id' => $payment->id,
                'invoice_id' => $invoice->inv_id
            ]);
        }

        // update invoice payment_date and flag to null 
        $invoices->update([
            'flag' => null,
            'payment_date' => $payment->date
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment successfullt added');
    }

    public function show($id)
    {
        $payment = Payment::with('payment_details.invoice')->find($id);
        // return $payment;
        // die;

        return view('payments.show', compact('payment'));
    }

    public function index_data()
    {
        if(auth()->user()->role == 'SUPERADMIN' || auth()->user()->role == 'ADMINACC') {
            $payments = Payment::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
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
