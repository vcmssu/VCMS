<?php

class AdminPagesModel extends Base {

    function del($id) {
        Cms::NoDataAdmin('pages', $id);

        $row = DB::run("SELECT * FROM `pages` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        DB::run("DELETE FROM `pages` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
        DB::run("OPTIMIZE TABLE `pages`");
        if (Cms::setup('adminlogs') == 1)
            Cms::adminlogs('Страницы', 'Удаление текстовой страницы ' . $row['name']); //пишем лог админа, если включено
        Functions::redirect(Cms::setup('adminpanel') . '/pages');
    }

    function edit($id) {
        Cms::NoDataAdmin('pages', $id);

        $row = DB::run("SELECT * FROM `pages` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 500)
                $error = 'Недопустимая длина названия!';

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 50000)
                $error = 'Недопустимая длина текста!';

            if (!isset($error)) {
                DB::run("UPDATE `pages` SET `name`='" . Cms::Input($_POST['name']) . "', 
                    `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                        `text`='" . Cms::Input($_POST['text']) . "', 
                            `time`='" . Cms::realtime() . "' WHERE `id`='" . intval($row['id']) . "'");
                if (Cms::setup('adminlogs') == 1)
                    Cms::adminlogs('Страницы', 'Редактирование текстовой страницы ' . Cms::Input($_POST['name'])); //пишем лог админа, если включено
                Functions::redirect(Cms::setup('adminpanel') . '/pages');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'row' => $row
        ));
        SmartySingleton::instance()->display(HOME . '/style/admin/pages/edit.tpl');
    }

    function add() {

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 500)
                $error = 'Недопустимая длина названия!';

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 50000)
                $error = 'Недопустимая длина текста!';

            if (!isset($error)) {
                DB::run("INSERT INTO `pages` SET `name`='" . Cms::Input($_POST['name']) . "', 
                    `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                        `text`='" . Cms::Input($_POST['text']) . "', 
                            `time`='" . Cms::realtime() . "'");
                if (Cms::setup('adminlogs') == 1)
                    Cms::adminlogs('Страницы', 'Создание новой текстовой страницы ' . Cms::Input($_POST['name'])); //пишем лог админа, если включено
                Functions::redirect(Cms::setup('adminpanel') . '/pages');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
        SmartySingleton::instance()->display(HOME . '/style/admin/pages/add.tpl');
    }

    function index($page) {
        $start = isset($page) ? number($page) : 0;

        //список
        $count = DB::run("SELECT COUNT(*) FROM `pages`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT * FROM `pages` ORDER BY `time` DESC LIMIT " . $start . ", " . Cms::setup('message'));
            while ($row = $req->fetch(PDO::FETCH_ASSOC))
                $arrayrow[] = $row;
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination(Cms::setup('adminpanel') . '/pages/', $start, $count, Cms::setup('message'))
        ));
        SmartySingleton::instance()->display(HOME . '/style/admin/pages/index.tpl');
    }

}

?>