<?php

class ForumController {

    function __construct() {
        $this->model = new ForumModel();
    }

    function index($id) {
        if ($id) {
            if (DB::run("SELECT COUNT(*) FROM `forum` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
                Functions::redirect(Cms::setup('home'));
            }

            $rows = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

            if ($rows['type'] == 1 && empty(User::$user['id'])) {
                Functions::redirect(Cms::setup('home'));
            }

            if ($rows['type'] == 2 && User::$user['level'] < 10) {
                Functions::redirect(Cms::setup('home'));
            }

            Cms::header(Functions::esc($rows['name']), $rows['keywords'], $rows['description']);
        } else {
            Cms::header('Форум');
        }
        $this->model->index($id);
        Cms::footer();
    }

    function forum($id, $id2) {
        if (DB::run("SELECT COUNT(*) FROM `forum` WHERE `id`='" . $id2 . "' AND `refid`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }

        $rows = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($rows['type'] == 1 && empty(User::$user['id'])) {
            Functions::redirect(Cms::setup('home'));
        }

        if ($rows['type'] == 2 && User::$user['level'] < 10) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header(Functions::esc($forum['name']) . ' / ' . Functions::esc($rows['name']), $rows['keywords'], $rows['description']);
        $this->model->forum($id, $id2);
        Cms::footer();
    }

    function add($id, $id2) {
        if (User::$user['id'] == null) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `forum` WHERE `id`='" . $id2 . "' AND `refid`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Создание новой темы');
        $this->model->add($id, $id2);
        Cms::footer();
    }

    function theme($id, $id2, $id3) {
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id3 . "' AND `id_razdel`='" . $id . "' AND `id_forum`='" . $id2 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $rows = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header(Functions::esc($rows['name']));
        $this->model->theme($id, $id2, $id3);
        Cms::footer();
    }

    function load($id, $id2, $id3, $id4) {
        if (DB::run("SELECT COUNT(*) FROM `post_files` WHERE `id`='" . $id4 . "' AND `id_razdel`='" . $id . "' AND `id_forum`='" . $id2 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->load($id, $id2, $id3, $id4);
    }

    function add_forum($id) {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Создание раздела (подраздела)');
        $this->model->add_forum($id);
        Cms::footer();
    }

    function setup($id) {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `forum` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Параметры раздела ' . Functions::esc($row['name']));
        $this->model->setup($id);
        Cms::footer();
    }

    function setup_del($id) {
        if (User::$user['level'] < 100) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `forum` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление раздела ' . Functions::esc($row['name']));
        $this->model->setup_del($id);
        Cms::footer();
    }

    function closed($id) {
        if (User::$user['level'] < 30) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->closed($id);
    }

    function open($id) {
        if (User::$user['level'] < 30) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->open($id);
    }

    function tema_up($id) {
        if (User::$user['level'] < 30) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->tema_up($id);
    }

    function tema_down($id) {
        if (User::$user['level'] < 30) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $this->model->tema_down($id);
    }

    function tema_setup($id) {
        if (User::$user['level'] < 30) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Параметры темы ' . Functions::esc($row['name']));
        $this->model->tema_setup($id);
        Cms::footer();
    }

    function tema_del($id) {
        if (User::$user['level'] < 30) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление темы ' . Functions::esc($row['name']));
        $this->model->tema_del($id);
        Cms::footer();
    }

    function post_setup($id) {
        if (User::$user['level'] < 30) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `post` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `post` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Редактирование сообщения');
        $this->model->post_setup($id);
        Cms::footer();
    }

    function post_del($id) {
        if (User::$user['level'] < 30) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `post` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `post` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Удаление сообщения');
        $this->model->post_del($id);
        Cms::footer();
    }

    function post_reply($id, $id2, $id3, $id4) {
        if (User::$user['id'] == null) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `forum` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `forum` WHERE `id`='" . $id2 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id3 . "' AND `closed`='0'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `post` WHERE `id`='" . $id4 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `post` WHERE `id`='" . $id4 . "'")->fetch(PDO::FETCH_ASSOC);
        if ($row['id_user'] == User::$user['id']) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Ответ на пост');
        $this->model->post_reply($id, $id2, $id3, $id4);
        Cms::footer();
    }

    function post_quote($id, $id2, $id3, $id4) {
        if (User::$user['id'] == null) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `forum` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `forum` WHERE `id`='" . $id2 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id3 . "' AND `closed`='0'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        if (DB::run("SELECT COUNT(*) FROM `post` WHERE `id`='" . $id4 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `post` WHERE `id`='" . $id4 . "'")->fetch(PDO::FETCH_ASSOC);
        if ($row['id_user'] == User::$user['id']) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Цитирование сообщения');
        $this->model->post_quote($id, $id2, $id3, $id4);
        Cms::footer();
    }

    function new_thems() {
        Cms::header('Новые темы');
        $this->model->new_thems();
        Cms::footer();
    }

    function new_posts() {
        Cms::header('Новые посты');
        $this->model->new_posts();
        Cms::footer();
    }

    function search($search) {
        Cms::header('Поиск');
        $this->model->search($search);
        Cms::footer();
    }

    function files($id, $id2, $id3) {
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id3 . "' AND `id_razdel`='" . $id . "' AND `id_forum`='" . $id2 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $rows = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Файлы темы ' . Functions::esc($rows['name']));
        $this->model->files($id, $id2, $id3);
        Cms::footer();
    }

    function vote($id, $id2, $id3) {
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id3 . "' AND `id_razdel`='" . $id . "' AND `id_forum`='" . $id2 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);
        if (User::$user['level'] < 30 && User::$user['id'] != $row['id_user']) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Голосование к теме ' . Functions::esc($row['name']));
        $this->model->vote($id, $id2, $id3);
        Cms::footer();
    }

    function vote_edit($id, $id2, $id3) {
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id3 . "' AND `id_razdel`='" . $id . "' AND `id_forum`='" . $id2 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);
        if (User::$user['level'] < 30 && User::$user['id'] != $row['id_user']) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Редактирование голосования к теме ' . Functions::esc($row['name']));
        $this->model->vote_edit($id, $id2, $id3);
        Cms::footer();
    }

    function vote_del($id, $id2, $id3) {
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id3 . "' AND `id_razdel`='" . $id . "' AND `id_forum`='" . $id2 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);
        if (User::$user['level'] < 30 && User::$user['id'] != $row['id_user']) {
            Functions::redirect(Cms::setup('home'));
        }
        Cms::header('Удаление голосования к теме ' . Functions::esc($row['name']));
        $this->model->vote_del($id, $id2, $id3);
        Cms::footer();
    }

    function vote_all($id, $id2, $id3) {
        if (DB::run("SELECT COUNT(*) FROM `tema` WHERE `id`='" . $id3 . "' AND `id_razdel`='" . $id . "' AND `id_forum`='" . $id2 . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }
        $row = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header('Список проголосовавших в теме ' . Functions::esc($row['name']));
        $this->model->vote_all($id, $id2, $id3);
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

}
