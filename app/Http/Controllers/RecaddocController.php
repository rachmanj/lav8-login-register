<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use App\Models\Recaddoc;
use Illuminate\Http\Request;

class RecaddocController extends Controller
{
    public function copy_to_doktams(Request $request)
    {
        $recaddoc_id = $request->recaddoc_id;
        $recaddoc = Recaddoc::find($recaddoc_id);

        // membuat record doktam baru
        $doktam = new Doktam();
        $doktam->doctypes_id = $recaddoc->doctype;
        $doktam->document_no = $recaddoc->addoc_no;
        $doktam->receive_date = $recaddoc->addoc_recdate;
        $doktam->doktams_po_no = $recaddoc->po_no;
        $doktam->created_by = Auth()->user()->username;
        $doktam->save();

        // mengupdate record recaddoc status copied -> 1
        $recaddoc->copied = 1;
        $recaddoc->update();

        return redirect()->route('reports.report3')->with('success', 'Data additional docs berhasil dicopy ke table doktams.');

        



    }
}
