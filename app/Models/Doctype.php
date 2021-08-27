<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctype extends Model
{
    use HasFactory;

    protected $table = 'irr5_doctype';
    protected $primaryKey = 'doctype_id';
}
