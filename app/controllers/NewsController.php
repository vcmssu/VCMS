<?php

class NewsController {

    function __construct() {
        $this->model = new NewsModel();
    }

    function index() {
        Cms::header('Новости');
        $this->model->index();
        Cms::footer();
    }

    function view($id) {
        if (DB::run("SELECT COUNT(*) FROM `news` WHERE `id`='" . $id . "' AND `status`='1'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }

        $row = DB::run("SELECT * FROM `news` WHERE `id`='" . $id . "' AND `status`='1'")->fetch(PDO::FETCH_ASSOC);

        Cms::header(Functions::esc($row['name']), $row['keywords'], $row['description']);
        $this->model->view($id);
        Cms::footer();
    }

    function comments($id) {
        if (DB::run("SELECT COUNT(*) FROM `news` WHERE `id`='" . $id . "' AND `status`='1'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }

        $row = DB::run("SELECT * FROM `news` WHERE `id`='" . $id . "' AND `status`='1'")->fetch(PDO::FETCH_ASSOC);

        Cms::header('Комментарии', $row['keywords'], $row['description']);
        $this->model->comments($id);
        Cms::footer();
    }

    function add() {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Добавить новость');
        $this->model->add();
        Cms::footer();
    }

    function edit($id) {
        if (User::$user['level'] < 30) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `news` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/news');
        }
        Cms::header('Редактирование новости');
        $this->model->edit($id);
        Cms::footer();
    }

    function del($id) {
        if (User::$user['level'] < 40) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `news` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/news');
        }
        Cms::header('Удаление новости');
        $this->model->del($id);
        Cms::footer();
    }

    function all() {
        if (User::$user['level'] < 30) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Все новости');
        $this->model->all();
        Cms::footer();
    }

    function edit_comments($id) {
        if (User::$user['level'] < 10) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `news_comments` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/news');
        }
        Cms::header('Редактирование комментария');
        $this->model->edit_comments($id);
        Cms::footer();
    }

    function del_comments($id) {
        if (User::$user['level'] < 20) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `news_comments` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/news');
        }
        Cms::header('Удаление комментария');
        $this->model->del_comments($id);
        Cms::footer();
    }

}
