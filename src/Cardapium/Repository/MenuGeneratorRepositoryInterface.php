<?php

declare(strict_types = 1);

namespace Cardapium\Repository;

/**
 *
 * @author Marcio
 */
interface MenuGeneratorRepositoryInterface
{
    public function generate(array $params = []);
}
