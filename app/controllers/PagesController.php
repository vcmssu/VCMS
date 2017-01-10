<?php

class PagesController {

    function __construct() {
        $this->model = new PagesModel();
    }

    function index($id) {
        if (DB::run("SELECT COUNT(*) FROM `pages` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect(Cms::setup('home'));
        }

        $row = DB::run("SELECT * FROM `pages` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::header(Functions::esc($row['name']), $row['name'], $row['text']);
        $this->model->index($id);
        Cms::footer();
    }

}
