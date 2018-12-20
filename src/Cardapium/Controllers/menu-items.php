<?php

use Cardapium\Models\MenuItem;
use Cardapium\Models\Validators\ValidatorException;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/menu-items/{id}/add', function(ServerRequestInterface $request) use($app) {
            return addMenuItems($request, $app);
        }, 'menu-items.add')
        ->post('/menu-items/store', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $data['dt_week'] = dateParse($data['dt_week']);

            $repository = $app->service('menu-item.repository');
            try {
                $model = $repository->create($data);
            } catch (ValidatorException $exc) {
                return addMenuItems($request, $app, [
                    'errors' => $exc->getErrorMessages(),
                    'data' => $data
                ]);
            } catch (Exception $exc) {
                return addMenuItens($request, $app, [
                    'data' => $data,
                    'errors' => [[
                    'Algo não saiu como esperado'
                        ]]
                ]);
            }

            return $app->redirect('/menu-items/' . $model->menu_id . '/add');
        }, 'menu-items.store')
        ->get('/menu-items/{id}/show', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = (int) $request->getAttribute('id');
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
            $id = (int) $request->getAttribute('id');

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

function addMenuItems($request, $app, array $params = [])
{
    $view = $app->service('view.renderer');
    $id = (int) isset($params['data']) ? $params['data']['menu_id'] : $request->getAttribute('id');
    $repository = $app->service('menu.repository');
    $repositoryI = $app->service('meal.repository');
    $menu = $repository->findOneBy([
        'id' => $id,
    ]);

    $repositoryItem = $app->service('menu-item.repository');
    $items = $repositoryItem->findByField('menu_id', $menu->id)->sortBy('dt_week');

    foreach ($items as $item) {
        $item->dt_ext = ucfirst(gmstrftime('%A', strtotime($item->dt_week)));
    }

    return $view->render('menu-items/add.html.twig', [
                'menu' => $menu,
                'meals' => $repositoryI->all()->sortBy('name'),
                'meal_splits' => MenuItem::getTypes(),
                'items' => $items,
                'errors' => isset($params['errors']) ? $params['errors'] : [],
    ]);
}
