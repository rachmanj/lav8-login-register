<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use Illuminate\Http\Request;

class LogisticSiteMonitoringController extends Controller
{
    public function index()
    {
        $user_project_id = auth()->user()->projects_id; 

        $itos = Doktam::where('need_receiveback', 1)
                ->whereNull('receiveback_date')
                ->where('project_id', $user_project_id)
                ->orderBy('document_no', 'asc')
                ->get();

        return view('logistic.site-monitor.index', compact([
                'itos'
            ])
        );
    }

    public function update(Request $request)
    {
        $ito = Doktam::findOrFail($request->ito_id);

        $ito->update([
            'ta_no' => $request->ta_no
        ]);

        return redirect()->route('logistic.site-monitoring.index')->with('success', 'Data successfully updated');
    }
    
    public function update_many(Request $request)
    {
        $ito = Doktam::whereIn('id', $request->ito_ids)->update([
            'ta_no' => $request->ta_no
        ]);

        return redirect()->route('logistic.site-monitoring.index')->with('success', 'Data successfully updated');
    }

    public function data()
    {
        $user_project_id = auth()->user()->projects_id; 

        $itos = Doktam::where('need_receiveback', 1)
                ->whereNull('receiveback_date')
                ->where('project_id', $user_project_id)
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
            ->addColumn('action', 'logistic.site-monitor.action')
            ->rawColumns(['action'])
            ->toJson();
    }
}
