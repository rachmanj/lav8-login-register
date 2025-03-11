<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    use HasFactory;

    protected $table = 'irr5_followup';
    protected $primaryKey = 'fol_id';
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'inv_id', 'inv_id');
    }
}
