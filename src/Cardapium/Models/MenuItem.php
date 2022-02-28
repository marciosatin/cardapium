<?php

namespace Cardapium\Models;

use Cardapium\Models\Validators\FillableValidatorInterface;
use Cardapium\Models\Validators\RecordExists;
use Illuminate\Database\Eloquent\Model;
use Laminas\Filter\StringTrim;
use Laminas\Filter\ToInt;
use Laminas\Filter\ToNull;
use Laminas\Validator\InArray;
use Laminas\Validator\NotEmpty;

class MenuItem extends Model implements FillableValidatorInterface
{
    const TYPE_ALMOCO = 1;
    const TYPE_JANTAR = 2;
    const TYPE_CAFE_MANHA = 3;
    const TYPE_CAFE_TARDE = 4;

    // Mass Assignment
    protected $fillable = [
        'dt_week',
        'meal_split_id',
        'meal_id',
        'menu_id',
    ];

    private static $types = [
        self::TYPE_ALMOCO => 'Almoço',
        self::TYPE_JANTAR => 'Jantar',
        self::TYPE_CAFE_MANHA => 'Café da manhã',
        self::TYPE_CAFE_TARDE => 'Café da tarde',
    ];
    protected $fillableValidators = [];

    public static function getTypes()
    {
        return self::$types;
    }

    public function meals()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }

    public function prepareFillableValidators(array $options = [])
    {
        $this->fillableValidators = [
            'meal_split_id' => [
                'filters' => [
                    new ToInt(),
                    new ToNull(),
                ],
                'validators' => [
                    (new InArray(['haystack' => array_keys(self::getTypes())]))
                            ->setMessage('Tipo não esperado')
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
            'menu_id' => [
                'filters' => [
                    new ToInt(),
                    new ToNull(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Menu não pode ser vazio'),
                    new RecordExists([
                        'table' => Menu::class,
                        'field' => 'id'
                            ]),
                ]
            ],
            'dt_week' => [
                'filters' => [
                    new ToNull(),
                    new StringTrim(),
                ],
                'validators' => [
                    (new NotEmpty)->setMessage('Dia não pode ser vazio')
                ]
            ]
        ];
    }

    public function getFillableValidators()
    {
        return $this->fillableValidators;
    }
    
}
