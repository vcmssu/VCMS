<?php

class MainController {

    function __construct() {
        $this->model = new MainModel();
    }

    function index() {
        Cms::header(Cms::setup('namesite'));
        $this->model->index();
        Cms::footer();
    }

    function captcha() {
        $this->model->captcha();
    }

    function bbcode_ajax() {
        $this->model->bbcode_ajax();
    }

    function online() {
        Cms::header('Пользователи на сайте');
        $this->model->online();
        Cms::footer();
    }

    function guest() {
        Cms::header('Гости на сайте');
        $this->model->guest();
        Cms::footer();
    }

    function smiles() {
        Cms::header('Список смайлов');
        $this->model->smiles();
        Cms::footer();
    }

    function smiles_my() {
        if (empty(User::$user['id'])) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Мои смайлы');
        $this->model->smiles_my();
        Cms::footer();
    }

    function bbcode() {
        Cms::header('BB коды');
        $this->model->bbcode();
        Cms::footer();
    }

    function error404() {
        Cms::header('404. Страницы не существует!');
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/error.tpl');
        Cms::footer();
    }

}
