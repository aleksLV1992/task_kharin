<?php


namespace models;


use vendor\Models;
use vendor\Site as Site;

class TaskStatus extends Models
{
    public $id;
    public $name;
    public $label;

    /**
     * Получения Именени таблицы в БД
     * @return string
     */
    private static function getTable()
    {
        return 'task_status';
    }

    /**
     * Список статусов
     * @return mixed
     */
    public static function getStatusTask()
    {
        $table = self::getTable();
        $stmt = Site::$db->query("SELECT * FROM {$table}");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
}