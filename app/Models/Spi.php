<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spi extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['to_project'];

    public function to_project()
    {
        return $this->belongsTo(Project::class, 'to_projects_id', 'project_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'spis_id', 'id');
    }

    public function doktams()
    {
        return $this->hasMany(Doktam::class, 'spi_id', 'id');
    }

}
