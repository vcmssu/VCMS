<?php

class AdminUsers {

    function __construct() {
        $this->model = new AdminUsersModel();
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
    }

    function index($page) {
        Cms::header('Список пользователей');
        $this->model->index($page);
        Cms::footer();
    }

    function edit($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('adminpanel'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование пользователя ' . $row['login']);
        $this->model->edit($id);
        Cms::footer();
    }

    function del($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('adminpanel'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление пользователя ' . $row['login']);
        $this->model->del($id);
        Cms::footer();
    }

    function signup() {
        Cms::header('Настройка регистрации');
        $this->model->signup();
        Cms::footer();
    }

    function balls() {
        Cms::header('Управление баллами');
        $this->model->balls();
        Cms::footer();
    }

    function ban($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('adminpanel'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Бан пользователя ' . $row['login']);
        $this->model->ban($id);
        Cms::footer();
    }

    function unban($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('adminpanel'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Разбан пользователя ' . $row['login']);
        $this->model->unban($id);
        Cms::footer();
    }

}
