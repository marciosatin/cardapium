<?php

namespace Cardapium\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientType extends Model
{

    // Mass Assignment
    protected $fillable = [
        'id',
        'name',
    ];

}
