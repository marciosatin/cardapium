<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get('/menus', function() use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('menu.repository');
            $menus = $repository->all();

            $types = [
                1 => 'Mensal',
                2 => 'Semanal',
            ];

            return $view->render('menus/list.html.twig', [
                        'menus' => $menus,
                        'types' => $types,
            ]);
        }, 'menus.list')
        ->get('/menus/new', function() use($app) {
            $view = $app->service('view.renderer');
            $menuRepo = $app->service('menu.repository');
            $menus = $menuRepo->all();

            $types = [
                1 => 'Mensal',
                2 => 'Semanal',
            ];

            return $view->render(
                            'menus/create.html.twig', [
                        'menus' => $menus,
                        'types' => $types,
            ]);
        }, 'menus.new')
        ->post('/menus/store', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $repository = $app->service('menu.repository');

            $data['dt_start'] = dateParse($data['dt_start']);
            $data['dt_end'] = dateParse($data['dt_end']);

            $model = $repository->create($data);
            return $app->redirect('/menu-items/' . $model->id . '/add');
        }, 'menus.store')
        ->get('/menus/{id}/edit', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('menu.repository');
            $id = $request->getAttribute('id');
            $menu = $repository->findOneBy([
                'id' => $id,
            ]);
            $menuRepo = $app->service('menu-menu.repository');
            $menus = $menuRepo->all();
            return $view->render(
                            'menus/edit.html.twig', [
                        'menu' => $menu,
                        'menus' => $menus
                            ]
            );
        }, 'menus.edit')
        ->post('/menus/{id}/update', function(ServerRequestInterface $request) use($app) {
            $id = $request->getAttribute('id');
            $data = $request->getParsedBody();

            $repository = $app->service('menu.repository');
            $repository->update([
                'id' => $id,
                    ], $data);

            return $app->redirect('/menus');
        }, 'menus.update')
        ->get('/menus/{id}/show', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = $request->getAttribute('id');
            $repository = $app->service('menu.repository');
            $menu = $repository->findOneBy([
                'id' => $id,
            ]);
            return $view->render('menus/show.html.twig', [
                        'menu' => $menu
            ]);
        }, 'menus.show')
        ->get('/menus/{id}/delete', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('menu.repository');
            $id = $request->getAttribute('id');
            $repository->delete([
                'id' => $id,
            ]);
            return $app->route('menus.list');
        }, 'menus.delete');
