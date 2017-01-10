<?php

class AdminAds {

    function __construct() {
        $this->model = new AdminAdsModel();
        if (User::$user['level'] < 100) {
            redirect(Cms::setup('home'));
        }
    }

    function index() {
        Cms::header('Управление рекламой сайта');
        $this->model->index();
        Cms::footer();
    }

    function add() {
        Cms::header('Управление рекламой сайта');
        $this->model->add();
        Cms::footer();
    }

    function edit($id) {
        Cms::header('Управление рекламой сайта');
        $this->model->edit($id);
        Cms::footer();
    }

    function del($id) {
        Cms::header('Управление рекламой сайта');
        $this->model->del($id);
        Cms::footer();
    }

    function stat($id) {
        Cms::header('Управление рекламой сайта');
        $this->model->stat($id);
        Cms::footer();
    }

}
