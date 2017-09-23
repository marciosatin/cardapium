<?php

namespace Cardapium\Models;

use Illuminate\Database\Eloquent\Model;

class MealItem extends Model
{

    // Mass Assignment
    protected $fillable = [
        'ingredient_id',
        'state_id',
        'type_id',
        'quantity',
    ];

    
}
