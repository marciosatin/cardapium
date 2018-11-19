<?php

use Cardapium\Models\Validators\ValidatorException;
use Psr\Http\Message\ServerRequestInterface;

$app->get(
                '/users', function() use($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('user.repository');
            $users = $repository->all();
            return $view->render('users/list.html.twig', [
                        'users' => $users
            ]);
        }, 'users.list')
        ->get(
                '/users/new', function() use($app) {
            $view = $app->service('view.renderer');
            return $view->render('users/create.html.twig');
        }, 'users.new')
        ->post(
                '/users/store', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();
            $auth = $app->service('auth');
            $repository = $app->service('user.repository');
            try {
                $data['password'] = $auth->hashPassword($data['password']);
                $repository->create($data);
            } catch (ValidatorException $exc) {
                $view = $app->service('view.renderer');
                return $view->render('users/create.html.twig', [
                            'errors' => $exc->getErrorMessages()
                ]);
            } catch (\InvalidArgumentException $exc) {
                $msg = 'Senha deve ser informada';
                $view = $app->service('view.renderer');
                return $view->render('users/create.html.twig', [
                            'errors' => [[$msg]]
                ]);
            } catch (\Exception $exc) {
                $msg = 'Ops. Algo não saiu como esperado: ' . $exc->getCode();
                $view = $app->service('view.renderer');
                return $view->render('users/create.html.twig', [
                            'errors' => [[$msg]]
                ]);
            }

            return $app->redirect('/users');
        }, 'users.store')
        ->get(
                '/users/{id}/edit', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = (int) $request->getAttribute('id');
            $repository = $app->service('user.repository');
            $user = $repository->find($id);
            return $view->render('users/edit.html.twig', [
                        'user' => $user
            ]);
        }, 'users.edit')
        ->post(
                '/users/{id}/update', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('user.repository');
            $id = (int) $request->getAttribute('id');
            $data = $request->getParsedBody();
            if (isset($data['password'])) {
                unset($data['password']);
            }
            try {
                $repository->update($id, $data);
            } catch (ValidatorException $exc) {

                $view = $app->service('view.renderer');
                $repository = $app->service('user.repository');
                $user = $repository->find($id);

                return $view->render('users/edit.html.twig', [
                            'user' => $user,
                            'errors' => $exc->getErrorMessages(),
                ]);
            } catch (\Exception $exc) {

                $msg = 'Ops. Algo não saiu como esperado ' . $exc->getCode();

                $view = $app->service('view.renderer');
                $repository = $app->service('user.repository');
                $user = $repository->findOneBy([
                    'id' => $id,
                ]);

                return $view->render('users/edit.html.twig', [
                            'user' > $user,
                            'errors' => [[$msg]],
                ]);
            }

            return $app->route('users.list');
        }, 'users.update')
        ->get(
                '/users/{id}/show', function(ServerRequestInterface $request) use($app) {
            $view = $app->service('view.renderer');
            $id = (int) $request->getAttribute('id');
            $repository = $app->service('user.repository');
            $user = $repository->find($id);
            return $view->render('users/show.html.twig', [
                        'user' => $user
            ]);
        }, 'users.show')
        ->get(
                '/users/{id}/delete', function(ServerRequestInterface $request) use($app) {
            $repository = $app->service('user.repository');
            $id = (int) $request->getAttribute('id');
            $repository->delete($id);
            return $app->route('users.list');
        }, 'users.delete');
