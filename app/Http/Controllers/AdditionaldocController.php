<?php

namespace App\Http\Controllers;

use App\Models\Addoc;
use App\Models\Doctype;
use App\Models\Doktam;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdditionaldocController extends Controller
{
    public function index()
    {
        return view('additionaldocs.index');
    }

    public function search_index()
    {
        $document_types = Doctype::orderBy('docdesc', 'asc')->get();

        return view('additionaldocs.search', compact('document_types'));
    }

    public function search_result(Request $request)
    {
        // return $request;
        if ($request->document_no === null && $request->invoice_no === null && $request->po_no === null) {
            return redirect()->back()->with('danger', 'Please fill at least one field');
        }

        $query = Doktam::get();

        if ($request->invoice_no) {
            $invoice_id = Invoice::where('inv_no', 'LIKE', '%' . $request->invoice_no . '%')->first()->inv_id;
            $query = Doktam::where('invoices_id', $invoice_id);
        }

        if ($request->po_no) {
            $query = Doktam::where('doktams_po_no', 'LIKE', '%' . $request->po_no . '%');
        }

        if ($request->document_no) {
            $query = Doktam::where('document_no', 'LIKE', '%' . $request->document_no . '%');
        }

        $doktams = $query->get();

        // return $doktams;
        return view('additionaldocs.search_result', compact('doktams'));
        
    }

    public function index_data()
    {
        // $date = Carbon::now();
        $date = '2021-01-01';

        $doktams = Doktam::with(['invoice'])->whereYear('created_at', '>=', $date)
                    ->whereNull('receive_date')
                    ->whereDoesntHave('spi')
                    ->latest()
                    ->get();

        return datatables()->of($doktams)
            // ->editColumn('receive_date', function ($doktams) {
            //     if(!$doktams->receive_date) {
            //         return 'null';
            //     } else {
            //         return date('d-M-Y', strtotime($doktams->receive_date));
            //     }
            // })
            ->addColumn('invoice', function ($doktams) {
                if(!$doktams->invoice) {
                    return '-';
                } else {
                    return $doktams->invoice->inv_no;
                }
            })
            ->addColumn('doctype', function ($doktams) {
                return $doktams->doctype->docdesc;
            })
            ->addColumn('vendor', function ($doktams) {
                if(!$doktams->invoice) {
                    return '-';
                } else {
                    return $doktams->invoice->vendor->vendor_name;
                }
            })
            // ->addColumn('spi', function ($doktams) {
            //     if($doktams->spi) {
            //         return $doktams->spi->nomor;
            //     } else {
            //         return null;
            //     }
            // })
            ->addColumn('action', 'additionaldocs.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        $doctypes = Doctype::orderBy('docdesc', 'asc')->get();

        return view('additionaldocs.create', compact('doctypes'));
    }

    public function store(Request $request)
    {
        if ($request->doctypes_id == 9) {    // jika doctype == ITO
            $data_tosave = $this->validate($request, [
                'document_no'   => ['required','unique:doktams'],
                'doctypes_id'   => ['required'],
                'receive_date'  => ['required'],
            ]);
        } else {
            $data_tosave = $this->validate($request, [
                'document_no'   => ['required'],
                'doctypes_id'   => ['required'],
                'receive_date'  => ['required'],
            ]);
        }

        $saved_doktam = Doktam::create(array_merge($data_tosave, [
            'doktams_po_no'         => $request->doktams_po_no,
            'created_by'    => Auth()->user()->username
        ]));

        $doktams_id = $saved_doktam->id;

        //save to irr5_addoc table
        $addoc = new Addoc();
        $addoc->docnum = $request->document_no;
        $addoc->doctype = $request->doctypes_id;
        $addoc->docreceive = $request->receive_date;
        $addoc->doktams_id = $doktams_id;
        $addoc->created_by = Auth()->user()->username;
        $addoc->save();

        return redirect()->route('additionaldocs.index')->with('success', 'Document succesfully added!');
    }

    public function edit($id)
    {
        $doktam = Doktam::find($id);
        $doctypes = Doctype::orderBy('docdesc', 'asc')->get();

        return view('additionaldocs.edit', compact('doktam', 'doctypes'));
    }

    public function update(Request $request, $id)
    {
        $doktam = Doktam::find($id);
        $irr5_addoc = Addoc::where('doktams_id', $id)->first();

        if ($request->doctypes_id == 9) {    // jika doctype == ITO
            $data_tosave = $this->validate($request, [
                'document_no'   => ['required','unique:doktams,document_no,'. $id],
                'doctypes_id'   => ['required'],
                'receive_date'  => ['required'],
            ]);
        } else {
            $data_tosave = $this->validate($request, [
                'document_no'   => ['required'],
                'doctypes_id'   => ['required'],
                'receive_date'  => ['required'],
            ]);
        }

        $doktam->update(array_merge($data_tosave, [
            'doktams_po_no'         => $request->doktams_po_no,
        ]));

        // update record di irr5_addoc jika ada yg sesuai
        if($irr5_addoc) {
            $irr5_addoc->docnum = $request->document_no;
            $irr5_addoc->doctype = $request->doctypes_id;
            $irr5_addoc->docreceive = $request->receive_date;
            $irr5_addoc->docreceive = $request->po_no;
            $irr5_addoc->update();
        }
        
        return redirect()->route('additionaldocs.index')->with('success', 'Document succesfully updated!');
    }

    public function destroy($id)
    {
        $doktam = Doktam::find($id);
        $irr5_addoc = Addoc::where('doktams_id', $id)->first();

        $doktam->delete();

        // delete rcord di table irr5_addoc jika ada yg sesuai
        if($irr5_addoc) {
            $irr5_addoc->delete();
        }

        return redirect()->route('additionaldocs.index')->with('success', 'Document succesfully deleted!');
    }




}
