<?php

class ProfileController {

    function __construct() {
        $this->model = new ProfileModel();
        if (User::$user['id'] == null) {
            Functions::redirect(Cms::setup('home'));
        }
    }

    function index() {
        Cms::header('Мой кабинет');
        $this->model->index();
        Cms::footer();
    }

    function mail() {
        Cms::header('Почта');
        $this->model->mail();
        Cms::footer();
    }

    function mail_id($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        if ($row['id'] == User::$user['id']) {
            Functions::redirect('/profile');
        }
        Cms::header('Переписка с пользователем ' . Functions::esc($row['login']));
        $this->model->mail_id($id);
        Cms::footer();
    }

    function mail_load($id) {
        if (DB::run("SELECT COUNT(*) FROM `mail_files` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->mail_load($id);
    }

    function my() {
        Cms::header('Анкета');
        $this->model->my();
        Cms::footer();
    }

    function setup() {
        Cms::header('Мои настройки');
        $this->model->setup();
        Cms::footer();
    }

    function security() {
        Cms::header('Настройки безопасности');
        $this->model->security();
        Cms::footer();
    }

    function history() {
        Cms::header('История авторизаций');
        $this->model->history();
        Cms::footer();
    }

    function bookmark() {
        Cms::header('Закладки');
        $this->model->bookmark();
        Cms::footer();
    }

    function notice() {
        Cms::header('Уведомления');
        $this->model->notice();
        Cms::footer();
    }
    
    function notice_clear() {
        Cms::header('Уведомления');
        $this->model->notice_clear();
        Cms::footer();
    }

    function bookmark_add() {
        Cms::header('Добавление в закладки');
        $this->model->bookmark_add();
        Cms::footer();
    }

    function bookmark_edit($id) {
        if (DB::run("SELECT COUNT(*) FROM `bookmark` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }

        $row = DB::run("SELECT * FROM `bookmark` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::header('Редактирование закладки ' . Functions::esc($row['name']));
        $this->model->bookmark_edit($id);
        Cms::footer();
    }

    function bookmark_del($id) {
        if (DB::run("SELECT COUNT(*) FROM `bookmark` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }

        $row = DB::run("SELECT * FROM `bookmark` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::header('Удаление закладки ' . Functions::esc($row['name']));
        $this->model->bookmark_del($id);
        Cms::footer();
    }

    function friends() {
        Cms::header('Список друзей');
        $this->model->friends();
        Cms::footer();
    }

    function friends_add($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        if ($row['id'] == User::$user['id'] || DB::run("SELECT COUNT(*) FROM `friends` WHERE `id_user`='" . User::$user['id'] . "' AND `user_id`='" . $id . "' OR `id_user`='" . $id . "' AND `user_id`='" . User::$user['id'] . "'")->fetchColumn() > 0) {
            Functions::redirect('/profile');
        }
        Cms::header('Заявка на добавление в друзья пользователя ' . Functions::esc($row['login']));
        $this->model->friends_add($id);
        Cms::footer();
    }

    function friends_del($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        if ($row['id'] == User::$user['id'] || DB::run("SELECT COUNT(*) FROM `friends` WHERE `id_user`='" . User::$user['id'] . "' AND `user_id`='" . $id . "' OR `id_user`='" . $id . "' AND `user_id`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        Cms::header('Удаление пользователя ' . Functions::esc($row['login']) . ' из друзей');
        $this->model->friends_del($id);
        Cms::footer();
    }

    function friends_yes($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        if ($row['id'] == User::$user['id'] || DB::run("SELECT COUNT(*) FROM `friends` WHERE `user_id`='" . User::$user['id'] . "' AND `status`='0'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        Cms::header('Заявка на добавление в друзья подтверждена');
        $this->model->friends_yes($id);
        Cms::footer();
    }

    function blacklist() {
        Cms::header('Черный список');
        $this->model->blacklist();
        Cms::footer();
    }

    function blacklist_add($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        if ($row['id'] == User::$user['id'] || DB::run("SELECT COUNT(*) FROM `blacklist` WHERE `id_user`='" . User::$user['id'] . "' AND `user_id`='" . $row['id'] . "'")->fetchColumn() > 0) {
            Functions::redirect('/profile');
        }
        $this->model->blacklist_add($id);
    }

    function blacklist_del($id) {
        if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        if ($row['id'] == User::$user['id'] || DB::run("SELECT COUNT(*) FROM `blacklist` WHERE `id_user`='" . User::$user['id'] . "' AND `user_id`='" . $row['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $this->model->blacklist_del($id);
    }

    function blog() {
        Cms::header('Мой блог');
        $this->model->blog();
        Cms::footer();
    }

    function blog_add() {
        Cms::header('Добавить пост');
        $this->model->blog_add();
        Cms::footer();
    }

    function blog_edit($id) {
        if (DB::run("SELECT COUNT(*) FROM `blog` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `blog` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование поста ' . Functions::esc($row['name']));
        $this->model->blog_edit($id);
        Cms::footer();
    }

    function blog_del($id) {
        if (DB::run("SELECT COUNT(*) FROM `blog` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `blog` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление поста ' . Functions::esc($row['name']));
        $this->model->blog_del($id);
        Cms::footer();
    }

    function gallery($id) {
        if ($id && DB::run("SELECT COUNT(*) FROM `gallery` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        Cms::header('Фотоальбомы');
        $this->model->gallery($id);
        Cms::footer();
    }

    function gallery_add() {
        Cms::header('Добавить альбом');
        $this->model->gallery_add();
        Cms::footer();
    }

    function gallery_add_photo($id) {
        if (DB::run("SELECT COUNT(*) FROM `gallery` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        Cms::header('Добавить фото');
        $this->model->gallery_add_photo($id);
        Cms::footer();
    }

    function gallery_edit_album($id) {
        if (DB::run("SELECT COUNT(*) FROM `gallery` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        Cms::header('Редактирование альбома');
        $this->model->gallery_edit_album($id);
        Cms::footer();
    }

    function gallery_del_album($id) {
        if (DB::run("SELECT COUNT(*) FROM `gallery` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        Cms::header('Удаление альбома');
        $this->model->gallery_del_album($id);
        Cms::footer();
    }

    function gallery_edit($id) {
        if (DB::run("SELECT COUNT(*) FROM `gallery_photo` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `gallery_photo` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование фотографии ' . Functions::esc($row['name']));
        $this->model->gallery_edit($id);
        Cms::footer();
    }

    function gallery_del($id) {
        if (DB::run("SELECT COUNT(*) FROM `gallery_photo` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `gallery_photo` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление фотографии ' . Functions::esc($row['name']));
        $this->model->gallery_del($id);
        Cms::footer();
    }

    function library() {
        Cms::header('Статьи');
        $this->model->library();
        Cms::footer();
    }

    function library_edit($id) {
        if (DB::run("SELECT COUNT(*) FROM `library` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование статьи ' . Functions::esc($row['name']));
        $this->model->library_edit($id);
        Cms::footer();
    }

    function library_del($id) {
        if (DB::run("SELECT COUNT(*) FROM `library` WHERE `id`='" . $id . "' AND `id_user`='" . User::$user['id'] . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление статьи ' . Functions::esc($row['name']));
        $this->model->library_del($id);
        Cms::footer();
    }

    function files() {
        Cms::header('Файлы');
        $this->model->files();
        Cms::footer();
    }

}
