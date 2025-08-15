<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
   use SoftDeletes;
     protected $fillable = [
        'main_image',
        'gallery_images',
        'topic',
        'description',
        'status',
        'created_at',
        'deleted_at',
    ];

    protected $casts = [
    'gallery_images' => 'array',
];
}
