<?php

class AdminTemplates {

    function __construct() {
        $this->model = new AdminTemplatesModel();
        if (User::$user['level'] < 100)
            Functions::redirect(Cms::setup('home'));
    }

    function index() {
        Cms::header('Управление шаблонами');
        $this->model->index();
        Cms::footer();
    }

    function del($temp) {
        Cms::header('Управление шаблонами');
        $this->model->del($temp);
        Cms::footer();
    }

    function view($temp) {
        Cms::header('Управление шаблонами');
        $this->model->view($temp);
        Cms::footer();
    }

    function edit($temp) {
        Cms::header('Управление шаблонами');
        $this->model->edit($temp);
        Cms::footer();
    }

    function email($temp) {
        Cms::header('Управление шаблонами');
        $this->model->email($temp);
        Cms::footer();
    }

}
