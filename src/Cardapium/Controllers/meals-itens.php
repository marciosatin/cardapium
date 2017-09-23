<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get('/meals-itens/{id}/add', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = $request->getAttribute('id');
            $repository = $app->service('meal.repository');
            $meal = $repository->findOneBy([
                'id' => $id,
            ]);
            return $view->render('meals-itens/add.html.twig', [
                        'meal' => $meal
            ]);
        }, 'meals-itens.add')
        ->post('/meals-itens/store', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $repository = $app->service('meal-item.repository');
            $model = $repository->create($data);
            return $app->redirect('/meals-itens/' . $model->id . '/add');
        }, 'meals-itens.store');

