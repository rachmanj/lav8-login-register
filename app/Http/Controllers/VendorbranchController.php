<?php

namespace App\Http\Controllers;

use App\Models\Vendorbranch;
use Illuminate\Http\Request;

class VendorbranchController extends Controller
{
    public function get_branch_by_vendor_id(Request $request)
    {
        if(!$request->vendor_id) {
            $html = '<option value="">-- pilih cabang --<option>';
        } else {
            $html = '';
            $branches = Vendorbranch::where('vendor_id', $request->vendor_id)->get();
            foreach ($branches as $branch) {
                $html .= '<option value="' .$branch->id. '">'.$branch->branch.'</option>';
            }
        }

        return response()->json(['html' => $html]);
    }


}
