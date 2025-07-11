<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [

        'user_id',
        'title',
        'message',
    ];

    // Define any relationships or additional methods if needed
}
