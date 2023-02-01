<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class WaitPaymentController extends Controller
{
    public function index()
    {
        return view('wait-payment.index');
    }

    public function send(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        // send to remote db
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://192.168.33.15/payreq-support/api/invoices', [
            'form_params' => [
                "nomor_invoice" => $invoice->inv_no,
                "invoice_irr_id" => $invoice->inv_id,
                "vendor_name" => $invoice->vendor->vendor_name,
                "received_date" => $invoice->receive_date,
                "amount" => $invoice->inv_nominal,
                "remarks" => $invoice->remarks,
            ]
        ]);

        // update invoice set senttoacc_id = 1
        $invoice->senttoacc_id = 1;
        $invoice->save();

        // return $response;
        // die;

        return redirect()->route('wait-payment.index')->with('success', 'Invoice berhasil dibayar');
    }

    public function data()
    {
        $date = '2022-01-01';
        $invoices = Invoice::where('receive_date', '>', $date)
            ->where('payment_place', 'BPN')
            ->whereNotNull('spi_bpn_date')
            ->whereNull('payment_date')
            ->whereNull('senttoacc_id')
            ->orderBy('receive_date', 'asc')
            ->get();

        return datatables()->of($invoices)
            ->editColumn('receive_date', function ($invoices) {
                return $invoices->receive_date ? date('d-M-Y', strtotime($invoices->receive_date)) : '-';
            })
            ->editColumn('inv_nominal', function ($invoices) {
                return number_format($invoices->inv_nominal, 2);
            })
            ->addColumn('vendor', function ($invoices) {
                return $invoices->vendor->vendor_name;
            })
            ->addColumn('days', function ($invoices) {
                $receive_date = new \DateTime($invoices->receive_date);
                $today = new \DateTime(now());
                $diff_days = $receive_date->diff($today)->format('%a');

                return $diff_days;
            })
            ->addIndexColumn()
            ->addColumn('action', 'wait-payment.action')
            ->rawColumns(['action'])
            ->toJson();
    }
}
