<?php
use Psr\Http\Message\ServerRequestInterface;

$app
    ->get('/shopping-list', function(ServerRequestInterface $request) use($app){
        $view = $app->service('view.renderer');
        $repository = $app->service('shopping-list.repository');
        $repositoryMenu = $app->service('menu.repository');
        $data = $request->getQueryParams();

        $dtInicio = $data['dtInicio'] ?? new \DateTime();
        $dtInicio = $dtInicio instanceof \DateTime ? $dtInicio->format('Y-m-d')
            : \DateTime::createFromFormat('Y-m-d', $dtInicio)->format('Y-m-d');

        $dtFim = $data['dtFim'] ?? (new \DateTime())->modify('+7 days');
        $dtFim = $dtFim instanceof \DateTime ? $dtFim->format('Y-m-d')
            : \DateTime::createFromFormat('Y-m-d', $dtFim)->format('Y-m-d');

        $menuId = isset($data['menu_id']) ? (int) $data['menu_id'] : 0;

        $itens = ($menuId) ? $repository->all($dtInicio, $dtFim, $menuId) : array();

        return $view->render('shopping-list.html.twig', [
            'itens' => $itens,
            'menus' => $repositoryMenu->all(),
            'dtInicio' => $dtInicio,
            'dtFim' => $dtFim,
            'menu_id' => $menuId,
        ]);
    }, 'shopping-list.list');