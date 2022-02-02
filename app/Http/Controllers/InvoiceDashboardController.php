<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceDashboardController extends Controller
{
    public function index1()
    {
        $date = Carbon::now();

        return view('accounting.dashboard.index1', [
            'thisMontAvgDayProcess' => $this->thisMonthInvAvgDayProcess(),
            'thisYearInvAvgDayProcess' => $this->thisYearInvAvgDayProcess(),
            'monthly_avg' => $this->monthly_avg(),
            'thisMonthReceiveCount' => $this->thisMonthReceiveCount(),
            'thisYearReceiveCount' => $this->thisYearReceiveCount(),
            'thisMonthProcessed' => $this->thisMonthprocessed(),
            'thisYearProcessedCount' => $this->thisYearProcessed(),
            'thisYearReceivedGet' => $this->monthlyInvoiceReceivedGet($date),
            'thisYearProcessedGet' => $this->monthlyInvoiceProcessedGet($date),
            'invoiceSentThisMonth' => $this->invoiceSentThisMonth(),
            'invoiceSentThisYear' => $this->invoiceSentThisYear(),
        ]);
    }

    public function thisMonthInvAvgDayProcess()
    {
        $date = Carbon::now();

        $average = DB::table('irr5_invoice')
                    // ->select(DB::raw("avg(datediff(mailroom_bpn_date, receive_date)) as avg_days"))
                    ->select(DB::raw("datediff(mailroom_bpn_date, receive_date) as days"))
                    ->whereYear('receive_date', $date)
                    ->whereMonth('receive_date', $date)
                    ->get()
                    ->avg('days');

        return $average;
    }

    public function thisYearInvAvgDayProcess()
    {
        // $date = '2021-01-01';
        $date = Carbon::now();

        $average = DB::table('irr5_invoice')
                    // ->select(DB::raw("avg(datediff(mailroom_bpn_date, receive_date)) as avg_days"))
                    ->select(DB::raw("datediff(mailroom_bpn_date, receive_date) as days"))
                    ->whereYear('receive_date', $date)
                    // ->whereMonth('receive_date', $date)
                    ->get()
                    ->avg('days');

        return $average;
    }

    public function monthly_avg()
    {
        // $date = '2021-01-01';
        $date = Carbon::now();

        $list = Invoice::whereYear('receive_date', $date)
                ->where('receive_place', 'BPN')
                ->whereNotNull('mailroom_bpn_date')
                ->selectRaw('substring(receive_date, 6, 2) as month')
                ->selectRaw('count(*) as count')
                ->selectRaw('avg(datediff(mailroom_bpn_date, receive_date)) as avg_days')
                // ->selectRaw('avg(datediff(mailroom_bpn_date, receive_date)) as days')
                ->groupBy('month')
                ->get();
                
        return $list;
    }

    public function thisMonthReceiveCount()
    {
        $date = Carbon::now();

        $count = Invoice::whereYear('receive_date', $date->year)
                ->whereMonth('receive_date', $date->month)
                ->where('receive_place', 'BPN')
                ->count();
        
            return $count;
    }

    public function thisYearReceiveCount()
    {
        $date = Carbon::now();

        $count = Invoice::whereYear('receive_date', $date->year)
                ->where('receive_place', 'BPN')
                ->count();
        
            return $count;
    }

    public function thisMonthProcessed()
    {
        $date = Carbon::now();

        $count = Invoice::where('receive_place', 'BPN')
                ->whereYear('receive_date', $date)
                ->whereMonth('receive_date', $date)
                ->whereNotNull('spis_id')
                ->count();

        return $count;
    }

    public function thisYearProcessed()
    {
        $date = Carbon::now();

        $count = Invoice::where('receive_place', 'BPN')
                ->whereYear('receive_date', $date)
                ->whereNotNull('spis_id')
                ->count();

        return $count;
    }

    public function monthlyInvoiceReceivedGet($date)
    {
        $invoices = Invoice::whereYear('receive_date', $date)
                    ->where('receive_place', 'BPN')
                    // ->where('inv_status', '<>', 'RETURN')
                    ->selectRaw('substring(receive_date, 6, 2) as month')
                    ->selectRaw('count(*) as receive_count')
                    ->groupBy('month')
                    ->get();

        return $invoices;

    }

    public function monthlyInvoiceProcessedGet($date)
    {
        $invoices = Invoice::whereYear('receive_date', $date)
                    ->where('receive_place', 'BPN')
                    ->whereNotNull('spis_id')
                    ->selectRaw('substring(receive_date, 6, 2) as month')
                    // ->selectRaw('count(*) as processed_count')
                    // ->groupBy('month')
                    ->get();

        return $invoices;

    }

    public function invoiceSentThisMonth()
    {
        $date = Carbon::now();

        $count = Invoice::whereYear('mailroom_bpn_date', $date->year)
                ->whereMonth('mailroom_bpn_date', $date->month)
                ->where('receive_place', 'BPN')
                ->count();
        return $count;
    }

    public function invoiceSentThisYear()
    {
        $date = Carbon::now();

        $count = Invoice::whereYear('mailroom_bpn_date', $date->year)
                ->where('receive_place', 'BPN')
                ->count();
        return $count;
    }

    public function test()
    {
        $avg = $this->monthly_avg();
        // $process = $this->monthlyInvoiceProcessedGet();
        return $avg;
        // return view('accounting.dashboard.test', compact('invoices', 'process'));
    }
}
