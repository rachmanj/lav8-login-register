<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spi;
use App\Models\Project;
use App\Models\Doktam;
use App\Models\Doctype;

class SpiLogisticController extends Controller
{
    public function index()
    {
        return view('spis.logistic.index');
    }

    public function create()
    {
        $add_all_button = null;
        $remove_all_button = Doktam::where('flag', 'LPD' . auth()->user()->id)->count() > 0 ? true : false;
        $doctypes = Doctype::orderBy('docdesc', 'asc')->get();
        $projects = Project::where('is_active', 1)->orderBy('project_code', 'asc')->get();

        return view('spis.logistic.create', compact([
            'add_all_button',
            'remove_all_button',
            'doctypes',
            'projects'
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'to_person' => 'required',
        ]);

        // CREATE SPI
        $spi = Spi::create([
            'nomor' => $request->nomor,
            'to_person' => $request->to_person,
            'date' => date('Y-m-d'),
            'to_projects_id' => 5, // 000H or HO
            'created_by' => auth()->user()->name,
            'docsend_type' => 'LPD', 
            'from_department' => 'Logistic',
            'to_department' => 'Accounting',
            "flag" => "NOTSENT",
        ]);

        // UPDATE DOKTAM FLAG
        $flag = 'LPD' . auth()->user()->id;
        $doktams = Doktam::where('flag', $flag)->get();
        foreach ($doktams as $doktam) {
            $doktam->flag = 'NOTSENT'; 
            $doktam->spi_id = $spi->id;
            $doktam->save();
        }

        return redirect()->route('spis.logistic.index')->with('success', 'LPD created succesfuly');
    }

    public function store_doktam(Request $request)
    {
        $request->validate([
            'document_no' => 'required',
        ]);

        $doktam = Doktam::create([
            'document_no' => $request->document_no,
            'document_date' => $request->document_date,
            'project_id' => $request->project_id,
            'doctypes_id' => $request->doctypes_id,
            'doktams_po_no' => $request->po_no,
            'created_by' => auth()->user()->name,
        ]);

        return redirect()->back();
    }

    public function add_tocart(Request $request)
    {
        $doktam = Doktam::find($request->document_id);
        $doktam->flag = 'LPD' . auth()->user()->id; // LPD = Lembar Pengiriman Dokumen
        $doktam->save();

        return redirect()->back(); 
    }

    public function remove_fromcart(Request $request)
    {
        $doktam = Doktam::find($request->document_id);
        $doktam->flag = null; 
        $doktam->save();

        return redirect()->back();  
    }

    public function move_all_tocart()
    {
        // 
    }

    public function remove_all_fromcart()
    {
        $doktams = Doktam::where('flag', 'LPD' . auth()->user()->id)->get();
        foreach ($doktams as $doktam) {
            $doktam->flag = null;
            $doktam->save();
        }

        return redirect()->back();
    }

    public function show($spi_id)
    {
        $spi = Spi::where('id', $spi_id)->first();
        $documents = $spi->doktams;
       
        return view('spis.logistic.show', compact([
            'spi',
            'documents',
        ]));
    }

    public function edit($spi_id)
    {
        $lpd = Spi::findOrFail($spi_id);
        $doktams = Doktam::where('spi_id', $spi_id);
        // return $doktams;
        // die;

        $flag = 'EDIT-LPD' . auth()->user()->id; // LPD = Lembar Pengiriman Dokumen
        $doktams->update([
            "flag" => $flag 
        ]);

        $remove_all_button = Doktam::where('flag', 'EDIT-LPD' . auth()->user()->id)->count() > 0 ? true : false;

        return view('spis.logistic.edit', compact([
            'remove_all_button',
            'lpd'
        ]));
    }

    public function print($spi_id)
    {
        $spi = Spi::where('id', $spi_id)->first();
        
        $documents = $spi->doktams;
       
        return view('spis.logistic.print', compact([
            'spi',
            'documents'
        ]));
    }

    public function sent($spi_id)
    {
        $spi = Spi::findOrFail($spi_id);
        $spi->update([
            "flag" => "SENT",
        ]);
        $doktams = Doktam::where('spi_id', $spi_id);
        $doktams->update([
            "flag" => "TRN-000H", // TRN = Transfer ke 000H atau sedang dalam pengiriman ke 000H
        ]);

        return redirect()->route('spis.logistic.index')->with('success', 'LPD sent succesfuly');
    }

    public function destroy($spi_id)
    {
        $spi = Spi::findOrFail($spi_id);
        $doktams = Doktam::where('spi_id', $spi_id);
        $doktams->update([
            "flag" => null,
            'updated_by' => null,
            'spi_id' => null
        ]);

        $spi->delete();

        return redirect()->route('spis.logistic.index')->with('success', 'LPD deleted succesfuly');
    }

    public function data()
    {
        $cutoff_date = "2022-12-31";

        if(auth()->user()->role === 'SUPERADMIN') {
            $spis = Spi::where('from_department', 'Logistic')
                    ->orderBy('date', 'desc') //
                    ->orderBy('nomor', 'desc')
                    ->get();
        } else {
            $spis = Spi::where('from_department', 'Logistic')
                ->orderBy('date', 'desc') //
                ->orderBy('nomor', 'desc')
                ->get();
        }

        return datatables()->of($spis)
            ->editColumn('date', function ($spi) {
                return date('d-M-Y', strtotime($spi->date));
            })
            ->addColumn('status', function ($spi) {
                if ($spi->flag === "NOTSENT") {
                    return '<button class="btn btn-xs btn-warning" style="pointer-events: none;">NOT SENT</button>';
                } elseif ($spi->flag === "SENT") {
                    return '<button class="btn btn-xs btn-info" style="pointer-events: none;">SENT</button>';
                } elseif ($spi->flag === "RECEIVED") {
                    return '<button class="btn btn-xs btn-success" style="pointer-events: none;">RECEIVED</button> on ' .    date('d-M-Y', strtotime($spi->received_at)) . ' by ' . $spi->received_by;
                } else {
                    return '<button class="btn btn-xs btn-danger" style="pointer-events: none;">' . $spi->flag . '</button>';
                }
            })
            ->addColumn('destination', function ($spi) {
                return $spi->to_department . ' - ' . $spi->to_project->project_code . ', ' . $spi->to_person;
            })
            ->addIndexColumn()
            ->addColumn('action', 'spis.logistic.action')
            ->rawColumns(['action', 'status'])
            ->toJson();
    
    }

    public function to_cart_data()
    {
        $cutoff_date = "2022-12-31";

        $documents = Doktam::whereNull('receive_date')
                    ->where('created_at', '>', $cutoff_date)
                    ->whereNull('flag')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return datatables()->of($documents)
                ->addColumn('document_type', function ($document) {
                    return $document->doctype->docdesc;
                })
                ->addColumn('invoice_no', function ($document) {
                    return $document->invoice ? $document->invoice->inv_no : "-";
                })
                ->addColumn('po_no', function ($document) {
                    if ($document->doktams_po_no) {
                        return $document->doktams_po_no;
                    } elseif ($document->invoice) {
                        return $document->invoice->po_no;
                    } else {
                        return "-";
                    }
                })
                ->addColumn('vendor_name', function ($document) {
                    return $document->invoice ? $document->invoice->vendor->vendor_name : "-";
                })
                ->addColumn('project_code', function ($document) {
                    if ($document->project) {
                        return $document->project->project_code;
                    } elseif ($document->invoice) {
                        return $document->invoice->project->project_code;
                    } else {
                        return "-";
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', 'spis.logistic.to-cart-action')
                ->rawColumns(['action'])
                ->toJson();
    }

    public function in_cart_data()
    {
        $flag = "LPD" . auth()->user()->id;

        $documents = Doktam::where('flag', $flag)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return datatables()->of($documents)
                ->addColumn('document_type', function ($document) {
                    return $document->doctype->docdesc;
                })
                ->addColumn('invoice_no', function ($document) {
                    return $document->invoice ? $document->invoice->inv_no : "-";
                })
                ->addColumn('po_no', function ($document) {
                    if ($document->doktams_po_no) {
                        return $document->doktams_po_no;
                    } elseif ($document->invoice) {
                        return $document->invoice->po_no;
                    } else {
                        return "-";
                    }
                })
                ->addColumn('vendor_name', function ($document) {
                    return $document->invoice ? $document->invoice->vendor->vendor_name : "-";
                })
                ->addColumn('project_code', function ($document) {
                    if ($document->project) {
                        return $document->project->project_code;
                    } elseif ($document->invoice) {
                        return $document->invoice->project->project_code;
                    } else {
                        return "-";
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', 'spis.logistic.in-cart-action')
                ->rawColumns(['action'])
                ->toJson();
    }

    public function in_cart_data_edit()
    {
        $flag = "EDIT-LPD" . auth()->user()->id;

        $documents = Doktam::where('flag', $flag)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return datatables()->of($documents)
                ->addColumn('document_type', function ($document) {
                    return $document->doctype->docdesc;
                })
                ->addColumn('invoice_no', function ($document) {
                    return $document->invoice ? $document->invoice->inv_no : "-";
                })
                ->addColumn('po_no', function ($document) {
                    return $document->invoice ? $document->invoice->po_no : "-";
                })
                ->addColumn('vendor_name', function ($document) {
                    return $document->invoice->vendor ? $document->invoice->vendor->vendor_name : "-";
                })
                ->addColumn('project_code', function ($document) {
                    return $document->invoice->project ? $document->invoice->project->project_code : "-";
                })
                ->addIndexColumn()
                ->addColumn('action', 'spis.logistic.in-cart-action')
                ->rawColumns(['action'])
                ->toJson();
    }
}
