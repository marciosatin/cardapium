<?php

declare(strict_types = 1);

namespace Cardapium\Plugins;

use Cardapium\Models\IngredientType;
use Cardapium\Models\User;
use Cardapium\Repository\RepositoryFactory;
use Cardapium\ServiceContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Interop\Container\ContainerInterface;

class DbPlugin implements PluginInterface
{

    public function register(ServiceContainerInterface $container)
    {
        $capsule = new Capsule();
        $config = include __DIR__ . '/../../../config/db.php';
        $capsule->addConnection($config['default_connection']);
        $capsule->bootEloquent();

        $container->add('repository.factory', new RepositoryFactory());
        $container->addLazy('user.repository', function (ContainerInterface $container) {
            return $container->get('repository.factory')->factory(User::class);
        });
        $container->addLazy('ingredient-type.repository', function (ContainerInterface $container) {
            return $container->get('repository.factory')->factory(IngredientType::class);
        });
    }

}
