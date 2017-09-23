<?php

namespace Cardapium\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    // Mass Assignment
    protected $fillable = [
        'id',
        'name',
    ];

}
