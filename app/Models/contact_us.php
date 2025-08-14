<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class contact_us extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'address',
        'email',
        'phone',
        'linkedin_link',
        'instergram_link',
        'facebook_link',
        'created_at',
        'deleted_at',
    ];
}
