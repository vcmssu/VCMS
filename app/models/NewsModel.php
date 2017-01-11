<?php

class NewsModel extends Base {

    function index() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `news` WHERE `status`='1'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `news`.*, (SELECT COUNT(1) FROM `news_comments` WHERE `news_comments`.`id_news`=`news`.`id`) AS `count` FROM `news` WHERE `status`='1' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
                $text[] = BBcode::delete($row['text']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'text' => $text,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/news?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/news/index.tpl');
    }

    function view($id, $page) {
        $row = DB::run("SELECT * FROM `news` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Cms::addviews('news', $row); //подсчет кол-ва просмотров
        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => Cms::bbcode($row['text']),
            'count' => DB::run("SELECT COUNT(*) FROM `news_comments` WHERE `id_news`='" . $row['id'] . "'")->fetchColumn(),
            'arrayrow' => $arrayrow
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/news/view.tpl');
    }

    function comments($id) {
        $row = DB::run("SELECT * FROM `news` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::comments('news_comments', 'id_news', $row['id'], $this->user['id'], 'captcha_comments_news', 'news/comments/' . $row['id']);

        $count = DB::run("SELECT COUNT(*) FROM `news_comments` WHERE `id_news`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `news_comments`.*, " . User::data('news_comments') . " FROM `news_comments` WHERE `id_news`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
                $text[] = Cms::bbcode($rows['text']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => $text,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/news/comments/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/news/comments.tpl');
    }

    function all() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `news`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `news`.*, (SELECT COUNT(1) FROM `news_comments` WHERE `news_comments`.`id_news`=`news`.`id`) AS `count` FROM `news` ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
                $text[] = BBcode::delete($row['text']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'text' => $text,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/news/all?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/news/all.tpl');
    }

    function add() {

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 500) {
                $error .= 'Недопустимая длина названия!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 50000) {
                $error .= 'Недопустимая длина текста!';
            }

            if (!isset($error)) {
                DB::run("INSERT INTO `news` SET 
                `name`='" . Cms::Input($_POST['name']) . "', 
                    `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                       `text`='" . Cms::Input($_POST['text']) . "', 
                           `keywords`='" . Cms::Input($_POST['keywords']) . "',
                               `description`='" . Cms::Input($_POST['description']) . "',
                                    `status`='" . Cms::Input($_POST['status']) . "', 
                                        `comments`='" . Cms::Input($_POST['comments']) . "', 
                                            `time`='" . Cms::realtime() . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Новости', 'Добавление новости ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/news');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/news/add.tpl');
    }

    function edit($id) {
        $row = DB::run("SELECT * FROM `news` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 500) {
                $error .= 'Недопустимая длина названия!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 50000) {
                $error .= 'Недопустимая длина текста!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `news` SET 
                `name`='" . Cms::Input($_POST['name']) . "', 
                    `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                       `text`='" . Cms::Input($_POST['text']) . "', 
                           `keywords`='" . Cms::Input($_POST['keywords']) . "',
                               `description`='" . Cms::Input($_POST['description']) . "',
                                    `status`='" . Cms::Input($_POST['status']) . "', 
                                        `comments`='" . Cms::Input($_POST['comments']) . "' WHERE `id`='" . $row['id'] . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Новости', 'Редактирование новости ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/news/' . $row['id'] . '-' . $row['translate']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/news/edit.tpl');
    }

    function del($id) {
        $row = DB::run("SELECT * FROM `news` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `news` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("DELETE FROM `news_comments` WHERE `id_news` = '" . $row['id'] . "'");
            DB::run("OPTIMIZE TABLE `news`");
            DB::run("OPTIMIZE TABLE `news_comments`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Новости', 'Удаление новости ' . Functions::esc($row['name']));
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/news');
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/news');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => Cms::bbcode($row['text'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/news/del.tpl');
    }

    function edit_comments($id) {
        $row = DB::run("SELECT `news_comments`.*, (SELECT `name` FROM `news` WHERE `news`.`id`=`news_comments`.`id_news`) AS `name`,
            (SELECT `translate` FROM `news` WHERE `news`.`id`=`news_comments`.`id_news`) AS `translate` FROM `news_comments` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 5000) {
                $error .= 'Недопустимая длина текста комментария!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `news_comments` SET `text`='" . Cms::Input($_POST['text']) . "' WHERE `id`='" . $row['id'] . "'");
                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Новости', 'Редактирование комментария к новости ' . Functions::esc($row['name']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/news/comments/' . $row['id_news']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/news/edit_comments.tpl');
    }

    function del_comments($id) {
        $row = DB::run("SELECT `news_comments`.*, (SELECT `name` FROM `news` WHERE `news`.`id`=`news_comments`.`id_news`) AS `name`,
            (SELECT `translate` FROM `news` WHERE `news`.`id`=`news_comments`.`id_news`) AS `translate` FROM `news_comments` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `news_comments` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("OPTIMIZE TABLE `news_comments`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Новости', 'Удалил комментарий к новости ' . Functions::esc($row['name']));
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/news/comments/' . $row['id_news']);
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/news/comments/' . $row['id_news']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => Cms::bbcode($row['text'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/news/del_comments.tpl');
    }

}
