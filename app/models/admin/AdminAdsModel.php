<?php

class AdminAdsModel extends Base {

    function index() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `ads`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `ads`.*, (SELECT COUNT(1) FROM `ads_stat` WHERE `ads_stat`.`id_link`=`ads`.`id`) AS `counts` FROM `ads` ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination(Cms::setup('adminpanel') . '/ads?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/ads/index.tpl');
    }

    function add() {
        if ($_POST['ok']) {

            $time = Cms::realtime() + $_POST['ch'] * $_POST['mn'] * 60 * 60 * 24;

            if (empty($_POST['link'])) {
                $error .= 'Не указана ссылка!<br/>';
            }

            if (empty($_POST['text'])) {
                $error .= 'Не введен текст, содержание рекламного материала!<br/>';
            }

            if (!isset($error)) {
                DB::run("INSERT INTO `ads` SET 
                    `link`='" . Cms::Input($_POST['link']) . "', 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `text`='" . Cms::Input($_POST['text']) . "', 
                                `type`='" . Cms::Input($_POST['type']) . "', 
                                    `target`='" . Cms::Input($_POST['target']) . "', 
                                        `count`='" . Cms::Input($_POST['count']) . "', `time`='" . $time . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Рекламный менеджер', 'Добавление новой рекламной ссылки ' . Cms::Input($_POST['link']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('adminpanel') . '/ads');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/ads/add.tpl');
    }

    function edit($id) {
        $row = DB::run("SELECT * FROM `ads` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if ($row['time'] > Cms::realtime()) {
                $time = $row['time'] + $_POST['ch'] * $_POST['mn'] * 60 * 60 * 24;
            } else {
                $time = Cms::realtime() + $_POST['ch'] * $_POST['mn'] * 60 * 60 * 24;
            }

            if (empty($_POST['link'])) {
                $error .= 'Не указана ссылка!<br/>';
            }

            if (empty($_POST['text'])) {
                $error = 'Не введен текст, содержание рекламного материала!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `ads` SET 
                    `link`='" . Cms::Input($_POST['link']) . "', 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `text`='" . Cms::Input($_POST['text']) . "', 
                                `type`='" . Cms::Input($_POST['type']) . "', 
                                    `target`='" . Cms::Input($_POST['target']) . "', 
                                        `count`='" . Cms::Input($_POST['count']) . "', `time`='" . $time . "' WHERE `id`='" . $row['id'] . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Рекламный менеджер', 'Редактирование рекламной ссылки ' . Cms::Input($_POST['link']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('adminpanel') . '/ads');
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/ads/edit.tpl');
    }

    function del($id) {
        $row = DB::run("SELECT * FROM `ads` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `ads` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("DELETE FROM `ads_stat` WHERE `id_link` = '" . $row['id'] . "'");
            DB::run("OPTIMIZE TABLE `ads`");
            DB::run("OPTIMIZE TABLE `ads_stat`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Рекламный менеджер', 'Удаление рекламной ссылки ' . Cms::Input($_POST['link']));
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('adminpanel') . '/ads');
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('adminpanel') . '/ads');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/ads/del.tpl');
    }

    function stat($id) {
        $row = DB::run("SELECT * FROM `ads` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `ads_stat` WHERE `id_link`=" . $row['id'] . "")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT * FROM `ads_stat` WHERE `id_link`=" . $row['id'] . " ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination(Cms::setup('adminpanel') . '/ads/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/ads/stat.tpl');
    }

}
