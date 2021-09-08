<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index');
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);

        return view('invoices.show', compact('invoice'));
    }
}
