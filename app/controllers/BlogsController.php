<?php

class BlogsController {

    function __construct() {
        $this->model = new BlogsModel();
    }

    function index() {
        Cms::header('Блоги');
        $this->model->index();
        Cms::footer();
    }

    function top() {
        Cms::header('Популярные посты');
        $this->model->top();
        Cms::footer();
    }

    function search($search) {
        Cms::header('Поиск по блогам');
        $this->model->search($search);
        Cms::footer();
    }

    function category() {
        Cms::header('Категории блогов');
        $this->model->category();
        Cms::footer();
    }

    function category_add() {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Создать категорию');
        $this->model->category_add();
        Cms::footer();
    }

    function category_id($id) {
        if (DB::run("SELECT COUNT(*) FROM `blog_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $row = DB::run("SELECT * FROM `blog_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header(Functions::esc($row['name']), $row['keywords'], $row['description']);
        $this->model->category_id($id);
        Cms::footer();
    }

    function category_edit($id) {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `blog_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $row = DB::run("SELECT * FROM `blog_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование категории ' . Functions::esc($row['name']));
        $this->model->category_edit($id);
        Cms::footer();
    }

    function category_del($id) {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `blog_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $row = DB::run("SELECT * FROM `blog_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование категории ' . Functions::esc($row['name']));
        $this->model->category_del($id);
        Cms::footer();
    }

    function up($id) {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `blog_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $this->model->up($id);
    }

    function down($id) {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `blog_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $this->model->down($id);
    }

    function post($id, $id2) {
        if (DB::run("SELECT COUNT(*) FROM `blog` WHERE `id`='" . $id2 . "' AND `refid`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $row = DB::run("SELECT * FROM `blog` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header(Functions::esc($row['name']), $row['keywords'], $row['description']);
        $this->model->post($id, $id2);
        Cms::footer();
    }

    function edit($id) {
        if (User::$user['level'] < 40) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `blog` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $row = DB::run("SELECT * FROM `blog` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование поста');
        $this->model->edit($id);
        Cms::footer();
    }

    function del($id) {
        if (User::$user['level'] < 40) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `blog` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $row = DB::run("SELECT * FROM `blog` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление поста');
        $this->model->del($id);
        Cms::footer();
    }

    function comments($id) {
        if (DB::run("SELECT COUNT(*) FROM `blog` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $row = DB::run("SELECT * FROM `blog` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Комментарии к посту ' . Functions::esc($row['name']));
        $this->model->comments($id);
        Cms::footer();
    }

    function edit_comments($id) {
        if (User::$user['level'] < 10) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `blog_comments` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $row = DB::run("SELECT * FROM `blog_comments` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование комментария');
        $this->model->edit_comments($id);
        Cms::footer();
    }

    function del_comments($id) {
        if (User::$user['level'] < 10) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `blog_comments` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/blogs');
        }
        $row = DB::run("SELECT * FROM `blog_comments` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление комментария');
        $this->model->del_comments($id);
        Cms::footer();
    }

}
