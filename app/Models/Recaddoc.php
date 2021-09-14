<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recaddoc extends Model
{
    use HasFactory;
    
    protected $table = 'irr5_rec_addoc';
    protected $primaryKey = 'recaddoc_id';
    protected $with = ['doctype'];
    protected $guarded = [];

    public function doctype()
    {
        return $this->belongsTo(Doctype::class, 'doctype', 'doctype_id');
    }
}
