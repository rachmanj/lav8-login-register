<?php

namespace App\Http\Controllers;

use App\Models\Addoc;
use App\Models\Doctype;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function outdocs_index()
    {
        return view('accounting.pending_docs.index');
    }

    public function outsdocs000H()
    {
        return view('accounting.000H.index');
    }

    public function outsdocs001H()
    {
        return view('accounting.001H.index');
    }

    public function edit_addoc($id)
    {
        $addoc = Addoc::find($id);

        // return $addoc;
        return view('accounting.pending_docs.edit', compact('addoc'));
    }

    public function update_addoc(Request $request, $id)
    {
        $this->validate($request, [
            'docreceive' => 'required'
        ]);

        $addoc = Addoc::find($id);
        $addoc->docreceive = $request->docreceive;
        $addoc->update();

        return redirect()->route('accounting.outdocs_index')->with('status', 'Data updated successfully!!');
    }

    public function invoices()
    {
        return view('accounting.irr5_invoice.invoices_index');
    }

    public function add_addoc($inv_id)
    {
        $inv_id = $inv_id;
        $doctypes = Doctype::orderBy('docdesc', 'asc')->get();
        $invoice = Invoice::find($inv_id);
        // $addocs = Addoc::without(['invoice'])->where('inv_id', $id)->get();

        return view('accounting.irr5_invoice.add_addoc', compact('inv_id', 'invoice', 'doctypes'));
    }

    public function store_addoc(Request $request, $inv_id)
    {
        $addoc = new Addoc();
        $addoc->inv_id = $inv_id;
        $addoc->doctype = $request->doctype;
        $addoc->docnum = $request->docnum;
        $addoc->docreceive = $request->docreceive;
        $addoc->created_by = Auth()->user()->username;
        $addoc->save();

        return redirect()->route('accounting.add_addoc', $inv_id);

    }

    public function destroy_addoc($id)
    {
        $addoc = Addoc::find($id);
        $inv_id = $addoc->inv_id;

        $addoc->delete();
        return redirect()->route('accounting.add_addoc', $inv_id);
    }
}
