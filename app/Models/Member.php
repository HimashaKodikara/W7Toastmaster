<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'image',
        'name',
        'testimonial',
        'status',
        'linkedin_link',
        'instergram_link',
        'created_at',
        'deleted_at',
    ];
}
