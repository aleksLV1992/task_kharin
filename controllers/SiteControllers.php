<?php

use vendor\Controllers as Controllers;
use vendor\Site as Site;


class SiteControllers extends Controllers
{

    const ORDER = [
        ['value' => 'name', 'label' => 'Имя пользователя(По возрастанию)', 'column' => 'user_name', 'desc' => false],
        ['value' => 'name_desc', 'label' => 'Имя пользователя(По убыванию)', 'column' => 'user_name', 'desc' => true],
        ['value' => 'email', 'label' => 'Email(По возрастанию)', 'column' => 'email', 'desc' => false],
        ['value' => 'email_desc', 'label' => 'Email(По убыванию)', 'column' => 'email', 'desc' => true],
        ['value' => 'role', 'label' => 'Статус(По возрастанию)', 'column' => 'role_label', 'desc' => false],
        ['value' => 'role_desc', 'label' => 'Статус(По убыванию)', 'column' => 'role_label', 'desc' => true],


    ];

    /**
     * Выводит список Task
     * @return string
     */
    public function actionIndex()
    {
        $page = 1;
        $orderby = null;
        if (isset($_GET['page']) && is_int(intval($_GET['page'])))
            $page = intval($_GET['page']);
        if (isset($_GET['orderby']))
            $orderby = $_GET['orderby'];
        $listTask = $this->getTaskList($page, $orderby);
        return $this->render('task', $listTask);
    }

    /**
     * Список задач
     * @param int $page
     * @param null $orderby
     * @return array
     */
    private function getTaskList($page = 1, $orderby = null)
    {
        $countPage = 3;
        $min = (($page - 1) * $countPage);
        $limit = "LIMIT {$min},{$countPage}";
        $order = "";
        if (!empty($orderby)) {
            $index = array_search($orderby, array_column(self::ORDER, 'value'));
            if ($index !== false) {
                $ObjOrder = (self::ORDER[$index]);
                $order = "ORDER BY " . $ObjOrder['column'] . " " . (($ObjOrder['desc']) ? "DESC" : "ASC");
            }
        }
        $stmt = \vendor\Site::$db->query("SELECT SQL_CALC_FOUND_ROWS t.*,s.`name` AS name_status,s.`label` AS role_label FROM task t LEFT JOIN task_status s ON t.id_status = s.id {$order} {$limit}");
        $task = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmCount = \vendor\Site::$db->query("SELECT FOUND_ROWS() as countTask;");

        $result = [
            'task' => $task,
            'page' => $page,
            'countPage' => $countPage,
            'count' => $stmCount->fetchAll(PDO::FETCH_ASSOC),
            'orderList' => self::ORDER,
            'order' => $orderby
        ];
        return $result;
    }

    /**
     * Добавления Task
     */
    public function actionAddTask()
    {
        $task = new \models\Task();
        if (isset($_POST['user_name'])) {
            $task->Loading($_POST);
            if ($task->valid()) {
                $task->save();
                $task->user_name = null;
                $task->email = null;
                $task->text = null;
            }
        }

        return $this->render('add-task', ['model' => $task, 'error' => $task->errorList, 'success' => $task->successList]);

    }

    /**
     * Страница выхода из акаунта
     */
    public function actionLogout()
    {
        if (Site::GetUser() === false) {
            $this->redirect("/site/login");
        }

        $user = new \models\Login();
        $user->logout();
        $this->redirect("/site/login");
    }

    /**
     * Страница авторизации
     */
    public function actionLogin()
    {
        $user = new \models\Login();

        if ($user::getUser()) {
            $this->redirect("/");
        }

        if (isset($_POST['user_name'])) {
            $user->Loading($_POST);
            if ($user->valid()) {
                $user->login();
                $user->user_name = null;
                $user->password = null;
                $this->redirect("/");
            } else {
                $user->password = null;
            }
        }

        return $this->render('login', ['model' => $user, 'error' => $user->errorList, 'success' => $user->successList]);
    }

    /**
     * Страница редактирования Task
     */
    public function actionUpdateTask()
    {

        if (Site::GetUser() !== false) {

            /**
             * Провека есть ли данные в БД по полученному id
             */
            $id = null;
            if (isset($_GET['id']) && !empty($_GET['id']))
                $id = $_GET['id'];
            if (isset($_POST['id']) && !empty($_POST['id']))
                $id = $_POST['id'];
            $task = null;
            $model = new \models\Task();
            $statusList = [];
            if (!empty($id)) {
                $task = $model::getTaskID($id);

                $model->Loading($task);
                $status = new models\TaskStatus();
                $statusList = $status::getStatusTask();
                if (isset($_POST['text'])) {
                    /**
                     * Update
                     */
                    $model->Loading($_POST);
                    if ($model->valid()) {
                        $model->update();
                    }
                }
                if (!empty($model)) {
                    return $this->render('add-task', ['model' => $model, 'error' => $model->errorList, 'success' => $model->successList, 'update' => true, 'statusList' => $statusList]);
                }
            }
        }

        return $this->redirect("/site/login");
    }


}