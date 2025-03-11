<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReportsGroup2Controller extends Controller
{
    // Report 8 is All invoice
    public function report8_index()
    {
        // Get distinct vendor names for dropdown
        $vendors = Invoice::select('vendor_id')
            ->with('vendor')
            ->distinct()
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->vendor_id,
                    'name' => $invoice->vendor->vendor_name ?? 'Unknown'
                ];
            })
            ->sortBy('name')
            ->values();

        return view('reports.report8.index', [
            'nama_report' => 'All Invoices',
            'vendors' => $vendors
        ]);
    }

    public function report8_show($id)
    {
        $invoice = Invoice::with([
            'vendor',
            'vendorbranch',
            'project',
            'invtype',
            'doktams.doctype',
            'spi.to_project'
        ])->findOrFail($id);

        return view('reports.report8.show', compact('invoice'));
    }

    public function report8_data(Request $request)
    {
        // Remove the 3-year limitation
        $query = Invoice::with(['project', 'vendor', 'vendorbranch']);

        // Apply filters if provided
        if ($request->has('inv_no') && !empty($request->inv_no)) {
            $query->where('inv_no', 'like', '%' . $request->inv_no . '%');
        }

        if ($request->has('po_no') && !empty($request->po_no)) {
            $query->where('po_no', 'like', '%' . $request->po_no . '%');
        }

        if ($request->has('vendor_id') && !empty($request->vendor_id)) {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->has('project_code') && !empty($request->project_code)) {
            $query->whereHas('project', function ($q) use ($request) {
                $q->where('project_code', 'like', '%' . $request->project_code . '%');
            });
        }

        return datatables()->of($query)
            ->editColumn('receive_date', function ($invoice) {
                return date('d-M-Y', strtotime($invoice->receive_date));
            })
            ->editColumn('inv_date', function ($invoice) {
                return date('d-M-Y', strtotime($invoice->inv_date));
            })
            ->addColumn('vendor', function ($invoice) {
                return $invoice->vendor->vendor_name ?? 'N/A';
            })
            ->addColumn('project', function ($invoice) {
                return $invoice->project->project_code ?? 'N/A';
            })
            ->addColumn('amount', function ($invoice) {
                return number_format($invoice->inv_nominal, 0);
            })
            ->addIndexColumn()
            ->addColumn('action', 'reports.report8.action')
            ->rawColumns(['action'])
            ->toJson();
    }

    // report 9
    public function report9_index()
    {
        return view('reports.report9.index', [
            'nama_report' => 'Invoice by Month of receive, order by Days of completion & status'
        ]);
    }

    public function report9_display(Request $request)
    {
        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);

        $invoices = Invoice::whereYear('receive_date', $year)
            ->whereMonth('receive_date', $month)
            ->where('receive_place', $request->receive_place)
            ->select('inv_id', 'inv_no', 'inv_date', 'po_no', 'receive_date', 'inv_nominal', 'sent_status', 'vendor_id', 'inv_project', 'mailroom_bpn_date')
            ->selectRaw('datediff(mailroom_bpn_date, receive_date) as days')
            ->selectRaw('datediff(now(), receive_date) as days_out')
            ->orderBy('days', 'desc')
            ->get();

        return view('reports.report9.display', [
            'date' => $request->date,
            'report_name' => 'Invoice by Month of receive, Days of completion & status (receive at ' . $request->receive_place . ')',
            'receive_place' => $request->receive_place,
            'invoices' => $invoices,
        ]);
    }
}
