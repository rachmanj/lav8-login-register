<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use Illuminate\Http\Request;

class LogisticItoMonitoringController extends Controller
{
    public function index()
    {
        $itos = Doktam::where('need_receiveback', 1)
                ->whereNull('receiveback_date')
                ->orderBy('document_no', 'asc')
                ->get();
        
        return view('logistic.ito-monitor.index', compact([
                'itos'
            ])
        );
    }

    public function update(Request $request)
    {
        $ito = Doktam::findOrFail($request->ito_id);

        $ito->update([
            'need_receiveback' => 0,
            'receiveback_date' => $request->receiveback_date
        ]);

        return redirect()->route('logistic.ito-monitoring.index')->with('success', 'Data successfully updated');
    }
    
    public function update_many(Request $request)
    {
        $ito = Doktam::whereIn('id', $request->ito_ids)->update([
            'need_receiveback' => 0,
            'receiveback_date' => $request->receiveback_date
        ]);

        return redirect()->route('logistic.ito-monitoring.index')->with('success', 'Data successfully updated');
    }

    public function data()
    {
        $itos = Doktam::where('need_receiveback', 1)
            ->whereNull('receiveback_date')
            ->orderBy('delivery_date', 'asc')
            ->get();

        return datatables()->of($itos)
            ->addColumn('days', function ($ito) {
                $today = new \Carbon\Carbon();
                $delivery_d = new \Carbon\Carbon($ito->delivery_date);
                $days = $today->diffInDays($delivery_d);
                return $days;
            })
            ->editColumn('document_date', function ($ito) {
                return date('d-M-Y', strtotime($ito->document_date));
            })
            ->editColumn('delivery_date', function ($ito) {
                return date('d-M-Y', strtotime($ito->delivery_date));
            })
            ->addIndexColumn()
            ->addColumn('action', 'logistic.ito-monitor.action')
            ->rawColumns(['action'])
            ->toJson();
    }
}

