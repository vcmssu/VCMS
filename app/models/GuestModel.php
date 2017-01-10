<?php

class GuestModel extends Base {

    function index() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `guest`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `guest`.*, ".User::data('guest')." FROM `guest` ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
                $text[] = Cms::bbcode($row['text']);
            }
        }

        if (isset($_POST['ok']) && $this->user['id'] || isset($_POST['ok']) && Cms::setup('guest') == 1) {

            if (empty($this->user['id'])) {
                if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 32) {
                    $error .= 'Недопустимая длина имени!<br/>';
                }

                if ($_POST['captcha'] != $_COOKIE['code']) {
                    $error .= 'Проверочное число с картинки введено не верно!<br/>';
                }
            }

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 5000) {
                $error .= 'Недопустимая длина текста сообщения!<br/>';
            }

            //проверка на повторяющееся сообщение
            $req = DB::run("SELECT `text` FROM `guest` WHERE `id_user`='" . $this->user['id'] . "' ORDER BY `id` DESC")->fetch(PDO::FETCH_ASSOC);
            if (Cms::Input($_POST['text']) && $req['text'] == Cms::Input($_POST['text'])) {
                $error .= 'Ваше сообщение повторяет предыдущее!<br/>';
            }

            //ограничение на отправку сообщений
            if (DB::run("SELECT COUNT(*) FROM `antiflood` WHERE `ip`='" . Recipe::getClientIP() . "' AND `time` > '" . intval(Cms::realtime() - Cms::setup('antiflood')) . "'")->fetchColumn() > 0) {
                $error .= 'Вы не можете отправлять сообщения чаще 1 раза в ' . Functions::ending_second(Cms::setup('antiflood')) . '! Пожалуйста, немного подождите...';
            }

            if (!isset($error)) {
                DB::run("INSERT INTO `guest` SET 
                    `id_user`='" . $this->user['id'] . "', 
                        `name`='" . Cms::Input($_POST['name']) . "',
                            `text`='" . Cms::Input($_POST['text']) . "', 
                                `time`='" . Cms::realtime() . "'");

                Cms::antiflood(); //антифлуд

                setcookie('name', Cms::Input($_POST['name']), Cms::realtime() + 60 * 60 * 24 + 1, '/'); //записываем имя пользователя в куки

                Functions::redirect(Cms::setup('home') . '/guest');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'text' => $text,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/guest?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/guest/index.tpl');
    }

    function edit($id) {
        Cms::NoDataAdmin('guest', $id);
        $row = DB::run("SELECT * FROM `guest` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 5000) {
                $error .= 'Недопустимая длина текста сообщения!<br/>';
            }

            if (!isset($error)) {
                DB::run("UPDATE `guest` SET 
                    `id_user`='" . $this->user['id'] . "', 
                        `name`='" . Cms::Input($_POST['name']) . "',
                            `text`='" . Cms::Input($_POST['text']) . "' WHERE `id`='" . $row['id'] . "'");
                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Гостевая', 'Отредактировано сообщение ' . Cms::Input($_POST['text']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/guest');
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/guest/edit.tpl');
    }

    function del($id) {
        Cms::NoDataAdmin('guest', $id);
        $row = DB::run("SELECT * FROM `guest` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `guest` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("OPTIMIZE TABLE `guest`");
            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Гостевая', 'Удаление сообщения ' . Functions::esc($row['text']));
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/guest');
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/guest');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => Cms::bbcode($row['text'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/guest/del.tpl');
    }

}
