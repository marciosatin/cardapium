<?php

$app->get(
        '/error404', function() use($app) {
    $view = $app->service('view.renderer');
    return $view->render('error/404.html.twig');
}, 'error.404');
