<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class DocumentPendingExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $date = Carbon::now();
        $documents = $this->pending_doktams();

        return view('doktams.pendings_export', compact('documents', 'date'));
    }

    public function pending_doktams()
    {
        $date = '2021-01-01';

        $list = DB::table('doktams')
                ->join('irr5_invoice', 'doktams.invoices_id', '=', 'irr5_invoice.inv_id')
                ->join('irr5_doctype', 'doktams.doctypes_id', '=', 'irr5_doctype.doctype_id')
                ->join('irr5_project', 'irr5_invoice.inv_project', '=', 'irr5_project.project_id')
                ->join('irr5_vendor', 'irr5_invoice.vendor_id', '=', 'irr5_vendor.vendor_id')
                ->select(
                    'doktams.id',
                    'doktams.document_no',
                    'irr5_doctype.docdesc as doctype',
                    'irr5_invoice.inv_no',
                    'irr5_invoice.inv_id',
                    'irr5_invoice.po_no',
                    'irr5_vendor.vendor_name as vendor',
                    'irr5_invoice.receive_date as inv_date', 
                    'irr5_project.project_code as project',
                    DB::raw("datediff(curdate(), irr5_invoice.receive_date) as days")
                )
                ->whereNull('doktams.receive_date')
                ->whereYear('inv_date', '>=', $date)
                // ->orderBy('doctype', 'asc')
                ->orderBy('days', 'desc')
                ->orderBy('project', 'asc')
                ->get();
                
                return $list;
    }
}
