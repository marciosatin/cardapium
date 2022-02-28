<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Cardapium\Models\Validators\NoRecordExists;
use Cardapium\Models\Validators\RecordExists;
use Illuminate\Database\Eloquent\Model;
use Laminas\Filter\StringTrim;
use Laminas\Filter\ToInt;
use Laminas\Filter\ToNull;
use Laminas\Validator\NotEmpty;

class Ingredient extends Model implements FillableValidatorInterface
{

    // Mass Assignment
    protected $fillable = [
        'name',
        'ingredient_type_id'
    ];
    protected $fillableValidators = [];

    public function ingredientTypes()
    {
        return $this->belongsTo(IngredientType::class, 'ingredient_type_id');
    }

    public function prepareFillableValidators(array $options = [])
    {
        $noRecordOpt = [
            'table' => Ingredient::class,
            'field' => 'name'
        ];

        $recordOpt = [
            'table' => IngredientType::class,
            'field' => 'id'
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
            'ingredient_type_id' => [
                'filters' => [
                    new ToInt(),
                    new ToNull(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Tipo não pode ser vazio'),
                    (new RecordExists($recordOpt))
                ]
            ]
        ];
    }

    public function getFillableValidators()
    {
        return $this->fillableValidators;
    }

}
