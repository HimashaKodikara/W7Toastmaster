<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
   use SoftDeletes;
    protected $fillable = [
        'image',
        'name',
        'body',
        'created_at',
        'deleted_at',
    ];
}
