<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'irr5_invoice';
    protected $primaryKey = 'inv_id';
    protected $with = ['project', 'vendor', 'invtype'];

    public function addocs()
    {
        return $this->hasMany(Addoc::class, 'inv_id', 'inv_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'inv_project', 'project_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'vendor_id');
    }

    public function vendorbranch()
    {
        return $this->belongsTo(Vendorbranch::class, 'vendor_branch', 'id');
    }

    public function doktams()
    {
        return $this->hasMany(Doktam::class, 'invoices_id', 'inv_id');
    }

    public function invtype()
    {
        return $this->belongsTo(Invoicetype::class, 'inv_type', 'invtype_id');
    }

    public function doktams_by_po()
    {
        // return $this->hasMany(Doktam::class, 'po_no', 'doktams_po_no');
        return $this->hasMany(Doktam::class, 'doktams_po_no', 'po_no');
    }

    public function doktams_null()
    {
        return $this->hasMany(Doktam::class, 'invoices_id', 'inv_id')->whereNull('receive_date');
    }
}
