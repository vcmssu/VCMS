<?php

class GuestController {

    function __construct() {
        $this->model = new GuestModel();
    }

    function index() {
        Cms::header('Гостевая');
        $this->model->index();
        Cms::footer();
    }

    function edit($id) {
        if (User::$user['level'] < 10) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Редактирование сообщения');
        $this->model->edit($id);
        Cms::footer();
    }

    function del($id) {
        if (User::$user['level'] < 20) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Удаление сообщения');
        $this->model->del($id);
        Cms::footer();
    }

}
