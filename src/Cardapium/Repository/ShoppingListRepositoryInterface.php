<?php

declare(strict_types = 1);

namespace Cardapium\Repository;

/**
 *
 * @author Marcio
 */
interface ShoppingListRepositoryInterface
{
    public function all(string $dtInicio, string $dtFim, int $menuId) : array;
}
