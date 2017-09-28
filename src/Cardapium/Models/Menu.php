<?php

namespace Cardapium\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    // Mass Assignment
    protected $fillable = [
        'name',
        'type_id',
        'dt_start',
        'dt_end',
    ];

}
