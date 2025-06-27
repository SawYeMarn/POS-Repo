<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actionlog extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'action',
    ];
}
