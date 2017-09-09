<?php

function dateParse($date){
    $dateArray = explode('/', $date);
    $dateArray = array_reverse($dateArray);
    return implode('-',$dateArray);
}

function numberParse($number){
    $newNumber = str_replace('.','',$number);
    $newNumber = str_replace(',','.',$newNumber);
    return $newNumber;
}