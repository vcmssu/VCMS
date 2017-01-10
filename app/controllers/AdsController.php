<?php

class AdsController {

    function __construct() {
        $this->model = new AdsModel();
    }

    function index($id) {
        if (DB::run("SELECT COUNT(*) FROM `ads` WHERE `id`='" . $id . "'")->fetchColumn() == 0) {
            Functions::redirect('/');
        }

        $row = DB::run("SELECT * FROM `ads` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $this->model->view($id);
    }

}
