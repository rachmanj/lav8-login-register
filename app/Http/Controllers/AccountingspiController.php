<?php

namespace App\Http\Controllers;

use App\Models\Spi;

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
        $spis = Spi::where('docsend_type','SPI')
                ->orderBy('date', 'desc') //
                ->orderBy('nomor', 'desc')
                ->get();

        return datatables()->of($spis)
            ->editColumn('date', function ($spis) {
                return date('d-M-Y', strtotime($spis->date));
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

    public function spiInfo_print_pdf($id)
    {
        $spi = Spi::with('invoices.doktams')->find($id);
        
        // return $spi;
        return view('accounting.spis.spi-info_pdf', compact('spi'));
    }
}
