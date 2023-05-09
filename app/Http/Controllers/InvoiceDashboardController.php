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
        $this_year = Carbon::now();
        $last_year = Carbon::now()->subYear();

        $process_index = $this->yearProcessedCount($this_year) && $this->yearReceiveCount($this_year) ? number_format(($this->yearProcessedCount($this_year) / $this->yearReceiveCount($this_year)) * 100, 2) : '-';

        return view('accounting.dashboard.index1', [
            'thisMontAvgDayProcess' => $this->thisMonthInvAvgDayProcess(),
            // 'thisYearInvAvgDayProcess' => $this->thisYearInvAvgDayProcess('BPN'),
            'thisYearInvAvgDayProcess' => $this->invAvgDayProcess('BPN', $this_year->year),
            'lastYearInvAvgDayProcess' => $this->invAvgDayProcess('BPN', $last_year->year),
            'monthly_avg' => $this->monthly_avg($this_year), //this year monthly avg
            'thisMonthReceiveCount' => $this->thisMonthReceiveCount(),
            'thisYearReceiveCount' => number_format($this->yearReceiveCount($this_year), 0),
            'thisMonthProcessed' => $this->thisMonthprocessed(),
            'process_index' => $process_index,
            'thisYearProcessedCount' => $this->yearProcessedCount($this_year),
            'thisYearReceivedGet' => $this->monthlyInvoiceReceivedGet($this_year),
            'thisYearProcessedGet' => $this->monthlyInvoiceProcessedGet($this_year),
            'invoiceSentThisMonth' => $this->invoiceSentThisMonth(),
            'invoiceSentThisYear' => number_format($this->invoiceSentThisYear(), 0),
            'doktamNoInvoiceOldCount' => $this->doktamNoInvoiceOldCount(),
            'lastYearReceivedGet' => $this->monthlyInvoiceReceivedGet($last_year),
            'lastYearProcessedGetCount' => $this->monthlyProcessedCount(Carbon::now()->subYear()),
            'lastYear_avg' => $this->monthly_avg($last_year),
            'lastYearProcessedCount' => $this->yearProcessedCount($last_year),
            'lastYearReceiveCount' => $this->yearReceiveCount($last_year),
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

    public function invAvgDayProcess($receive_place, $year)
    {
        // $date = '2021-01-01';
        // $date = Carbon::now();

        $average = DB::table('irr5_invoice')
                    // ->select(DB::raw("avg(datediff(mailroom_bpn_date, receive_date)) as avg_days"))
                    ->select(DB::raw("datediff(mailroom_bpn_date, receive_date) as days"))
                    ->whereYear('receive_date', $year)
                    ->where('receive_place', $receive_place)
                    // ->whereMonth('receive_date', $date)
                    ->get()
                    ->avg('days');

        return $average;
    }

    public function monthly_avg($date)
    {
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

    public function yearProcessedCount($date)
    {
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
        $invoices = Invoice::select(DB::raw('substring(receive_date, 6, 2) as month, count(*) as processed_count'))
        ->whereYear('receive_date', $date->year)
                    ->where('receive_place', 'BPN')
                    ->whereNotNull('spis_id')
                    // ->selectRaw('count(*) as processed_count')
                    ->groupBy('month')
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
        // $date = Carbon::now()->subYear();
        $date = Carbon::now();

        $list = $this->monthlyInvoiceProcessedGet($date);
        return $list;
    }
}
