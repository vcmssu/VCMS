<?php

class AdminBlog {

    function __construct() {
        $this->model = new AdminBlogModel();
        if (User::$user['level'] < 100)
            Functions::redirect(Cms::setup('home'));
    }

    function category() {
        Cms::header('Управление блогами');
        $this->model->category();
        Cms::footer();
    }

    function category_edit($id) {
        if (DB::run("SELECT COUNT(*) FROM `blog_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('adminpanel'));
        }
        Cms::header('Управление блогами');
        $this->model->category_edit($id);
        Cms::footer();
    }

    function category_del($id) {
        if (DB::run("SELECT COUNT(*) FROM `blog_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('adminpanel'));
        }
        Cms::header('Управление блогами');
        $this->model->category_del($id);
        Cms::footer();
    }

    function up($id) {
        if (DB::run("SELECT COUNT(*) FROM `blog_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('adminpanel'));
        }
        $this->model->up($id);
    }

    function down($id) {
        if (DB::run("SELECT COUNT(*) FROM `blog_category` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('adminpanel'));
        }
        $this->model->down($id);
    }

}
