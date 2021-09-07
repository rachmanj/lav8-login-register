<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doktam extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['doctype', 'invoice'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoices_id', 'inv_id');
    }

    public function doctype()
    {
        return $this->belongsTo(Doctype::class, 'doctypes_id', 'doctype_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'doktams_id', 'id');
    }
}
