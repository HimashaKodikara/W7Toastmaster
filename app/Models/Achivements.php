<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achivements extends Model
{
    use SoftDeletes;
     protected $fillable = [
        'front_image',
        'gallery_images',
        'title',
        'body',
        'status',
        'created_at',
        'deleted_at',
    ];

    protected $casts = [
    'gallery_images' => 'array',
];
}
