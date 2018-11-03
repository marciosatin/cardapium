<?php

namespace Cardapium\Models;

use Illuminate\Database\Eloquent\Model;
use Cardapium\Models\Validators\FillableValidatorInterface;

class MenuItem extends Model implements FillableValidatorInterface
{

    // Mass Assignment
    protected $fillable = [
        'dt_week',
        'meal_split_id',
        'meal_id',
        'menu_id',
    ];

    public function meals()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }

    public function prepareFillableValidators(array $options = [])
    {

    }

    public function getFillableValidators()
    {

    }
    
}
