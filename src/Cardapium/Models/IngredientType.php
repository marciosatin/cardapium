<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Cardapium\Models\Validators\NoRecordExists;
use Illuminate\Database\Eloquent\Model;
use Zend\Filter\StringTrim;
use Zend\Filter\ToNull;
use Zend\Validator\NotEmpty;

class IngredientType extends Model implements FillableValidatorInterface
{

    // Mass Assignment
    protected $fillable = [
        'id',
        'name',
    ];
    protected $fillableValidators = [];

    public function getFillableValidators()
    {
        return $this->fillableValidators;
    }

    public function prepareFillableValidators(array $options = [])
    {
        $noRecordOpt = [
            'table' => IngredientType::class,
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
                    new NoRecordExists($noRecordOpt)
                ]
            ]
        ];
    }

}
