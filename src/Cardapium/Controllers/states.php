<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get(
                '/states', function() use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('state.repository');
            $states = $repository->all();
            return $view->render('states/list.html.twig', [
                        'states' => $states
            ]);
        }, 'states.list')
        ->get(
                '/states/new', function() use($app) {
            $view = $app->service('view.renderer');
            return $view->render('states/create.html.twig');
        }, 'states.new')
        ->post(
                '/states/store', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $repository = $app->service('state.repository');
            $repository->create($data);
            return $app->redirect('/states');
        }, 'states.store')
        ->get(
                '/states/{id}/edit', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = $request->getAttribute('id');
            $repository = $app->service('state.repository');
            $state = $repository->find($id);
            return $view->render('states/edit.html.twig', [
                        'state' => $state
            ]);
        }, 'states.edit')
        ->post(
                '/states/{id}/update', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('state.repository');
            $id = (int) $request->getAttribute('id');
            $data = $request->getParsedBody();
            $repository->update($id, $data);
            return $app->route('states.list');
        }, 'states.update')
        ->get(
                '/states/{id}/show', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = $request->getAttribute('id');
            $repository = $app->service('state.repository');
            $state = $repository->find($id);
            return $view->render('states/show.html.twig', [
                        'state' => $state
            ]);
        }, 'states.show')
        ->get(
                '/states/{id}/delete', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('state.repository');
            $id = (int) $request->getAttribute('id');
            $repository->delete($id);
            return $app->route('states.list');
        }, 'states.delete');
