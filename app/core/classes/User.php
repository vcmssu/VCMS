<?php

class User {

    public static $user = array();

    public static function auth() {
        /* Авторизация */
        if (isset($_COOKIE['id_user']) && isset($_COOKIE['hashcode']) && $_COOKIE['id_user'] != NULL && $_COOKIE['hashcode'] != NULL) {
            $userdata = DB::run("SELECT * FROM `users` WHERE `id` = " . Cms::Int($_COOKIE['id_user']) . " AND `hashcode` = '" . Cms::Input($_COOKIE['hashcode']) . "' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            if ($userdata['id']) {
                /* записываем последнее посещение */
                DB::run("UPDATE LOW_PRIORITY `users` SET `date_last`='" . Cms::realtime() . "' WHERE `id`='" . $userdata['id'] . "'");

                /* онлайн */
                if (DB::run("SELECT COUNT(*) FROM `online` WHERE `id_user`='" . $userdata['id'] . "'")->fetchColumn() > 0) {
                    DB::run("UPDATE LOW_PRIORITY `online` SET `time`='" . Cms::realtime() . "', `referer`='" . Cms::Input(Cms::setup('home') . '' . Functions::GET_PATH_INFO()) . "' WHERE `id_user`='" . $userdata['id'] . "'");
                } else {
                    DB::run("INSERT INTO LOW_PRIORITY `online` SET 
                       `id_user`='" . $userdata['id'] . "', 
                           `ip`='" . Recipe::getClientIP() . "', 
                                `browser`='" . Recipe::getBrowser() . "',
                                    `referer`='" . Cms::Input(Cms::setup('home') . '' . Functions::GET_PATH_INFO()) . "',
                                        `time`='" . Cms::realtime() . "'");
                }

                SmartySingleton::instance()->assign(array(
                    'newnotice' => DB::run("SELECT COUNT(*) FROM `notice` WHERE `id_user`='" . $userdata['id'] . "' AND `status`='1'")->fetchColumn(),
                    'newmail' => DB::run("SELECT COUNT(*) FROM `mail` WHERE `user_id`= '" . $userdata['id'] . "' AND `read`='0'")->fetchColumn()
                ));
                self::$user = $userdata;
                return self::$user;
            }
        } else {
            setcookie('id_user', '', 0, '/');
            setcookie('hashcode', '', 0, '/');
            session_destroy();
            /* онлайн для гостей */
            if (DB::run("SELECT COUNT(*) FROM `online` WHERE `ip`='" . Recipe::getClientIP() . "' AND `type` = '2'")->fetchColumn() > 0) {
                DB::run("UPDATE LOW_PRIORITY `online` SET `time`='" . Cms::realtime() . "', `referer`='" . Cms::Input(Cms::setup('home') . '' . Functions::GET_PATH_INFO()) . "' WHERE `ip`='" . Recipe::getClientIP() . "' AND `type` = '2'");
            } else {
                DB::run("INSERT INTO LOW_PRIORITY `online` SET 
                           `ip`='" . Recipe::getClientIP() . "', 
                                `browser`='" . Recipe::getBrowser() . "',
                                    `referer`='" . Cms::Input(Cms::setup('home') . '' . Functions::GET_PATH_INFO()) . "',
                                        `type` = '2',
                                            `time`='" . Cms::realtime() . "'");
            }
        }
    }

    function data($table) {
        $array = "(SELECT `login` FROM `users` WHERE `users`.`id`=`$table`.`id_user`) AS `login`,
                    (SELECT `avatar` FROM `users` WHERE `users`.`id`=`$table`.`id_user`) AS `avatar`,
                        (SELECT `level` FROM `users` WHERE `users`.`id`=`$table`.`id_user`) AS `level`";
        return $array;
    }

}
