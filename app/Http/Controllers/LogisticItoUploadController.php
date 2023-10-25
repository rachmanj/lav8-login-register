<?php

namespace App\Http\Controllers;

use App\Imports\ItoImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Doktam;

class LogisticItoUploadController extends Controller
{
    public function index()
    {
        $itos_count = Doktam::where('created_by', 'uploaded')
            ->orderBy('created_at', 'desc')
            ->where('flag', 'UPLOAD-TEMP-' . auth()->user()->id)
            ->count();

        return view('logistic.ito-upload.index', compact('itos_count'));
    }

    public function addtodb()
    {
        $doktams = Doktam::where('flag', 'UPLOAD-TEMP-' . auth()->user()->id)->get();

        foreach ($doktams as $doktam) {
            $doktam->flag = null;
            $doktam->save();
        }

        return redirect()->route('logistic.ito-upload.index')->with('success', 'Records successfuly add to the database!');
    }

    public function undo()
    {
        Doktam::where('flag', 'UPLOAD-TEMP-' . auth()->user()->id)->delete();

        return redirect()->route('logistic.ito-upload.index')->with('success', 'Records successfuly deleted from the database!');
    }

    /**
     * Uploads a file and imports data from it.
     * and check if the ito already exists is_duplicate wwill set to true
     * if exist (records that is_duplicate is true) then will be deleted
     */
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

        // upload ke folder ito_upload
        $file->move('ito_upload', $nama_file);

        // import data
        Excel::import(new ItoImport, public_path('/ito_upload/' . $nama_file));

        // cek apakah ada data yang duplikat
        $duplicates_count = Doktam::where('is_duplicate', true)->count();

        if ($duplicates_count > 0) {
            // delete duplicate data
            Doktam::where('is_duplicate', true)->delete();

            return redirect()->route('logistic.ito-upload.index')->with('error', $duplicates_count . ' Data already exists and deleted!');
        } else {
            // alihkan halaman kembali
            return redirect()->route('logistic.ito-upload.index')->with('success', 'Data successfuly uploaded!');
        }

    }

    public function data()
    {
        $itos = Doktam::where('created_by', 'uploaded')
            ->orderBy('created_at', 'desc')
            ->where('flag', 'UPLOAD-TEMP-' . auth()->user()->id)
            ->limit(100)
            ->get();

        return datatables()->of($itos)
            ->addColumn('source', function ($ito) {
                return $ito->userLogistic->username;
            })
            ->addColumn('status', function ($ito) {
                return "<span class='badge badge-warning'>Just Uploaded</span>";
            })
            ->addColumn('project', function ($ito) {
                return $ito->project->project_code;
            })
            ->addIndexColumn()
            // ->addColumn('action', 'logistic.ito-upload.action')
            ->rawColumns(['status'])
            ->toJson();
    }
}
