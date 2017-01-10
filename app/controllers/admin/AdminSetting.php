<?php

class AdminSetting {

    function __construct() {
        $this->model = new AdminSettingModel();
        if (User::$user['level'] < 100)
            Functions::redirect(Cms::setup('home'));
    }

    function index() {
        Cms::header('Настройки сайта');
        $this->model->index();
        Cms::footer();
    }

    function email() {
        Cms::header('Настройки сайта');
        $this->model->email();
        Cms::footer();
    }

    function other() {
        Cms::header('Настройки сайта');
        $this->model->other();
        Cms::footer();
    }

    function counters() {
        Cms::header('Настройки сайта');
        $this->model->counters();
        Cms::footer();
    }

    function forum() {
        Cms::header('Настройки сайта');
        $this->model->forum();
        Cms::footer();
    }

    function smiles() {
        Cms::header('Настройки сайта');
        $this->model->smiles();
        Cms::footer();
    }

    function smiles_update() {
        $this->model->smiles_update();
    }

    function smiles_del($id) {
        Cms::header('Настройки сайта');
        $this->model->smiles_del();
        Cms::footer();
    }

    function zc() {
        Cms::header('Настройки сайта');
        $this->model->zc();
        Cms::footer();
    }

}
