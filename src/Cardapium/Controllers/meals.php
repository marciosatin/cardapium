<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get('/meals', function() use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('meal.repository');
            $meals = $repository->all();
            return $view->render('meals/list.html.twig', [
                        'meals' => $meals
            ]);
        }, 'meals.list')
        ->get('/meals/new', function() use($app) {
            $view = $app->service('view.renderer');
            $mealRepo = $app->service('meal.repository');
            $meals = $mealRepo->all();
            return $view->render(
                            'meals/create.html.twig', [
                        'meals' => $meals
            ]);
        }, 'meals.new')
        ->post('/meals/store', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $repository = $app->service('meal.repository');
            $model = $repository->create($data);
            return $app->redirect('/meals-itens/' . $model->id . '/add');
        }, 'meals.store')
        ->get('/meals/{id}/edit', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('meal.repository');
            $id = $request->getAttribute('id');
            $meal = $repository->findOneBy([
                'id' => $id,
            ]);
            $mealRepo = $app->service('meal-meal.repository');
            $meals = $mealRepo->all();
            return $view->render(
                            'meals/edit.html.twig', [
                        'meal' => $meal,
                        'meals' => $meals
                            ]
            );
        }, 'meals.edit')
        ->post('/meals/{id}/update', function(ServerRequestInterface $request) use($app) {
            $id = $request->getAttribute('id');
            $data = $request->getParsedBody();

            $repository = $app->service('meal.repository');
            $repository->update([
                'id' => $id,
                    ], $data);

            return $app->redirect('/meals');
        }, 'meals.update')
        ->get('/meals/{id}/show', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = $request->getAttribute('id');
            $repository = $app->service('meal.repository');
            $meal = $repository->findOneBy([
                'id' => $id,
            ]);
            return $view->render('meals/show.html.twig', [
                        'meal' => $meal
            ]);
        }, 'meals.show')
        ->get('/meals/{id}/delete', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('meal.repository');
            $id = $request->getAttribute('id');
            $repository->delete([
                'id' => $id,
            ]);
            return $app->route('meals.list');
        }, 'meals.delete');
