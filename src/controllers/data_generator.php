<?php
loadModel('WorkingHours');

Database::executeSQL('DELETE FROM working_hours');
Database::getResultFromQuery('DELETE FROM users WHERE id > 5');

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
function populateWorkingHours($userId, $initialDate, $regularRate, $extraRate, $lazyRate)
{
    $currentDate = $initialDate; //data atual recebe a datainicial, cada dataatual será modificada conforme o while
    $today = new DateTime(); // instanciando a DateTime
    $columns = ['user_id' => $userId,  'work_date' => $currentDate]; //inserindo na coluna do WorkingHours

    while (isBefore($currentDate, $today)) { //enquanto a data for antes da data de hoje
        if (!isWeekend($currentDate)) { //não registrar os finais de semana
            $template = getDayTemplateByOdds($regularRate, $extraRate, $lazyRate); //usando a função para gerar os horários definidos na função conforme os seus rates
            $columns = array_merge($columns, $template); //agora fazendo um merge para que $coluns também carregue o q foi dado pelas Odds eu seus respectivos time1,time2..., worked_time
            $workingHours = new WorkingHours($columns); //instanciando a class WorkingHours com os dados da $columns
            $workingHours->insert(); //inserindo no BD.
        }
        $currentDate = getNextDay($currentDate)->format('Y-m-d'); // ainda dentro do while, aqui pegará o próximo dia, que nosso caso, será o dia 2, já que foi passado o dia 1
        $columns['work_date'] = $currentDate; //vai inserir no index work_date a data atual do cálculo
    }
}
$lastMonth = strtotime('first day of last month');
populateWorkingHours(1, date('Y-m-1'), 70, 20, 10);
populateWorkingHours(3, date('Y-m-d', $lastMonth), 20, 75, 5);
populateWorkingHours(4, date('Y-m-d', $lastMonth), 20, 10, 70);
echo 'Tudo certo';