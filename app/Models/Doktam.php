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

    public function spi()
    {
        return $this->belongsTo(Invoice::class, 'invoices_id')
            ->join('spis', 'spis.id', '=', 'irr5_invoice.spis_id');
    }

    protected static function boot()
    {
        parent::boot();
        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = auth()->user()->username;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->username;
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->username;
            }
        });
    }
}
