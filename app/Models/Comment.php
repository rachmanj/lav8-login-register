<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $with = ['user'];
    protected $fillable = ['doktams_id', 'users_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

}
