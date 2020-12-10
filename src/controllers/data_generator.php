<?php

function getDayTemplateByOdds($regularRate, $extraRate, $lazyRate) //tem que fechar 100% pois é probabilidade
{
    $regularDayTemplate = [ //1 dia de 8 horas trabalhadas
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00',
        'worked_time' => DAILY_TIME
    ];
    $extraHourDayTemplate = [ //1 dia de 8 horas trabalhadas + 1 hora extra
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '18:00:00',
        'worked_time' => DAILY_TIME + 3600
    ];

    $lazyDayTemplate = [ //1 dia de 7:30 horas trabalhadas
        'time1' => '08:30:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00',
        'worked_time' => DAILY_TIME - 1800
    ];

    $value = rand(0, 100);
    if ($value <= $regularRate) {
        return $regularDayTemplate;
    } elseif ($value <= $regularRate + $extraRate) {
        return $extraHourDayTemplate;
    } else {
        return $lazyDayTemplate;
    }
}
echo "<pre>";
print_r(getDayTemplateByOdds(90, 5, 5));
echo "</pre>";