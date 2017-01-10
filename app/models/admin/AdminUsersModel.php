<?php

class AdminUsersModel extends Base {

    function index() {
        $count = DB::run("SELECT COUNT(*) FROM `users`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `users`.*, (SELECT COUNT(1) FROM `gallery` WHERE `gallery`.`id_user`=`users`.`id`) AS `gallery` FROM `users` ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination(Cms::setup('adminpanel') . '/users?', $this->page, $count, Cms::setup('message'))
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/users/index.tpl');
    }

    function edit($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['login'])) < 3 || mb_strlen(Cms::Input($_POST['login'])) > 32) {
                $error = 'Недопустимая длина логина!';
            }

            if (!preg_match("#^([A-zА-я0-9\-\_\ ])+$#ui", Cms::Input($_POST['login']))) {
                $error = 'Специальные символы в логине запрещены!';
            }

            if (!preg_match("#^[a-z0-9]+$#i", Cms::Input($_POST['login']))) {
                $error = 'Разрешены только символы a-z и цифры!';
            }

            if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`!='" . $row['id'] . "' AND `login`='" . Cms::Input($_POST['login']) . "'")->fetchColumn() > 0) {
                $error .= 'Пользователь с этим логином уже зарегистрирован!<br/>';
            }

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

            if (DB::run("SELECT COUNT(*) FROM `users` WHERE `id`!='" . $row['id'] . "' AND `email`='" . Cms::Input($_POST['email']) . "'")->fetchColumn() > 0) {
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

            if (!isset($error)) {
                DB::run("UPDATE `users` SET 
                    `login`='" . Cms::Input($_POST['login']) . "', 
                        `firstname`='" . Cms::Input($_POST['firstname']) . "', 
                            `lastname`='" . Cms::Input($_POST['lastname']) . "', 
                                `email`='" . Cms::Input($_POST['email']) . "', 
                                    `phone` = '" . Cms::Input($_POST['phone']) . "', 
                                       `skype`='" . Cms::Input($_POST['skype']) . "', 
                                           `icq`='" . Cms::Input($_POST['icq']) . "',
                                               `city`='" . Cms::Input($_POST['city']) . "',
                                                    `about`='" . Cms::Input($_POST['about']) . "',
                                                        `balls`='" . Cms::Input($_POST['balls']) . "',
                                                            `level`='" . Cms::Input($_POST['level']) . "' WHERE `id`='" . $row['id'] . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Пользователи', 'Редактирование пользователя ' . Cms::Input($_POST['login']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('adminpanel') . '/users');
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/users/edit.tpl');
    }

    function del($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if ($row['level'] == 100) {
                $error = 'Вы не можете удалить главного администратора!';
            }

            if (!isset($error)) {
                //удаляем комментарии к новостям
                DB::run("DELETE FROM `news_comments` WHERE `id_user` = '" . $row['id'] . "'");
                //сообщения с гостевой
                DB::run("DELETE FROM `guest` WHERE `id_user` = '" . $row['id'] . "'");
                //сообщения
                DB::run("DELETE FROM `mail` WHERE `id_user` = '" . $row['id'] . "' OR `user_id` = '" . $row['id'] . "'");
                //контакты
                DB::run("DELETE FROM `contacts` WHERE `id_user` = '" . $row['id'] . "' OR `user_id` = '" . $row['id'] . "'");
                //файлы сообщений
                DB::run("DELETE FROM `mail_files` WHERE `id_user` = '" . $row['id'] . "'");
                //черный список
                DB::run("DELETE FROM `blacklist` WHERE `id_user` = '" . $row['id'] . "' OR `user_id` = '" . $row['id'] . "'");
                //друзья
                DB::run("DELETE FROM `friends` WHERE `id_user` = '" . $row['id'] . "' OR `user_id` = '" . $row['id'] . "'");
                //блог
                DB::run("DELETE FROM `blog` WHERE `id_user` = '" . $row['id'] . "'");
                //комментарии к блогам
                DB::run("DELETE FROM `blog_comments` WHERE `id_user` = '" . $row['id'] . "'");
                //файлы в ЗЦ и комментарии
                $file = DB::run("SELECT * FROM `files` WHERE `id_user` = '" . $row['id'] . "'");
                while ($file2 = $file->fetch(PDO::FETCH_ASSOC)) {
                    //удаляем скриншот
                    Cms::DelFile($file2['path'] . "" . $file2['screen']);
                    //удалем картинки
                    if ($file2['type'] == 'jpg' || $file2['type'] == 'png' || $file2['type'] == 'jpeg' || $file2['type'] == 'gif') {
                        Cms::DelFile($file2['path'] . "small_" . $file2['file']);
                        Cms::DelFile($file2['path'] . "view_" . $file2['file']);
                        Cms::DelFile($file2['path'] . "240x320_" . $file2['file']);
                        Cms::DelFile($file2['path'] . "360x640_" . $file2['file']);
                        Cms::DelFile($file2['path'] . "480x800_" . $file2['file']);
                        Cms::DelFile($file2['path'] . "480x854_" . $file2['file']);
                        Cms::DelFile($file2['path'] . "540x960_" . $file2['file']);
                    }
                    //удаляем скрины к видео
                    if ($file2['type'] == 'mp4' || $file2['type'] == 'avi' || $file2['type'] == '3gp' || $file2['type'] == 'wmv') {
                        Cms::DelFile($file2['path'] . "small_" . $file2['file'] . ".GIF");
                        Cms::DelFile($file2['path'] . "" . $file2['file'] . ".GIF");
                    }
                    //темам
                    if ($file2['type'] == 'nth' || $file2['type'] == 'thm') {
                        Cms::DelFile($file2['path'] . "" . $file2['file'] . ".GIF");
                    }
                    //и сам основной файл
                    Cms::DelFile($file2['path'] . "" . $file2['file']);
                    DB::run("DELETE FROM `files` WHERE `id` = '" . $file2['id'] . "'");
                    DB::run("DELETE FROM `files_comments` WHERE `id_file` = '" . $file2['id'] . "'");
                }
                //темы, посты, файлы к постам, голосования, результаты голосований
                $t = DB::run("SELECT * FROM `tema` WHERE `id_user` = '" . $row['id'] . "'");
                while ($tema = $t->fetch(PDO::FETCH_ASSOC)) {
                    DB::run("DELETE FROM `tema` WHERE `id` = '" . $tema['id'] . "'");
                    DB::run("DELETE FROM `post` WHERE `id_tema` = '" . $tema['id'] . "'");
                    DB::run("DELETE FROM `tema_vote` WHERE `id_tema` = '" . $tema['id'] . "'");
                    DB::run("DELETE FROM `tema_vote_us` WHERE `id_tema` = '" . $tema['id'] . "'");
                    DB::run("DELETE FROM `post_files` WHERE `id_tema` = '" . $tema['id'] . "'");
                }
                //закладки
                DB::run("DELETE FROM `bookmark` WHERE `id_user` = '" . $row['id'] . "'");
                //альбомы
                DB::run("DELETE FROM `gallery` WHERE `id_user` = '" . $row['id'] . "'");
                //фотографии в альбомах
                DB::run("DELETE FROM `gallery_photo` WHERE `id_user` = '" . $row['id'] . "'");
                //рекламу и статистику переходов
                $a = DB::run("SELECT * FROM `ads` WHERE `id_user` = '" . $row['id'] . "'");
                while ($ads = $a->fetch(PDO::FETCH_ASSOC)) {
                    DB::run("DELETE FROM `ads` WHERE `id` = '" . $ads['id'] . "'");
                    DB::run("DELETE FROM `ads_stat` WHERE `id_link` = '" . $ads['id'] . "'");
                }
                //логи с админки, если был в админ.составе
                DB::run("DELETE FROM `adminlogs` WHERE `id_user` = '" . $row['id'] . "'");
                //уведомления
                DB::run("DELETE FROM `notice` WHERE `id_user` = '" . $row['id'] . "'");
                //логи пользователей или лента - ФУНКЦИОНАЛ ЕЩЕ НЕ ГОТОВ
                DB::run("DELETE FROM `userlogs` WHERE `id_user` = '" . $row['id'] . "'");
                //история авторизаций
                DB::run("DELETE FROM `history` WHERE `id_user` = '" . $row['id'] . "'");
                //онлайн
                DB::run("DELETE FROM `online` WHERE `id_user` = '" . $row['id'] . "'");
                //папку с файлами пользователя
                Cms::DelDir('files/user/' . $row['id']);
                //и самого пользователя
                DB::run("DELETE FROM `users` WHERE `id` = '" . $row['id'] . "'");

                //оптимизируем если нужно
                if ($_POST['optimize'] == 1) {
                    DB::run("OPTIMIZE TABLE `news_comments`");
                    DB::run("OPTIMIZE TABLE `guest`");
                    DB::run("OPTIMIZE TABLE `mail`");
                    DB::run("OPTIMIZE TABLE `contacts`");
                    DB::run("OPTIMIZE TABLE `mail_files`");
                    DB::run("OPTIMIZE TABLE `blacklist`");
                    DB::run("OPTIMIZE TABLE `friends`");
                    DB::run("OPTIMIZE TABLE `blog`");
                    DB::run("OPTIMIZE TABLE `blog_comments`");
                    DB::run("OPTIMIZE TABLE `files`");
                    DB::run("OPTIMIZE TABLE `files_comments`");
                    DB::run("OPTIMIZE TABLE `tema`");
                    DB::run("OPTIMIZE TABLE `post`");
                    DB::run("OPTIMIZE TABLE `tema_vote`");
                    DB::run("OPTIMIZE TABLE `tema_vote_us`");
                    DB::run("OPTIMIZE TABLE `post_files`");
                    DB::run("OPTIMIZE TABLE `bookmark`");
                    DB::run("OPTIMIZE TABLE `gallery`");
                    DB::run("OPTIMIZE TABLE `gallery_photo`");
                    DB::run("OPTIMIZE TABLE `ads`");
                    DB::run("OPTIMIZE TABLE `ads_stat`");
                    DB::run("OPTIMIZE TABLE `adminlogs`");
                    DB::run("OPTIMIZE TABLE `notice`");
                    DB::run("OPTIMIZE TABLE `userlogs`");
                    DB::run("OPTIMIZE TABLE `history`");
                    DB::run("OPTIMIZE TABLE `online`");
                }

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Пользователи', 'Удаление пользователя ' . Cms::Input($_POST['login']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('adminpanel') . '/users');
            }
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('adminpanel') . '/users');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/users/del.tpl');
    }

    function balls() {


        SmartySingleton::instance()->assign(array(
            'users' => $a
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/users/balls.tpl');
    }

    function signup() {
        if (isset($_POST['ok'])) {
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['registration']) . "' WHERE `name`='registration'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['activation']) . "' WHERE `name`='activation'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['login_edit']) . "' WHERE `name`='login_edit'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['captcha_signup']) . "' WHERE `name`='captcha_signup'");
            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Настройки сайта', 'Отредактированы настройки регистрации');
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('adminpanel') . '/users/signup');
        }
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/users/signup.tpl');
    }

    function ban($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok'] && $row['level'] < 100) {

            if (empty($_POST['count'])) {
                $error = 'Вы не указали срок бана!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `users` SET `ban`='1',
                            `banprichina`='" . Cms::Input($_POST['text']) . "',
                                `bantime`='" . Cms::Input(Cms::realtime() + $_POST['count'] * $_POST['time'] * 86400) . "' WHERE `id`='" . $row['id'] . "'");

                SmartySingleton::instance()->assign('row', $row);
                SmartySingleton::instance()->assign('banprichina', Cms::bbcode($_POST['text']));
                // инициализируем класс
                $mailer = new phpmailer();
                //настройки
                $mailer->Mailer = Cms::setup('sendmail');
                $mailer->Host = Cms::setup('smtphost');
                $mailer->Port = Cms::setup('smtpport');
                $mailer->Username = Cms::setup('smtpusername');
                $mailer->Password = Cms::setup('smtppassword');
                // Устанавливаем тему письма
                $mailer->Subject = "Блокировка аккаунта на ресурсе " . Cms::setup('home');
                //задаем e-mail админа
                $mailer->From = Cms::setup('emailadmin');
                $mailer->ContentType = 'text/html';
                // Задаем тело письма
                $mailer->Body = SmartySingleton::instance()->fetch(SMARTY_TEMPLATE_LOAD . '/templates/mail/ban.tpl');
                // Добавляем адрес в список получателей
                $mailer->AddAddress($row['email'], $row['login']);
                $mailer->Send();

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Пользователи', 'Бан пользователя ' . $row['login']);
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('adminpanel') . '/users');
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/users/ban.tpl');
    }

    function unban($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (!isset($error)) {
                DB::run("UPDATE `users` SET `ban`='0',
                            `banprichina`='',
                                `bantime`='0' WHERE `id`='" . $row['id'] . "'");

                SmartySingleton::instance()->assign('row', $row);
                SmartySingleton::instance()->assign('banprichina', Cms::bbcode($_POST['text']));
                // инициализируем класс
                $mailer = new phpmailer();
                //настройки
                $mailer->Mailer = Cms::setup('sendmail');
                $mailer->Host = Cms::setup('smtphost');
                $mailer->Port = Cms::setup('smtpport');
                $mailer->Username = Cms::setup('smtpusername');
                $mailer->Password = Cms::setup('smtppassword');
                // Устанавливаем тему письма
                $mailer->Subject = "Разблокирование аккаунта на ресурсе " . Cms::setup('home');
                //задаем e-mail админа
                $mailer->From = Cms::setup('emailadmin');
                $mailer->ContentType = 'text/html';
                // Задаем тело письма
                $mailer->Body = SmartySingleton::instance()->fetch(SMARTY_TEMPLATE_LOAD . '/templates/mail/unban.tpl');
                // Добавляем адрес в список получателей
                $mailer->AddAddress($row['email'], $row['login']);
                $mailer->Send();

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Пользователи', 'Разбан пользователя ' . $row['login']);
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('adminpanel') . '/users');
            }
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('adminpanel') . '/users');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/users/unban.tpl');
    }

}
