<?php

class ActiveController {

    function __construct() {
        $this->model = new ActiveModel();
    }

    function guest($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Сообщения в гостевой пользователя ' . Functions::esc($row['login']));
        $this->model->guest($id);
        Cms::footer();
    }

    function thems($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Темы на форуме пользователя ' . Functions::esc($row['login']));
        $this->model->thems($id);
        Cms::footer();
    }

    function posts($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Посты на форуме пользователя ' . Functions::esc($row['login']));
        $this->model->posts($id);
        Cms::footer();
    }

    function download($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Файлы в загрузках пользователя ' . Functions::esc($row['login']));
        $this->model->download($id);
        Cms::footer();
    }

    function blogs($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Посты в блоге пользователя ' . Functions::esc($row['login']));
        $this->model->blogs($id);
        Cms::footer();
    }

    function news_comments($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Комментарии к новостям пользователя ' . Functions::esc($row['login']));
        $this->model->news_comments($id);
        Cms::footer();
    }

    function download_comments($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Комментарии к файлам пользователя ' . Functions::esc($row['login']));
        $this->model->download_comments($id);
        Cms::footer();
    }

    function blogs_comments($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Комментарии к блогам пользователя ' . Functions::esc($row['login']));
        $this->model->blogs_comments($id);
        Cms::footer();
    }

    function gallery($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Фотографий в галерее пользователя ' . Functions::esc($row['login']));
        $this->model->gallery($id);
        Cms::footer();
    }

    function library($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Статьи в библиотеке пользователя ' . Functions::esc($row['login']));
        $this->model->library($id);
        Cms::footer();
    }

    function library_comments($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Комментарии к статьям пользователя ' . Functions::esc($row['login']));
        $this->model->library_comments($id);
        Cms::footer();
    }

}
