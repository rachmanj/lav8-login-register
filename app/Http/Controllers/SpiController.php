<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\Spi;
use Illuminate\Http\Request;

class SpiController extends Controller
{
    public function index()
    {
        return view('spis.create.index');
    }

    public function receive_edit($spi_id)
    {
        $spi = Spi::with('invoices')->find($spi_id);

        return view('spis.create.receive', compact('spi'));
    }

    public function receive_update(Request $request, $spi_id)
    {
        $this->validate($request, [
            'received_date' => ['required']
        ]);

        $spi = Spi::find($spi_id);
        $spi->update([
            'received_at' => $request->received_date,
            'received_by' => auth()->user()->name
        ]);

        $bpn_project_id = Project::where('project_code', '000H')->first()->project_id;
        
        if (auth()->user()->projects_id === $bpn_project_id) {  // kalo user project 000H
            Invoice::where('spis_id', $spi->id)->update([
                'spi_bpn_date' => $request->received_date
            ]);
        } else {     // kalo user selain 000H / balikpapan
            Invoice::where('spis_id', $spi->id)->update([
                'mailroom_jkt_date' => $request->received_date
            ]);
        }

        return redirect()->route('spis.create.index')->with('success', 'SPI receive updated');
    }

    public function index_data()
    {
        if(auth()->user()->role === 'SUPERADMIN') {
            $spis = Spi::whereNull('received_at')
                    ->orderBy('date', 'desc') //
                    ->orderBy('nomor', 'desc')
                    ->get();
        } else {
            $bpn_project_id = Project::where('project_code', '000H')->first()->project_id;
            $jkt_project_id = Project::where('project_code', '001H')->first()->project_id;

            if(auth()->user()->projects_id === $bpn_project_id) {
                $to_projects_id = $bpn_project_id;
            } else {
                $to_projects_id = $jkt_project_id;
            }

            $spis = Spi::whereNull('received_at')
                ->where('to_projects_id', $to_projects_id)
                ->orderBy('date', 'desc') //
                ->orderBy('nomor', 'desc')
                ->get();
        }

        return datatables()->of($spis)
            ->editColumn('date', function ($spis) {
                return date('d-M-Y', strtotime($spis->date));
            })
            ->addColumn('to_project', function ($spis) {
                return $spis->to_project->project_code;
            })
            ->addIndexColumn()
            ->addColumn('action', 'spis.create.action')
            ->rawColumns(['action'])
            ->toJson();
    }
}
