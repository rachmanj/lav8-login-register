<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doktam extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['doctype'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function doctype()
    {
        return $this->belongsTo(doctype::class, 'doctypes_id', 'doctype_id');
    }
}
