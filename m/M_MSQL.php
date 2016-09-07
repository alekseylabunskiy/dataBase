<?php
//
// Помощник работы с БД
//
class M_MSQL
{
    private static $instance;   // ссылка на экземпляр класса

    public function __construct()
    {
        $conn = new M_Connect();
        $this->msql = $conn->Connection();
    }

    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function Instance()
    {
        if (self::$instance == null) {
            self::$instance = new M_MSQL();
        }
        return self::$instance;
    }

    //
    // Выборка строк
    // $query       - полный текст SQL запроса
    // результат    - массив выбранных объектов
    //
    public function Select($query)
    {
        $result = $this->msql->query($query);
        if (!$result) {
            die($this->msql->error);
        }

        $arr = [];

        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        return $arr;
    }

    //
    // Вставка строки
    // $table       - имя таблицы
    // $object      - ассоциативный массив с парами вида "имя столбца - значение"
    // результат    - идентификатор новой строки
    //
    public function Insert($table, $object)
    {
        $columns = [];
        $values = [];

        foreach ($object as $key => $value) {
            $key = $this->msql->real_escape_string($key . '');
            $columns[] = $key;

            if ($value === null) {
                $values[] = 'NULL';
            } else {
                $value = $this->msql->real_escape_string($value . '');
                $values[] = "'$value'";
            }
        }

        $columns_s = implode(',', $columns);
        $values_s = implode(',', $values);

        $query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
        $result = $this->msql->query($query);

        return $result;
    }

    //
    // Изменение строк
    // $table       - имя таблицы
    // $object      - ассоциативный массив с парами вида "имя столбца - значение"
    // $where       - условие (часть SQL запроса)
    // результат    - число измененных строк
    //
    public function Update($table, $object, $where)
    {
        $sets = [];

        foreach ($object as $key => $value) {
            $key = $this->msql->real_escape_string($key . '');

            if ($value === null) {
                $sets[] = "$key=NULL";
            } else {
                $value = $this->msql->real_escape_string($value . '');
                $sets[] = "$key='$value'";
            }
        }

        $sets_s = implode(',', $sets);
        $query = "UPDATE $table SET $sets_s WHERE $where";
        $result = $this->msql->query($query);

        return $result;
    }

    //
    // Удаление строк
    // $table       - имя таблицы
    // $where       - условие (часть SQL запроса)
    // результат    - число удаленных строк
    //
    public function Delete($table, $where)
    {
        $query = "DELETE FROM $table WHERE $where";
        $result = $this->msql->query($query);

        return $result;
    }
}
