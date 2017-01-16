<?php

class UserModel extends Base {

    function index($id) {
        $row = DB::run("SELECT `users`.*, (SELECT COUNT(*) FROM `guest` WHERE `guest`.`id_user`=`users`.`id`) AS `guest`,
                        (SELECT COUNT(*) FROM `files` WHERE `files`.`id_user`=`users`.`id` AND `id_file`='0'  AND `user`='0') AS `download`,
                        (SELECT COUNT(*) FROM `blog` WHERE `blog`.`id_user`=`users`.`id`) AS `blog`,
                        (SELECT COUNT(*) FROM `news_comments` WHERE `news_comments`.`id_user`=`users`.`id`) AS `news_comments`,
                        (SELECT COUNT(*) FROM `files_comments` WHERE `files_comments`.`id_user`=`users`.`id`) AS `files_comments`,
                        (SELECT COUNT(*) FROM `blog_comments` WHERE `blog_comments`.`id_user`=`users`.`id`) AS `blog_comments`,
                        (SELECT COUNT(*) FROM `gallery_photo` WHERE `gallery_photo`.`id_user`=`users`.`id`) AS `gallery_photo`,
                        (SELECT COUNT(*) FROM `library` WHERE `library`.`id_user`=`users`.`id`) AS `library`,
                        (SELECT COUNT(*) FROM `library_comments` WHERE `library_comments`.`id_user`=`users`.`id`) AS `library_comments` FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'friends' => DB::run("SELECT COUNT(*) FROM `friends` WHERE `id_user`='" . $this->user['id'] . "' AND `user_id`='" . $row['id'] . "' OR `id_user`='" . $row['id'] . "' AND `user_id`='" . $this->user['id'] . "'")->fetchColumn(),
            'blacklist' => DB::run("SELECT COUNT(*) FROM `blacklist` WHERE `id_user`='" . $this->user['id'] . "' AND `user_id`='" . $row['id'] . "'")->fetchColumn()
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/index.tpl');
    }

    function users($id) {
        $count = DB::run("SELECT COUNT(*) FROM `users`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT * FROM `users` ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/users?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/users.tpl');
    }
    
    function users_admin($id) {
        $count = DB::run("SELECT COUNT(*) FROM `users` WHERE `level`>'1'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT * FROM `users` WHERE `level`>'1' ORDER BY `level` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/users/admin?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/users_admin.tpl');
    }

    function login() {
        if ($this->user['id']) {
            Functions::redirect(Cms::setup('home'));
        }

        if ($_POST['ok']) {
            $user = DB::run("SELECT * FROM `users` WHERE `login` = '" . Cms::Input($_POST['login']) . "' AND `pass` = '" . crypt(Cms::Input($_POST['password']), '$6$rounds=5000$usesomesillystringforsalt$') . "'")->fetch(PDO::FETCH_ASSOC);
            if ($user == 0) {
                $error = 'Неправильный логин или пароль!';
            }

            if ($user['activation'] != null) {
                $error = 'Вы ещё не активировали свой аккаунт! Авторизация возможна только после активации аккаунта!';
            }

            if (!isset($error)) {
                $user = DB::run("SELECT * FROM `users` WHERE `login` = '" . Cms::Input($_POST['login']) . "' AND `pass` = '" . crypt(Cms::Input($_POST['password']), '$6$rounds=5000$usesomesillystringforsalt$') . "'")->fetch(PDO::FETCH_ASSOC);
                DB::run("UPDATE `users` SET `hashcode` = '" . crypt(Cms::Input($_POST['password']) . '' . $user['date_reg'], '$6$rounds=5000$usesomesillystringforsalt$') . "' WHERE `id`=" . $user['id']);
                setcookie('id_user', $user['id'], Cms::realtime() + 60 * 60 * 24 * 3, '/');
                setcookie('hashcode', crypt(Cms::Input($_POST['password']) . '' . $user['date_reg'], '$6$rounds=5000$usesomesillystringforsalt$'), Cms::realtime() + 60 * 60 * 24 * 3, '/');

                Cms::history($user['id']); /* история авторизаций */

                Functions::redirect(Cms::setup('home') . '/profile');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/login.tpl');
    }

    function signup() {
        if ($this->user['id']) {
            Functions::redirect(Cms::setup('home'));
        }

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['login'])) < 3 || mb_strlen(Cms::Input($_POST['login'])) > 32) {
                $error .= 'Недопустимая длина логина!<br/>';
            }

            if (Cms::Input($_POST['login']) && !preg_match("#^([A-zА-я0-9\-\_\ ])+$#ui", Cms::Input($_POST['login']))) {
                $error .= 'Специальные символы в логине запрещены!<br/>';
            }

            if (Cms::Input($_POST['login']) && !preg_match("#^[a-z0-9]+$#i", Cms::Input($_POST['login']))) {
                $error .= 'В логине разрешены только символы a-z и цифры!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['password'])) < 6 || mb_strlen(Cms::Input($_POST['password'])) > 32) {
                $error .= 'Недопустимая длина пароля!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['email'])) < 5 || mb_strlen(Cms::Input($_POST['email'])) > 32) {
                $error .= 'Недопустимая длина e-mail!<br/>';
            }

            if (!filter_var(Cms::Input($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                $error .= 'Недопустимые символы в e-mail<br/>';
            }

            if (DB::run("SELECT COUNT(*) FROM `users` WHERE `login`='" . Cms::Input($_POST['login']) . "'")->fetchColumn() > 0) {
                $error .= 'Пользователь с этим логином уже зарегистрирован!<br/>';
            }

            if (DB::run("SELECT COUNT(*) FROM `users` WHERE `email`='" . Cms::Input($_POST['email']) . "'")->fetchColumn() > 0) {
                $error .= 'Пользователь с этим e-mail уже зарегистрирован!<br/>';
            }

            if (Cms::setup('captcha_signup') == 1 && $_POST['captcha'] != $_COOKIE['code']) {
                $error .= 'Проверочное число с картинки введено не верно!<br/>';
            }

            if (!isset($error)) {
                if (Cms::setup('activation') == 1) {
                    $activation = md5(Functions::passgen());
                } else {
                    $activation = null;
                }

                DB::run("INSERT INTO `users` SET 
                    `login` = '" . Cms::Input($_POST['login']) . "', 
                        `email` = '" . Cms::Input($_POST['email']) . "', 
                            `pass` = '" . crypt(Cms::Input($_POST['password']), '$6$rounds=5000$usesomesillystringforsalt$') . "', 
                                `hashcode` = '" . crypt(Cms::Input($_POST['password']) . '' . Cms::realtime(), '$6$rounds=5000$usesomesillystringforsalt$') . "', 
                                    `date_reg` =  '" . Cms::realtime() . "', 
                                        `date_last` =  '" . Cms::realtime() . "', 
                                            `activation` =  '" . $activation . "'");

                $fid = DB::lastInsertId();
                ;

                //создаём нужные папки
                mkdir(HOME . '/files/user/' . $fid);
                mkdir(HOME . '/files/user/' . $fid . '/files');
                mkdir(HOME . '/files/user/' . $fid . '/forum');
                mkdir(HOME . '/files/user/' . $fid . '/gallery');

                /* письмо на ящик */
                SmartySingleton::instance()->assign('email', Cms::Input($_POST['email']));
                SmartySingleton::instance()->assign('login', Cms::Input($_POST['login']));
                SmartySingleton::instance()->assign('pass', Cms::Input($_POST['password']));
                SmartySingleton::instance()->assign('fid', $fid);
                SmartySingleton::instance()->assign('activation', $activation);

                // инициализируем класс
                $mailer = new phpmailer();
                //настройки
                $mailer->Mailer = Cms::setup('sendmail');
                $mailer->Host = Cms::setup('smtphost');
                $mailer->Port = Cms::setup('smtpport');
                $mailer->Username = Cms::setup('smtpusername');
                $mailer->Password = Cms::setup('smtppassword');
                // Устанавливаем тему письма
                $mailer->Subject = "Регистрация на ресурсе " . Cms::setup('home');
                //задаем e-mail админа
                $mailer->From = Cms::setup('emailadmin');
                $mailer->ContentType = 'text/html';
                // Задаем тело письма
                $mailer->Body = SmartySingleton::instance()->fetch(SMARTY_TEMPLATE_LOAD . '/templates/mail/signup.tpl');
                // Добавляем адрес в список получателей
                $mailer->AddAddress(Cms::Input($_POST['email']), Cms::Input($_POST['login']));
                $mailer->Send();

                if (Cms::setup('activation') != 1) {
                    setcookie('id_user', $fid, Cms::realtime() + 60 * 60 * 24 * 3, '/');
                    setcookie('hashcode', crypt(Cms::Input($_POST['password']) . '' . Cms::realtime(), '$6$rounds=5000$usesomesillystringforsalt$'), Cms::realtime() + 60 * 60 * 24 * 3, '/');
                }

                Functions::redirect(Cms::setup('home'));
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/signup.tpl');
    }

    function lostpass($id, $code) {
        if ($this->user['id']) {
            Functions::redirect(Cms::setup('home'));
        }

        if ($id) {
            $req = DB::run("SELECT * FROM `users` WHERE `id` = '" . intval($id) . "' AND `rest_code` = '" . $code . "' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            if ($req) {
                $res = $req;
                if (empty($res['rest_code']) || empty($res['rest_time'])) {
                    $error = 'Восстановление пароля невозможно!';
                }
                if (!$error && $res['rest_time'] < Cms::realtime() - 3600) {
                    $error = 'Время, отведенное на восстановления пароля прошло!';
                    DB::run("UPDATE `users` SET `rest_code` = '', `rest_time` = '' WHERE `id` = '" . intval($id) . "'");
                }
            } else {
                $error = 'Восстановление пароля невозможно!';
            }

            if (!$error) {
                // Высылаем пароль на E-mail
                $pass = Functions::passgen(16);
                // инициализируем класс
                SmartySingleton::instance()->assign('row', $res);
                SmartySingleton::instance()->assign('pass', $pass);

                $mailer = new phpmailer();
                //настройки
                $mailer->Mailer = Cms::setup('sendmail');
                $mailer->Host = Cms::setup('smtphost');
                $mailer->Port = Cms::setup('smtpport');
                $mailer->Username = Cms::setup('smtpusername');
                $mailer->Password = Cms::setup('smtppassword');
                // Устанавливаем тему письма
                $mailer->Subject = "Ваш новый пароль";
                //задаем e-mail админа
                $mailer->From = Cms::setup('emailadmin');
                $mailer->ContentType = 'text/html';
                // Задаем тело письма
                $mailer->Body = SmartySingleton::instance()->fetch(SMARTY_TEMPLATE_LOAD . '/templates/mail/lostpassnew.tpl');
                // Добавляем адрес в список получателей
                $mailer->AddAddress($res['email'], $res['login']);
                if ($mailer->Send()) {
                    DB::run("UPDATE `users` SET 
                    `rest_code` = '', `rest_time` = '0', 
                        `pass` = '" . crypt($pass, '$6$rounds=5000$usesomesillystringforsalt$') . "' 
                            WHERE `id` = '" . intval($id) . "'");
                    $ok = 'Пароль успешно изменен. Новый пароль выслан на ваш e-mail.';
                } else {
                    $error = 'Ошибка отправки E-mail!';
                }
            }
        } else {
            if ($_POST['ok']) {

                // Проверяем данные по базе
                $req = DB::run("SELECT * FROM `users` WHERE `email` = '" . Cms::Input($_POST['email']) . "' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                if ($req) {
                    $res = $req;
                    if (empty($res['email']) || $res['email'] != Cms::Input($_POST['email'])) {
                        $error = 'E-mail адрес указан неверно!';
                    }
                    if ($res['rest_time'] > Cms::realtime() - 300) {
                        $error = 'Пароль можно восстанавливать не чаще 1 раза в 5 минут!';
                    }
                } else {
                    $error = 'Пользователь с таким e-mail не зарегистрирован!';
                }

                if (!isset($error)) {
                    // Высылаем инструкции на E-mail
                    SmartySingleton::instance()->assign('row', $res);

                    $mailer = new phpmailer();
                    //настройки
                    $mailer->Mailer = Cms::setup('sendmail');
                    $mailer->Host = Cms::setup('smtphost');
                    $mailer->Port = Cms::setup('smtpport');
                    $mailer->Username = Cms::setup('smtpusername');
                    $mailer->Password = Cms::setup('smtppassword');
                    // Устанавливаем тему письма
                    $mailer->Subject = "Восстановление пароля";
                    //задаем e-mail админа
                    $mailer->From = Cms::setup('emailadmin');
                    $mailer->ContentType = 'text/html';
                    // Задаем тело письма
                    $mailer->Body = SmartySingleton::instance()->fetch(SMARTY_TEMPLATE_LOAD . '/templates/mail/lostpass.tpl');

                    // Добавляем адрес в список получателей
                    $mailer->AddAddress($res['email'], $res['login']);
                    if ($mailer->Send()) {
                        DB::run("UPDATE `users` SET 
                        `rest_code` = '" . md5(Cms::realtime()) . "', 
                            `rest_time` = '" . Cms::realtime() . "' WHERE `id` = '" . $res['id'] . "'");
                    }
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'ok' => $ok,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/lostpass.tpl');
    }

    function activation($id, $code) {
        if ($this->user['id']) {
            Functions::redirect(Cms::setup('home'));
        }

        if (isset($id) && isset($id) && $code != NULL) {
            $count = DB::run("SELECT COUNT(*) FROM `users` WHERE `id` = '" . intval($id) . "' AND `activation` = '" . Cms::Input($code) . "'")->fetch(PDO::FETCH_NUM);
            if ($count[0] > 0) {
                DB::run("UPDATE `users` SET `activation` = null WHERE `id` = '" . intval($id) . "' LIMIT 1");
            } else {
                $error = 'Во время активации аккаунта возникла непредвиденная ошибка или аккаунт уже был активирован!';
            }
        } else {
            $error = 'Во время активации аккаунта возникла непредвиденная ошибка! Попробуйте ещё раз.';
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/activation.tpl');
    }

    function logout() {
        if ($this->user['id'] == null) {
            Functions::redirect(Cms::setup('home'));
        }

        setcookie('id_user', '', 0, '/');
        setcookie('hashcode', '', 0, '/');
        session_destroy();
        Functions::redirect(Recipe::getReferer());
    }

    function ban() {
        SmartySingleton::instance()->assign('banprichina', Cms::bbcode($this->user['banprichina']));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/ban.tpl');
    }

}
