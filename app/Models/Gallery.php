<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;
     protected $fillable = [
        'image_name',
        'image',
        'status',
        'created_at',
        'deleted_at',
    ];
}
