<?php

namespace App\Http\Controllers;

use App\Models\Addoc;
use App\Models\Comment;
use App\Models\Doktam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoktamController extends Controller
{
    public function index()
    {
        return view('doktams.index');
    }

    public function index_data()
    {
        if (Auth()->user()->role === 'ADMINSITE') {
            $project = Auth()->user()->project->project_code;
            $doktams = $this->pending_doktams()->where('project', $project);
        } elseif (Auth()->user()->role === 'ADMINAPS')  {
            $doktams = $this->pending_doktams();
        } else {
            $doktams = $this->pending_doktams();
        }

        return datatables()->of($doktams)
            ->editColumn('inv_date', function ($doktams) {
                return date('d-M-Y', strtotime($doktams->inv_date));
            })
            ->addIndexColumn()
            ->addColumn('comments', function ($doktams) {
                return Comment::where('doktams_id', $doktams->id)->count();
            })
            ->addColumn('action', 'doktams.action')
            ->rawColumns(['action'])
            ->toJson();
        
    }

    public function edit($id)
    {
        $doktam = Doktam::find($id);

        return view('doktams.edit', compact('doktam'));
    }

    public function update(Request $request, $id)
    {
        $doktam = Doktam::find($id);
        $doktam->receive_date = $request->receive_date;
        $doktam->update();

        $addoc = Addoc::where('doktams_id', $id)->first();
        $addoc->docreceive = $request->receive_date;
        $addoc->update();

        return redirect()->route('doktams.index')->with('success', 'Document successfully updated!');
    }

    public function show($id)
    {
        $doktam = Doktam::with(['comments' => function ($query) {
            $query->latest();
        }])->find($id);
        
        return view('doktams.show', compact('doktam'));
        
    }

    public function post_comment(Request $request)
    {
        $doktams_id = $request->doktams_id;
        $comment = new Comment();
        $comment->doktams_id = $doktams_id;
        $comment->users_id = Auth()->user()->id;
        $comment->body = $request->body;
        $comment->save();

        return redirect()->route('doktams.show', $doktams_id);
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
