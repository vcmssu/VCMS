<?php

class AdminCore {

    function __construct() {
        $this->model = new AdminCoreModel();
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
    }

    function index() {
        Cms::header('Административная панель');
        $this->model->index();
        Cms::footer();
    }

}
