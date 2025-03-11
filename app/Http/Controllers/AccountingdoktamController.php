<?php

namespace App\Http\Controllers;

use App\Models\Addoc;
use App\Models\Doctype;
use App\Models\Doktam;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AccountingdoktamController extends Controller
{
    public function invoices_index()
    {
        // Get data needed for filters
        $projects = \App\Models\Project::select('project_id', 'project_code')
            ->orderBy('project_code')
            ->get();

        $vendors = \App\Models\Vendor::select('vendor_id', 'vendor_name')
            ->orderBy('vendor_name')
            ->get();

        return view('accounting.doktams.index', compact('projects', 'vendors'));
    }

    public function invoices_show($inv_id)
    {
        $invoice = Invoice::with('doktams')->find($inv_id);
        $doctypes = Doctype::orderBy('docdesc', 'asc')->get();

        // return $invoice;
        return view('accounting.doktams.show_invoice', compact('invoice', 'doctypes'));
    }

    public function doktam_add(Request $request, $inv_id)
    {
        $data_tosave = $this->validate($request, [
            'document_no'   => ['required', 'unique:doktams,document_no'],
            'doctypes_id'   => 'required'
        ]);

        $saved_doktam = Doktam::create(array_merge($data_tosave, [
            'receive_date' => $request->receive_date,
            'invoices_id' => $inv_id,
            'created_by' => Auth()->user()->username,
        ]));

        $doktams_id = $saved_doktam->id;

        //save to irr5_addoc table
        $addoc = new Addoc();
        $addoc->docnum = $request->document_no;
        $addoc->doctype = $request->doctypes_id;
        $addoc->docreceive = $request->receive_date;
        $addoc->inv_id = $inv_id;
        $addoc->doktams_id = $doktams_id;
        $addoc->created_by = Auth()->user()->username;
        $addoc->save();

        // dd($doktam);

        return redirect()->route('accounting.doktam_invoices.show', $inv_id)->with('status', 'New additional document added!');
    }

    public function doktam_delete($id)
    {
        $doktam = Doktam::find($id);
        $inv_id = $doktam->invoices_id;
        $irr5_addoc = Addoc::where('doktams_id', $id)->first();

        $doktam->forceDelete(); //permanently delete doktam
        $irr5_addoc->delete();

        return redirect()->route('accounting.doktam_invoices.show', $inv_id)->with('status', 'Aadditional document deleted!');
    }

    public function edit_doktam($id)
    {
        $doktam = Doktam::find($id);
        $doctypes = Doctype::orderBy('docdesc', 'asc')->get();

        return view('accounting.doktams.edit', compact('doktam', 'doctypes'));
    }

    public function update_doktam($id)
    {
        $doktam = Doktam::find($id);
        $inv_id = $doktam->invoices_id;
        $irr5_addoc = Addoc::where('doktams_id', $id)->first();

        $doktam->receive_date = request()->receive_date;
        $doktam->update();

        $irr5_addoc->docreceive = request()->receive_date;
        $irr5_addoc->update();

        return redirect()->route('accounting.doktam_invoices.show', $inv_id)->with('status', 'Additional document updated!');
    }
}
