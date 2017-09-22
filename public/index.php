<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
    $dotenv->overload();
}
require_once __DIR__ . '/../src/helpers.php';

use Cardapium\Application;
use Cardapium\Plugins\AuthPlugin;
use Cardapium\Plugins\DbPlugin;
use Cardapium\Plugins\RoutePlugin;
use Cardapium\Plugins\ViewPlugin;
use Cardapium\ServiceContainer;
use Psr\Http\Message\RequestInterface;

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());
$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

$app->get('/', function(RequestInterface $request) use ($app) {
    return $app->redirect('/users');
});

require_once __DIR__ . '/../src/Cardapium/Controllers/users.php';
require_once __DIR__ . '/../src/Cardapium/Controllers/auth.php';
require_once __DIR__ . '/../src/Cardapium/Controllers/ingredient-types.php';
require_once __DIR__ . '/../src/Cardapium/Controllers/ingredients.php';

$app->start();
