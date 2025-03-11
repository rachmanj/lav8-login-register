<?php

namespace App\Http\Controllers;

use App\Models\Addoc;
use App\Models\Doktam;
use App\Models\Invoice;
use App\Models\Invoicetype;
use App\Models\Project;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Psy\Command\EditCommand;

class InvoiceController extends Controller
{
    public function index()
    {
        $vendors = Vendor::orderBy('vendor_name', 'asc')->get();
        $projects = Project::orderBy('project_code', 'asc')->get();

        return view('invoices.index', compact('vendors', 'projects'));
    }

    public function create()
    {
        $vendors    = Vendor::orderBy('vendor_name', 'asc')->get();
        $categories = Invoicetype::orderBy('invtype_name', 'asc')->get();
        $projects   = Project::orderBy('project_code', 'asc')->get();

        return view('invoices.create', compact('vendors', 'categories', 'projects'));
    }

    public function show($id)
    {
        try {
            $invoice = Invoice::with([
                'vendor',
                'project',
                'invtype',
                'vendorbranch',
                'doktams',
                'spi',
                'spi.from_project',
                'spi.to_project'
            ])->findOrFail($id);

            // Try to load followups if the relationship exists
            try {
                if (method_exists($invoice, 'followups')) {
                    $invoice->load('followups');
                }
            } catch (\Exception $e) {
                // Silently handle the error if followups relationship doesn't exist
            }

            return view('invoices.show', compact('invoice'));
        } catch (\Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Invoice not found: ' . $e->getMessage());
        }
    }

    public function index_data(Request $request)
    {
        // Handle preload request for faster initial page load
        if ($request->has('preload') && $request->preload) {
            return response()->json(['data' => []]);
        }

        // Start with a base query with specific columns to reduce data transfer
        $query = Invoice::select([
            'inv_id',
            'inv_no',
            'inv_date',
            'vendor_id',
            'po_no',
            'inv_project',
            'inv_nominal',
            'inv_status',
            'receive_date'
        ])
            ->with([
                'vendor:vendor_id,vendor_name',
                'project:project_id,project_code'
            ]);

        // Apply filters if provided
        if ($request->filled('inv_no')) {
            $query->where('inv_no', 'like', '%' . $request->inv_no . '%');
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->filled('po_no')) {
            $query->where('po_no', 'like', '%' . $request->po_no . '%');
        }

        if ($request->filled('project_id')) {
            $query->where('inv_project', $request->project_id);
        }

        // Default date filter - can be adjusted as needed
        $date = '2020-01-01';
        $query->where('receive_date', '>=', $date)
            ->whereIn('inv_status', ['PENDING', 'SAP'])
            ->whereNull('mailroom_bpn_date');

        // Get the data with pagination handled by DataTables
        $invoices = $query->latest('inv_date');

        // Get current date for days calculation
        $today = Carbon::now();

        // Return as DataTables JSON
        return datatables()->of($invoices)
            ->addColumn('vendor', function ($invoice) {
                return $invoice->vendor->vendor_name ?? 'N/A';
            })
            ->addColumn('project', function ($invoice) {
                return $invoice->project->project_code ?? 'N/A';
            })
            ->addColumn('invoice_info', function ($invoice) {
                $invNo = $invoice->inv_no ?? 'N/A';
                $invDate = $invoice->inv_date ? Carbon::parse($invoice->inv_date)->format('d M Y') : 'N/A';
                return '<strong>' . $invNo . '</strong><br><small class="text-muted">' . $invDate . '</small>';
            })
            ->editColumn('receive_date', function ($invoice) {
                return $invoice->receive_date ? Carbon::parse($invoice->receive_date)->format('d M Y') : 'N/A';
            })
            ->addColumn('days_diff', function ($invoice) use ($today) {
                if (!$invoice->receive_date) return null;

                $receiveDate = Carbon::parse($invoice->receive_date);
                return $receiveDate->diffInDays($today);
            })
            ->addColumn('amount', function ($invoice) {
                return number_format($invoice->inv_nominal, 0);
            })
            ->addIndexColumn()
            ->addColumn('action', function ($invoice) {
                $actionBtn = '<div class="btn-group">
                        <a href="' . route('invoices.show', $invoice->inv_id) . '" class="btn btn-xs btn-info" data-toggle="tooltip" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . route('invoices.edit', $invoice->inv_id) . '" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="' . route('invoices.add_doktams', $invoice->inv_id) . '" class="btn btn-xs btn-success" data-toggle="tooltip" title="Add Documents">
                            <i class="fas fa-file-alt"></i>
                        </a>
                    </div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'invoice_info'])
            ->toJson();
    }

    public function test() {}

    public function store(Request $request)
    {
        // Use the raw value if available, otherwise use the formatted value
        $nominal = $request->filled('inv_nominal_raw') ? $request->inv_nominal_raw : $request->inv_nominal;

        // Create the invoice with the processed nominal value
        $invoice = new Invoice();
        $invoice->inv_no = $request->inv_no;
        $invoice->inv_date = $request->inv_date;
        $invoice->vendor_id = $request->vendor_id;
        $invoice->vendor_branch = $request->vendor_branch;
        $invoice->receive_date = $request->receive_date;
        $invoice->payment_place = $request->payment_place;
        $invoice->inv_currency = $request->inv_currency;
        $invoice->po_no = $request->po_no;
        $invoice->inv_type = $request->inv_type;
        $invoice->inv_project = $request->inv_project;
        $invoice->inv_nominal = $nominal;
        $invoice->receive_place = $request->receive_place;
        $invoice->remarks = $request->remarks;
        $invoice->creator = auth()->user()->name;
        $invoice->inv_status = 'PENDING';
        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully');
    }

    public function edit($id)
    {
        $invoice    = Invoice::with('vendorbranch')->find($id);
        $vendors    = Vendor::orderBy('vendor_name', 'asc')->get();
        $categories = Invoicetype::orderBy('invtype_name', 'asc')->get();
        $projects   = Project::orderBy('project_code', 'asc')->get();

        return view('invoices.edit', compact('invoice', 'vendors', 'categories', 'projects'));
    }

    public function update(Request $request, $id)
    {
        // Use the raw value if available, otherwise use the formatted value
        $nominal = $request->filled('inv_nominal_raw') ? $request->inv_nominal_raw : $request->inv_nominal;

        $invoice = Invoice::findOrFail($id);
        $invoice->inv_no = $request->inv_no;
        $invoice->inv_date = $request->inv_date;
        $invoice->vendor_id = $request->vendor_id;
        $invoice->vendor_branch = $request->vendor_branch;
        $invoice->receive_date = $request->receive_date;
        $invoice->payment_place = $request->payment_place;
        $invoice->inv_currency = $request->inv_currency;
        $invoice->po_no = $request->po_no;
        $invoice->inv_type = $request->inv_type;
        $invoice->inv_project = $request->inv_project;
        $invoice->inv_nominal = $nominal;
        $invoice->receive_place = $request->receive_place;
        $invoice->remarks = $request->remarks;
        $invoice->inv_status = $request->inv_status;
        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully');
    }

    public function add_doktams($inv_id)
    {
        $invoice = Invoice::find($inv_id);
        $doktams = Doktam::where('doktams_po_no', $invoice->po_no)
            ->whereNull('invoices_id')
            ->get();

        return view('invoices.add_doktams', compact('invoice', 'doktams'));
    }


    // mengupdate field invoices_id 
    public function addto_invoice(Request $request, $id)
    {
        $doktam = Doktam::find($id);
        $inv_id = $request->invoices_id;
        $doktam->invoices_id = $inv_id;
        $doktam->update();

        // update data di table irr5_addoc jika ada
        $irr5_addoc = Addoc::where('doktams_id', $id)->first();
        if ($irr5_addoc) {
            $irr5_addoc->inv_id = $inv_id;
            $irr5_addoc->update();
        }

        return redirect()->route('invoices.add_doktams', $inv_id);
    }

    // edit / menghilangkan invoices_id 
    public function removefrom_invoice(Request $request, $id)
    {
        $doktam = Doktam::find($id);
        $inv_id = $request->invoices_id;
        $doktam->invoices_id = null;
        $doktam->update();

        return redirect()->route('invoices.add_doktams', $inv_id);
    }

    /* public function possible_doktams_data($inv_id)
    {
        $invoice = Invoice::find($inv_id);
        $po_no = $invoice->po_no;

        $doktams = Doktam::where('po_no', $po_no)
                    ->whereNull('invoices_id')
                    ->get();

        // return $doktams;
        return datatables()->of($doktams)
            ->editColumn('receive_date', function ($doktams) {
                return date('d-M-Y', strtotime($doktams->receive_date));
            })
            ->editColumn('doctype', function($doktams) {
                return $doktams->doctype->docdesc;
            })
            ->addIndexColumn()
            ->addColumn('action', 'invoices.add_doktam_action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function doktams_of_invoice_data($inv_id)
    {
        $doktams = Doktam::where('invoices_id', $inv_id)->get();

        return datatables()->of($doktams)
                ->editColumn('receive_date', function ($doktams) {
                    return date('d-M-Y', strtotime($doktams->receive_date));
                })
                ->editColumn('doctype', function($doktams) {
                    return $doktams->doctype->docdesc;
                })
                ->addIndexColumn()
                ->addColumn('action', 'invoices.remove_doktam_action')
                ->rawColumns(['action'])
                ->toJson();
    } */
}
