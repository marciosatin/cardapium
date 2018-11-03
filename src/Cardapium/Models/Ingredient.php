<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model implements FillableValidatorInterface
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

    public function prepareFillableValidators(array $options = [])
    {

    }

    public function getFillableValidators()
    {

    }

}
