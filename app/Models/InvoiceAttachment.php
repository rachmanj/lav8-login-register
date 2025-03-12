<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceAttachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    /**
     * Get the invoice that owns the attachment.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'inv_id', 'inv_id');
    }
}
