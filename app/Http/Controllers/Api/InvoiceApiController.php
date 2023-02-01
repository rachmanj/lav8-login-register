<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceApiController extends Controller
{
    public function test(Request $request)
    {
        return response()->json([
            'message' => 'Invoice berhasil dibayar',
        ], 200);
    }

    public function show($id)
    {
        $invoice = Invoice::where('inv_id', $id)->first();

        return response()->json([
            'message' => 'Invoice berhasil dikirim ke Cashier',
            'data' => $invoice,
        ], 200);
    }


    // update invoice
    public function update(Request $request, $id)
    {
        $invoice = Invoice::where('inv_id', $id)->first();

        if (!$invoice) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $invoice->payment_date = $request->payment_date;
        $invoice->save();

        return response()->json([
            'message' => 'Invoice berhasil diupdate',
        ], 200);
    }
}
