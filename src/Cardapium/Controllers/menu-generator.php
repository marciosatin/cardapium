<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get('/menu-generator', function(ServerRequestInterface $request) use($app) {
            $data = $request->getQueryParams();

            $dtInicio = $data['dtInicio'] ?? new \DateTime();
            $dtInicio = $dtInicio instanceof \DateTime ? $dtInicio->format('Y-m-d') : \DateTime::createFromFormat('Y-m-d', $dtInicio)->format('Y-m-d');

            $dtFim = $data['dtFim'] ?? (new \DateTime())->modify('+7 days');
            $dtFim = $dtFim instanceof \DateTime ? $dtFim->format('Y-m-d') : \DateTime::createFromFormat('Y-m-d', $dtFim)->format('Y-m-d');

            return $app->service('view.renderer')
                    ->render('/menu-generator/filter.html.twig', [
                        'dtInicio' => $dtInicio,
                        'dtFim' => $dtFim
            ]);
        }, 'menu-generator.filter')
        ->post('/menu-generator/list', function(ServerRequestInterface $request) use($app) {
            $data = $request->getParsedBody();

            $dtInicio = $data['dtInicio'] ?? new \DateTime();
            $dtInicio = $dtInicio instanceof \DateTime ? $dtInicio->format('Y-m-d') : \DateTime::createFromFormat('Y-m-d', $dtInicio)->format('Y-m-d');

            $dtFim = $data['dtFim'] ?? (new \DateTime())->modify('+7 days');
            $dtFim = $dtFim instanceof \DateTime ? $dtFim->format('Y-m-d') : \DateTime::createFromFormat('Y-m-d', $dtFim)->format('Y-m-d');

            $repository = $app->service('menu-generator.repository');
            $dataView = $repository->generate([
                'dtInicio' => $dtInicio,
                'dtFim' => $dtFim
            ]);

            return $app->service('view.renderer')
                    ->render('/menu-generator/list.html.twig', [
                        'headers' => $dataView['headers'],
                        'menu' => $dataView['menu'],
                        'dtIni' => $dtInicio,
                        'dtFin' => $dtFim
            ]);
        }, 'menu-generator.list')
        ->post('/menu-generator/store', function(ServerRequestInterface $request) use($app) {
            $menuData = $request->getParsedBody();

            $data = json_decode($menuData['menu'], true);

            $dateIni = new DateTime($data['dtIni']);
            $dateFin = new DateTime($data['dtFin']);

            $data['name'] = 'Cardápio: ' . $dateIni->format('d/m/Y') . ' - ' . $dateFin->format('d/m/Y');

            $diff = $dateFin->diff($dateIni);

            if ($diff->days > 15) {
                $data['type_id'] = \Cardapium\Models\Menu::MENSAL;
            } else {
                $data['type_id'] = \Cardapium\Models\Menu::SEMANAL;
            }

            $data['dt_start'] = $data['dtIni'];
            $data['dt_end'] = $data['dtFin'];

            $repoMenu = $app->service('menu.repository');
            $menu = $repoMenu->create($data);

            $itens = $data['itens'];

            try {
                foreach ($itens as $item) {
                    for ($i = 1; $i <= 2; $i++) {
                        $repoMenuItem = $app->service('menu-item.repository');
                        $repoMenuItem->create([
                            'dt_week' => $item['day'],
                            'meal_split_id' => $i,
                            'meal_id' => $i == 1 ? $item['amealid'] : $item['jmealid'],
                            'menu_id' => $menu->id
                        ]);
                    }
                }
            } catch (Exception $exc) {
                return $app->json(['error' => $exc->getMessage()]);
            }
            return $app->json(['response' => 'ok']);
        }, 'menu-generator.store');
