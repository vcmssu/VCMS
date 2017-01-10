<?php

class ProfileModel extends Base {

    function index() {
        SmartySingleton::instance()->assign(array(
            'blog_user' => DB::run("SELECT COUNT(*) FROM `blog` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn(),
            'bookmark' => DB::run("SELECT COUNT(*) FROM `bookmark` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn(),
            'history' => DB::run("SELECT COUNT(*) FROM `history` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn(),
            'notice' => DB::run("SELECT COUNT(*) FROM `notice` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn(),
            'mail' => DB::run("SELECT COUNT(*) FROM `mail` WHERE `id_user`= '" . $this->user['id'] . "' OR `user_id`= '" . $this->user['id'] . "'")->fetchColumn(),
            'blacklist' => DB::run("SELECT COUNT(*) FROM `blacklist` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn(),
            'friends' => DB::run("SELECT COUNT(*) FROM `friends` WHERE `id_user`='" . $this->user['id'] . "' OR `user_id`='" . $this->user['id'] . "'")->fetchColumn(),
            'friendsnew' => DB::run("SELECT COUNT(*) FROM `friends` WHERE `user_id`='" . $this->user['id'] . "' AND `status`='0'")->fetchColumn(),
            'gallery_user' => DB::run("SELECT COUNT(*) FROM `gallery` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn(),
            'gallery_photo_user' => DB::run("SELECT COUNT(*) FROM `gallery_photo` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn()
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/index.tpl');
    }

    function mail() {
        $count = DB::run("SELECT COUNT(*) FROM `contacts` WHERE `id_user`= '" . $this->user['id'] . "' OR `user_id`= '" . $this->user['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT cn.*, 
                    (SELECT `login` FROM `users` WHERE `users`.`id`=cn.`id_user`) AS `login`,
                    (SELECT `avatar` FROM `users` WHERE `users`.`id`=cn.`id_user`) AS `avatar`,
                    (SELECT `login` FROM `users` WHERE `users`.`id`=cn.`user_id`) AS `login2`,
                    (SELECT `avatar` FROM `users` WHERE `users`.`id`=cn.`user_id`) AS `avatar2`,
                    (SELECT COUNT(1) FROM `mail` WHERE `mail`.`id_user`=cn.`id_user` AND `mail`.`user_id`=cn.`user_id` OR `mail`.`id_user`=cn.`user_id` AND `mail`.`user_id`=cn.`id_user`) AS `count_mail`,
                    (SELECT COUNT(1) FROM `mail` WHERE `mail`.`id_user`=cn.`id_user` AND `mail`.`user_id`='" . $this->user['id'] . "' AND `read` = '0' OR `mail`.`id_user`=cn.`user_id` AND `mail`.`user_id`='" . $this->user['id'] . "' AND `read` = '0') AS `count_mail_new` FROM `contacts` cn WHERE cn.`id_user`= '" . $this->user['id'] . "' OR cn.`user_id`= '" . $this->user['id'] . "' ORDER BY cn.`time` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/profile/mail?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/mail.tpl');
    }

    function mail_id($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        //прочитываем сообщения
        if ($row['id'] != $this->user['id']) {
            DB::run("UPDATE LOW_PRIORITY `mail` SET `read` = '1' WHERE `user_id`= '" . $this->user['id'] . "' AND `id_user`= '" . $row['id'] . "'");
        }

        //добавляем в контакты
        if (DB::run("SELECT COUNT(*) FROM `contacts` WHERE `id_user` = '" . $this->user['id'] . "' AND `user_id` = '" . $row['id'] . "' OR `id_user` = '" . $row['id'] . "' AND `user_id` = '" . $this->user['id'] . "'")->fetchColumn() == 0 && $this->user['id'] > 0) {
            DB::run("INSERT INTO `contacts` SET 
            `id_user`='" . $this->user['id'] . "',
                `user_id`='" . $row['id'] . "',
                    `time`='" . Cms::realtime() . "'");
        }

        if ($_POST['ok'] && DB::run("SELECT COUNT(*) FROM `blacklist` WHERE `id_user`='" . $row['id'] . "' AND `user_id`='" . $this->user['id'] . "'")->fetchColumn() == 0) {
            if (mb_strlen(Cms::Input($_POST['text'])) < 1 || mb_strlen(Cms::Input($_POST['text'])) > 5000) {
                $error .= 'Недопустимая длина текста сообщения!<br/>';
            }

            //ограничение на отправку сообщений
            if (DB::run("SELECT COUNT(*) FROM `antiflood` WHERE `ip`='" . Recipe::getClientIP() . "' AND `time` > '" . intval(Cms::realtime() - Cms::setup('antiflood')) . "'")->fetchColumn() > 0) {
                $error .= 'Вы не можете отправлять сообщения чаще 1 раза в ' . ending_second(Cms::setup('antiflood')) . '! Пожалуйста, немного подождите...<br/>';
            }

            for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                $do_file = false;
                // Проверка загрузки с обычного браузера
                if ($_FILES['file']['size'][$i] > 0) {
                    $do_file = true;
                    $ifnamefile = strtolower($_FILES['file']['name'][$i]);
                    $typ = pathinfo($ifnamefile, PATHINFO_EXTENSION);
                    $rand = rand(11111, 99999); //случайное число	
                    //Конечное имя файла для сохранения без расширения
                    $fnamefile = Functions::name_replace($ifnamefile);
                    //Конечное имя файла для сохранения с расширением
                    $ftp = Functions::name_replace(Functions::truncate($ifnamefile, 200)) . '_' . $rand . '_' . strtoupper(str_replace('http://', '', Cms::setup('home'))) . '.' . $typ;
                    $fsizefile = $_FILES['file']['size'][$i];
                }

                //обработка файла
                if ($do_file) {
                    // Список недопустимых расширений файлов.
                    $al_ext = explode(", ", Cms::setup('filetype_forum'));
                    $ext = explode(".", $ftp);
                    // Проверка на допустимый размер файла
                    if ($fsizefile >= Cms::setup('filesize_forum') * 1024 * 1024) {
                        $error .= 'Недопустимый вес файла ' . $ifnamefile . '!<br/>';
                    }
                    // Проверка файла на наличие только одного расширения
                    /*
                      if (count($ext) != 2)
                      $error .= 'Файл ' . $ftp . ' имеет двойное расширение!<br/>';
                      ; */
                    // Проверка недопустимых расширений файлов
                    if (!in_array($typ, $al_ext)) {
                        $error .= 'Запрещенный тип файла ' . $ifnamefile . '!<br/>';
                    }

                    if ($typ == null) {
                        $error .= 'Файл ' . $ifnamefile . ' не имеет расширения!<br/>';
                    }
                }
            }

            if (count($_FILES['file']['name']) > Cms::setup('filecount_forum')) {
                $error .= 'Вы не можете загрузить больше ' . Cms::setup('filecount_forum') . ' файлов!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `contacts` SET `time` = '" . Cms::realtime() . "' WHERE `id_user`= '" . $this->user['id'] . "' AND `user_id`= '" . $row['id'] . "'");

                DB::run("INSERT INTO `mail` SET 
                        `id_user`='" . $this->user['id'] . "',
                            `user_id`='" . $row['id'] . "',
                                `text`='" . Cms::Input($_POST['text']) . "',
                                    `time`='" . Cms::realtime() . "'");

                $fid = DB::$pdo->lastInsertId();

                Cms::antiflood(); //антифлуд

                /* обработка загрузки файлов */
                for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                    $do_file = false;
                    // Проверка загрузки с обычного браузера
                    if ($_FILES['file']['size'][$i] > 0) {
                        $do_file = true;
                        $ifnamefile = strtolower($_FILES['file']['name'][$i]);
                        $typ = pathinfo($ifnamefile, PATHINFO_EXTENSION);
                        $rand = rand(11111, 99999); //случайное число	
                        //Конечное имя файла для сохранения без расширения
                        $fnamefile = Functions::name_replace($ifnamefile);
                        //Конечное имя файла для сохранения с расширением
                        $ftp = Functions::name_replace(Functions::truncate($ifnamefile, 200)) . '_' . $rand . '_' . strtoupper(str_replace('http://', '', Cms::setup('home'))) . '.' . $typ;
                        $fsizefile = $_FILES['file']['size'][$i];
                    }

                    if ((move_uploaded_file($_FILES['file']['tmp_name'][$i], HOME . '/files/user/' . $this->user['id'] . '/files/' . $ftp)) == true) {
                        DB::run("INSERT INTO `mail_files` SET 
                                `id_user` = '" . $this->user['id'] . "', 
                                    `user_id` = '" . $row['id'] . "',
                                        `id_mail` = '" . $fid . "', 
                                            `file` = '" . $ftp . "', 
                                                `type` = '" . $typ . "', 
                                                    `size` = '" . Functions::size($fsizefile) . "', 
                                                        `time` = '" . Cms::realtime() . "'");
                    }
                }

                Functions::redirect(Cms::setup('home') . '/profile/mail/' . $row['id']);
            }
        }

        $count = DB::run("SELECT COUNT(*) FROM `mail` WHERE `id_user`= '" . $this->user['id'] . "' AND `user_id`= '" . $row['id'] . "' OR `id_user`= '" . $row['id'] . "' AND `user_id`= '" . $this->user['id'] . "'")->fetchColumn();
        if ($count) {
            $req = DB::run("SELECT mail.*, (SELECT COUNT(*) FROM `mail_files` WHERE `mail_files`.`id_mail` = mail.`id`) AS `count_file`,
                    " . User::data('mail') . " FROM `mail` mail WHERE mail.`id_user`= '" . $this->user['id'] . "' AND mail.`user_id`= '" . $row['id'] . "' OR mail.`id_user`= '" . $row['id'] . "' AND mail.`user_id`= '" . $this->user['id'] . "' ORDER BY mail.`id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
                $text[] = Cms::bbcode($rows['text']);
                $reqfile = DB::run("SELECT * FROM `mail_files` WHERE `id_mail`='" . $rows['id'] . "' ORDER BY `id` ASC");
                while ($rowfile = $reqfile->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrowfile[] = $rowfile;
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => $text,
            'error' => $error,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'arrayrowfile' => $arrayrowfile,
            'blacklist' => DB::run("SELECT COUNT(*) FROM `blacklist` WHERE `id_user`='" . $row['id'] . "' AND `user_id`='" . $this->user['id'] . "'")->fetchColumn(),
            'pagenav' => Functions::pagination('/profile/mail/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/mail.tpl');
    }

    function mail_load($id) {
        $row = DB::run("SELECT * FROM `mail_files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        DB::run("UPDATE `mail_files` SET `loadcounts` = '" . intval($row['loadcounts'] + 1) . "', `timeload` = '" . Cms::realtime() . "' WHERE `id` = '" . $row['id'] . "'");
        Download::load('files/user/' . $row['id_user'] . '/files/' . $row['file']);
    }

    function my() {
        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['firstname'])) > 32) {
                $error .= 'Недопустимая длина имени!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['lastname'])) > 32) {
                $error .= 'Недопустимая длина фамилии!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['city'])) > 32) {
                $error .= 'Недопустимая длина названия города!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['email'])) < 5 || mb_strlen(Cms::Input($_POST['email'])) > 32) {
                $error .= 'Недопустимая длина e-mail!<br/>';
            }

            if (!filter_var(Cms::Input($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                $error .= 'Недопустимые символы в e-mail<br/>';
            }

            if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`!='" . $this->user['id'] . "' AND `email`='" . Cms::Input($_POST['email']) . "'")->fetchColumn() > 0) {
                $error .= 'Пользователь с этим e-mail уже зарегистрирован!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['phone'])) > 20) {
                $error .= 'Недопустимая длина номера телефона!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['skype'])) > 32) {
                $error .= 'Недопустимая длина skype!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['icq'])) > 10) {
                $error .= 'Недопустимая длина ICQ!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['about'])) > 500) {
                $error .= 'Недопустимая длина информации о себе!<br/>';
            }

            $do_filephoto = false;
            // Проверка загрузки с обычного браузера
            if ($_FILES['file']['size'] > 0) {
                $do_filephoto = true;
                $ifname = strtolower($_FILES['file']['name']);
                $type = pathinfo($ifname, PATHINFO_EXTENSION);
                //Конечное имя файла для сохранения с расширением
                $fnamephoto = Functions::passgen(25) . '.' . $type;
                $fsize = $_FILES['file']['size'];
            }

            //обработка файла
            if ($do_filephoto) {
                // Список допустимых расширений файлов.
                $al_ext = array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png'
                );
                $ext = explode(".", $fnamephoto);
                // Проверка файла на наличие только одного расширения
                if (count($ext) != 2) {
                    $error .= 'Запрещенный формат картинки!<br/>';
                }
                // Проверка допустимых расширений файлов
                if (!in_array($ext[1], $al_ext)) {
                    $error .= 'Не допустимый формат картинки!<br/>';
                }
                // Проверка на допустимый размер файла
                if ($fsize >= Cms::setup('filesize_photo') * 1024 * 1024) {
                    $error .= 'Недопустимый вес файла! Максимум ' . Cms::setup('filesize_photo') . ' Mb!<br/>';
                }

                $img = getimagesize($_FILES["file"]["tmp_name"]);
                if ($img[0] < 250) {
                    $error .= 'Ваша картинка слишком маленькая! Минимальный допустимый размер для загрузки составляет 250 пикселей по ширине!<br/>';
                }
            }

            if (!isset($error)) {
                DB::run("UPDATE `users` SET 
                    `firstname`='" . Cms::Input($_POST['firstname']) . "', 
                        `lastname`='" . Cms::Input($_POST['lastname']) . "', 
                            `email`='" . Cms::Input($_POST['email']) . "', 
                                `phone` = '" . Cms::Input($_POST['phone']) . "', 
                                   `skype`='" . Cms::Input($_POST['skype']) . "', 
                                       `icq`='" . Cms::Input($_POST['icq']) . "',
                                           `city`='" . Cms::Input($_POST['city']) . "',
                                                `about`='" . Cms::Input($_POST['about']) . "' WHERE `id`='" . $this->user['id'] . "'");

                if ((move_uploaded_file($_FILES["file"]["tmp_name"], HOME . '/files/user/' . $this->user['id'] . '/' . $fnamephoto)) == true) {
                    Cms::DelFile(HOME . '/files/user/' . $this->user['id'] . '/small-' . $this->user['avatar']);
                    Cms::DelFile(HOME . '/files/user/' . $this->user['id'] . '/view-' . $this->user['avatar']);
                    Cms::DelFile(HOME . '/files/user/' . $this->user['id'] . '/' . $this->user['avatar']);
                    $img = new SimpleImage();
                    $img->load(HOME . '/files/user/' . $this->user['id'] . '/' . $fnamephoto)->resize(48, 48)->save(HOME . '/files/user/' . $this->user['id'] . '/small-' . $fnamephoto);
                    $img->load(HOME . '/files/user/' . $this->user['id'] . '/' . $fnamephoto)->fit_to_width(100)->save(HOME . '/files/user/' . $this->user['id'] . '/view-' . $fnamephoto);
                    $img->load(HOME . '/files/user/' . $this->user['id'] . '/' . $fnamephoto)->fit_to_width(250)->save(HOME . '/files/user/' . $this->user['id'] . '/' . $fnamephoto);

                    DB::run("UPDATE `users` SET `avatar`='" . Cms::Input($fnamephoto) . "' WHERE `id`='" . $this->user['id'] . "'");
                }
                Functions::redirect(Cms::setup('home') . '/profile/my');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/my.tpl');
    }

    function setup() {

        if ($_POST['ok']) {

            if (Cms::Input($_POST['message']) < 5 || Cms::Input($_POST['message']) > 100) {
                $error .= 'Недопустимое значение кол-ва сообщений на страницу!<br/>';
            }

            if ($_POST['message'] && preg_match('#[^0-9]#ui', $_POST['message'])) {
                $error .= 'Разрешено вводить только цифры!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `users` SET 
                `news_send`='" . intval(Cms::Input($_POST['news_send'])) . "', 
                    `skin` = '" . Cms::Input($_POST['skin']) . "', 
                       `message`='" . intval(Cms::Input($_POST['message'])) . "', 
                           `timezone`='" . Cms::Input($_POST['timezone']) . "' WHERE `id`='" . $this->user['id'] . "'");

                Functions::redirect(Cms::setup('home') . '/profile/setup');
            }
        }

        $dir = opendir(HOME . '/style/');
        while ($skin = readdir($dir)) {
            if (($skin != '.') && ($skin != '..') && ($skin != '.svn') && ($skin != 'admin')) {
                $arrayrowskin[] = $skin;
            }
        }
        closedir($dir);

        $req = DB::run("SELECT * FROM `zone` ORDER BY `zone_name` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $arrayrow[] = $row;
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'arrayrow' => $arrayrow,
            'arrayrowskin' => $arrayrowskin
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/setup.tpl');
    }

    function security() {

        if ($_POST['ok']) {

            $users = DB::run("SELECT * FROM `users` WHERE `id` = '" . $this->user['id'] . "' AND `pass` = '" . crypt($_POST['oldpass'], '$6$rounds=5000$usesomesillystringforsalt$') . "'")->fetch(PDO::FETCH_ASSOC);
            if ($this->user['pass'] != $users['pass']) {
                $error .= 'Старый пароль не верен!<br/>';
            }

            if (mb_strlen($_POST['newpass']) < 6 || mb_strlen($_POST['newpass']) > 32) {
                $error .= 'Недопустимая длина нового пароля!<br/>';
            }

            if ($_POST['newpass'] != $_POST['newpass_confirm']) {
                $error .= 'Пароли не совпадают!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `users` SET 
                    `pass` = '" . crypt($_POST['newpass'], '$6$rounds=5000$usesomesillystringforsalt$') . "', 
                        `hashcode` = '" . crypt($_POST['newpass'] . '' . $this->user['date_reg'], '$6$rounds=5000$usesomesillystringforsalt$') . "' WHERE `id`='" . $this->user['id'] . "'");

                SmartySingleton::instance()->assign('newpassword', $_POST['newpass']);
                // инициализируем класс
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
                $mailer->Body = SmartySingleton::instance()->fetch(SMARTY_TEMPLATE_LOAD . '/templates/mail/newpass.tpl');
                // Добавляем адрес в список получателей
                $mailer->AddAddress($this->user['email'], $this->user['login']);
                $mailer->Send();

                setcookie('hashcode', '', 0, '/');
                setcookie('hashcode', crypt($_POST['newpass'] . '' . $this->user['date_reg'], '$6$rounds=5000$usesomesillystringforsalt$'), Cms::realtime() + 60 * 60 * 24 * 7, '/');

                Functions::redirect(Cms::setup('home') . '/profile');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/security.tpl');
    }

    function history() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `history` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT * FROM `history` WHERE `id_user`='" . $this->user['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/profile/history?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/history.tpl');
    }

    function bookmark() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `bookmark` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT * FROM `bookmark` WHERE `id_user`='" . $this->user['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/profile/bookmark?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/bookmark.tpl');
    }

    function bookmark_add() {
        if (DB::run("SELECT COUNT(*) FROM `bookmark` WHERE `id_user`='" . $this->user['id'] . "' AND `url`='" . Cms::Input($_REQUEST['url']) . "'")->fetchColumn() > 0) {
            $error = 'Страницу ' . Cms::Input($_REQUEST['url']) . ' Вы уже добавили в закладки!';
        }

        if (!isset($error)) {
            DB::run("INSERT INTO `bookmark` SET 
            `id_user`='" . $this->user['id'] . "', 
                `name`='" . Cms::Input($_REQUEST['name']) . "', 
                    `url`='" . Cms::Input($_REQUEST['url']) . "', 
                        `time`='" . Cms::realtime() . "'");

            Functions::redirect(Recipe::getReferer());
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/bookmark_add.tpl');
    }

    function bookmark_edit($id) {
        $row = DB::run("SELECT * FROM `bookmark` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 5 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия!<br/>';
            }

            if (!isset($error)) {
                DB::run("UPDATE `bookmark` SET 
                `name`='" . Cms::Input($_POST['name']) . "', 
                    `url` = '" . Cms::Input($_POST['url']) . "' WHERE `id`='" . $row['id'] . "'");
                Functions::redirect(Cms::setup('home') . '/profile/bookmark');
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/bookmark_edit.tpl');
    }

    function bookmark_del($id) {
        $row = DB::run("SELECT * FROM `bookmark` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `bookmark` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            Functions::redirect(Cms::setup('home') . '/profile/bookmark');
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/profile/bookmark');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/bookmark_del.tpl');
    }

    function notice() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `notice` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT notice. * , (SELECT `login` FROM `users` WHERE `users`.`id` = notice.`user_id` ) AS `login` FROM `notice` WHERE `id_user`='" . $this->user['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
                $text[] = Cms::bbcode($row['text']);
            }
        }

        //прочитываем уведомления
        if (DB::run("SELECT COUNT(*) FROM `notice` WHERE `id_user`='" . $this->user['id'] . "' AND `status`='1'")->fetchColumn()) {
            DB::run("UPDATE `notice` SET `status`='0' WHERE `id_user`='" . $this->user['id'] . "'");
        }

        SmartySingleton::instance()->assign(array(
            'text' => $text,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/profile/notice?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/notice.tpl');
    }

    function friends() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `friends` WHERE `id_user`='" . $this->user['id'] . "' OR `user_id`= '" . $this->user['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT cn.*, (SELECT `login` FROM `users` WHERE `users`.`id`=cn.`id_user`) AS `login`,
                    (SELECT `login` FROM `users` WHERE `users`.`id`=cn.`user_id`) AS `login2`
                            FROM `friends` cn WHERE cn.`id_user`= '" . $this->user['id'] . "' OR cn.`user_id`= '" . $this->user['id'] . "' ORDER BY cn.`time` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'text' => $text,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/profile/friends?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/friends.tpl');
    }

    function friends_add($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $blacklist = DB::run("SELECT COUNT(*) FROM `blacklist` WHERE `id_user`='" . $row['id'] . "' AND `user_id`='" . $this->user['id'] . "'")->fetchColumn();

        if ($blacklist == 0) {
            DB::run("INSERT INTO `friends` SET 
            `id_user`='" . $this->user['id'] . "',
                `user_id`='" . $row['id'] . "',
                    `time`='" . Cms::realtime() . "'");
            Cms::notice($row['id'], $this->user['id'], 'Отправил заявку в [url=' . Cms::setup('home') . '/profile/friends]друзья[/url]!');
        }

        SmartySingleton::instance()->assign(array(
            'blacklist' => $blacklist
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/friends_add.tpl');
    }

    function friends_del($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        DB::run("DELETE FROM `friends` WHERE `id_user`='" . $this->user['id'] . "' AND `user_id`='" . $row['id'] . "' OR `id_user`='" . $row['id'] . "' AND `user_id`='" . $this->user['id'] . "' LIMIT 1");

        Cms::notice($row['id'], $this->user['id'], 'Удалил Вас из друзей!');

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/friends_del.tpl');
    }

    function friends_yes($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        DB::run("UPDATE `friends` SET `status`='1' WHERE `id_user`='" . $row['id'] . "' AND `user_id`='" . $this->user['id'] . "' LIMIT 1");

        Cms::notice($row['id'], $this->user['id'], 'Принял заявку в друзья!');

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/friends_yes.tpl');
    }

    function blacklist() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `blacklist` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT blacklist. * , (SELECT `login` FROM `users` WHERE `users`.`id` = blacklist.`user_id` ) AS `login` FROM `blacklist` WHERE `id_user`='" . $this->user['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/profile/blacklist?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/blacklist.tpl');
    }

    function blacklist_add($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        DB::run("INSERT INTO `blacklist` SET 
            `id_user`='" . $this->user['id'] . "',
                `user_id`='" . $row['id'] . "',
                    `time`='" . Cms::realtime() . "'");

        Cms::notice($row['id'], $this->user['id'], 'Добавил Вас в черный список!');

        Functions::redirect(Cms::setup('home') . '/profile/blacklist');
    }

    function blacklist_del($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        DB::run("DELETE FROM `blacklist` WHERE `id_user`='" . $this->user['id'] . "' AND `user_id`='" . $row['id'] . "' LIMIT 1");

        Cms::notice($row['id'], $this->user['id'], 'Удалил Вас из черного списка!');

        Functions::redirect(Cms::setup('home') . '/profile/blacklist');
    }

    function blog() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `blog` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT blog. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog.`refid` ) AS `namecat` FROM `blog` WHERE `id_user`='" . $this->user['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/profile/blog?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/blog.tpl');
    }

    function blog_add() {

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия поста!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['name'])) < 5 || mb_strlen(Cms::Input($_POST['name'])) > 100000) {
                $error .= 'Недопустимая длина содержания поста!<br/>';
            }

            if (!isset($error)) {
                DB::run("INSERT INTO `blog` SET 
                    `id_user`='" . $this->user['id'] . "',
                        `refid`='" . intval($_POST['refid']) . "',
                            `name`='" . Cms::Input($_POST['name']) . "', 
                                `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                    `text`='" . Cms::Input($_POST['text']) . "',
                                        `time`='" . Cms::realtime() . "',
                                            `keywords`='" . Functions::seokeywords(Cms::Input($_POST['name'])) . "', 
                                                `description`='" . BBcode::delete(Functions::truncate(Cms::Input($_POST['text']), 350)) . "'");

                Functions::redirect(Cms::setup('home') . '/profile/blog');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'arrayrow' => DB::run("SELECT * FROM `blog_category` ORDER BY `realid` ASC")->fetchAll()
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/blog_add.tpl');
    }

    function blog_edit($id) {
        $row = DB::run("SELECT * FROM `blog` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия поста!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['name'])) < 5 || mb_strlen(Cms::Input($_POST['name'])) > 100000) {
                $error .= 'Недопустимая длина содержания поста!<br/>';
            }

            if (!isset($error)) {
                $category = DB::run("SELECT * FROM `blog_category` WHERE `id`='" . intval($_POST['refid']) . "'")->fetch(PDO::FETCH_ASSOC);
                DB::run("UPDATE `blog` SET 
                        `refid`='" . intval($_POST['refid']) . "',
                            `name`='" . Cms::Input($_POST['name']) . "', 
                                `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                    `text`='" . Cms::Input($_POST['text']) . "',
                                        `keywords`='" . Functions::seokeywords(Cms::Input($_POST['name'])) . "', 
                                            `description`='" . BBcode::delete(Functions::truncate(Cms::Input($_POST['text']), 350)) . "' WHERE `id`='" . $row['id'] . "'");

                if ($row['refid'] != $_POST['refid']) {
                    DB::run("UPDATE `blog_comments` SET `refid`='" . intval($_POST['refid']) . "' WHERE `id_post`='" . $row['id'] . "'");
                }

                Functions::redirect(Cms::setup('home') . '/profile/blog');
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error,
            'arrayrow' => DB::run("SELECT * FROM `blog_category` ORDER BY `realid` ASC")->fetchAll()
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/blog_edit.tpl');
    }

    function blog_del($id) {
        $row = DB::run("SELECT * FROM `blog` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `blog` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("DELETE FROM `blog_comments` WHERE `refid` = '" . $row['id'] . "'");
            Functions::redirect(Cms::setup('home') . '/profile/blog');
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/profile/blog');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/blog_del.tpl');
    }

    function gallery($id) {
        if ($id) {
            $row = DB::run("SELECT * FROM `gallery` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

            $count = DB::run("SELECT COUNT(*) FROM `gallery_photo` WHERE `id_gallery`='" . $row['id'] . "'")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT * FROM `gallery_photo` WHERE `id_gallery`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
                while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $rows;
                }
            }

            SmartySingleton::instance()->assign(array(
                'row' => $row,
                'count' => $count,
                'arrayrow' => $arrayrow,
                'pagenav' => Functions::pagination('/profile/gallery/' . $row['id'] . '?', $this->page, $count, $this->message)
            ));
        } else {
            //список
            $count = DB::run("SELECT COUNT(*) FROM `gallery` WHERE `id_user`='" . $this->user['id'] . "'")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT gallery. * , (SELECT COUNT(*) FROM `gallery_photo` WHERE `gallery_photo`.`id_gallery` = gallery.`id` ) AS `count` FROM `gallery` WHERE `id_user`='" . $this->user['id'] . "' ORDER BY `time` DESC LIMIT " . $this->page . ", " . $this->message);
                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $row;
                }
            }

            SmartySingleton::instance()->assign(array(
                'count' => $count,
                'arrayrow' => $arrayrow,
                'pagenav' => Functions::pagination('/profile/gallery?', $this->page, $count, $this->message)
            ));
        }
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/gallery.tpl');
    }

    function gallery_add() {
        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия альбома!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) > 500) {
                $error .= 'Недопустимая длина описания альбома!<br/>';
            }

            if (!isset($error)) {
                DB::run("INSERT INTO `gallery` SET 
                    `id_user`='" . $this->user['id'] . "',
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                `text`='" . Cms::Input($_POST['text']) . "',
                                    `time`='" . Cms::realtime() . "',
                                        `keywords`='" . Functions::seokeywords(Cms::Input($_POST['name'])) . "', 
                                            `description`='" . BBcode::delete(Functions::truncate(Cms::Input($_POST['text']), 350)) . "'");

                $fid = DB::$pdo->lastInsertId();

                mkdir('files/user/' . $this->user['id'] . '/gallery/' . $fid);

                Functions::redirect(Cms::setup('home') . '/profile/gallery');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/gallery_add.tpl');
    }

    function gallery_add_photo($id) {
        $row = DB::run("SELECT * FROM `gallery` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия фотографии!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) > 500) {
                $error .= 'Недопустимая длина описания фотографии!<br/>';
            }

            $do_filephoto = false;
            // Проверка загрузки с обычного браузера
            if ($_FILES['file']['size'] > 0) {
                $do_filephoto = true;
                $ifname = strtolower($_FILES['file']['name']);
                $type = pathinfo($ifname, PATHINFO_EXTENSION);
                //Конечное имя файла для сохранения с расширением
                $fnamephoto = Functions::passgen(25) . '.' . $type;
                $fsize = $_FILES['file']['size'];
            }

            //обработка файла
            if ($do_filephoto) {
                // Список допустимых расширений файлов.
                $al_ext = array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png'
                );
                $ext = explode(".", $fnamephoto);
                // Проверка файла на наличие только одного расширения
                if (count($ext) != 2) {
                    $error .= 'Запрещенный формат картинки!<br/>';
                }
                // Проверка допустимых расширений файлов
                if (!in_array($ext[1], $al_ext)) {
                    $error .= 'Не допустимый формат картинки!<br/>';
                }
                // Проверка на допустимый размер файла
                if ($fsize >= Cms::setup('filesize_photo') * 1024 * 1024) {
                    $error .= 'Недопустимый вес файла! Максимум ' . Cms::setup('filesize_photo') . ' Mb!<br/>';
                }

                $img = getimagesize($_FILES["file"]["tmp_name"]);
                if ($img[0] < Cms::setup('gallerypreview')) {
                    $error .= 'Ваша фотография слишком маленькая! Минимальный допустимый размер для загрузки составляет 250 пикселей по ширине!<br/>';
                }
            }

            if (empty($do_filephoto)) {
                $error .= 'Вы не выбрали фотографию!';
            }

            if (!isset($error)) {
                if ((move_uploaded_file($_FILES["file"]["tmp_name"], HOME . '/files/user/' . $this->user['id'] . '/gallery/' . $row['id'] . '/' . $fnamephoto)) == true) {
                    $img = new SimpleImage();
                    $img->load(HOME . '/files/user/' . $this->user['id'] . '/gallery/' . $row['id'] . '/' . $fnamephoto)->fit_to_width(Cms::setup('gallerypreview'))->save(HOME . '/files/user/' . $this->user['id'] . '/gallery/' . $row['id'] . '/small-' . $fnamephoto);

                    DB::run("INSERT INTO `gallery_photo` SET 
                    `id_user`='" . $this->user['id'] . "',
                        `id_gallery`='" . $row['id'] . "',
                            `name`='" . Cms::Input($_POST['name']) . "', 
                                `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                    `photo`='" . $fnamephoto . "',
                                        `size`='" . Functions::size($fsize) . "',
                                            `text`='" . Cms::Input($_POST['text']) . "',
                                                `time`='" . Cms::realtime() . "',
                                                    `keywords`='" . Functions::seokeywords(Cms::Input($_POST['name'])) . "', 
                                                        `description`='" . BBcode::delete(Functions::truncate(Cms::Input($_POST['text']), 350)) . "'");
                }

                DB::run("UPDATE `gallery` SET `time` = '" . Cms::realtime() . "' WHERE `id`= '" . $row['id'] . "'");

                Functions::redirect(Cms::setup('home') . '/profile/gallery/' . $row['id']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/gallery_add_photo.tpl');
    }

    function gallery_edit_album($id) {
        $row = DB::run("SELECT * FROM `gallery` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия альбома!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) > 500) {
                $error .= 'Недопустимая длина описания альбома!<br/>';
            }

            if (!isset($error)) {
                DB::run("UPDATE `gallery` SET 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                `text`='" . Cms::Input($_POST['text']) . "',
                                    `keywords`='" . Functions::seokeywords(Cms::Input($_POST['name'])) . "', 
                                        `description`='" . BBcode::delete(Functions::truncate(Cms::Input($_POST['text']), 350)) . "' WHERE `id`='" . $row['id'] . "'");

                Functions::redirect(Cms::setup('home') . '/profile/gallery');
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/gallery_edit_album.tpl');
    }

    function gallery_del_album($id) {
        $row = DB::run("SELECT * FROM `gallery` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            Cms::DelDir('files/user/' . $this->user['id'] . '/gallery/' . $row['id']);

            DB::run("DELETE FROM `gallery` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("DELETE FROM `gallery_photo` WHERE `id_gallery` = '" . $row['id'] . "'");
            DB::run("OPTIMIZE TABLE `gallery`");
            DB::run("OPTIMIZE TABLE `gallery_photo`");

            Functions::redirect(Cms::setup('home') . '/profile/gallery');
        }

        if ($_POST['close']) {

            Functions::redirect(Cms::setup('home') . '/profile/gallery');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/gallery_del_album.tpl');
    }

    function gallery_edit($id) {
        $row = DB::run("SELECT gallery_photo. * , (SELECT `name` FROM `gallery` WHERE `gallery`.`id` = gallery_photo.`id_gallery` ) AS `namealbum` FROM `gallery_photo` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия фотографии!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) > 500) {
                $error .= 'Недопустимая длина описания фотографии!<br/>';
            }

            $do_filephoto = false;
            // Проверка загрузки с обычного браузера
            if ($_FILES['file']['size'] > 0) {
                $do_filephoto = true;
                $ifname = strtolower($_FILES['file']['name']);
                $type = pathinfo($ifname, PATHINFO_EXTENSION);
                //Конечное имя файла для сохранения с расширением
                $fnamephoto = Functions::passgen(25) . '.' . $type;
                $fsize = $_FILES['file']['size'];
            }

            //обработка файла
            if ($do_filephoto) {
                // Список допустимых расширений файлов.
                $al_ext = array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png'
                );
                $ext = explode(".", $fnamephoto);
                // Проверка файла на наличие только одного расширения
                if (count($ext) != 2) {
                    $error .= 'Запрещенный формат картинки!<br/>';
                }
                // Проверка допустимых расширений файлов
                if (!in_array($ext[1], $al_ext)) {
                    $error .= 'Не допустимый формат картинки!<br/>';
                }
                // Проверка на допустимый размер файла
                if ($fsize >= Cms::setup('filesize_photo') * 1024 * 1024) {
                    $error .= 'Недопустимый вес файла! Максимум ' . Cms::setup('filesize_photo') . ' Mb!<br/>';
                }

                $img = getimagesize($_FILES["file"]["tmp_name"]);
                if ($img[0] < Cms::setup('gallerypreview')) {
                    $error .= 'Ваша фотография слишком маленькая! Минимальный допустимый размер для загрузки составляет 250 пикселей по ширине!<br/>';
                }
            }

            if (!isset($error)) {
                DB::run("UPDATE `gallery_photo` SET 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                `text`='" . Cms::Input($_POST['text']) . "',
                                    `keywords`='" . Functions::seokeywords(Cms::Input($_POST['name'])) . "', 
                                        `description`='" . BBcode::delete(Functions::truncate(Cms::Input($_POST['text']), 350)) . "' WHERE `id`='" . $row['id'] . "'");

                if ((move_uploaded_file($_FILES["file"]["tmp_name"], HOME . '/files/user/' . $this->user['id'] . '/gallery/' . $row['id_gallery'] . '/' . $fnamephoto)) == true) {
                    Cms::DelFile(HOME . '/files/user/' . $this->user['id'] . '/gallery/' . $row['id_gallery'] . '/small-' . $row['photo']);
                    Cms::DelFile(HOME . '/files/user/' . $this->user['id'] . '/gallery/' . $row['id_gallery'] . '/' . $row['photo']);

                    $img = new SimpleImage();
                    $img->load(HOME . '/files/user/' . $this->user['id'] . '/gallery/' . $row['id_gallery'] . '/' . $fnamephoto)->fit_to_width(Cms::setup('gallerypreview'))->save(HOME . '/files/user/' . $this->user['id'] . '/gallery/' . $row['id_gallery'] . '/small-' . $fnamephoto);

                    DB::run("UPDATE `gallery_photo` SET `photo` = '" . $fnamephoto . "', `size`='" . Functions::size($fsize) . "' WHERE `id`= '" . $row['id'] . "'");
                }

                Functions::redirect(Cms::setup('home') . '/profile/gallery/' . $row['id_gallery']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/gallery_edit.tpl');
    }

    function gallery_del($id) {
        $row = DB::run("SELECT gallery_photo. * , (SELECT `name` FROM `gallery` WHERE `gallery`.`id` = gallery_photo.`id_gallery` ) AS `namealbum` FROM `gallery_photo` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            Cms::DelFile('files/user/' . $this->user['id'] . '/gallery/' . $row['id_gallery'] . '/small-' . $row['photo']);
            Cms::DelFile('files/user/' . $this->user['id'] . '/gallery/' . $row['id_gallery'] . '/' . $row['photo']);

            DB::run("DELETE FROM `gallery_photo` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("OPTIMIZE TABLE `gallery_photo`");

            Functions::redirect(Cms::setup('home') . '/profile/gallery/' . $row['id_gallery']);
        }

        if ($_POST['close']) {

            Functions::redirect(Cms::setup('home') . '/profile/gallery/' . $row['id_gallery']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/profile/gallery_del.tpl');
    }

}
