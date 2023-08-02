<?php

namespace App\Http\Controllers;

use App\Imports\ReconcileDetailImport;
use App\Exports\ReconcileExport;
use App\Models\ReconcileDetail;
use App\Models\Reconcile;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ReportsReconcileController extends Controller
{
    public function index()
    {
        $reconciles = $this->getReconcileData();
        
        return view('reports.reconcile.index', compact('reconciles'));
                
    }

    public function upload(Request $request)
    {
        // validasi
        $this->validate($request, [
            // 'vendor_id' => 'required',
            'file_upload' => 'required|mimes:xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file_upload');

        // membuat nama file unik
        $nama_file = rand() . '_' . $file->getClientOriginalName();

        // upload ke folder file_upload
        $file->move('file_upload', $nama_file);

        // import data
        Excel::import(new ReconcileDetailImport, public_path('/file_upload/' . $nama_file));

        // UPDATE FLAG FIELD
        $temp_flag = 'TEMP' . auth()->user()->id;

        ReconcileDetail::where('flag', $temp_flag)->update([
            'vendor_id' => $request->vendor_id,
            'flag' => null
        ]);

        // alihkan halaman kembali
        return redirect()->route('reports.reconcile.index')->with('success', 'Data successfuly uploaded!');
    }

    public function delete_mine()
    {
        $reconciles = ReconcileDetail::where('user_id', auth()->user()->id);
        $reconciles->delete();

        // alihkan halaman kembali
        return redirect()->route('reports.reconcile.index')->with('success', 'Data successfuly deleted!');
    }

    public function export()
    {
        return Excel::download(new ReconcileExport(), 'reconcile_soa.xlsx');
    }

    public function data()
    {
        $reconciles = ReconcileDetail::orderBy('created_at', 'desc')
                ->where('user_id', auth()->user()->id)
                ->get();

        return datatables()->of($reconciles)
            ->addColumn('receive_date', function ($reconcile) {
                $invoice = $this->getInvoiceIrr($reconcile->invoice_no);
                if ($invoice) {
                    return date('d-M-Y', strtotime($invoice->receive_date));
                }
                return null; 
            })
            ->addColumn('vendor_name', function ($reconcile) {
                $invoice = $this->getInvoiceIrr($reconcile->invoice_no);
                if ($invoice) {
                    return $invoice->vendor->vendor_name; 
                }
                return null;
            })
            ->addColumn('amount', function ($reconcile) {
                $invoice = $this->getInvoiceIrr($reconcile->invoice_no);
                if ($invoice) {
                    return number_format($invoice->inv_nominal, 2); 
                }
                return null;
            })
            ->addColumn('spi_no', function ($reconcile) {
                $invoice = $this->getInvoiceIrr($reconcile->invoice_no);
                if ($invoice) {
                    return $invoice->spis_id !== null ? $invoice->spi->nomor : null;
                } 
                return null;
            })
            ->addColumn('spi_date', function ($reconcile) {
                $invoice = $this->getInvoiceIrr($reconcile->invoice_no);
                if ($invoice) {
                    return $invoice->spis_id !== null ? date('d-M-Y', strtotime($invoice->spi->date)) : null;
                } 
                return null;
            })
            ->addIndexColumn()
            ->toJson();
    }

    public function getInvoiceIrr($invoice_no)
    {
        return Invoice::where('inv_no', 'LIKE', '%' . $invoice_no . '%')->first();  
    }

    public function getReconcileData()
    {
        $reconciles = ReconcileDetail::orderBy('created_at', 'desc')
            ->where('user_id', auth()->user()->id)
            ->get();

        foreach ($reconciles as $reconcile) {
            $invoice = Invoice::where('inv_no', 'LIKE', '%' . $reconcile->invoice_no . '%')->first();

            if ($invoice) {
                $reconcile['invoice_irr'] = $invoice->inv_no;
                $reconcile['vendor'] = $invoice->vendor->vendor_name;
                $reconcile['receive_date'] = $invoice->receive_date;
                $reconcile['amount'] = $invoice->inv_nominal;
                $reconcile['spi_no'] = $invoice->spis_id ? $invoice->spi->nomor : null;
                $reconcile['spi_date'] = $invoice->spis_id ? $invoice->spi->date : null;
            } else {
                $reconcile['invoice_irr'] = null;
                $reconcile['receive_date'] = null;
                $reconcile['amount'] = null;
                $reconcile['spi_no'] = null;
                $reconcile['spi_date'] = null;
            }
        };

        return $reconciles;
    }
}
