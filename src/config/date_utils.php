<?php

function getDateAsDateTime($date) //Sempre retornar um DateTime(class)
{ //verificação se o recebido é uma string, se sim, vai chamar o construtor do DateTime passando a $date, caso contrário, retorna o próprio $date
    return is_string($date) ? new DateTime($date) : $date;
}

function isWeekend($date) //está no final de semana ou não?
{
    $inputDate = getDateAsDateTime($date); //tratando para podermos usar o método da Class DateTime
    return $inputDate->format('N') >= 6; //pega o número representado do dia, sendo 6 e 7 os finais de semana
}

function isBefore($date1, $date2) //para comparar a primeira data1 é antes da data2?
{
    $inputDate1 = getDateAsDateTime($date1); //tratando para usar a Class DateTime
    $inputDate2 = getDateAsDateTime($date2);
    return $inputDate1 <= $inputDate2;
}

function getNextDay($date) //pegar o próximo dia
{
    $inputDate = getDateAsDateTime($date);
    $inputDate->modify('+1 day');
    return $inputDate;
}