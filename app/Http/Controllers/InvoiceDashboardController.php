<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
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
            'thisYearInvAvgDayProcess' => $this->thisYearInvAvgDayProcess('BPN'),
            'monthly_avg' => $this->monthly_avg($date), //this year monthly avg
            'thisMonthReceiveCount' => $this->thisMonthReceiveCount(),
            'thisYearReceiveCount' => $this->yearReceiveCount($date),
            'thisMonthProcessed' => $this->thisMonthprocessed(),
            'thisYearProcessedCount' => $this->yearProcessedCount($date),
            'thisYearReceivedGet' => $this->monthlyInvoiceReceivedGet($date),
            'thisYearProcessedGet' => $this->monthlyInvoiceProcessedGet($date),
            'invoiceSentThisMonth' => $this->invoiceSentThisMonth(),
            'invoiceSentThisYear' => $this->invoiceSentThisYear(),
            'doktamNoInvoiceOldCount' => $this->doktamNoInvoiceOldCount(),
            'lastYearReceivedGet' => $this->monthlyInvoiceReceivedGet($date->subYear()),
            'lastYearProcessedGetCount' => $this->monthlyProcessedCount(Carbon::now()->subYear()),
            'lastYear_avg' => $this->monthly_avg($date->subYear()),
            'lastYearProcessedCount' => $this->yearProcessedCount(Carbon::now()->subYear()),
            'lastYearReceiveCount' => $this->yearReceiveCount(Carbon::now()->subYear()),
            'monthOf2021' => ['08','09', '10', '11', '12'],
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

    public function thisYearInvAvgDayProcess($receive_place)
    {
        // $date = '2021-01-01';
        $date = Carbon::now();

        $average = DB::table('irr5_invoice')
                    // ->select(DB::raw("avg(datediff(mailroom_bpn_date, receive_date)) as avg_days"))
                    ->select(DB::raw("datediff(mailroom_bpn_date, receive_date) as days"))
                    ->whereYear('receive_date', $date)
                    ->where('receive_place', $receive_place)
                    // ->whereMonth('receive_date', $date)
                    ->get()
                    ->avg('days');

        return $average;
    }

    public function monthly_avg($date)
    {
        // $date = '2021-01-01';
        // $date = Carbon::now();

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

    public function yearReceiveCount($date)
    {
        // $date = Carbon::now();

        $count = Invoice::whereYear('receive_date', $date)
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

    public function yearProcessedCount($date)
    {
        // $date = Carbon::now();

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

    public function doktamNoInvoiceOldCount()
    {
        $count = Doktam::whereNull('invoices_id')
                ->where('receive_date', '<', Carbon::now()->subDays(60))
                ->count();
        
        return $count;
    }

    public function monthlyProcessedCount($date)
    {
        // Carbon::now();

        return Invoice::whereYear('receive_date', $date)
                ->where('receive_place', 'BPN')
                ->whereNotNull('spis_id')
                ->selectRaw('substring(receive_date, 6, 2) as month')
                ->selectRaw('count(*) as process_count')
                ->groupBy('month')
                ->get();
    }

    public function test()
    {
        $date = Carbon::now()->subYear();
        // $list = $this->monthlyInvoiceProcessedGet($date)
        //         ->where('month', '07')
        //         ->count();
        
        // $list = $this->monthlyInvoiceReceivedGet($date->subYear());
        // $list = $this->monthlyInvoiceProcessedGet($date);

        $list = $this->monthlyProcessedCount($date)->where('month', '12');;

        // $process = $this->monthlyInvoiceProcessedGet($date);
        return $list;
        // return view('accounting.dashboard.test', compact('invoices', 'process'));
    }
}
