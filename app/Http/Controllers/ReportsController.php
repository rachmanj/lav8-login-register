<?php

namespace App\Http\Controllers;

use App\Models\Doktam;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }
     
    public function report1() // 
    {
        return view('reports.report1');
    }

    public function report1_data()
    {
        $doktams = Doktam::whereNull('invoices_id')->get();

        return $doktams;
        
    }
}
