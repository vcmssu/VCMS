<?php

class AdminCoreModel {

    function index() {
        SmartySingleton::instance()->assign(array(
            'users' => DB::run("SELECT COUNT(*) FROM `users`")->fetchColumn(),
            'ads' => DB::run("SELECT COUNT(*) FROM `ads`")->fetchColumn(),
            'logs' => DB::run("SELECT COUNT(*) FROM `adminlogs`")->fetchColumn(),
            'notice' => DB::run("SELECT COUNT(*) FROM `notice`")->fetchColumn(),
            'blog' => DB::run("SELECT COUNT(*) FROM `blog`")->fetchColumn(),
            'blog_category' => DB::run("SELECT COUNT(*) FROM `blog_category`")->fetchColumn(),
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/index.tpl');
    }

}
