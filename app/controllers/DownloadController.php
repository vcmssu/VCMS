<?php

class DownloadController {

    function __construct() {
        $this->model = new DownloadModel();
    }

    function index($id) {
        if ($id) {
            if (DB::query("SELECT COUNT(*) FROM `category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
                Functions::redirect(Cms::setup('home'));
            }

            $rowcat = DB::query("SELECT * FROM `category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
            Cms::header('Загрузки - ' . Functions::esc($rowcat['name']), $rowcat['keywords'], $rowcat['description']);
        } else {
            Cms::header('Загрузки');
        }
        $this->model->index($id);
        Cms::footer();
    }

    function add($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Создать папку');
        $this->model->add($id);
        Cms::footer();
    }

    function setup($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::query("SELECT COUNT(*) FROM `category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::query("SELECT * FROM `category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Параметры категории ' . Functions::esc($row['name']));
        $this->model->setup($id);
        Cms::footer();
    }

    function del_category($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::query("SELECT COUNT(*) FROM `category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::query("SELECT * FROM `category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление категории ' . Functions::esc($row['name']));
        $this->model->del_category($id);
        Cms::footer();
    }

    function edit($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::query("SELECT COUNT(*) FROM `files` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::query("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование файла ' . Functions::esc($row['name']));
        $this->model->edit($id);
        Cms::footer();
    }

    function del($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::query("SELECT COUNT(*) FROM `files` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::query("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление файла ' . Functions::esc($row['name']));
        $this->model->del($id);
        Cms::footer();
    }

    function file($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::query("SELECT COUNT(*) FROM `files` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::query("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Дополнительные файлы к файлу  ' . Functions::esc($row['name']));
        $this->model->file($id);
        Cms::footer();
    }

    function view($id) {
        if (DB::query("SELECT COUNT(*) FROM `files` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::query("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header(Functions::esc($row['name']), $row['keywords'], $row['description']);
        $this->model->view($id);
        Cms::footer();
    }

    function comments($id) {
        if (DB::query("SELECT COUNT(*) FROM `files` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::query("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Комментарии к файлу ' . Functions::esc($row['name']), $row['keywords'], $row['description']);
        $this->model->comments($id);
        Cms::footer();
    }

    function edit_comments($id) {
        if (User::$user['level'] < 10) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Редактирование комментария');
        $this->model->edit_comments($id);
        Cms::footer();
    }

    function del_comments($id) {
        if (User::$user['level'] < 20) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Удаление комментария');
        $this->model->del_comments($id);
        Cms::footer();
    }

    function load($id) {
        if (DB::query("SELECT COUNT(*) FROM `files` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->load($id);
    }

    function newfile() {
        Cms::header('Новые файлы');
        $this->model->newfile();
        Cms::footer();
    }

    function top() {
        Cms::header('Популярные файлы');
        $this->model->top();
        Cms::footer();
    }

    function search($search) {
        Cms::header('Поиск файлов');
        $this->model->search($search);
        Cms::footer();
    }

    function moderation() {
        if (User::$user['level'] < 50) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Модерация файлов');
        $this->model->moderation();
        Cms::footer();
    }

    function moderation_yes($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::query("SELECT COUNT(*) FROM `files` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->moderation_yes($id);
    }

    function up($refid, $id) {
        if (User::$user['level'] < 50) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->up($refid, $id);
    }

    function down($refid, $id) {
        if (User::$user['level'] < 50) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->down($refid, $id);
    }

}
