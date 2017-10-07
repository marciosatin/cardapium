<?php

declare(strict_types = 1);

namespace Cardapium\Plugins;

use Cardapium\Models\Ingredient;
use Cardapium\Models\IngredientType;
use Cardapium\Models\Meal;
use Cardapium\Models\MealsIten;
use Cardapium\Models\Menu;
use Cardapium\Models\MenuItem;
use Cardapium\Models\State;
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
        $container->addLazy('ingredient.repository', function (ContainerInterface $container) {
            return $container->get('repository.factory')->factory(Ingredient::class);
        });
        $container->addLazy('ingredient-type.repository', function (ContainerInterface $container) {
            return $container->get('repository.factory')->factory(IngredientType::class);
        });
        $container->addLazy('state.repository', function (ContainerInterface $container) {
            return $container->get('repository.factory')->factory(State::class);
        });
        $container->addLazy('meal.repository', function (ContainerInterface $container) {
            return $container->get('repository.factory')->factory(Meal::class);
        });
        $container->addLazy('meal-item.repository', function (ContainerInterface $container) {
            return $container->get('repository.factory')->factory(MealsIten::class);
        });
        $container->addLazy('menu.repository', function (ContainerInterface $container) {
            return $container->get('repository.factory')->factory(Menu::class);
        });
        $container->addLazy('menu-item.repository', function (ContainerInterface $container) {
            return $container->get('repository.factory')->factory(MenuItem::class);
        });
    }

}
