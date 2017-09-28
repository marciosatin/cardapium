<?php

namespace Cardapium\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{

    // Mass Assignment
    protected $fillable = [
        'dt_week',
        'meal_split_id',
        'meal_id',
    ];

    public function meals()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }
    
}
