<?php

namespace Cardapium\Repository;

use Cardapium\Models\MenuItem;

/**
 * Description of ShoppingListRepository
 *
 * @author Marcio
 */
class ShoppingListRepository implements ShoppingListRepositoryInterface
{

    public function all(string $dtInicio, string $dtFim, int $menuId): array
    {
        /*
         * select i.id, i.name, sum(mit.quantity) as quantidade
          from menu_items as mi
          inner join meals_itens mit on mit.meal_id = mi.meal_id
          inner join ingredients i on i.id = mit.ingredient_id
          where dt_week between '2017-10-20' and '2017-10-31'
          group by i.id
          order by i.name
          ;
         */

        $shoppingList = MenuItem::query()
                ->selectRaw('ingredients.id, ingredients.name')
                ->join('meals_itens', 'meals_itens.meal_id', '=', 'menu_items.meal_id')
                ->join('ingredients', 'ingredients.id', '=', 'meals_itens.ingredient_id')
                ->whereBetween('dt_week', [$dtInicio, $dtFim])
                ->where('menu_items.menu_id', $menuId)
                ->groupBy('ingredients.id')
                ->orderBy('ingredients.name')
                ->get();

        return $shoppingList->toArray();
    }

}
