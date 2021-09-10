<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoicetype extends Model
{
    use HasFactory;

    protected $table = 'irr5_invtype';
    protected $primaryKey = 'invtype_id';
}
