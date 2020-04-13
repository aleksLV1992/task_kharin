<?php


namespace models;


use vendor\Models;
use vendor\Site as Site;

class Task extends Models
{
    /**
     * @var Индификатор
     */
    public $id;

    /**
     * @var Имя пользователя
     */
    public $user_name;

    /**
     * @var Email
     */
    public $email;

    /**
     * @var Текст задачи
     */
    public $text;

    /**
     * @var Статус Задачи
     */
    public $id_status = 1;

    const COMMENT = "отредактировано администратором";

    /**
     * Получения Именени таблицы в БД
     * @return string
     */
    private static function getTable()
    {
        return 'task';
    }

    /**
     * Проверка валидности модели
     * @return bool
     */
    public function valid()
    {
        $isValid = false;
        if (strlen($this->user_name) === 0) {
            $this->errorList [] = "Заполните Имя пользователя";
        } else if (strlen($this->email) === 0) {
            $this->errorList [] = "Заполните Email";
        } else if (strlen($this->text) === 0) {
            $this->errorList [] = "Заполните Текст задачи";
        } else {

            if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $isValid = true;
            } else {
                $this->errorList [] = "Ошибка формата Email";
            }

        }
        return $isValid;
    }

    /**
     * Сохранения Task
     * @return bool|\PDOStatement
     */
    public function save()
    {
        $table = self::getTable();
        $this->id_status = 1;
        $stmt = Site::$db->prepare("INSERT INTO {$table}(user_name,email,text,id_status) value(:u,:e,:t,:s)");
        $stmt->execute(['u' => htmlspecialchars($this->user_name), 'e' => htmlspecialchars($this->email), 't' => htmlspecialchars($this->text), 's' => $this->id_status]);
        $this->successList [] = "Задача успешно создана!";
        return $stmt;
    }

    /**
     * Update Task
     * @return bool|\PDOStatement
     */
    public function update()
    {
        $table = self::getTable();
        $stmt = Site::$db->prepare("UPDATE {$table} SET user_name = :u,email = :e ,text = :t,id_status = :s,comment=:c WHERE id=:id");
        $stmt->execute([':u' => htmlspecialchars($this->user_name), ':e' => htmlspecialchars($this->email), ':t' => htmlspecialchars($this->text), ':s' => $this->id_status, ':id' => $this->id,':c'=>self::COMMENT]);
        $this->successList [] = "Задача успешно обновлена!";
        return $stmt;
    }

    /**
     * Вовзрашает Task по ID
     */
    public static function getTaskID($id)
    {
        $table = self::getTable();
        $stmt = Site::$db->prepare("SELECT * FROM {$table} WHERE id=:id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

}