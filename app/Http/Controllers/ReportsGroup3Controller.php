<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use App\Models\Invoice;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class ReportsGroup3Controller extends Controller
{
    public function report10_index()
    {
        return view('reports.report10.index');
    }

    public function report10_display(Request $request)
    {
        $documents = Doktam::where('document_no', 'like', '%' . $request->document_no . '%')->get();
        // return $documents;
        // die;

        return view('reports.report10.display', compact('documents'));
    }

    public function report10_edit($id)
    {
        $document = Doktam::findOrFail($id);

        return view('reports.report10.edit', compact('document'));
    }

    public function report10_update(Request $request, $id)
    {
        //validasi
        $this->validate($request, [
            'file_upload' => 'required',
        ]);

        // $filename = $request->file('file_upload')->store('public/document_upload');

        // menangkap file yang diupload
        $file = $request->file('file_upload');


        // membuat nama file random dengan extension
        $nama_file = rand(). '_' . $file->getClientOriginalName();

        // upload ke folder file_upload
        // $file->move('document_upload', $nama_file);
        $file->move('public/document_upload', $nama_file);

        $document = Doktam::findOrFail($id);

        $document->filename = $nama_file;
        $document->save();

        return redirect()->route('reports.report10.index')->with('success', 'Document updated successfully');
    }

    public function report11_index()
    {
        return view('reports.report11.index');
    }

    public function report11_display(Request $request)
    {
        // if (! $request->invoice_no && $request->po_no)
        // {
        //     return redirect()->route('reports.report11.index')->with('error', 'Please fill at least one field');
        // }

        if($request->invoice_no){
            $invoices = Invoice::where('inv_no', 'like', '%' . $request->invoice_no . '%')->get();
        }

        if($request->po_no){
            $invoices = Invoice::where('po_no', 'like', '%' . $request->po_no . '%')->get();
        }

        // return $invoices;
        // die;

        return view('reports.report11.display', compact('invoices'));
    }

    public function report11_edit($id)
    {
        $invoice = Invoice::findOrFail($id);

        return view('reports.report11.edit', compact('invoice'));
    }

    public function report11_update(Request $request, $id)
    {
        //validasi
        $this->validate($request, [
            'file_upload' => 'required',
        ]);

        // $filename = $request->file('file_upload')->store('public/document_upload');

        // menangkap file yang diupload
        $file = $request->file('file_upload');


        // membuat nama file random dengan extension
        $nama_file = rand(). '_' . $file->getClientOriginalName();

        // upload ke folder file_upload
        $file->move('public/document_upload', $nama_file);

        $invoice = Invoice::findOrFail($id);

        $invoice->filename = $nama_file;
        $invoice->save();

        return redirect()->route('reports.report11.index')->with('success', 'Document updated successfully');
    }

}
