<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Cardapium\Models\Validators\NoRecordExists;
use Illuminate\Database\Eloquent\Model;
use Laminas\Filter\StringTrim;
use Laminas\Filter\ToNull;
use Laminas\Validator\NotEmpty;

class Meal extends Model implements FillableValidatorInterface
{

    // Mass Assignment
    protected $fillable = [
        'name',
        'meal_recipe_link',
    ];
    protected $fillableValidators = [];

    public function prepareFillableValidators(array $options = [])
    {
        $noRecordOpt = [
            'table' => Meal::class,
            'field' => 'name'
        ];

        if (isset($options['idExclude'])) {
            $noRecordOpt['exclude'] = [
                'excludeField' => 'id',
                'excludeValue' => (int) $options['idExclude']
            ];
        }
        $this->fillableValidators = [
            'name' => [
                'filters' => [
                    new ToNull(),
                    new StringTrim(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Nome não pode ser vazio'),
                    (new NoRecordExists($noRecordOpt))
                ]
            ],
            'meal_recipe_link' => [
                'filters' => [
                    new ToNull(),
                    new StringTrim(),
                ]
            ]
        ];
    }

    public function getFillableValidators()
    {
        return $this->fillableValidators;
    }

}
