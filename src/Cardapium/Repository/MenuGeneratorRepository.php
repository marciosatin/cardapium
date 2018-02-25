<?php

namespace Cardapium\Repository;

use Cardapium\Models\Meal;
use Cardapium\Models\MealsIten;

/**
 * Description of MenuGeneratorRepository
 *
 * @author Marcio
 */
class MenuGeneratorRepository implements MenuGeneratorRepositoryInterface
{

    public function generate(array $params = [])
    {
        if ($params['dtInicio'] and $params['dtFim']) {

            $r = [];
            $meals = $this->getMeals();

            $j = 0;
            for ($day = strtotime($params['dtInicio']); $day <= strtotime($params['dtFim']); $day = strtotime('+1day', $day)) {

                //dia da semana string
//                $weekDay = ucfirst(gmstrftime('%A', strtotime($params['dtInicio'])));

                if (!isset($r[$day])) {
                    $r[$day] = [];
                }

                $mealsRand = array_random($meals);

                for ($i = 0; $i < 2; $i++) {
                    if (!isset($r[$day]['almoco'])) {
                        $r[$day]['almoco'] = [
                            'meal' => $mealsRand,
                        ];
                    }
                    if (!isset($r[$day]['jantar'])) {
                        $r[$day]['jantar'] = [
                            'meal' => $mealsRand,
                        ];
                    }
                }

                if ($j == 2) {
                    break;
                }

                $j++;
            }

            return $r;
        }
    }

    private function getMeals()
    {

        /*
         * select m.id meal_id, m.name meal_name, it.id ingredient_types_id from meals_itens mi
          inner join meals m on m.id = mi.meal_id
          inner join ingredients i on i.id = mi.ingredient_id
          inner join ingredient_types it on it.id = i.ingredient_type_id
          where mi.type_id = 1
          and it.id in (3,6,16,17)
          order by it.id
         */

        $meals = MealsIten::query()
                ->selectRaw('m.id meal_id, m.name meal_name, it.id ingredient_types_id')
                ->join('meals as m', 'm.id', '=', 'meals_itens.meal_id')
                ->join('ingredients as i', 'i.id', '=', 'meals_itens.ingredient_id')
                ->join('ingredient_types as it', 'it.id', '=', 'i.ingredient_type_id')
                ->where('meals_itens.type_id', 1)
                ->whereIn('it.id', [3, 6, 16, 17])
                ->orderBy('it.id')
                ->get();

        return $meals->toArray();
    }

}
