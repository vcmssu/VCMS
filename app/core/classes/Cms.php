<?php

class Cms {

    //настройки сайта
    static function setting() {
        $setting = DB::run("SELECT * FROM `setting`");
        $setup = array();
        while ($set = $setting->fetch(PDO::FETCH_ASSOC)) {
            $setup[$set['name']] = $set['value'];
        }
        return $setup;
    }

    //вытаскиваем одну настройку
    static function setup($name) {
        $query = DB::run("SELECT * FROM `setting` WHERE `name`='" . $name . "'")->fetch(PDO::FETCH_ASSOC);
        return $query['value'];
    }

    //шапка сайта
    static function header($title, $keywords = false, $description = false) {
        SmartySingleton::instance()->assign(array(
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
            'smile' => self::smile(),
            'lastthems' => self::lastthems(),
            'blog' => DB::run("SELECT COUNT(*) FROM `blog`")->fetchColumn(),
            'guest' => DB::run("SELECT COUNT(*) FROM `guest`")->fetchColumn(),
            'users' => DB::run("SELECT COUNT(*) FROM `users`")->fetchColumn(),
            'gallery' => DB::run("SELECT COUNT(*) FROM `gallery`")->fetchColumn(),
            'gallery_photo' => DB::run("SELECT COUNT(*) FROM `gallery_photo`")->fetchColumn(),
            'tema' => DB::run("SELECT COUNT(*) FROM `tema`")->fetchColumn(),
            'post' => DB::run("SELECT COUNT(*) FROM `post`")->fetchColumn(),
            'download' => DB::run("SELECT COUNT(*) FROM `files` WHERE `id_file`='0' AND `user`='0'")->fetchColumn(),
            'downloadnew' => DB::run("SELECT COUNT(*) FROM `files` WHERE `size` > '0' AND `time` > '" . intval(self::realtime() - self::setup('newfile')) . "' AND `id_file`='0' AND `user`='0'")->fetchColumn(),
            'usersonline' => DB::run("SELECT COUNT(*) FROM `online` WHERE `type` = '1'")->fetchColumn(),
            'guestonline' => DB::run("SELECT COUNT(*) FROM `online` WHERE `type` = '2'")->fetchColumn(),
            'library' => DB::run("SELECT COUNT(*) FROM `library`")->fetchColumn(),
            'adsheadindex' => Ads::head_index(),
            'adsheadnoindex' => Ads::head_no_index(),
            'adshead' => Ads::head(),
            'adsfoot' => Ads::foot(),
            'adsleft' => Ads::left()
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/system/header.tpl');
    }

    //футер сайта
    static function footer() {
        SmartySingleton::instance()->assign(array(
            'times_page' => round(Functions::times_page() - TIMESTART, 4)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/system/footer.tpl');
    }

    //текущее время
    static function realtime($time) {
        if (User::$user['id']) {
            date_default_timezone_set(User::$user['timezone']);
        } //временная зона авторизованного пользователя
        else {
            date_default_timezone_set(self::setup('timezone'));
        } //временная зона сайта
        $time = intval(time());
        return $time;
    }

    static function NoDataAdmin($table, $id) {
        $counts = DB::run("SELECT COUNT(*) FROM `$table` WHERE `id`='" . intval($id) . "'")->fetchColumn();
        if ($counts == 0) {
            SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/no.tpl');
            self::footer();
            exit;
        }
    }

    function DelFile($file) {
        if (is_file($file)) {
            unlink($file);
        }
    }

    function DelDir($directory) {
        $dir = scandir($directory);
        $dir = array_slice($dir, 2);
        foreach ($dir as $file) {
            $file = $directory . '/' . $file;
            if (is_dir($file)) {
                self::DelDir($file);
                if (is_dir($file)) {
                    rmdir($file);
                }
            } else {
                unlink($file);
            }
        }
        rmdir($directory);
    }

    function mres($value) {
        $search = array(
            "\\",
            "\x00",
            "\n",
            "\r",
            "'",
            '"',
            "\x1a"
        );
        $replace = array(
            "\\\\",
            "\\0",
            "\\n",
            "\\r",
            "\'",
            '\"',
            "\\Z"
        );

        return str_replace($search, $replace, $value);
    }

    function Input($txt) {
        $txt = preg_replace('!<script[^>]*>(.)*</script>!Uis', '', $txt); //вырезаем js
        $txt = htmlentities(trim($txt), ENT_QUOTES, 'UTF-8');
        //$txt = preg_replace('~<script[^>]*>.*?</script>~si', '', $txt);  
        //$txt = preg_replace('!<script[^>]*>(.)*</script>!Uis', '', $txt); 
        $txt = stripslashes($txt); // удаляем слэши
        $txt = trim($txt); // удаляем пробелы по бокам (если нужно только с одного бока удалить пробелы есть функции ltrim() и rtrim()
        $txt = htmlspecialchars($txt); // переводим HTML в текст
        $txt = preg_replace("~ +~", " ", $txt); // множественные пробелы заменяем на одинарные
        $txt = preg_replace("/(\r\n){3,}/", "\r\n\r\n", $txt); // убираем лишние переводы строк
        $txt = str_replace("\'", "&#39;", $txt);
        $txt = str_replace('\\', "&#92;", $txt);
        $txt = str_replace("|", "I", $txt);
        $txt = str_replace("||", "I", $txt);
        $txt = str_replace("/\\\$/", "&#36;", $txt);
        //$simb = array("'","`");
        //$txt=str_replace($simb,"",$txt);
        $txt = self::mres($txt);
        # Если точно знаете, что в форме ничего кроме цифр и текста не будет снимите комментарий
        # $txt= preg_replace ("/[^a-zA-Zа-яА-Я0-9-_.]/","",$txt);
        return $txt; //возвращаем переменную
    }

    function Int($txt) {
        return abs(intval($txt));
    }

    //логи админа
    function adminlogs($modul, $text) {
        DB::run("INSERT INTO `adminlogs` SET 
            `id_user`='" . User::$user['id'] . "',
                `modul`='" . $modul . "', 
                    `text`='" . $text . "', 
                        `ip`='" . Recipe::getClientIP() . "', 
                            `browser`='" . Recipe::getBrowser() . "', 
                                `time`='" . self::realtime() . "'");
    }

    //история авторизаций
    function history($id) {
        DB::run("INSERT INTO `history` SET 
            `id_user`='" . $id . "',
                `ip`='" . Recipe::getClientIP() . "', 
                    `browser`='" . Recipe::getBrowser() . "', 
                        `time`='" . self::realtime() . "'");
    }

    //уведомления
    function notice($id_user, $user_id, $text, $url = false) {
        DB::run("INSERT INTO `notice` SET 
            `id_user`='" . intval($id_user) . "',
                `user_id`='" . intval($user_id) . "',
                    `text`='" . self::Input($text) . "', 
                        `url`='" . self::Input($url) . "', 
                            `time`='" . self::realtime() . "'");
    }

    //антифлуд
    function antiflood() {
        DB::run("INSERT INTO `antiflood` SET 
                    `ip`='" . Recipe::getClientIP() . "', 
                        `time`='" . self::realtime() . "'");
    }

    //хлебные крошки для ЗЦ
    function BreadcrumbDownload($id) {
        $nadir = $id;
        while ($nadir != "") {
            $dnew = DB::run("SELECT * FROM `category` WHERE `id` = '" . $nadir . "'");
            $dnew1 = $dnew->fetch(PDO::FETCH_ASSOC);
            if ($dnew1['id']) {
                $pat[] = ' / <a href="' . self::setup('home') . '/download/' . $dnew1['id'] . '">' . Functions::esc($dnew1['name']) . '</a> ';
            }
            $nadir = $dnew1['refid'];
        }
        krsort($pat);
        return $pat;
    }

    //хлебные крошки для библиотеки
    function BreadcrumbLibrary($id) {
        $nadir = $id;
        while ($nadir != "") {
            $dnew = DB::run("SELECT * FROM `library_category` WHERE `id` = '" . $nadir . "'");
            $dnew1 = $dnew->fetch(PDO::FETCH_ASSOC);
            if ($dnew1['id']) {
                $pat[] = ' / <a href="' . self::setup('home') . '/library/' . $dnew1['id'] . '">' . Functions::esc($dnew1['name']) . '</a> ';
            }
            $nadir = $dnew1['refid'];
        }
        krsort($pat);
        return $pat;
    }

    //автоочистка
    function AutoClear() {
        //очищаем антифлуд
        if (DB::run("DELETE FROM `antiflood` WHERE `time` < '" . intval(self::realtime() - 300) . "'")) {
            DB::run("OPTIMIZE TABLE `antiflood`");
        }

        //очищяем онлайн
        if (DB::run("DELETE FROM `online` WHERE `time` < '" . intval(self::realtime() - 300) . "'")) {
            DB::run("OPTIMIZE TABLE `online`");
        }

        //очищяем гостевую
        if (self::setup('autoclear_guest') > 0 && DB::run("DELETE FROM `guest` WHERE `time` < '" . intval(self::realtime() - 86400 * self::setup('autoclear_guest')) . "'")) {
            DB::run("OPTIMIZE TABLE `guest`");
        }

        //снимаем бан
        if (DB::run("SELECT `ban`, `bantime` FROM `users` WHERE `bantime` < '" . intval(self::realtime()) . "'")) {
            DB::run("UPDATE `users` SET `ban` = '0' WHERE `bantime` < '" . intval(self::realtime()) . "'");
        }
    }

    //бб коды для текста
    function bbcode($text) {
        $bbcode = new BBcode;
        $text = $bbcode->bb($text);
        $text = $bbcode->smiles($text);
        return $text;
    }

    //смайлы пользователя или гостя
    function smile() {
        if (User::$user['id'] && DB::run("SELECT COUNT(*) FROM `smiles_user` WHERE `id_user` = '" . User::$user['id'] . "'")->fetchColumn() > 0) {
            $req = DB::run("SELECT `smiles_user`.*, 
                            `smiles`.`code`, `smiles`.`photo`
                                FROM `smiles` LEFT JOIN `smiles_user` ON `smiles`.`id` = `smiles_user`.`id_smile` WHERE `id_user` = '" . User::$user['id'] . "' ORDER BY `id` ASC");
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        } else {
            $count = DB::run("SELECT COUNT(*) FROM `smiles`")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT * FROM `smiles` ORDER BY rand() LIMIT " . self::setup('count_smiles'));
                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $row;
                }
            }
        }
        return $arrayrow;
    }

    //добавление комментария
    function comments($table, $ref, $refid, $user, $captcha, $url, $blog = false) {
        if (isset($_POST['ok']) && $user) {

            if (mb_strlen(self::Input($_POST['text'])) < 2 || mb_strlen(self::Input($_POST['text'])) > 5000) {
                $error .= 'Недопустимая длина текста комментария!<br/>';
            }

            //проверка на повторяющееся сообщение
            $req = DB::run("SELECT `text` FROM `$table` WHERE `$ref`='" . $refid . "' AND `id_user`='" . $user . "' ORDER BY `id` DESC")->fetch(PDO::FETCH_ASSOC);
            if (self::Input($_POST['text']) && $req['text'] == self::Input($_POST['text'])) {
                $error .= 'Ваше сообщение повторяет предыдущее!<br/>';
            }

            //ограничение на отправку сообщений
            if (DB::run("SELECT COUNT(*) FROM `antiflood` WHERE `ip`='" . Recipe::getClientIP() . "' AND `time` > '" . intval(self::realtime() - self::setup('antiflood')) . "'")->fetchColumn() > 0) {
                $error .= 'Вы не можете отправлять сообщения чаще 1 раза в ' . Functions::ending_second(self::setup('antiflood')) . '! Пожалуйста, немного подождите...<br/>';
            }

            if (self::setup($captcha) == 1 && $_POST['captcha'] != $_COOKIE['code']) {
                $error .= 'Проверочное число с картинки введено не верно!<br/>';
            }

            if (!isset($error)) {
                if ($blog) {
                    DB::run("INSERT INTO `$table` SET 
                    `refid`='" . $blog . "', 
                        `$ref`='" . $refid . "',
                        `id_user`='" . $user . "', 
                           `text`='" . self::Input($_POST['text']) . "', 
                               `time`='" . self::realtime() . "'");
                } else {
                    DB::run("INSERT INTO `$table` SET 
                `$ref`='" . $refid . "', 
                    `id_user`='" . $user . "', 
                       `text`='" . self::Input($_POST['text']) . "', 
                           `time`='" . self::realtime() . "'");
                }

                self::antiflood(); //антифлуд

                Functions::redirect(self::setup('home') . '/' . $url);
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
    }

    //голосование
    function addrating($tablefirst, $table, $ref, $user) {
        if (isset($_POST['ok']) && $user) {
            if (DB::run("SELECT COUNT(*) FROM `$table` WHERE `refid`='" . $ref['id'] . "' AND `id_user`='" . $user . "'")->fetchColumn() == 0) {
                DB::run("INSERT INTO `$table` SET 
                    `refid`='" . $ref['id'] . "', 
                        `id_user`='" . $user . "', 
                           `rating`='" . intval($_POST['rating']) . "', 
                               `time`='" . self::realtime() . "'");
                //вычисляем рейтинг
                $count = DB::run("SELECT COUNT(*) FROM `$table` WHERE `refid`='" . $ref['id'] . "'")->fetchColumn();
                $countsum = DB::run("SELECT SUM(`rating`) FROM `$table` WHERE `refid`='" . $ref['id'] . "'")->fetchColumn();
                $ratingall = $countsum / $count;

                DB::run("UPDATE `$tablefirst` SET `rating` = '" . round($ratingall, 2) . "' WHERE `id`='" . intval($ref['id']) . "'");
            }
        }
    }

    //добавляем 1 просмотр к выбранному модулю
    function addviews($table, $refid) {
        DB::run("UPDATE `$table` SET `views` = '" . intval($refid['views'] + 1) . "' WHERE `id` = '" . $refid['id'] . "'");
    }

    //прибавляем баллы
    function addballs($module) {
        if (User::$user['id']) {
            DB::run("UPDATE `users` SET `balls` = '" . self::Int(User::$user['balls'] + $module) . "' WHERE `id` = '" . User::$user['id'] . "'");
        }
    }

    //новые темы на форуме
    function lastthems() {
        if (empty(User::$user['id'])) {
            $filter = " WHERE `type` = '0'";
        } else if (User::$user['id'] && User::$user['level'] == 1) {
            $filter = " WHERE `type` != '2'";
        }

        $array = DB::run("SELECT `tema`.*,
                                    `users`.`login`
                                        FROM `tema` LEFT JOIN `users` ON `tema`.`id_user_last` = `users`.`id`$filter ORDER BY `time` DESC LIMIT " . self::setup('lastthems'))->fetchAll();
        return $array;
    }

}
