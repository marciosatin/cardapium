<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Cardapium\Models\Validators\NoRecordExists;
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
                'validators' => [
                    (new NotEmpty)->setMessage('Nome não pode ser vazio'),
                    (new NoRecordExists($noRecordOpt))
                ]
            ]
        ];
    }

    public function getFillableValidators()
    {
        return $this->fillableValidators;
    }

}
