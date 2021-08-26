<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'irr5_project';
    protected $fillable = ['project_code', 'project_owner', 'project_location'];
    protected $primaryKey = 'project_id';

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'project_id', 'inv_project');
    }
}
