<?php

function dateParse($date)
{
    $dateArray = explode('/', $date);
    $dateArray = array_reverse($dateArray);
    return implode('-', $dateArray);
}

function numberParse($number)
{
    $newNumber = str_replace('.', '', $number);
    $newNumber = str_replace(',', '.', $newNumber);
    return $newNumber;
}

function formatDateInicioFim($dtInicioP, $dtFimP)
{

    if ($dtInicioP) {
        if (!preg_match('/\\d{4}-\\d{2}-\\d{2}/', $dtInicioP)) {
            throw new \InvalidArgumentException('Data início não possui formato válido');
        }
    }
    if ($dtFimP) {
        if (!preg_match('/\\d{4}-\\d{2}-\\d{2}/', $dtFimP)) {
            throw new \InvalidArgumentException('Data fim não possui formato válido');
        }
    }

    $dtInicio = ($dtInicioP) ? $dtInicioP : new \DateTime();
    $dtInicio = $dtInicio instanceof \DateTime ? $dtInicio->format('Y-m-d') : \DateTime::createFromFormat('Y-m-d', $dtInicio)->format('Y-m-d');

    $dtFim = ($dtFimP) ? $dtFimP : (new \DateTime())->modify('+7 days');
    $dtFim = $dtFim instanceof \DateTime ? $dtFim->format('Y-m-d') : \DateTime::createFromFormat('Y-m-d', $dtFim)->format('Y-m-d');

    return [
        'dtInicio' => $dtInicio,
        'dtFim' => $dtFim
    ];
}
