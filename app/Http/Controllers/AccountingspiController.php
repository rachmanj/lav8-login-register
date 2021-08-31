<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Spi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountingspiController extends Controller
{
    public function spi_index()
    {
        return view('accounting.spis.spi_index');
    }

    public function spi_detail($id)
    {
        $spi = Spi::with('invoices.doktams')->find($id);
        
        // return $spi;
        return view('accounting.spis.spi_detail', compact('spi'));
    }

    public function spi_index_data()
    {
        $spis = Spi::orderBy('date', 'asc')->get();

        return datatables()->of($spis)
            ->editColumn('date', function ($spis) {
                return date('d-m-Y', strtotime($spis->date));
            })
            ->addColumn('to_project', function ($spis) {
                return $spis->to_project->project_code;
            })
            ->addIndexColumn()
            ->addColumn('action', 'accounting.spis.index_action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function spi_print_pdf($id)
    {
        $spi = Spi::with('invoices.doktams')->find($id);
        
        // return $spi;
        return view('accounting.spis.spi_pdf', compact('spi'));
    }
}
