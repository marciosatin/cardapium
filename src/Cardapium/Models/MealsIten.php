<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Illuminate\Database\Eloquent\Model;

class MealsIten extends Model implements FillableValidatorInterface
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

    public function prepareFillableValidators(array $options = [])
    {

    }

    public function getFillableValidators()
    {

    }
    
}
