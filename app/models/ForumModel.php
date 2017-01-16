<?php

class ForumModel extends Base {

    function index($id) {

        if (empty($this->user['id'])) {
            $filter = " AND `type` = '0'";
        } else if ($this->user['id'] && $this->user['level'] == 1) {
            $filter = " AND `type` != '2'";
        }

        if ($id) {
            $rows = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'$filter")->fetch(PDO::FETCH_ASSOC);
            $count = DB::run("SELECT COUNT(*) FROM `forum` WHERE `refid`='" . $rows['id'] . "'")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT * FROM `forum` WHERE `refid`='" . $rows['id'] . "'$filter ORDER BY `realid` ASC");
                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $row;
                    $text[] = Cms::bbcode($row['text']);
                }
            }
        } else {
            $count = DB::run("SELECT COUNT(*) FROM `forum` WHERE `refid`='0'$filter")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT * FROM `forum` WHERE `refid`='0'$filter ORDER BY `realid` ASC");
                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $row;
                    $text[] = Cms::bbcode($row['text']);
                    $reqs = DB::run("SELECT * FROM `forum` WHERE `refid`='" . $row['id'] . "'$filter ORDER BY `realid` ASC");
                    while ($rows = $reqs->fetch(PDO::FETCH_ASSOC)) {
                        $arrayrows[] = $rows;
                        $texts[] = Cms::bbcode($rows['text']);
                    }
                }
            }
        }
        SmartySingleton::instance()->assign(array(
            'rows' => $rows,
            'text' => $text,
            'texts' => $texts,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'arrayrows' => $arrayrows
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/index.tpl');
    }

    function add_forum($id) {
        $rows = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) > 250) {
                $error .= 'Недопустимая длина описания!';
            }

            if (!isset($error)) {
                if ($rows['id']) {
                    DB::run("INSERT INTO `forum` SET 
                    `refid` = '" . $id . "', 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                               `text`='" . Cms::Input($_POST['text']) . "', 
                                   `keywords`='" . Cms::Input($_POST['keywords']) . "',
                                       `description`='" . Cms::Input($_POST['description']) . "',
                                            `type`='" . $rows['type'] . "'");
                } else {
                    DB::run("INSERT INTO `forum` SET 
                    `refid` = '" . $id . "', 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                               `text`='" . Cms::Input($_POST['text']) . "', 
                                   `keywords`='" . Cms::Input($_POST['keywords']) . "',
                                       `description`='" . Cms::Input($_POST['description']) . "',
                                            `type`='" . Cms::Input($_POST['type']) . "'");
                }

                $fid = DB::lastInsertId();

                DB::run("UPDATE `forum` SET `realid` = '" . $fid . "' WHERE `id`='" . $fid . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Форум', 'Создание раздела ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                if ($id) {
                    Functions::redirect(Cms::setup('home') . '/forum/' . $id);
                } else {
                    Functions::redirect(Cms::setup('home') . '/forum');
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'rows' => $rows,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/add_forum.tpl');
    }

    function setup($id) {
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $row['refid'] . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) > 250) {
                $error .= 'Недопустимая длина описания!';
            }

            if (!isset($error)) {
                if ($row['refid'] > 0) {
                    $f = DB::run("SELECT * FROM `forum` WHERE `id`='" . Cms::Input($_POST['forum']) . "'")->fetch(PDO::FETCH_ASSOC);
                    DB::run("UPDATE `forum` SET 
                    `refid` = '" . Cms::Input($_POST['forum']) . "', 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                               `text`='" . Cms::Input($_POST['text']) . "', 
                                   `keywords`='" . Cms::Input($_POST['keywords']) . "',
                                       `description`='" . Cms::Input($_POST['description']) . "',
                                            `type`='" . Cms::Input($f['type']) . "' WHERE `id`='" . $row['id'] . "'");

                    if ($row['refid'] != $_POST['forum']) {
                        DB::run("UPDATE `tema` SET `id_razdel` = '" . Cms::Input($_POST['forum']) . "', `type`='" . Cms::Input($f['type']) . "' WHERE `id_forum`='" . $row['id'] . "'");
                        DB::run("UPDATE `post` SET `id_razdel` = '" . Cms::Input($_POST['forum']) . "', `type`='" . Cms::Input($f['type']) . "' WHERE `id_forum`='" . $row['id'] . "'");
                        DB::run("UPDATE `post_files` SET `id_razdel` = '" . Cms::Input($_POST['forum']) . "' WHERE `id_forum`='" . $row['id'] . "'");
                    }
                } else {
                    DB::run("UPDATE `forum` SET 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                               `text`='" . Cms::Input($_POST['text']) . "', 
                                   `keywords`='" . Cms::Input($_POST['keywords']) . "',
                                       `description`='" . Cms::Input($_POST['description']) . "',
                                            `type`='" . Cms::Input($_POST['type']) . "' WHERE `id`='" . $row['id'] . "'");
                }

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Форум', 'Редактирование раздела ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                if ($row['refid']) {
                    Functions::redirect(Cms::setup('home') . '/forum/' . $_POST['forum']);
                } else {
                    Functions::redirect(Cms::setup('home') . '/forum');
                }
            }
        }
        $req = DB::run("SELECT `forum`.*, (SELECT COUNT(*) FROM `tema` WHERE `tema`.`id_razdel`=`forum`.`id`) AS `counttema`,
                       (SELECT COUNT(*) FROM `post` WHERE `post`.`id_razdel`=`forum`.`id`) AS `countpost` FROM `forum` WHERE `refid`='0' ORDER BY `realid` ASC");
        while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
            $arrayrow[] = $rows;
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'forum' => $forum,
            'error' => $error,
            'arrayrow' => $arrayrow
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/setup.tpl');
    }

    function setup_del($id) {
        set_time_limit(0);
        /* довольно затратная операция при большом кол-ве данных */
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $row['refid'] . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            if ($row['refid'] > 0) {
                $req = DB::run("SELECT `post`.*, (SELECT `countpost` FROM `users` WHERE `users`.`id`=`post`.`id_user`) AS `countpost` FROM `post` WHERE `id_forum` = '" . $row['id'] . "'");
                while ($post = $req->fetch(PDO::FETCH_ASSOC)) {
                    $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_forum` = '" . $row['id'] . "' AND `id_user`='" . $post['id_user'] . "'")->fetchColumn();
                    $countforum = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_forum`='" . $row['id'] . "'")->fetchColumn();
                    //обновляем кол-во постов у пользователей
                    DB::run("UPDATE `users` SET `countpost` = '" . Cms::Int($post['countpost'] - $count) . "' WHERE `id` = '" . $post['id_user'] . "'");
                    //у раздела
                    DB::run("UPDATE `forum` SET `countpost` = '" . Cms::Int($forum['countpost'] - $countforum) . "' WHERE `id` = '" . $row['refid'] . "'");
                }

                $reqs = DB::run("SELECT `tema`.*, (SELECT `counttema` FROM `users` WHERE `users`.`id`=`tema`.`id_user`) AS `counttema` FROM `tema` WHERE `id_forum` = '" . $row['id'] . "'");
                while ($tema = $reqs->fetch(PDO::FETCH_ASSOC)) {
                    $counts = DB::run("SELECT COUNT(*) FROM `tema` WHERE `id_forum` = '" . $row['id'] . "' AND `id_user`='" . $tema['id_user'] . "'")->fetchColumn();
                    $countsforum = DB::run("SELECT COUNT(*) FROM `tema` WHERE `id_forum`='" . $row['id'] . "'")->fetchColumn();
                    //обновляем кол-во тем у пользователей
                    DB::run("UPDATE `users` SET `counttema` = '" . Cms::Int($tema['counttema'] - $counts) . "' WHERE `id` = '" . $tema['id_user'] . "'");
                    //у раздела
                    DB::run("UPDATE `forum` SET `counttema` = '" . Cms::Int($forum['counttema'] - $countsforum) . "' WHERE `id` = '" . $row['refid'] . "'");
                }

                DB::run("DELETE FROM `forum` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
                DB::run("DELETE FROM `tema` WHERE `id_forum` = '" . $row['id'] . "'");
                DB::run("DELETE FROM `post` WHERE `id_forum` = '" . $row['id'] . "'");
                DB::run("DELETE FROM `tema_vote` WHERE `id_forum` = '" . $row['id'] . "'");
                DB::run("DELETE FROM `tema_vote_us` WHERE `id_forum` = '" . $row['id'] . "'");

                $reqfile = DB::run("SELECT * FROM `post_files` WHERE `id_forum` = '" . $row['id'] . "'");
                while ($file = $reqfile->fetch(PDO::FETCH_ASSOC)) {
                    Cms::DelFile('files/user/' . $file['id_user'] . '/forum/' . $file['file']);
                    DB::run("DELETE FROM `post_files` WHERE `id` = '" . $file['id'] . "'");
                }

                /*
                  DB::run("OPTIMIZE TABLE `forum`");
                  DB::run("OPTIMIZE TABLE `tema`");
                  DB::run("OPTIMIZE TABLE `post`");
                  DB::run("OPTIMIZE TABLE `post_files`");
                  DB::run("OPTIMIZE TABLE `tema_vote`");
                  DB::run("OPTIMIZE TABLE `tema_vote_us`"); */
            } else {
                $req = DB::run("SELECT `post`.*, (SELECT `countpost` FROM `users` WHERE `users`.`id`=`post`.`id_user`) AS `countpost` FROM `post` WHERE `id_razdel` = '" . $row['id'] . "'");
                while ($post = $req->fetch(PDO::FETCH_ASSOC)) {
                    $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_razdel` = '" . $row['id'] . "' AND `id_user`='" . $post['id_user'] . "'")->fetchColumn();
                    //обновляем кол-во постов у пользователей
                    if ($count > 0) {
                        DB::run("UPDATE `users` SET `countpost` = '" . Cms::Int($post['countpost'] - $count) . "' WHERE `id` = '" . $post['id_user'] . "'");
                    }
                }

                $reqs = DB::run("SELECT `tema`.*, (SELECT `counttema` FROM `users` WHERE `users`.`id`=`tema`.`id_user`) AS `counttema` FROM `tema` WHERE `id_razdel` = '" . $row['id'] . "'");
                while ($tema = $reqs->fetch(PDO::FETCH_ASSOC)) {
                    $counts = DB::run("SELECT COUNT(*) FROM `tema` WHERE `id_razdel` = '" . $row['id'] . "' AND `id_user`='" . $tema['id_user'] . "'")->fetchColumn();
                    //обновляем кол-во тем у пользователей
                    if ($counts > 0) {
                        DB::run("UPDATE `users` SET `counttema` = '" . Cms::Int($tema['counttema'] - $counts) . "' WHERE `id` = '" . $tema['id_user'] . "'");
                    }
                }

                DB::run("DELETE FROM `forum` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
                DB::run("DELETE FROM `forum` WHERE `refid` = '" . $row['id'] . "'");
                DB::run("DELETE FROM `tema` WHERE `id_razdel` = '" . $row['id'] . "'");
                DB::run("DELETE FROM `post` WHERE `id_razdel` = '" . $row['id'] . "'");
                DB::run("DELETE FROM `tema_vote` WHERE `id_razdel` = '" . $row['id'] . "'");
                DB::run("DELETE FROM `tema_vote_us` WHERE `id_razdel` = '" . $row['id'] . "'");

                $reqfile = DB::run("SELECT * FROM `post_files` WHERE `id_razdel` = '" . $row['id'] . "'");
                while ($file = $reqfile->fetch(PDO::FETCH_ASSOC)) {
                    Cms::DelFile('files/user/' . $file['id_user'] . '/forum/' . $file['file']);
                    DB::run("DELETE FROM `post_files` WHERE `id` = '" . $file['id'] . "'");
                }
                /*
                  DB::run("OPTIMIZE TABLE `forum`");
                  DB::run("OPTIMIZE TABLE `tema`");
                  DB::run("OPTIMIZE TABLE `post`");
                  DB::run("OPTIMIZE TABLE `post_files`");
                  DB::run("OPTIMIZE TABLE `tema_vote`");
                  DB::run("OPTIMIZE TABLE `tema_vote_us`"); */
            }

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Форум', 'Удаление раздела ' . $row['name']);
            } //пишем лог админа, если включено
            if ($row['refid'] > 0) {
                Functions::redirect(Cms::setup('home') . '/forum/' . $row['refid']);
            } else
                Functions::redirect(Cms::setup('home') . '/forum');
        }

        if ($_POST['close'] && $row['refid'] > 0) {
            Functions::redirect(Cms::setup('home') . '/forum/' . $row['refid']);
        }

        if ($_POST['close'] && $row['refid'] == 0) {
            Functions::redirect(Cms::setup('home') . '/forum');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'forum' => $forum
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/setup_del.tpl');
    }

    function closed($id) {
        $row = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        DB::run("UPDATE `tema` SET `closed`='1' WHERE `id`='" . $row['id'] . "'");

        if (Cms::setup('adminlogs') == 1) {
            Cms::adminlogs('Форум', 'Закрытие темы ' . $row['name']);
        } //пишем лог админа, если включено

        Functions::redirect(Cms::setup('home') . '/forum/' . $row['id_razdel'] . '/' . $row['id_forum'] . '/' . $row['id']);
    }

    function open($id) {
        $row = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        DB::run("UPDATE `tema` SET `closed`='0' WHERE `id`='" . $row['id'] . "'");

        if (Cms::setup('adminlogs') == 1) {
            Cms::adminlogs('Форум', 'Открытие темы ' . $row['name']);
        } //пишем лог админа, если включено

        Functions::redirect(Cms::setup('home') . '/forum/' . $row['id_razdel'] . '/' . $row['id_forum'] . '/' . $row['id']);
    }

    function tema_up($id) {
        $row = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        DB::run("UPDATE `tema` SET `up`='1' WHERE `id`='" . $row['id'] . "'");

        if (Cms::setup('adminlogs') == 1) {
            Cms::adminlogs('Форум', 'Закрепление темы ' . $row['name']);
        } //пишем лог админа, если включено

        Functions::redirect(Cms::setup('home') . '/forum/' . $row['id_razdel'] . '/' . $row['id_forum'] . '/' . $row['id']);
    }

    function tema_down($id) {
        $row = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        DB::run("UPDATE `tema` SET `up`='0' WHERE `id`='" . $row['id'] . "'");

        if (Cms::setup('adminlogs') == 1) {
            Cms::adminlogs('Форум', 'Открепление темы ' . $row['name']);
        } //пишем лог админа, если включено

        Functions::redirect(Cms::setup('home') . '/forum/' . $row['id_razdel'] . '/' . $row['id_forum'] . '/' . $row['id']);
    }

    function tema_setup($id) {
        $tema = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $tema['id_forum'] . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $tema['id_razdel'] . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 3 || mb_strlen(Cms::Input($_POST['name'])) > 500) {
                $error .= 'Недопустимая длина названия темы!<br/>';
            }

            if (!isset($error)) {
                $f = DB::run("SELECT * FROM `forum` WHERE `id`='" . Cms::Input($_POST['forum']) . "'")->fetch(PDO::FETCH_ASSOC);

                DB::run("UPDATE `tema` SET 
                    `id_razdel`='" . $f['refid'] . "', 
                        `id_forum`='" . $f['id'] . "',
                            `realid`='" . Cms::Int($_POST['realid']) . "',
                                `name` = '" . Cms::Input($_POST['name']) . "', 
                                    `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                        `type` = '" . $f['type'] . "' WHERE `id`='" . $tema['id'] . "'");

                if ($tema['id_forum'] != $_POST['forum']) {

                    DB::run("UPDATE `post` SET 
                    `id_razdel`='" . $f['refid'] . "', 
                        `id_forum`='" . $f['id'] . "', 
                            `type` = '" . $f['type'] . "' WHERE `id_tema`='" . $tema['id'] . "'");

                    DB::run("UPDATE `post_files` SET 
                    `id_razdel`='" . $f['refid'] . "', 
                        `id_forum`='" . $f['id'] . "' WHERE `id_tema`='" . $tema['id'] . "'");
                }

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Форум', 'Отредактировал тему ' . $tema['name']);
                } //пишем лог админа, если включено

                Functions::redirect(Cms::setup('home') . '/forum/' . $f['refid'] . '/' . $f['id'] . '/' . $tema['id']);
            }
        }

        //разделы
        $reqsr = DB::run("SELECT * FROM `forum` WHERE `refid`='0' ORDER BY `realid` ASC");
        while ($rowsr = $reqsr->fetch(PDO::FETCH_ASSOC)) {
            $arrayrowr[] = $rowsr;
        }
        //подразделы
        $reqs = DB::run("SELECT * FROM `forum` WHERE `refid`>'0' ORDER BY `realid` ASC");
        while ($rowsp = $reqs->fetch(PDO::FETCH_ASSOC)) {
            $arrayrowp[] = $rowsp;
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'tema' => $tema,
            'forum' => $forum,
            'error' => $error,
            'arrayrowr' => $arrayrowr,
            'arrayrowp' => $arrayrowp
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/tema_setup.tpl');
    }

    function tema_del($id) {
        $tema = DB::run("SELECT `tema`.*, (SELECT `counttema` FROM `users` WHERE `users`.`id`=`tema`.`id_user`) AS `counttema` FROM `tema` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $tema['id_forum'] . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $tema['id_razdel'] . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            //обновляем кол-во тем у пользователя
            DB::run("UPDATE `users` SET `counttema` = '" . Cms::Int($tema['counttema'] - 1) . "' WHERE `id` = '" . $tema['id_user'] . "'");

            //обновляем кол-во тем у форума, подфорума
            DB::run("UPDATE `forum` SET `counttema` = '" . Cms::Int($forum['counttema'] - 1) . "' WHERE `id` = '" . $forum['id'] . "'");
            DB::run("UPDATE `forum` SET `counttema` = '" . Cms::Int($row['counttema'] - 1) . "' WHERE `id` = '" . $row['id'] . "'");

            $req = DB::run("SELECT `post`.*, (SELECT `countpost` FROM `users` WHERE `users`.`id`=`post`.`id_user`) AS `countpost` FROM `post` WHERE `id_tema` = '" . $tema['id'] . "'");
            while ($post = $req->fetch(PDO::FETCH_ASSOC)) {
                $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_tema` = '" . $tema['id'] . "' AND `id_user`='" . $post['id_user'] . "'")->fetchColumn();
                $countrazdel = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_tema` = '" . $tema['id'] . "' AND `id_razdel`='" . $post['id_razdel'] . "'")->fetchColumn();
                $countforum = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_tema` = '" . $tema['id'] . "' AND `id_forum`='" . $post['id_forum'] . "'")->fetchColumn();
                //обновляем кол-во постов у пользователей
                DB::run("UPDATE `users` SET `countpost` = '" . Cms::Int($post['countpost'] - $count) . "' WHERE `id` = '" . $post['id_user'] . "'");
                DB::run("UPDATE `forum` SET `countpost` = '" . Cms::Int($forum['countpost'] - $countrazdel) . "' WHERE `id` = '" . $forum['id'] . "'");
                DB::run("UPDATE `forum` SET `countpost` = '" . Cms::Int($row['countpost'] - $countforum) . "' WHERE `id` = '" . $row['id'] . "'");
            }

            $reqfile = DB::run("SELECT * FROM `post_files` WHERE `id_tema` = '" . $tema['id'] . "'");
            while ($file = $reqfile->fetch(PDO::FETCH_ASSOC)) {
                Cms::DelFile('files/user/' . $file['id_user'] . '/forum/' . $file['file']);
                DB::run("DELETE FROM `post_files` WHERE `id` = '" . $file['id'] . "'");
            }

            DB::run("DELETE FROM `tema` WHERE `id` = '" . $tema['id'] . "' LIMIT 1");
            DB::run("DELETE FROM `post` WHERE `id_tema` = '" . $tema['id'] . "'");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Форум', 'Удаление темы ' . Functions::esc($tema['name']));
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/forum/' . $tema['id_razdel'] . '/' . $tema['id_forum']);
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/forum/' . $tema['id_razdel'] . '/' . $tema['id_forum'] . '/' . $tema['id']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'tema' => $tema,
            'forum' => $forum
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/tema_del.tpl');
    }

    function post_setup($id) {
        $post = DB::run("SELECT * FROM `post` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT * FROM `tema` WHERE `id`='" . $post['id_tema'] . "'")->fetch(PDO::FETCH_ASSOC);
        $rows = DB::run("SELECT * FROM `forum` WHERE `id`='" . $post['id_forum'] . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $post['id_razdel'] . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_tema` = '" . $post['id_tema'] . "'  AND `id` " . (0 ? ">=" : "<=") . " '$id'")->fetchColumn();
        $starts = max(0, (int) $count - (((int) $count % (int) $this->message) == 0 ? $this->message : ((int) $count % (int) $this->message)));

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['text'])) < 3 || mb_strlen(Cms::Input($_POST['text'])) > 10000) {
                $error .= 'Недопустимая длина текста сообщения!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `post` SET `text` = '" . Cms::Input($_POST['text']) . "',
                        `timeedit` = '" . Cms::realtime() . "',
                        `kedit` = '" . Cms::Int($post['kedit'] + 1) . "',
                        `id_user_edit` = '" . $this->user['id'] . "' WHERE `id`='" . $post['id'] . "'");

                for ($i = 0; $i < count($_POST['del']); $i++) {
                    $file = DB::run("SELECT * FROM `post_files` WHERE `id`='" . Cms::Int($_POST['del'][$i]) . "'")->fetch(PDO::FETCH_ASSOC);
                    Cms::DelFile('files/user/' . $post['id_user'] . '/forum/' . $file['file']);
                    DB::run("DELETE FROM `post_files` WHERE `id` = '" . $file['id'] . "'");
                }

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Форум', 'Отредактировал пост в теме ' . $tema['name']);
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/forum/' . $post['id_razdel'] . '/' . $post['id_forum'] . '/' . $tema['id'] . '?page=' . $starts . '#' . $post['id']);
            }
        }

        $reqfile = DB::run("SELECT * FROM `post_files` WHERE `id_post`='" . $post['id'] . "' ORDER BY `id` ASC");
        while ($rowfile = $reqfile->fetch(PDO::FETCH_ASSOC)) {
            $arrayrowfile[] = $rowfile;
        }

        SmartySingleton::instance()->assign(array(
            'rows' => $rows,
            'row' => $post,
            'tema' => $tema,
            'forum' => $forum,
            'error' => $error,
            'starts' => $starts,
            'arrayrowfile' => $arrayrowfile,
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/post_setup.tpl');
    }

    function post_del($id) {
        $post = DB::run("SELECT `post`.*, (SELECT `countpost` FROM `users` WHERE `users`.`id`=`post`.`id_user`) AS `countpost` FROM `post` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT * FROM `tema` WHERE `id`='" . $post['id_tema'] . "'")->fetch(PDO::FETCH_ASSOC);
        $rows = DB::run("SELECT * FROM `forum` WHERE `id`='" . $post['id_forum'] . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $post['id_razdel'] . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_tema` = '" . $post['id_tema'] . "'  AND `id` " . (0 ? ">=" : "<=") . " '$id'")->fetchColumn();
        $starts = max(0, (int) $count - (((int) $count % (int) $this->message) == 0 ? $this->message : ((int) $count % (int) $this->message)));

        if ($_POST['ok']) {
            DB::run("DELETE FROM `post` WHERE `id` = '" . $post['id'] . "' LIMIT 1");

            //обновляем кол-во постов у пользователя
            DB::run("UPDATE `users` SET `countpost` = '" . Cms::Int($post['countpost'] - 1) . "' WHERE `id` = '" . $post['id_user'] . "'");

            //обновляем кол-во постов у форума, подфорума
            DB::run("UPDATE `forum` SET `countpost` = '" . Cms::Int($forum['countpost'] - 1) . "' WHERE `id` = '" . $forum['id'] . "'");
            DB::run("UPDATE `forum` SET `countpost` = '" . Cms::Int($rows['countpost'] - 1) . "' WHERE `id` = '" . $rows['id'] . "'");

            $reqfile = DB::run("SELECT * FROM `post_files` WHERE `id_post` = '" . $post['id'] . "'");
            while ($file = $reqfile->fetch(PDO::FETCH_ASSOC)) {
                Cms::DelFile('files/user/' . $file['id_user'] . '/forum/' . $file['file']);
                DB::run("DELETE FROM `post_files` WHERE `id` = '" . $file['id'] . "'");
            }

            $post = DB::run("SELECT * FROM `post` WHERE `id_tema`='" . $tema['id'] . "' ORDER BY `id` DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            DB::run("UPDATE `tema` SET
                    `id_user_last` = '" . $post['id_user'] . "',
                        `id_post_last` = '" . $post['id'] . "',
                            `countpost` = '" . Cms::Int($tema['countpost'] - 1) . "' WHERE `id` = '" . $tema['id'] . "'");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Форум', 'Удаление поста к теме ' . Functions::esc($tema['name']));
            } //пишем лог админа, если включено

            $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_tema` = '" . $post['id_tema'] . "'  AND `id` " . (0 ? ">=" : "<=") . " '$id'")->fetchColumn();
            $starts = max(0, (int) $count - (((int) $count % (int) $this->message) == 0 ? $this->message : ((int) $count % (int) $this->message)));
            Functions::redirect(Cms::setup('home') . '/forum/' . $post['id_razdel'] . '/' . $post['id_forum'] . '/' . $tema['id'] . '?page=' . $starts);
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/forum/' . $post['id_razdel'] . '/' . $post['id_forum'] . '/' . $tema['id'] . '?page=' . $starts . '#' . $post['id']);
        }

        SmartySingleton::instance()->assign(array(
            'rows' => $rows,
            'row' => $post,
            'text' => Cms::bbcode($post['text']),
            'tema' => $tema,
            'forum' => $forum,
            'starts' => $starts,
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/post_del.tpl');
    }

    function post_reply($id, $id2, $id3, $id4) {
        $post = DB::run("SELECT post. * , (SELECT `login` FROM `users` WHERE `users`.`id` = post.`id_user` ) AS `login` FROM `post` WHERE `id`='" . $id4 . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);
        $rows = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_tema` = '" . $post['id_tema'] . "'  AND `id` " . (0 ? ">=" : "<=") . " '$id4'")->fetchColumn();
        $starts = max(0, (int) $count - (((int) $count % (int) $this->message) == 0 ? $this->message : ((int) $count % (int) $this->message)));

        Forum::AddPost($forum, $rows, $tema, $post);

        SmartySingleton::instance()->assign(array(
            'rows' => $rows,
            'row' => $post,
            'tema' => $tema,
            'forum' => $forum,
            'starts' => $starts
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/post_reply.tpl');
    }

    function post_quote($id, $id2, $id3, $id4) {
        $post = DB::run("SELECT post. * , (SELECT `login` FROM `users` WHERE `users`.`id` = post.`id_user` ) AS `login` FROM `post` WHERE `id`='" . $id4 . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);
        $rows = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_tema` = '" . $post['id_tema'] . "'  AND `id` " . (0 ? ">=" : "<=") . " '$id4'")->fetchColumn();
        $starts = max(0, (int) $count - (((int) $count % (int) $this->message) == 0 ? $this->message : ((int) $count % (int) $this->message)));

        Forum::AddPost($forum, $rows, $tema, $post);

        SmartySingleton::instance()->assign(array(
            'rows' => $rows,
            'row' => $post,
            'tema' => $tema,
            'forum' => $forum,
            'starts' => $starts
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/post_quote.tpl');
    }

    function post($id, $id2, $id3, $id4) {
        $post = DB::run("SELECT post. * , " . User::data('post') . " FROM `post` WHERE `id`='" . $id4 . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT * FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);
        $rows = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_tema` = '" . $post['id_tema'] . "'  AND `id` " . (0 ? ">=" : "<=") . " '$id4'")->fetchColumn();
        $starts = max(0, (int) $count - (((int) $count % (int) $this->message) == 0 ? $this->message : ((int) $count % (int) $this->message)));

        SmartySingleton::instance()->assign(array(
            'row' => $rows,
            'rows' => $post,
            'text' => Cms::bbcode($post['text']),
            'tema' => $tema,
            'forum' => $forum,
            'starts' => $starts
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/post.tpl');
    }

    function forum($id, $id2) {
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `tema` WHERE `id_forum`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `tema`.*,
                                    `users`.`login`
                                        FROM `tema` LEFT JOIN `users` ON `tema`.`id_user_last` = `users`.`id` WHERE `id_forum`='" . $row['id'] . "'  ORDER BY `realid` = 0, `realid`, `up` DESC, `time` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
                $starts[] = max(0, (int) $rows['countpost'] - (((int) $rows['countpost'] % (int) $this->message) == 0 ? $this->message : ((int) $rows['countpost'] % (int) $this->message)));
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'forum' => $forum,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'starts' => $starts,
            'pagenav' => Functions::pagination('/forum/' . $forum['id'] . '/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/forum.tpl');
    }

    function add($id, $id2) {
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 3 || mb_strlen(Cms::Input($_POST['name'])) > 500) {
                $error .= 'Недопустимая длина названия темы!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) < 5 || mb_strlen(Cms::Input($_POST['text'])) > 10000) {
                $error .= 'Недопустимая длина текста сообщения!<br/>';
            }

            //ограничение на отправку сообщений
            if (DB::run("SELECT COUNT(*) FROM `antiflood` WHERE `ip`='" . Recipe::getClientIP() . "' AND `time` > '" . intval(Cms::realtime() - Cms::setup('antiflood')) . "'")->fetchColumn() > 0) {
                $error .= 'Вы не можете отправлять сообщения чаще 1 раза в ' . Functions::ending_second(Cms::setup('antiflood')) . '! Пожалуйста, немного подождите...<br/>';
            }

            if (Cms::setup('captcha_add_theme') == 1 && $_POST['captcha'] != $_COOKIE['code']) {
                $error .= 'Проверочное число с картинки введено не верно!<br/>';
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
                DB::run("INSERT INTO `tema` SET 
                `id_razdel` = '" . $forum['id'] . "', 
                    `id_forum` = '" . $row['id'] . "', 
                        `id_user` = '" . $this->user['id'] . "', 
                            `name` = '" . Cms::Input($_POST['name']) . "', 
                                `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                    `text` = '" . Cms::Input($_POST['text']) . "', 
                                        `time` = '" . Cms::realtime() . "', 
                                            `type` = '" . $forum['type'] . "'");

                $fid = DB::lastInsertId();

                DB::run("INSERT INTO `post` SET 
                `id_razdel` = '" . $forum['id'] . "', 
                    `id_forum` = '" . $row['id'] . "', 
                        `id_tema` = '" . $fid . "', 
                            `id_user` = '" . $this->user['id'] . "', 
                                `text` = '" . Cms::Input($_POST['text']) . "', 
                                    `time` = '" . Cms::realtime() . "', 
                                        `type` = '" . $forum['type'] . "'");

                $postid = DB::lastInsertId();

                DB::run("UPDATE `tema` SET
                        `id_user_last` = '" . $this->user['id'] . "',
                            `id_post_last` = '" . $postid . "',
                                `countpost` = '1' WHERE `id` = '" . $fid . "'");

                //обновляем кол-во постов/тем у пользователя
                DB::run("UPDATE `users` SET `counttema` = '" . Cms::Int($this->user['counttema'] + 1) . "', `countpost` = '" . Cms::Int($this->user['countpost'] + 1) . "' WHERE `id` = '" . $this->user['id'] . "'");
                //обновляем кол-во постов/тем у форума, подфорума
                DB::run("UPDATE `forum` SET `counttema` = '" . Cms::Int($forum['counttema'] + 1) . "', `countpost` = '" . Cms::Int($forum['countpost'] + 1) . "' WHERE `id` = '" . $forum['id'] . "'");
                DB::run("UPDATE `forum` SET `counttema` = '" . Cms::Int($row['counttema'] + 1) . "', `countpost` = '" . Cms::Int($row['countpost'] + 1) . "' WHERE `id` = '" . $row['id'] . "'");

                Cms::antiflood(); //антифлуд
                Cms::addballs(Cms::setup('balls_add_theme'));//прибавляем баллы

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

                    if ((move_uploaded_file($_FILES['file']['tmp_name'][$i], 'files/user/' . $this->user['id'] . '/forum/' . $ftp)) == true) {
                        DB::run("INSERT INTO `post_files` SET 
                            `id_razdel` = '" . $forum['id'] . "', 
                                `id_forum` = '" . $row['id'] . "', 
                                    `id_tema` = '" . $fid . "', 
                                        `id_post` = '" . $postid . "',
                                            `id_user` = '" . $this->user['id'] . "', 
                                                `file` = '" . $ftp . "', 
                                                    `type` = '" . $typ . "', 
                                                        `size` = '" . Functions::size($fsizefile) . "', 
                                                            `time` = '" . Cms::realtime() . "'");
                    }
                }

                Functions::redirect(Cms::setup('home') . '/forum/' . $forum['id'] . '/' . $row['id'] . '/' . $fid);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'forum' => $forum,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/add.tpl');
    }

    function theme($id, $id2, $id3) {
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT `tema`.*, (SELECT COUNT(*) FROM `post_files` WHERE `post_files`.`id_tema`=`tema`.`id`) AS `count`,
                        (SELECT COUNT(*) FROM `tema_vote` WHERE `tema_vote`.`id_tema`=`tema`.`id` AND `type`='1') AS `countvote`,
                        (SELECT COUNT(*) FROM `tema_vote_us` WHERE `tema_vote_us`.`id_tema`=`tema`.`id`) AS `countvoteall`,
                        (SELECT `name` FROM `tema_vote` WHERE `tema_vote`.`id_tema`=`tema`.`id` AND `type`='1') AS `namequestion` FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::addviews('tema', $tema); //подсчет кол-ва просмотров

        Forum::AddPost($forum, $row, $tema); //добавление поста

        $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_tema`='" . $tema['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT post. * , " . User::data('post') . ",
                            (SELECT `text` FROM `post` WHERE `post`.`id` = post.`cit`) AS `textcit`,
                            (SELECT `login` FROM `users` WHERE `users`.`id` = post.`id_user_edit`) AS `login_edit`,
                            (SELECT COUNT(*) FROM `post_files` WHERE `post_files`.`id_post` = post.`id`) AS `count_file` FROM `post`
                            WHERE post.`id_tema` = '" . $tema['id'] . "' ORDER BY post.`id` ASC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
                $text[] = Cms::bbcode($rows['text']);
                $reqfile = DB::run("SELECT * FROM `post_files` WHERE `id_post`='" . $rows['id'] . "' ORDER BY `id` ASC");
                while ($rowfile = $reqfile->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrowfile[] = $rowfile;
                }
            }
        }

        //голосование, варианты
        $reqvote = DB::run("SELECT * FROM `tema_vote` WHERE `id_tema`='" . $tema['id'] . "' AND `type`='2' ORDER BY `id` ASC");
        while ($rowvote = $reqvote->fetch(PDO::FETCH_ASSOC)) {
            $arrayrowvote[] = $rowvote;
        }

        if ($_POST['vote'] && $this->user['id'] && DB::run("SELECT COUNT(*) FROM `tema_vote_us` WHERE `id_tema`='" . $tema['id'] . "' AND `id_user`='" . $this->user['id'] . "'")->fetchColumn() == 0) {

            if (empty($_POST['reply'])) {
                $errorvote = 'Выберите хотя бы один вариант!';
            }

            if (!isset($errorvote)) {
                DB::run("INSERT INTO `tema_vote_us` SET
                        `id_razdel` = '" . $forum['id'] . "', 
                            `id_forum` = '" . $row['id'] . "', 
                                `id_tema` = '" . $tema['id'] . "', 
                                     `id_user` = '" . $this->user['id'] . "',
                                        `vote` = '" . Cms::Int($_POST['reply']) . "',
                                            `time` = '" . Cms::realtime() . "'");

                DB::run("UPDATE `tema_vote` SET `count` = `count` + 1 WHERE id = '" . Cms::Int($_POST['reply']) . "'");

                Functions::redirect($_SERVER['REQUEST_URI']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => $text,
            'forum' => $forum,
            'tema' => $tema,
            'errorvote' => $errorvote,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'arrayrowfile' => $arrayrowfile,
            'arrayrowvote' => $arrayrowvote,
            'pagenav' => Functions::pagination('/forum/' . $forum['id'] . '/' . $row['id'] . '/' . $tema['id'] . '?', $this->page, $count, $this->message),
            'checkvote' => DB::run("SELECT COUNT(*) FROM `tema_vote_us` WHERE `id_tema`='" . $tema['id'] . "' AND `id_user`='" . $this->user['id'] . "'")->fetchColumn(),
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/tema.tpl');
    }

    function files($id, $id2, $id3) {
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT `tema`.*, (SELECT COUNT(*) FROM `post_files` WHERE `post_files`.`id_tema`=`tema`.`id`) AS `count` FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `post_files` WHERE `id_tema`='" . $tema['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $reqfile = DB::run("SELECT * FROM `post_files` WHERE `id_tema`='" . $tema['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rowfile = $reqfile->fetch(PDO::FETCH_ASSOC)) {
                $arrayrowfile[] = $rowfile;
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'forum' => $forum,
            'tema' => $tema,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'arrayrowfile' => $arrayrowfile,
            'pagenav' => Functions::pagination('/forum/' . $forum['id'] . '/' . $row['id'] . '/' . $tema['id'] . '/files?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/files.tpl');
    }

    function new_thems() {

        if (empty($this->user['id'])) {
            $filter = " AND `type` = '0'";
        } else if ($this->user['id'] && $this->user['level'] == 1) {
            $filter = " AND `type` != '2'";
        }

        $count = DB::run("SELECT COUNT(*) FROM `tema` WHERE `time`>'" . intval(Cms::realtime() - Cms::setup('time_forum')) . "'$filter")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `tema`.*,
                                    `users`.`login`
                                        FROM `tema` LEFT JOIN `users` ON `tema`.`id_user_last` = `users`.`id` WHERE `time`>'" . intval(Cms::realtime() - Cms::setup('time_forum')) . "'$filter ORDER BY `time` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
                $starts[] = max(0, (int) $rows['countpost'] - (((int) $rows['countpost'] % (int) $this->message) == 0 ? $this->message : ((int) $rows['countpost'] % (int) $this->message)));
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'starts' => $starts,
            'pagenav' => Functions::pagination('/forum/new/thems?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/new_thems.tpl');
    }

    function new_posts() {

        if (empty($this->user['id'])) {
            $filter = " AND `type` = '0'";
        } else if ($this->user['id'] && $this->user['level'] == 1) {
            $filter = " AND `type` != '2'";
        }

        $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `time`>'" . intval(Cms::realtime() - Cms::setup('time_forum')) . "'$filter")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT post. * , " . User::data('post') . ",
                (SELECT `name` FROM `tema` WHERE `tema`.`id` = post.`id_tema`) AS `nametema`,
                (SELECT `text` FROM `post` WHERE `post`.`id` = post.`cit`) AS `textcit`,
                (SELECT COUNT(*) FROM `post_files` WHERE `post_files`.`id_post` = post.`id`) AS `count_file` FROM `post`
                WHERE post.`time` > '" . intval(Cms::realtime() - Cms::setup('time_forum')) . "'$filter ORDER BY post.`id` DESC  LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
                $text[] = Cms::bbcode($rows['text']);
                $reqfile = DB::run("SELECT * FROM `post_files` WHERE `id_post`='" . $rows['id'] . "' ORDER BY `id` ASC");
                while ($rowfile = $reqfile->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrowfile[] = $rowfile;
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'text' => $text,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'arrayrowfile' => $arrayrowfile,
            'pagenav' => Functions::pagination('/forum/new/posts?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/new_post.tpl');
    }

    function search($search) {

        if (empty($this->user['id'])) {
            $filter = " AND `type` = '0'";
        } else if ($this->user['id'] && $this->user['level'] == 1) {
            $filter = " AND `type` != '2'";
        }

        $search = $search ? $search : Cms::Input($_POST['search']);

        if (empty($search) && isset($_POST['ok'])) {
            $error = 'Задан пустой поисковый запрос!';
        }

        if (isset($_POST['ok'])) {
            Functions::redirect('/forum/search/' . Functions::replace($search));
        }

        if ($search) {
            $search = mb_strtolower(urldecode($search), 'UTF-8');

            if ($search && mb_strlen($search) < 3) {
                $error = 'Общая длина поискового запроса должна быть не менее 3 букв.';
            }

            if (!isset($error)) {
                $count = DB::run("SELECT COUNT(*) FROM `tema` WHERE MATCH (name) AGAINST ('*" . $search . "*' IN BOOLEAN MODE)$filter")->fetchColumn();
                if ($count > 0) {
                    $req = DB::run("SELECT `tema`.*,
                                    `users`.`login`
                                        FROM `tema` LEFT JOIN `users` ON `tema`.`id_user_last` = `users`.`id` WHERE MATCH (name) AGAINST ('*" . $search . "*' IN BOOLEAN MODE)$filter ORDER BY `time` DESC LIMIT " . $this->page . ", " . $this->message);
                    while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                        $arrayrow[] = $rows;
                        $starts[] = max(0, (int) $rows['countpost'] - (((int) $rows['countpost'] % (int) $this->message) == 0 ? $this->message : ((int) $rows['countpost'] % (int) $this->message)));
                    }
                }
            }
        }
        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'search' => $search,
            'starts' => $starts,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/forum/search/' . $search . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/search.tpl');
    }

    function load($id, $id2, $id3, $id4) {
        $row = DB::run("SELECT * FROM `post_files` WHERE `id`='" . $id4 . "'")->fetch(PDO::FETCH_ASSOC);
        DB::run("UPDATE `post_files` SET `loadcounts` = '" . Cms::Int($row['loadcounts'] + 1) . "', `timeload` = '" . Cms::realtime() . "' WHERE `id` = '" . $row['id'] . "'");
        if ($row['type'] == 'png' || $row['type'] == 'jpg' || $row['type'] == 'jpeg' || $row['type'] == 'gif') {
            Functions::redirect(Cms::setup('home') . '/files/user/' . $row['id_user'] . '/forum/' . $row['file']);
        } else {
            Download::load('files/user/' . $row['id_user'] . '/forum/' . $row['file']);
        }
    }

    function vote($id, $id2, $id3) {
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT `tema`.*, (SELECT COUNT(*) FROM `tema_vote` WHERE `tema_vote`.`id_tema`=`tema`.`id` AND `type`='1') AS `countvote` FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok'] && $tema['coutvote'] == 0) {
            if (mb_strlen(Cms::Input($_POST['name'])) < 5 || mb_strlen(Cms::Input($_POST['name'])) > 200) {
                $error .= 'Недопустимая длина названия опроса!<br/>';
            }

            for ($i = 1; $i < count($_POST['reply']); $i++) {
                if (Cms::Input($_POST['reply'][$i]) && mb_strlen(Cms::Input($_POST['reply'][$i])) < 1 || mb_strlen(Cms::Input($_POST['reply'][$i])) > 30) {
                    $error .= 'Недопустимая длина ответа №' . $i . '!<br/>';
                }
                if (Cms::Input($_POST['reply'][$i])) {
                    $not_empty++;
                }
            }

            if ($not_empty < 2) {
                $error .= 'Вы должны указать минимум 2 ответа!<br/>';
            }

            if (!isset($error)) {
                DB::run("INSERT INTO `tema_vote` SET 
                `id_razdel` = '" . $forum['id'] . "', 
                    `id_forum` = '" . $row['id'] . "', 
                        `id_tema` = '" . $tema['id'] . "', 
                            `id_user` = '" . $this->user['id'] . "', 
                                `name` = '" . Cms::Input($_POST['name']) . "', 
                                    `time` = '" . Cms::realtime() . "',
                                        `type` = '1'");

                for ($i = 1; $i < count($_POST['reply']); $i++) {
                    if (Cms::Input($_POST['reply'][$i])) {
                        DB::run("INSERT INTO `tema_vote` SET 
                        `id_razdel` = '" . $forum['id'] . "', 
                            `id_forum` = '" . $row['id'] . "', 
                                `id_tema` = '" . $tema['id'] . "', 
                                    `id_user` = '" . $this->user['id'] . "', 
                                        `name` = '" . Cms::Input($_POST['reply'][$i]) . "', 
                                            `time` = '" . Cms::realtime() . "',
                                                `type` = '2'");
                    }
                }
                Functions::redirect(Cms::setup('home') . '/forum/' . $forum['id'] . '/' . $row['id'] . '/' . $tema['id']);
            }
        }

        for ($vote = 0; $vote < Cms::setup('vote_forum'); $vote++) {
            $array[] = $vote;
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'forum' => $forum,
            'tema' => $tema,
            'error' => $error,
            'array' => $array
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/vote.tpl');
    }

    function vote_edit($id, $id2, $id3) {
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT `tema`.*, (SELECT COUNT(*) FROM `tema_vote` WHERE `tema_vote`.`id_tema`=`tema`.`id` AND `type`='1') AS `countvote`,
                (SELECT `name` FROM `tema_vote` WHERE `tema_vote`.`id_tema`=`tema`.`id` AND `type`='1') AS `namevote` FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `tema_vote` WHERE `id_tema`='" . $tema['id'] . "' AND `type`='2'")->fetchColumn();
        if ($count > 0) {
            $reqvote = DB::run("SELECT * FROM `tema_vote` WHERE `id_tema`='" . $tema['id'] . "' AND `type`='2' ORDER BY `id` ASC");
            while ($rowvote = $reqvote->fetch(PDO::FETCH_ASSOC)) {
                $arrayrowvote[] = $rowvote;
                ++$i2;
            }
        }

        for ($vote = $i2; $vote < Cms::setup('vote_forum'); $vote++) {
            $array[] = $vote;
        }

        if ($_POST['ok'] && $tema['countvote'] == 1) {
            if (mb_strlen(Cms::Input($_POST['name'])) < 5 || mb_strlen(Cms::Input($_POST['name'])) > 200) {
                $error .= 'Недопустимая длина названия опроса!<br/>';
            }

            for ($i = 1; $i < count($_POST['reply']); $i++) {
                if (Cms::Input($_POST['reply'][$i]) && mb_strlen(Cms::Input($_POST['reply'][$i])) < 1 || mb_strlen(Cms::Input($_POST['reply'][$i])) > 30) {
                    $error .= 'Недопустимая длина ответа №' . $i . '!<br/>';
                }
                if (Cms::Input($_POST['reply'][$i])) {
                    $not_empty++;
                }
            }

            if ($not_empty < 2) {
                $error .= 'Вы должны указать минимум 2 ответа!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `tema_vote` SET `name` = '" . Cms::Input($_POST['name']) . "' WHERE `id_tema` = '" . $tema['id'] . "' AND `type` = '1'");

                for ($i = $count; $i < count($_POST['reply']); $i++) {
                    if (Cms::Input($_POST['reply'][$i])) {
                        DB::run("INSERT INTO `tema_vote` SET 
                        `id_razdel` = '" . $forum['id'] . "', 
                            `id_forum` = '" . $row['id'] . "', 
                                `id_tema` = '" . $tema['id'] . "', 
                                    `id_user` = '" . $this->user['id'] . "', 
                                        `name` = '" . Cms::Input($_POST['reply'][$i]) . "', 
                                            `time` = '" . Cms::realtime() . "',
                                                `type` = '2'");
                    }
                }

                $reqvote = DB::run("SELECT * FROM `tema_vote` WHERE `id_tema`='" . $tema['id'] . "' AND `type`='2' ORDER BY `id` ASC");
                while ($rowvote = $reqvote->fetch(PDO::FETCH_ASSOC)) {
                    ++$is;
                    if (Cms::Input($_POST['reply'][$is])) {
                        DB::run("UPDATE `tema_vote` SET `name` = '" . Cms::Input($_POST['reply'][$is]) . "' WHERE `id` = '" . $rowvote['id'] . "'");
                    } else {
                        DB::run("DELETE FROM `tema_vote` WHERE `id` = '" . $rowvote['id'] . "' LIMIT 1");
                        DB::run("DELETE FROM `tema_vote_us` WHERE `vote` = '" . $rowvote['id'] . "'");
                    }
                }
                Functions::redirect(Cms::setup('home') . '/forum/' . $forum['id'] . '/' . $row['id'] . '/' . $tema['id']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'forum' => $forum,
            'tema' => $tema,
            'error' => $error,
            'array' => $array,
            'count' => $count,
            'arrayrowvote' => $arrayrowvote
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/vote_edit.tpl');
    }

    function vote_del($id, $id2, $id3) {
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT `tema`.*, (SELECT COUNT(*) FROM `tema_vote` WHERE `tema_vote`.`id_tema`=`tema`.`id` AND `type`='1') AS `countvote`,
                (SELECT `name` FROM `tema_vote` WHERE `tema_vote`.`id_tema`=`tema`.`id` AND `type`='1') AS `namevote` FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `tema_vote` WHERE `id_tema` = '" . $tema['id'] . "'");
            DB::run("DELETE FROM `tema_vote_us` WHERE `id_tema` = '" . $tema['id'] . "'");
            Functions::redirect(Cms::setup('home') . '/forum/' . $forum['id'] . '/' . $row['id'] . '/' . $tema['id']);
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/forum/' . $forum['id'] . '/' . $row['id'] . '/' . $tema['id']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'forum' => $forum,
            'tema' => $tema
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/vote_del.tpl');
    }

    function vote_all($id, $id2, $id3) {
        $row = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);
        $forum = DB::run("SELECT * FROM `forum` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $tema = DB::run("SELECT `tema`.*, (SELECT COUNT(*) FROM `tema_vote` WHERE `tema_vote`.`id_tema`=`tema`.`id` AND `type`='1') AS `countvote`,
                (SELECT `name` FROM `tema_vote` WHERE `tema_vote`.`id_tema`=`tema`.`id` AND `type`='1') AS `namevote` FROM `tema` WHERE `id`='" . $id3 . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `tema_vote_us` WHERE `id_tema`='" . $tema['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $reqvote = DB::run("SELECT `tema_vote_us`.*, " . User::data('tema_vote_us') . ",
                (SELECT `name` FROM `tema_vote` WHERE `tema_vote`.`id`=`tema_vote_us`.`vote`) AS `option` FROM `tema_vote_us` WHERE `id_tema`='" . $tema['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rowvote = $reqvote->fetch(PDO::FETCH_ASSOC)) {
                $arrayrowvote[] = $rowvote;
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'forum' => $forum,
            'tema' => $tema,
            'count' => $count,
            'arrayrow' => $arrayrowvote,
            'pagenav' => Functions::pagination(Cms::setup('home') . '/forum/' . $forum['id'] . '/' . $row['id'] . '/' . $tema['id'] . '/vote/all?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/forum/vote_all.tpl');
    }

    function down($refid, $id) {
        $req = DB::run("SELECT * FROM `forum` WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "' LIMIT 1");
        if ($req) {
            $res1 = $req->fetch(PDO::FETCH_ASSOC);
            $sort = $res1['realid'];
            $req = DB::run("SELECT * FROM `forum` WHERE `realid` > '" . abs(intval($sort)) . "' ORDER BY `realid` ASC LIMIT 1");
            if ($req) {
                $res = $req->fetch(PDO::FETCH_ASSOC);
                $id2 = $res['id'];
                $sort2 = $res['realid'];
                DB::run("UPDATE `forum` SET `realid` = '" . abs(intval($sort2)) . "' WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
                DB::run("UPDATE `forum` SET `realid` = '" . abs(intval($sort)) . "' WHERE `id` = '" . abs(intval($id2)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
            }
        }
        Functions::redirect(Recipe::getReferer());
    }

    function up($refid, $id) {
        $req = DB::run("SELECT * FROM `forum` WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "' LIMIT 1");
        if ($req) {
            $res1 = $req->fetch(PDO::FETCH_ASSOC);
            $sort = $res1['realid'];
            $req = DB::run("SELECT * FROM `forum` WHERE `realid` < '" . abs(intval($sort)) . "' ORDER BY `realid` DESC LIMIT 1");
            if ($req) {
                $res = $req->fetch(PDO::FETCH_ASSOC);
                $id2 = $res['id'];
                $sort2 = $res['realid'];
                DB::run("UPDATE `forum` SET `realid` = '" . abs(intval($sort2)) . "' WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
                DB::run("UPDATE `forum` SET `realid` = '" . abs(intval($sort)) . "' WHERE `id` = '" . abs(intval($id2)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
            }
        }
        Functions::redirect(Recipe::getReferer());
    }

}
