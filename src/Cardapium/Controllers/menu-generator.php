<?php
use Psr\Http\Message\ServerRequestInterface;

$app
    ->get('/menu-generator', function(ServerRequestInterface $request) use($app){
        $data = $request->getQueryParams();

        $dtInicio = $data['dtInicio'] ?? new \DateTime();
        $dtInicio = $dtInicio instanceof \DateTime ? $dtInicio->format('Y-m-d')
            : \DateTime::createFromFormat('Y-m-d', $dtInicio)->format('Y-m-d');

        $dtFim = $data['dtFim'] ?? (new \DateTime())->modify('+7 days');
        $dtFim = $dtFim instanceof \DateTime ? $dtFim->format('Y-m-d')
            : \DateTime::createFromFormat('Y-m-d', $dtFim)->format('Y-m-d');

        return $app->service('view.renderer')
                ->render('/menu-generator/filter.html.twig', [
                    'dtInicio' => $dtInicio,
                    'dtFim' => $dtFim
                ]);
    }, 'menu-generator.filter')
    ->post('/menu-generator/store', function(ServerRequestInterface $request) use($app){
        $data = $request->getParsedBody();

        $dtInicio = $data['dtInicio'] ?? new \DateTime();
        $dtInicio = $dtInicio instanceof \DateTime ? $dtInicio->format('Y-m-d')
            : \DateTime::createFromFormat('Y-m-d', $dtInicio)->format('Y-m-d');

        $dtFim = $data['dtFim'] ?? (new \DateTime())->modify('+7 days');
        $dtFim = $dtFim instanceof \DateTime ? $dtFim->format('Y-m-d')
            : \DateTime::createFromFormat('Y-m-d', $dtFim)->format('Y-m-d');

        return $app->service('view.renderer')
                ->render('/menu-generator/filter.html.twig', [
                    'dtInicio' => $dtInicio,
                    'dtFim' => $dtFim
                ]);
    }, 'menu-generator.store');