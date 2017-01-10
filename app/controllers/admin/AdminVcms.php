<?php

class AdminVcms {

    function __construct() {
        $this->model = new AdminVcmsModel();
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
    }

    function index() {
        Cms::header('Разработчики');
        $this->model->index();
        Cms::footer();
    }
    
    function info() {
        Cms::header('Конфигурация сервера');
        $this->model->info();
        Cms::footer();
    }
    
    function license() {
        Cms::header('Лицензионное соглашение');
        $this->model->license();
        Cms::footer();
    }

}
