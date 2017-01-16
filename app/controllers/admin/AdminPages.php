<?php

class AdminPages {

    function __construct() {
        $this->model = new AdminPagesModel();
        if (User::$user['level'] < 100)
            Functions::redirect(Cms::setup('home'));
    }

    function index($page) {
        Cms::header_admin('Управление текстовыми страницами');
        $this->model->index($page);
        Cms::footer_admin();
    }

    function add() {
        Cms::header_admin('Управление текстовыми страницами');
        $this->model->add();
        Cms::footer_admin();
    }

    function edit($id) {
        Cms::header_admin('Управление текстовыми страницами');
        $this->model->edit($id);
        Cms::footer_admin();
    }

    function del($id) {
        Cms::header_admin('Управление текстовыми страницами');
        $this->model->del($id);
        Cms::footer_admin();
    }

}
