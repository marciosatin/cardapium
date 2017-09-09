<?php

namespace Cardapium\Repository;

class RepositoryFactory
{

    public static function factory(string $modelClass)
    {
        return new DefaultRepository($modelClass);
    }

}
