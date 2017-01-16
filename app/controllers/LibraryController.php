<?php

class LibraryController {

    function __construct() {
        $this->model = new LibraryModel();
    }

    function index($id) {
        if ($id) {
            if (DB::run("SELECT COUNT(*) FROM `library_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
                Functions::redirect(Cms::setup('home'));
            }
            $rows = DB::run("SELECT * FROM `library_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
            Cms::header(Functions::esc($rows['name']), $rows['keywords'], $rows['description']);
        } else {
            Cms::header('Библиотека');
        }
        $this->model->index($id);
        Cms::footer();
    }

    function add($id) {
        if (User::$user['level'] < 100) {
            Functuions::redirect(Cms::setup('home'));
        }
        if ($id) {
            if (DB::run("SELECT COUNT(*) FROM `library_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
                Functions::redirect(Cms::setup('home'));
            }
            Cms::header('Создание категории');
        } else {
            Cms::header('Создание категории');
        }
        $this->model->add($id);
        Cms::footer();
    }

    function category_edit($id) {
        if (User::$user['level'] < 100) {
            Functuions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `library_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Редактирование категории');
        $this->model->category_edit($id);
        Cms::footer();
    }

    function category_del($id) {
        if (User::$user['level'] < 100) {
            Functuions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `library_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Удаление категории');
        $this->model->category_del($id);
        Cms::footer();
    }

    function articles($id) {
        if (User::$user['id'] == null) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `library_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }

        $rows = DB::run("SELECT * FROM `library_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if (User::$user['level'] == 1 && $rows['user'] == 1) {
            Functions::redirect(Cms::setup('home'));
        }

        Cms::header('Добавить статью');
        $this->model->articles($id);
        Cms::footer();
    }

    function view($id) {
        if (DB::run("SELECT COUNT(*) FROM `library` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $rows = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header(Functions::esc($rows['name']), $rows['keywords'], $rows['description']);
        $this->model->view($id);
        Cms::footer();
    }

    function edit($id) {
        if (User::$user['level'] < 20) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `library` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $rows = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование статьи', $rows['keywords'], $rows['description']);
        $this->model->edit($id);
        Cms::footer();
    }

    function del($id) {
        if (User::$user['level'] < 20) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `library` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $rows = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление статьи', $rows['keywords'], $rows['description']);
        $this->model->del($id);
        Cms::footer();
    }

    function comments($id) {
        if (DB::run("SELECT COUNT(*) FROM `library` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $rows = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Комментарии', $rows['keywords'], $rows['description']);
        $this->model->comments($id);
        Cms::footer();
    }

    function edit_comments($id) {
        if (User::$user['level'] < 10) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `library_comments` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/library');
        }
        Cms::header('Редактирование комментария');
        $this->model->edit_comments($id);
        Cms::footer();
    }

    function del_comments($id) {
        if (User::$user['level'] < 20) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `library_comments` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home') . '/library');
        }
        Cms::header('Удаление комментария');
        $this->model->del_comments($id);
        Cms::footer();
    }

    function up($refid, $id) {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->up($refid, $id);
    }

    function down($refid, $id) {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->down($refid, $id);
    }

    function top() {
        Cms::header('Топ статей');
        $this->model->top();
        Cms::footer();
    }

    function search($search) {
        Cms::header('Поиск статей');
        $this->model->search($search);
        Cms::footer();
    }

    function txt($id) {
        if (DB::run("SELECT COUNT(*) FROM `library` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $rows = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $this->model->txt($id);
    }

}
