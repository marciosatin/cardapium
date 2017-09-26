<?php

namespace Cardapium\Models;

use Illuminate\Database\Eloquent\Model;

class MealsIten extends Model
{

    // Mass Assignment
    protected $fillable = [
        'ingredient_id',
        'state_id',
        'type_id',
        'meal_id',
        'quantity',
    ];

    public function ingredients()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }

    public function states()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    
}
