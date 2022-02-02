<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoktamDashboardController extends Controller
{
    public function index()
    {
        $project = Auth()->user()->project->project_code;

        return view('dashboard.index', [
            'project' => $project,
            'doktams_count' => $this->doktamPendingCount($project),
            'this_month_avg' => $this->thisMonthAverage($project),
            'this_year_average' => $this->thisYearAverage($project),
        ]);
    }

    public function doktamPendingCount($project)
    {
        $doktams_count = $this->pending_doktams()->where('project', $project)->count();
        return $doktams_count;
    }

    public function thisMonthAverage($project)
    {
        $date = Carbon::now();
        // $date = '2021-01-01';

        $average = $this->finished_doktams()
                    ->whereYear('inv_date', $date->year)
                    ->whereMonth('inv_date', $date->month)
                    ->get()
                    ->where('project', $project)
                    ->avg('days');
        return $average;
    }

    public function thisYearAverage($project)
    {
        $date = Carbon::now();
        // $date = '2021-01-01';

        $average = $this->finished_doktams()
                    ->whereYear('inv_date', $date->year)
                    // ->whereMonth('inv_date', $date->month)
                    ->get()
                    ->where('project', $project)
                    ->avg('days');
        return $average;
    }

    public function pending_doktams()
    {
        $list = DB::table('doktams')
                ->join('irr5_invoice', 'doktams.invoices_id', '=', 'irr5_invoice.inv_id')
                ->join('irr5_doctype', 'doktams.doctypes_id', '=', 'irr5_doctype.doctype_id')
                ->join('irr5_project', 'irr5_invoice.inv_project', '=', 'irr5_project.project_id')
                ->join('irr5_vendor', 'irr5_invoice.vendor_id', '=', 'irr5_vendor.vendor_id')
                ->select(
                    'doktams.id',
                    'doktams.document_no',
                    'irr5_doctype.docdesc as doctype',
                    'irr5_invoice.inv_no',
                    'irr5_invoice.inv_id',
                    'irr5_invoice.po_no',
                    'irr5_vendor.vendor_name as vendor',
                    'irr5_invoice.receive_date as inv_date', 
                    'irr5_project.project_code as project',
                    DB::raw("datediff(curdate(), irr5_invoice.receive_date) as days")
                )
                ->whereNull('doktams.receive_date')
                // ->whereYear('inv_date', '>=', $date)
                // ->orderBy('doctype', 'asc')
                ->orderBy('days', 'desc')
                ->orderBy('project', 'asc')
                ->get();
                
                return $list;
    }

    public function finished_doktams()
    {
        $list = DB::table('doktams')
                ->join('irr5_invoice', 'doktams.invoices_id', '=', 'irr5_invoice.inv_id')
                ->join('irr5_doctype', 'doktams.doctypes_id', '=', 'irr5_doctype.doctype_id')
                ->join('irr5_project', 'irr5_invoice.inv_project', '=', 'irr5_project.project_id')
                ->join('irr5_vendor', 'irr5_invoice.vendor_id', '=', 'irr5_vendor.vendor_id')
                ->select(
                    'doktams.id',
                    'doktams.document_no',
                    'doktams.receive_date',
                    'irr5_doctype.docdesc as doctype',
                    'irr5_invoice.inv_no',
                    'irr5_invoice.inv_id',
                    'irr5_invoice.po_no',
                    'irr5_vendor.vendor_name as vendor',
                    'irr5_invoice.receive_date as inv_date', 
                    'irr5_project.project_code as project',
                    DB::raw("datediff(doktams.receive_date, irr5_invoice.receive_date) as days")
                )
                ->whereNotNull('doktams.receive_date')
                // ->whereYear('inv_date', '2022-01-01')
                // ->orderBy('doctype', 'asc')
                ->orderBy('days', 'desc')
                ->orderBy('project', 'asc');
                // ->get();
                
                return $list;
    }

    public function test()
    {
        $test = $this->finished_doktams()
                ->whereYear('inv_date', '2021-01-01')
                ->get()
                ->where('project', '017C');
                // ->avg('days');

        return $test;
        // return view('accounting.dashboard.test', compact('invoices', 'process'));
    }
}
