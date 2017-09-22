<?php

namespace Cardapium\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{

    // Mass Assignment
    protected $fillable = [
        'name',
        'ingredient_type_id'
    ];

    public function ingredientTypes()
    {
        return $this->belongsTo(IngredientType::class, 'ingredient_type_id');
    }

}
