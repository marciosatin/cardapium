<?php

use Illuminate\Database\QueryException;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

$app->get('/menus', function() use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('menu.repository');
            $menus = $repository->all()->sortByDesc('id');

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
            $id = (int) $request->getAttribute('id');
            $menu = $repository->findOneBy([
                'id' => $id,
            ]);

            $types = [
                1 => 'Mensal',
                2 => 'Semanal',
            ];
            return $view->render('menus/edit.html.twig', [
                        'menu' => $menu,
                        'types' => $types,
                            ]
            );
        }, 'menus.edit')
        ->post('/menus/{id}/update', function(ServerRequestInterface $request) use($app) {
            $id = (int) $request->getAttribute('id');
            $data = $request->getParsedBody();

            $data['dt_start'] = dateParse($data['dt_start']);
            $data['dt_end'] = dateParse($data['dt_end']);

            $repository = $app->service('menu.repository');
            $repository->update([
                'id' => $id,
                    ], $data);

            return $app->redirect('/menus');
        }, 'menus.update')
        ->get('/menus/{id}/show', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = (int) $request->getAttribute('id');
            $repository = $app->service('menu.repository');
            $menu = $repository->findOneBy([
                'id' => $id,
            ]);
            return $view->render('menus/show.html.twig', [
                        'menu' => $menu
            ]);
        }, 'menus.show')
        ->get('/menus/{id}/delete', function(ServerRequestInterface $request) use($app) {

            $erro = '';
            $repository = $app->service('menu.repository');
            $id = (int) $request->getAttribute('id');

            $view = $app->service('view.renderer');

            try {
                $repository->delete(['id' => $id]);
            } catch (QueryException $exc) {
                $erro = 'Erro inesperado';
                if ($exc->getCode() == '23000') {
                    $erro = 'Não é possível remover o cardápio, remova primeiro os itens';
                }
            } catch (ModelNotFoundException $exc) {
                $erro = 'Registro não encontrado';
            } catch (Exception $exc) {
                $erro = 'Ops!! Erro desconhecido';
            }

            if ($erro) {
                return $view->render('menus/list.html.twig', [
                            'erro' => $erro,
                ]);
            }
            return $app->route('menus.list');
        }, 'menus.delete');
