<?php

class AdminLogs {

    function __construct() {
        $this->model = new AdminLogsModel();
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
    }

    function index() {
        Cms::header('Логи администрации');
        $this->model->index();
        Cms::footer();
    }

    function notice() {
        Cms::header('Уведомления пользователей');
        $this->model->notice();
        Cms::footer();
    }

}
