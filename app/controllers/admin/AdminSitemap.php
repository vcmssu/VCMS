<?php

class AdminSitemap {

    function __construct() {
        $this->model = new AdminSitemapModel();
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
    }

    function index() {
        Cms::header('Управление картой сайта');
        $this->model->index();
        Cms::footer();
    }

    function generate() {
        $this->model->generate();
    }

    function del($temp) {
        $this->model->del($temp);
    }

    function edit($temp) {
        Cms::header('Управление картой сайта');
        $this->model->edit($temp);
        Cms::footer();
    }

    function robots() {
        Cms::header('Управление картой сайта');
        $this->model->robots();
        Cms::footer();
    }

    function setup() {
        Cms::header('Управление картой сайта');
        $this->model->setup();
        Cms::footer();
    }

}
