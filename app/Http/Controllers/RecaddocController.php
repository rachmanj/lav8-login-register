<?php

namespace App\Http\Controllers;

use App\Models\Addoc;
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
        $doktam = Doktam::create([
            'doctypes_id'   => $recaddoc->doctype,
            'document_no'   => $recaddoc->addoc_no,
            'receive_date'  => $recaddoc->addoc_recdate,
            'doktams_po_no' => $recaddoc->po_no,
            'created_by'    => Auth()->user()->username,
        ]);

        $doktams_id = $doktam->id;
        
        // mengcopy jg ke table irr5_addoc ====> Gile kaaannn !!! :D
        $addoc = new Addoc();
        $addoc->doctype = $recaddoc->doctype;
        $addoc->docnum = $recaddoc->addoc_no;
        $addoc->docreceive = $recaddoc->addoc_recdate;
        $addoc->doktams_id = $doktams_id;
        $addoc->created_by = Auth()->user()->username;
        $addoc->save();

        // mengupdate record recaddoc status copied -> 1
        $recaddoc->copied = 1;
        $recaddoc->update();

        return redirect()->route('reports.report3')->with('success', 'Data additional docs berhasil dicopy ke table doktams.');

        



    }
}
