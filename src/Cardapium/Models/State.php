<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Illuminate\Database\Eloquent\Model;

class State extends Model implements FillableValidatorInterface
{

    // Mass Assignment
    protected $fillable = [
        'id',
        'name',
    ];

    public function prepareFillableValidators(array $options = [])
    {

    }

    public function getFillableValidators()
    {

    }

}
