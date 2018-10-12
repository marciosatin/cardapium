<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Illuminate\Database\Eloquent\Model;

class IngredientType extends Model implements FillableValidatorInterface
{

    // Mass Assignment
    protected $fillable = [
        'id',
        'name',
    ];
    public function getFillableValidators()
    {
        
    }

    public function prepareFillableValidators()
    {

    }

}
