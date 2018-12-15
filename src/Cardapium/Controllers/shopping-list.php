<?php

use Psr\Http\Message\ServerRequestInterface;

$app
        ->get('/shopping-list', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('shopping-list.repository');
            $repositoryMenu = $app->service('menu.repository');
            $data = $request->getQueryParams();
            $errors = [];
            $itens = [];
            $menuId = 0;

            try {
                $dtInicio = $data['dtInicio'] ?? false;
                $dtFim = $data['dtFim'] ?? false;
                $r = formatDateInicioFim($dtInicio, $dtFim);

                $dtInicio = $r['dtInicio'];
                $dtFim = $r['dtFim'];

                $menuId = isset($data['menu_id']) ? (int) $data['menu_id'] : 0;

                $itens = ($menuId) ? $repository->all($dtInicio, $dtFim, $menuId) : array();
            } catch (\Exception $exc) {
                $errors[] = [
                  'Ops. Algo não saiu como esperado'
                ];
            }

            return $view->render('shopping-list.html.twig', [
                        'itens' => $itens,
                        'menus' => $repositoryMenu->all(),
                        'dtInicio' => $dtInicio,
                        'dtFim' => $dtFim,
                        'menu_id' => $menuId,
                        'errors' => $errors
            ]);
        }, 'shopping-list.list');
