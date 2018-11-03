<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Illuminate\Database\Eloquent\Model;
use Zend\Validator\NotEmpty;

class Meal extends Model implements FillableValidatorInterface
{

    // Mass Assignment
    protected $fillable = [
        'name',
    ];
    protected $fillableValidators = [];

    public function prepareFillableValidators(array $options = [])
    {
        $this->fillableValidators = [
            'name' => [
                'validators' => [
                    (new NotEmpty)->setMessage('Nome não pode ser vazio')
                ]
            ]
        ];
    }

    public function getFillableValidators()
    {
        return $this->fillableValidators;
    }

}
