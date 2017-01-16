<?php

class UserController {

    function __construct() {
        $this->model = new UserModel();
    }

    function index($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header(Functions::esc($row['login']));
        $this->model->index($id);
        Cms::footer();
    }

    function login() {
        Cms::header('Авторизация');
        $this->model->login();
        Cms::footer();
    }

    function signup() {
        Cms::header('Регистрация');
        $this->model->signup();
        Cms::footer();
    }

    function lostpass($id, $code) {
        Cms::header('Восстановление пароля');
        $this->model->lostpass($id, $code);
        Cms::footer();
    }

    function activation($id, $code) {
        Cms::header('Активация аккаунта');
        $this->model->activation($id, $code);
        Cms::footer();
    }

    function users() {
        Cms::header('Список пользователей');
        $this->model->users();
        Cms::footer();
    }
    
    function users_admin() {
        Cms::header('Администрация сайта');
        $this->model->users_admin();
        Cms::footer();
    }

    function ban() {
        if (User::$user['ban'] == 0 || User::$user['bantime'] < Cms::realtime()) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Вы забанены!');
        $this->model->ban();
        Cms::footer();
    }

    function logout() {
        $this->model->logout();
    }

}
