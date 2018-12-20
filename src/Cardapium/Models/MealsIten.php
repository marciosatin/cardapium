<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Cardapium\Models\Validators\RecordExists;
use Illuminate\Database\Eloquent\Model;
use Zend\Filter\ToInt;
use Zend\Filter\ToNull;
use Zend\Validator\GreaterThan;
use Zend\Validator\InArray;
use Zend\Validator\NotEmpty;

class MealsIten extends Model implements FillableValidatorInterface
{

    const TYPE_PRINCIPAL = 1;
    const TYPE_ACOMPANHAMENTO = 2;
    const TYPE_SALADA = 3;
    const TYPE_LEGUME = 4;

    // Mass Assignment
    protected $fillable = [
        'ingredient_id',
        'state_id',
        'type_id',
        'meal_id',
        'quantity',
    ];
    protected $fillableValidators;
    protected static $types = array(
        self::TYPE_PRINCIPAL => 'Principal',
        self::TYPE_ACOMPANHAMENTO => 'Acompanhamento',
        self::TYPE_SALADA => 'Salada',
        self::TYPE_LEGUME => 'Legume',
    );

    public static function getTypes()
    {
        return self::$types;
    }

    public function ingredients()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }

    public function states()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function prepareFillableValidators(array $options = [])
    {
        $this->fillableValidators = [
            'ingredient_id' => [
                'filters' => [
                    new ToInt(),
                    new ToNull(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Tipo de ingrediente não pode ser vazio'),
                    new RecordExists([
                        'table' => Ingredient::class,
                        'field' => 'id'
                            ]),
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
            'state_id' => [
                'filters' => [
                    new ToInt(),
                    new ToNull(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Estado não pode ser vazio'),
                    new RecordExists([
                        'table' => State::class,
                        'field' => 'id'
                            ]),
                ]
            ],
            'meal_id' => [
                'filters' => [
                    new ToInt(),
                    new ToNull(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Refeição não pode ser vazio'),
                    new RecordExists([
                        'table' => Meal::class,
                        'field' => 'id'
                            ]),
                ]
            ],
            'quantity' => [
                'filters' => [
                    new ToInt(),
                    new ToNull(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Quantidade não pode ser vazio'),
                    (new GreaterThan(0))->setMessage('Quantidade deve ser maior que 0'),
                ]
            ],
        ];
    }

    public function getFillableValidators()
    {
        return $this->fillableValidators;
    }

}
