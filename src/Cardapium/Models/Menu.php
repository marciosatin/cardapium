<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Illuminate\Database\Eloquent\Model;
use Zend\Filter\StringTrim;
use Zend\Filter\ToInt;
use Zend\Filter\ToNull;
use Zend\Validator\InArray;
use Zend\Validator\NotEmpty;

class Menu extends Model implements FillableValidatorInterface
{

    const MENSAL = 1;
    const SEMANAL = 2;

    // Mass Assignment
    protected $fillable = [
        'name',
        'type_id',
        'dt_start',
        'dt_end',
    ];
    protected $fillableValidators = [];

    public function getFillableValidators()
    {
        return $this->fillableValidators;
    }

    public function prepareFillableValidators(array $options = [])
    {
        $this->fillableValidators = [
            'name' => [
                'filters' => [
                    new ToNull(),
                    new StringTrim(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Nome não pode ser vazio')
                ]
            ],
            'type_id' => [
                'filters' => [
                    new ToInt(),
                    new ToNull(),
                ],
                'validators' => [
                    (new InArray(['haystack' => array_keys(self::getTypes())]))
                            ->setMessage('Tipo não esperado')
                ]
            ],
            'dt_start' => [
                'filters' => [
                    new ToNull(),
                    new StringTrim(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Data inicial não pode ser vazio')
                ]
            ],
            'dt_end' => [
                'filters' => [
                    new ToNull(),
                    new StringTrim(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Data final não pode ser vazio')
                ]
            ],
        ];
    }

    public static function getTypes()
    {
        return [
            self::MENSAL => 'Mensal',
            self::SEMANAL => 'Semanal'
        ];
    }

}
