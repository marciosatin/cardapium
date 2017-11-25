<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get('/meals-itens/{id}/add', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = (int) $request->getAttribute('id');
            $repository = $app->service('meal.repository');
            $repositoryI = $app->service('ingredient.repository');
            $repositoryS = $app->service('state.repository');
            $meal = $repository->findOneBy([
                'id' => $id,
            ]);

            $types = [
                ['id' => 1, 'name' => 'Principal'],
                ['id' => 2, 'name' => 'Acompanhamento'],
                ['id' => 3, 'name' => 'Salada'],
                ['id' => 4, 'name' => 'Legume']
            ];

            $repositoryItem = $app->service('meal-item.repository');
            $items = $repositoryItem->findByField('meal_id', $meal->id);

            return $view->render('meals-itens/add.html.twig', [
                        'meal' => $meal,
                        'ingredients' => $repositoryI->all(),
                        'states' => $repositoryS->all(),
                        'types' => $types,
                        'items' => $items
            ]);
        }, 'meals-itens.add')
        ->post('/meals-itens/store', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $repository = $app->service('meal-item.repository');
            $model = $repository->create($data);
            return $app->redirect('/meals-itens/' . $model->meal_id . '/add');
        }, 'meals-itens.store')
        ->get('/meals-itens/{id}/show', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = (int) $request->getAttribute('id');
            $repository = $app->service('meal-item.repository');
            $mealItem = $repository->findOneBy([
                'id' => $id,
            ]);
            return $view->render('meals-itens/show.html.twig', [
                        'item' => $mealItem
            ]);
        }, 'meals-itens.show')
        ->get('/meals-itens/{id}/delete', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('meal-item.repository');
            $id = (int) $request->getAttribute('id');

            $mealItem = $repository->findOneBy([
                'id' => $id,
            ]);

            $mealId = $mealItem->meal_id;

            $repository->delete([
                'id' => $mealItem->id,
            ]);
            return $app->redirect('/meals-itens/' . $mealId . '/add');
        }, 'meals-itens.delete')
        ->post('/meals-itens/del', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $repository = $app->service('meal-item.repository');

            $ids = explode(',', $data['id']);

            foreach ($ids as $id) {
                $repository->delete([
                    'id' => (int) $id,
                ]);
            }

            return $app->json(['response' => 'ok']);
        }, 'meals-itens.del');

