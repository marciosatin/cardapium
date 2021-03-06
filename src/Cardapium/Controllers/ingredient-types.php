<?php

use Cardapium\Models\Validators\ValidatorException;
use Psr\Http\Message\ServerRequestInterface;

$app->get(
                '/ingredient-types', function() use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('ingredient-type.repository');
            $ingredientTypes = $repository->all();
            return $view->render('ingredient-types/list.html.twig', [
                        'types' => $ingredientTypes
            ]);
        }, 'ingredient-types.list')
        ->get(
                '/ingredient-types/new', function() use($app) {
            $view = $app->service('view.renderer');
            return $view->render('ingredient-types/create.html.twig');
        }, 'ingredient-types.new')
        ->post(
                '/ingredient-types/store', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $repository = $app->service('ingredient-type.repository');
            try {
                $repository->create($data);
            } catch (ValidatorException $exc) {
                $view = $app->service('view.renderer');
                return $view->render('ingredient-types/create.html.twig', [
                            'errors' => $exc->getErrorMessages()
                ]);
            } catch (\Exception $exc) {
                $msg = 'Ops. Algo não saiu como esperado: ' . $exc->getCode();
                $view = $app->service('view.renderer');
                return $view->render('ingredient-types/create.html.twig', [
                            'errors' => [[$msg]]
                ]);
            }

            return $app->redirect('/ingredient-types');
        }, 'ingredient-types.store')
        ->get(
                '/ingredient-types/{id}/edit', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = (int) $request->getAttribute('id');
            $repository = $app->service('ingredient-type.repository');
            $ingredientType = $repository->find($id);
            return $view->render('ingredient-types/edit.html.twig', [
                        'type' => $ingredientType
            ]);
        }, 'ingredient-types.edit')
        ->post(
                '/ingredient-types/{id}/update', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('ingredient-type.repository');
            $id = (int) $request->getAttribute('id');
            $data = $request->getParsedBody();
            try {
                $repository->update($id, $data);
            } catch (ValidatorException $exc) {

                $view = $app->service('view.renderer');
                $repository = $app->service('ingredient-type.repository');
                $ingredientType = $repository->find($id);

                return $view->render('ingredient-types/edit.html.twig', [
                            'type' => $ingredientType,
                            'errors' => $exc->getErrorMessages(),
                ]);
            } catch (\Exception $exc) {

                $msg = 'Ops. Algo não saiu como esperado ' . $exc->getCode();

                $view = $app->service('view.renderer');
                $repository = $app->service('ingredient-type.repository');
                $ingredientType = $repository->find($id);

                return $view->render('ingredient-types/edit.html.twig', [
                            'type' => $ingredientType,
                            'errors' => [[$msg]],
                ]);
            }

            return $app->route('ingredient-types.list');
        }, 'ingredient-types.update')
        ->get(
                '/ingredient-types/{id}/show', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = (int) $request->getAttribute('id');
            $repository = $app->service('ingredient-type.repository');
            $ingredientType = $repository->find($id);
            return $view->render('ingredient-types/show.html.twig', [
                        'type' => $ingredientType
            ]);
        }, 'ingredient-types.show')
        ->get(
                '/ingredient-types/{id}/delete', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('ingredient-type.repository');
            $id = (int) $request->getAttribute('id');
            $repository->delete($id);
            return $app->route('ingredient-types.list');
        }, 'ingredient-types.delete');
