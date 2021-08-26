<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addoc extends Model
{
    use HasFactory;

    protected $table = 'irr5_addoc';
    protected $primaryKey = 'addoc_id';
    protected $with = ['invoice', 'addoctype'];
    protected $guarded = [];

    public function addoctype()
    {
        return $this->belongsTo(Doctype::class, 'doctype', 'doctype_id');
    }

    // public function invoice()
    // {
    //     return $this->belongsTo(Invoice::class, 'inv_id', 'inv_id');
    // }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'inv_id', 'inv_id');
    }
}
