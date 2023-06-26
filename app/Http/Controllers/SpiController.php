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
            'received_by' => auth()->user()->username
        ]);

        $bpn_project_id = Project::where('project_code', '000H')->first()->project_id;

        if (auth()->user()->projects_id === $bpn_project_id) {  // kalo user project 000H
            $invoices = Invoice::where('spis_id', $spi->id)->get();
            // sent api to Payreq-system post invoice
            foreach ($invoices as $invoice) {
                $url = 'http://192.168.33.15/payreq-support/api/invoices';
                $data = [
                    "nomor_invoice" => $invoice->inv_no,
                    "invoice_irr_id" => $invoice->inv_id,
                    "vendor_name" => $invoice->vendor->vendor_name,
                    "received_date" => $invoice->receive_date,
                    "amount" => $invoice->inv_nominal,
                    "remarks" => $invoice->remarks ? $invoice->remarks : '-',
                    'sender_name' => auth()->user()->username
                ];
                $client = new \GuzzleHttp\Client();
                $client->request('POST', $url, [
                    'form_params' => $data
                ]);
                $invoice->spi_bpn_date = $request->received_date;
                $invoice->senttoacc_id = 1;
                $invoice->save();
            }
        } else {     // kalo user selain 000H / balikpapan
            Invoice::where('spis_id', $spi->id)->update([
                'mailroom_jkt_date' => $request->received_date
            ]);
        }

        return redirect()->route('spis.create.index')->with('success', 'SPI receive updated and invoices send to cashier');
    }

    public function index_data()
    {
        $cutoff_date = '2022-12-31';

        if(auth()->user()->role === 'SUPERADMIN') {
            $spis = Spi::whereNull('received_at')
                    ->where('date', '>', $cutoff_date) 
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
                ->where('date', '>', $cutoff_date)
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
