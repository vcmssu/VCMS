<?php

class GalleryController {

    function __construct() {
        $this->model = new GalleryModel();
    }

    function index($id) {
        if ($id && DB::run("SELECT COUNT(*) FROM `gallery` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        if ($id) {
            $row = DB::run("SELECT * FROM `gallery` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
            Cms::header(Functions::esc($row['name']));
        } else {
            Cms::header('Фотогалерея');
        }
        $this->model->index($id);
        Cms::footer();
    }

    function photo($id, $id2) {
        if (DB::run("SELECT COUNT(*) FROM `gallery_photo` WHERE `id`='" . $id2 . "' AND `id_gallery`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $row = DB::run("SELECT * FROM `gallery_photo` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::header(Functions::esc($row['name']));
        $this->model->photo($id, $id2);
        Cms::footer();
    }

    function load($id) {
        if (DB::run("SELECT COUNT(*) FROM `gallery_photo` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/profile');
        }
        $this->model->load($id);
    }

    function top() {
        Cms::header('Топ фотографий');
        $this->model->top();
        Cms::footer();
    }

    function albums() {
        Cms::header('Альбомы пользователей');
        $this->model->albums();
        Cms::footer();
    }

    function edit_album($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect('/gallery');
        }
        if (DB::run("SELECT COUNT(*) FROM `gallery` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/gallery');
        }
        Cms::header('Редактирование альбома');
        $this->model->edit_album($id);
        Cms::footer();
    }

    function del_album($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect('/gallery');
        }
        if (DB::run("SELECT COUNT(*) FROM `gallery` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/gallery');
        }
        Cms::header('Удаление альбома');
        $this->model->del_album($id);
        Cms::footer();
    }

    function edit($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect('/gallery');
        }
        if (DB::run("SELECT COUNT(*) FROM `gallery_photo` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/gallery');
        }
        Cms::header('Редактирование фотографии');
        $this->model->edit($id);
        Cms::footer();
    }

    function del($id) {
        if (User::$user['level'] < 50) {
            Functions::redirect('/gallery');
        }
        if (DB::run("SELECT COUNT(*) FROM `gallery_photo` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/gallery');
        }
        Cms::header('Удаление фотографии');
        $this->model->del($id);
        Cms::footer();
    }

}
