<?php

class WorkingHours extends Model
{
    protected static $tableName = 'working_hours';
    protected static $columns = [
        'id',
        'user_id',
        'work_date',
        'time1',
        'time2',
        'time3',
        'time4',
        'worked_time'
    ];
    public static function loadFromUserAndDate($userId, $workDate)
    {
        $registry = self::getOne(['user_id' => $userId, 'work_date' => $workDate]);

        if (!$registry) {
            $registry = new WorkingHours([
                'user_id' => $userId,
                'work_date' => $workDate,
                'time1' => null,
                'time2' => null, //aparentemente, deu tudo certo, o update funciona desta maneira.
                'time3' => null,
                'time4' => null,
                'worked_time' => 0
            ]);
        }
        return $registry;
    }

    public function getNextTime()
    {
        if (!$this->time1) return 'time1'; //o 1 n tá setado?retorna ele para ser setado
        if (!$this->time2) return 'time2'; //o 2 n tá setado?retorna ele para ser setado
        if (!$this->time3) return 'time3'; //o 3 n tá setado?retorna ele para ser setado
        if (!$this->time4) return 'time4'; //o 4 n tá setado? retorna ele para ser setado
        return null; //e se todos atributos estiverem preenchidos, retorna null.
    }

    public function innout($time) //o momento exato em que o funcionário apertou o botão para bater
    {
        $timeColumn = $this->getNextTime(); //vai nos dizer qual coluna usaremos para preencher com o $time
        if (!$timeColumn) { //que dizer que todos os batimentos já foram executados
            throw new AppException("Você já fez os 4 batimentos do dia!");
        }
        //pegando o nome da coluna
        $this->$timeColumn = $time; //$timeColumn para dizer que é uma variável e não um atributo da class WorkingHours
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }
}