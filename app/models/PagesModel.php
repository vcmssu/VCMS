<?php

class PagesModel extends Model {

    function index($id) {
        SmartySingleton::instance()->assign(array(
            'row' => DB::run("SELECT * FROM `pages` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/pages/index.tpl');
    }

}

?>