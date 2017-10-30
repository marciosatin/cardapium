<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get('/menu-items/{id}/add', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = (int) $request->getAttribute('id');
            $repository = $app->service('menu.repository');
            $repositoryI = $app->service('meal.repository');
            $menu = $repository->findOneBy([
                'id' => $id,
            ]);

            $types = [
                1 => 'Almoço',
                2 => 'Jantar',
                3 => 'Café da manhã',
                4 => 'Café da tarde'
            ];

            $repositoryItem = $app->service('menu-item.repository');
            $items = $repositoryItem->findByField('menu_id', $menu->id);

            return $view->render('menu-items/add.html.twig', [
                        'menu' => $menu,
                        'meals' => $repositoryI->all(),
                        'meal_splits' => $types,
                        'items' => $items
            ]);
        }, 'menu-items.add')
        ->post('/menu-items/store', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $data['dt_week'] = dateParse($data['dt_week']);

            $repository = $app->service('menu-item.repository');
            $model = $repository->create($data);

            return $app->redirect('/menu-items/' . $model->menu_id . '/add');
        }, 'menu-items.store')
        ->get('/menu-items/{id}/show', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = $request->getAttribute('id');
            $repository = $app->service('menu-item.repository');
            $menuItem = $repository->findOneBy([
                'id' => $id,
            ]);
            return $view->render('menu-items/show.html.twig', [
                        'item' => $menuItem
            ]);
        }, 'menu-items.show')
        ->get('/menu-items/{id}/delete', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('menu-item.repository');
            $id = $request->getAttribute('id');

            $menuItem = $repository->findOneBy([
                'id' => $id,
            ]);

            $menuId = $menuItem->menu_id;

            $repository->delete([
                'id' => $menuItem->id,
            ]);
            return $app->redirect('/menu-items/' . $menuId . '/add');
        }, 'menu-items.delete')
        ->post('/menu-items/del', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $repository = $app->service('menu-item.repository');

            $ids = explode(',', $data['id']);

            foreach ($ids as $id) {
                $repository->delete([
                    'id' => (int) $id,
                ]);
            }

            return $app->json(['response' => 'ok']);
        }, 'menu-items.del');

