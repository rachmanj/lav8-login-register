<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceDashboardController extends Controller
{
    public function index1()
    {
        return view('dashboard.index1', [
            'thisMontAvgDayProcess' => $this->thisMonthInvAvgDayProcess(),
            'thisYearInvAvgDayProcess' => $this->thisYearInvAvgDayProcess(),
            'monthly_avg' => $this->monthly_avg(),
            'thisMonthReceiveCount' => $this->thisMonthReceiveCount(),
            'thisYearReceiveCount' => $this->thisYearReceiveCount(),
            'thisMonthProcessed' => $this->thisMonthprocessed(),
            'thisYearProcessed' => $this->thisYearProcessed()
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
                ->selectRaw('substring(receive_date, 6, 2) as month')
                ->selectRaw('avg(datediff(mailroom_bpn_date, receive_date)) as days')
                ->whereNotNull('mailroom_bpn_date')
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

    public function test()
    {
        $test = $this->thisYearProcessed();
        return $test;
    }
}
