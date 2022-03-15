<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ReportsGroup4Controller extends Controller
{
    public function report12_index()
    {
        return view('reports.report12.index');
    }

    public function report12_index_data()
    {
        
        $date = '2016-01-01';

        $invoices = Invoice::with('vendor')->whereYear('receive_date', '>=', $date)
                ->whereNotNull('filename')
                ->orderBy('receive_date', 'desc')
                ->get();

        return datatables()->of($invoices)
                ->addColumn('vendor', function ($invoices) {
                    return $invoices->vendor->vendor_name;
                })
                ->addColumn('project', function ($invoices) {
                    return $invoices->project->project_code;
                })
                ->editColumn('inv_date', function ($invoices) {
                    return date('d-M-Y', strtotime($invoices->inv_date));
                })
                ->addColumn('amount', function($invoices) {
                    return number_format($invoices->inv_nominal, 0);
                })
                ->addIndexColumn()
                ->addColumn('action', 'reports.report12.action')
                ->rawColumns(['action'])
                ->toJson();
    }

    public function report12_edit($id)
    {
        $invoice = Invoice::findOrFail($id);

        return view('reports.report12.edit', compact('invoice'));
    }

    public function report12_update(Request $request, $id)
    {
        //validasi
        $this->validate($request, [
            'file_upload' => 'required',
        ]);

        // menangkap file yang diupload
        $file = $request->file('file_upload');

        // membuat nama file random dengan extension
        $nama_file = rand(). '_' . $file->getClientOriginalName();

        // upload ke folder file_upload
        $file->move('public/document_upload', $nama_file);

        $invoice = Invoice::findOrFail($id);

        $invoice->filename = $nama_file;
        $invoice->save();

        return redirect()->route('reports.report12.index')->with('success', 'Document updated successfully');
    }

    public function report12_nodocs_index()
    {
        return view('reports.report12.index_nodocs');
    }

    public function report12_index_nodocs_data()
    {
        
        $date = '2020-01-01';

        $invoices = Invoice::with('vendor')->whereYear('receive_date', '>=', $date)
                ->whereNull('filename')
                ->orderBy('receive_date', 'asc')
                ->get();

        return datatables()->of($invoices)
                ->addColumn('vendor', function ($invoices) {
                    return $invoices->vendor->vendor_name;
                })
                ->addColumn('project', function ($invoices) {
                    return $invoices->project->project_code;
                })
                ->editColumn('inv_date', function ($invoices) {
                    return date('d-M-Y', strtotime($invoices->inv_date));
                })
                ->addColumn('amount', function($invoices) {
                    return number_format($invoices->inv_nominal, 0);
                })
                ->addIndexColumn()
                ->addColumn('action', 'reports.report12.action')
                ->rawColumns(['action'])
                ->toJson();
    }
}
