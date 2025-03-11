<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoktamdataController extends Controller
{
    public function doktam_invoices(Request $request)
    {
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
            'receive_date',
            'mailroom_bpn_date'
        ])
            ->with([
                'vendor:vendor_id,vendor_name',
                'project:project_id,project_code',
                'doktams:id,invoices_id'
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
        $date = '2021-01-01';
        $query->whereYear('receive_date', '>=', $date)
            ->whereNull('mailroom_bpn_date')
            ->where('inv_status', '!=', 'RETURN');

        // Get the data with pagination handled by DataTables
        $invoices = $query->latest('inv_date');

        // Get current date for days calculation
        $today = Carbon::now();

        // Return as DataTables JSON
        return datatables()->of($invoices)
            ->addColumn('project', function ($invoice) {
                return $invoice->project->project_code ?? 'N/A';
            })
            ->addColumn('vendor', function ($invoice) {
                return $invoice->vendor->vendor_name ?? 'N/A';
            })
            ->addColumn('amount', function ($invoice) {
                return number_format($invoice->inv_nominal, 0);
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
            ->addIndexColumn()
            ->addColumn('action', function ($invoice) {
                $actionBtn = '<a href="' . route('accounting.doktam_invoices.show', $invoice->inv_id) . '" class="btn btn-xs btn-info" data-toggle="tooltip" title="View Documents">
                    <i class="fas fa-eye"></i>
                </a>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'days_diff', 'invoice_info'])
            ->toJson();
    }
}
