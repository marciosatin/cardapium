<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get('/ingredients', function() use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('ingredient.repository');
            $ingredients = $repository->all();
            return $view->render('ingredients/list.html.twig', [
                    'ingredients' => $ingredients
            ]);
        }, 'ingredients.list')
        ->get('/ingredients/new', function() use($app) {
            $view = $app->service('view.renderer');
            $ingredientTypeRepo = $app->service('ingredient-type.repository');
            $types = $ingredientTypeRepo->all();
            return $view->render(
                        'ingredients/create.html.twig', [
                        'types' => $types
            ]);
        }, 'ingredients.new')
        ->post('/ingredients/store', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();

            $repository = $app->service('ingredient.repository');
            $ingredientTypeRepo = $app->service('ingredient-type.repository');

            $data['ingredient_type_id'] = $ingredientTypeRepo->findOneBy([
                        'id' => $data['ingredient_type_id'],
                    ])->id;

            $repository->create($data);
            return $app->redirect('/ingredients');
        }, 'ingredients.store')
        ->get('/ingredients/{id}/edit', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('ingredient.repository');
            $id = $request->getAttribute('id');
            $ingredient = $repository->findOneBy([
                'id' => $id,
            ]);
            $ingredientTypeRepo = $app->service('ingredient-type.repository');
            $types = $ingredientTypeRepo->all();
            return $view->render(
                            'ingredients/edit.html.twig', [
                        'ingredient' => $ingredient,
                        'types' => $types
                            ]
            );
        }, 'ingredients.edit')
        ->post('/ingredients/{id}/update', function(ServerRequestInterface $request) use($app) {
            $id = $request->getAttribute('id');
            $data = $request->getParsedBody();


            $repository = $app->service('ingredient.repository');
            $ingredientTypeRepo = $app->service('ingredient-type.repository');

            $data['ingredient_type_id'] = $ingredientTypeRepo->findOneBy([
                        'id' => $data['ingredient_type_id'],
                    ])->id;

            $repository->update([
                'id' => $id,
                    ], $data);

            return $app->redirect('/ingredients');
        }, 'ingredients.update')
        ->get('/ingredients/{id}/show', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = $request->getAttribute('id');
            $repository = $app->service('ingredient.repository');
            $ingredient = $repository->findOneBy([
                'id' => $id,
            ]);
            return $view->render('ingredients/show.html.twig', [
                        'ingredient' => $ingredient
            ]);
        }, 'ingredients.show')
        ->get('/ingredients/{id}/delete', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('ingredient.repository');
            $id = $request->getAttribute('id');
            $repository->delete([
                'id' => $id,
            ]);
            return $app->route('ingredients.list');
        }, 'ingredients.delete');
