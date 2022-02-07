<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReportsGroup2Controller extends Controller
{
    public function report7_index()
    {
        return view('reports.report7.index', [
            'nama_report' => 'Additional Docs (doktams table) Tanpa Nomor Invoice > 60 hari dan berstatus ACTIVE'
        ]);
    }

    public function report7_edit($id)
    {
        $doktam = Doktam::findOrFail($id);

        return view('reports.report7.edit', [
            'doktam' => $doktam,
        ]);
    }

    public function report7_update(Request $request, $id)
    {
        $doktam = Doktam::findOrFail($id);

        $doktam->update([
            'delete_reason' => $request->delete_reason,
        ]);

        $doktam->delete();

        return redirect()->route('reports.report7.index')->with('success', 'Record has been deleted');
    }

    public function report7_data()
    {
        $doktams = Doktam::whereNull('invoices_id')
            ->where('receive_date', '<', Carbon::now()->subDays(60))
            ->get();

        // return $doktams;
        return datatables()->of($doktams)
            ->editColumn('receive_date', function ($doktams) {
                return date('d-M-Y', strtotime($doktams->receive_date));
            })
            ->addColumn('doctype', function ($doktams) {
                return $doktams->doctype->docdesc;
            })
            ->addColumn('days', function ($doktams) {
                $date   = Carbon::parse($doktams->receive_date);
                $now    = Carbon::now();
                return $date->diffInDays($now);
            })
            ->addIndexColumn()
            ->addColumn('action', 'reports.report7.action')
            ->rawColumns(['action'])
            ->toJson();
        
    }
}
