<?php

class BlogsModel extends Base {

    function index() {
        $count = DB::run("SELECT COUNT(*) FROM `blog`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `blog`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog.`refid` ) AS `namecat`,"
                            . "(SELECT `login` FROM `users` WHERE `users`.`id` = blog.`id_user` ) AS `login`,"
                            . "(SELECT COUNT(*) FROM `blog_comments` WHERE `blog_comments`.`id_post` = blog.`id` ) AS `count` FROM `blog` ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/blogs?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/index.tpl');
    }

    function top() {
        $count = DB::run("SELECT COUNT(*) FROM `blog`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `blog`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog.`refid` ) AS `namecat`,"
                            . "(SELECT `login` FROM `users` WHERE `users`.`id` = blog.`id_user` ) AS `login`,"
                            . "(SELECT COUNT(*) FROM `blog_comments` WHERE `blog_comments`.`id_post` = blog.`id` ) AS `count` FROM `blog` ORDER BY `views` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/blogs/top?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/top.tpl');
    }

    function search($search) {
        $search = $search ? $search : Cms::Input($_POST['search']);
        if (empty($search) && isset($_POST['ok'])) {
            $error = 'Задан пустой поисковый запрос!';
        }

        if (isset($_POST['ok'])) {
            Functions::redirect('/blogs/search/' . Functions::replace($search));
        }

        if ($search) {
            $search = mb_strtolower(urldecode($search), 'UTF-8');

            if ($search && mb_strlen($search) < 3) {
                $error = 'Общая длина поискового запроса должна быть не менее 3 букв.';
            }

            if (!isset($error)) {
                $count = DB::run("SELECT COUNT(*) FROM `blog` WHERE MATCH (name, text) AGAINST ('*" . $search . "*' IN BOOLEAN MODE)")->fetchColumn();
                if ($count > 0) {
                    $req = DB::run("SELECT `blog`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog.`refid` ) AS `namecat`,"
                                    . "(SELECT `login` FROM `users` WHERE `users`.`id` = blog.`id_user` ) AS `login`,"
                                    . "(SELECT COUNT(*) FROM `blog_comments` WHERE `blog_comments`.`id_post` = blog.`id` ) AS `count` FROM `blog` WHERE MATCH (name, text) AGAINST ('*" . $search . "*' IN BOOLEAN MODE) ORDER BY `views` DESC LIMIT " . $this->page . ", " . $this->message);
                    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                        $arrayrow[] = $row;
                    }
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'search' => $search,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/blogs/search/' . $search . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/search.tpl');
    }

    function category() {
        //список
        $count = DB::run("SELECT COUNT(*) FROM `blog_category`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `blog_category`.*, (SELECT COUNT(*) FROM `blog` WHERE `blog`.`refid` = blog_category.`id` ) AS `count` FROM `blog_category` ORDER BY `realid` ASC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination(Cms::setup('home') . '/blogs/category?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/category.tpl');
    }

    function category_add() {
        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия категории!<br/>';
            }

            if (DB::run("SELECT COUNT(*) FROM `blog_category` WHERE `name`='" . Cms::Input($_POST['name']) . "'")->fetchColumn() > 0) {
                $error .= 'Категория с таким названием уже существует!<br/>';
            }

            if (!isset($error)) {
                DB::run("INSERT INTO `blog_category` SET 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                `keywords`='" . Cms::Input($_POST['keywords']) . "', 
                                    `description`='" . Cms::Input($_POST['description']) . "'");

                $fid = DB::lastInsertId();

                DB::run("UPDATE `blog_category` SET `realid`='" . $fid . "' WHERE `id`='" . $fid . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Блоги', 'Создание новой категории ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/blogs/category');
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination(Cms::setup('adminpanel') . '/blog/category?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/category_add.tpl');
    }

    function category_edit($id) {
        $row = DB::run("SELECT * FROM `blog_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error = 'Недопустимая длина названия категории!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `blog_category` SET 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                `keywords`='" . Cms::Input($_POST['keywords']) . "', 
                                    `description`='" . Cms::Input($_POST['description']) . "' WHERE `id`='" . $row['id'] . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Блоги', 'Редактирование категории ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/blogs/category');
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/category_edit.tpl');
    }

    function category_del($id) {
        $row = DB::run("SELECT * FROM `blog_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `blog_category` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("DELETE FROM `blog` WHERE `refid` = '" . $row['id'] . "'");
            DB::run("DELETE FROM `blog_comments` WHERE `refid` = '" . $row['id'] . "'");

            DB::run("OPTIMIZE TABLE `blog_category`");
            DB::run("OPTIMIZE TABLE `blog`");
            DB::run("OPTIMIZE TABLE `blog_comments`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Блоги', 'Удаление категории ' . Functions::esc($row['name']));
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/blogs/category');
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/blogs/category');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/category_del.tpl');
    }

    function category_id($id) {
        $category = DB::run("SELECT * FROM `blog_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `blog` WHERE `refid`='" . $category['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `blog`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog.`refid` ) AS `namecat`,"
                            . "(SELECT `login` FROM `users` WHERE `users`.`id` = blog.`id_user` ) AS `login`,"
                            . "(SELECT COUNT(*) FROM `blog_comments` WHERE `blog_comments`.`id_post` = blog.`id` ) AS `count` FROM `blog` WHERE `refid`='" . $category['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/blogs/' . $category['id'] . '?', $this->page, $count, $this->message)
        ));

        SmartySingleton::instance()->assign(array(
            'category' => $category,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/category.tpl');
    }

    function down($id) {
        $req = DB::run("SELECT * FROM `blog_category` WHERE `id` = '" . abs(intval($id)) . "' LIMIT 1");
        if ($req) {
            $res1 = $req->fetch(PDO::FETCH_ASSOC);
            $sort = $res1['realid'];
            $req = DB::run("SELECT * FROM `blog_category` WHERE `realid` > '" . abs(intval($sort)) . "' ORDER BY `realid` ASC LIMIT 1");
            if ($req) {
                $res = $req->fetch(PDO::FETCH_ASSOC);
                $id2 = $res['id'];
                $sort2 = $res['realid'];
                DB::run("UPDATE `blog_category` SET `realid` = '" . abs(intval($sort2)) . "' WHERE `id` = '" . abs(intval($id)) . "'");
                DB::run("UPDATE `blog_category` SET `realid` = '" . abs(intval($sort)) . "' WHERE `id` = '" . abs(intval($id2)) . "'");
            }
        }
        Functions::redirect(Recipe::getReferer());
    }

    function up($id) {
        $req = DB::run("SELECT * FROM `blog_category` WHERE `id` = '" . abs(intval($id)) . "' LIMIT 1");
        if ($req) {
            $res1 = $req->fetch(PDO::FETCH_ASSOC);
            $sort = $res1['realid'];
            $req = DB::run("SELECT * FROM `blog_category` WHERE `realid` < '" . abs(intval($sort)) . "' ORDER BY `realid` DESC LIMIT 1");
            if ($req) {
                $res = $req->fetch(PDO::FETCH_ASSOC);
                $id2 = $res['id'];
                $sort2 = $res['realid'];
                DB::run("UPDATE `blog_category` SET `realid` = '" . abs(intval($sort2)) . "' WHERE `id` = '" . abs(intval($id)) . "'");
                DB::run("UPDATE `blog_category` SET `realid` = '" . abs(intval($sort)) . "' WHERE `id` = '" . abs(intval($id2)) . "'");
            }
        }
        Functions::redirect(Recipe::getReferer());
    }

    function post($id, $id2) {
        $row = DB::run("SELECT `blog`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog.`refid` ) AS `namecat`,
                        (SELECT `login` FROM `users` WHERE `users`.`id` = blog.`id_user` ) AS `login`,
                        (SELECT COUNT(*) FROM `blog_comments` WHERE `blog_comments`.`id_post` = blog.`id` ) AS `count` FROM `blog` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::addviews('blog', $row); //подсчет кол-ва просмотров

        $strrpos = mb_strrpos($row['text'], " ");
        $pages = 1;
        if (isset($this->page)) {
            $page = abs(intval($this->page));
            if ($page == 0) {
                $page = 1;
            }
            $start = $page - 1;
        } else {
            $page = $start + 1;
        }
        $t_si = 0;
        if ($strrpos) {
            while ($t_si < $strrpos) {
                $string = mb_substr($row['text'], $t_si, Cms::setup('count_txt'));
                $t_ki = mb_strrpos($string, " ");
                $m_sim = $t_ki;
                $strings[$pages] = $string;
                $t_si = $t_ki + $t_si;
                if ($page == $pages) {
                    $page_text = $strings[$pages];
                }
                if ($strings[$pages] == "") {
                    $t_si = $strrpos++;
                } else {
                    $pages++;
                }
            }
            if ($page >= $pages) {
                $page = $pages - 1;
                $page_text = $strings[$page];
            }
            $pages = $pages - 1;
            if ($page != $pages) {
                $prb = mb_strrpos($page_text, " ");
                $page_text = mb_substr($page_text, 0, $prb);
            }
        } else {
            $page_text = $row['text'];
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'count' => $pages,
            'text' => Cms::bbcode($page_text),
            'pagenav' => Functions::pagination_text($pages, $page, Cms::setup('home') . '/blogs/' . $row['refid'] . '/' . $row['id'] . '-' . $row['translate'] . '?')
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/post.tpl');
    }

    function edit($id) {
        $row = DB::run("SELECT `blog`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog.`refid` ) AS `namecat`,
                        (SELECT `login` FROM `users` WHERE `users`.`id` = blog.`id_user` ) AS `login`,
                        (SELECT COUNT(*) FROM `blog_comments` WHERE `blog_comments`.`id_post` = blog.`id` ) AS `count` FROM `blog` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);


        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия поста!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['name'])) < 5 || mb_strlen(Cms::Input($_POST['name'])) > 100000) {
                $error .= 'Недопустимая длина содержания поста!<br/>';
            }

            if (!isset($error)) {
                $category = DB::run("SELECT * FROM `blog_category` WHERE `id`='" . Cms::Int($_POST['refid']) . "'")->fetch(PDO::FETCH_ASSOC);
                DB::run("UPDATE `blog` SET 
                        `refid`='" . Cms::Int($_POST['refid']) . "',
                            `name`='" . Cms::Input($_POST['name']) . "', 
                                `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                    `text`='" . Cms::Input($_POST['text']) . "',
                                        `keywords`='" . Functions::seokeywords(Cms::Input($_POST['name'])) . "', 
                                            `description`='" . BBcode::delete(Functions::truncate(Cms::Input($_POST['text']), 350)) . "' WHERE `id`='" . $row['id'] . "'");

                if ($row['refid'] != $_POST['refid']) {
                    DB::run("UPDATE `blog_comments` SET 
                              `refid`='" . Cms::Int($_POST['refid']) . "' WHERE `id_post`='" . $row['id'] . "'");
                }

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Блоги', 'Редактирование поста ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/blogs/' . $_POST['refid'] . '/' . $row['id'] . '-' . $row['translate']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error,
            'arrayrow' => DB::run("SELECT * FROM `blog_category` ORDER BY `realid` ASC")->fetchAll()
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/edit.tpl');
    }

    function del($id) {
        $row = DB::run("SELECT `blog`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog.`refid` ) AS `namecat`,
                        (SELECT `login` FROM `users` WHERE `users`.`id` = blog.`id_user` ) AS `login`,
                        (SELECT COUNT(*) FROM `blog_comments` WHERE `blog_comments`.`id_post` = blog.`id` ) AS `count` FROM `blog` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `blog` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("DELETE FROM `blog_comments` WHERE `refid` = '" . $row['id'] . "'");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Блоги', 'Удаление поста ' . Functions::esc($row['name']));
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/blogs');
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/blogs/' . $row['refid'] . '/' . $row['id'] . '-' . $row['translate']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/del.tpl');
    }

    function comments($id) {
        $row = DB::run("SELECT `blog`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog.`refid` ) AS `namecat` FROM `blog` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::comments('blog_comments', 'id_post', $row['id'], $this->user['id'], 'captcha_comments_blog', 'blogs/comments/' . $row['id'], $row['refid']);

        $count = DB::run("SELECT COUNT(*) FROM `blog_comments` WHERE `id_post`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `blog_comments`.*, " . User::data('blog_comments') . " FROM `blog_comments` WHERE `id_post`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
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
            'pagenav' => Functions::pagination('/blogs/comments/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/comments.tpl');
    }

    function edit_comments($id) {
        $row = DB::run("SELECT `blog_comments`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog_comments.`refid` ) AS `namecat`,
                        (SELECT `name` FROM `blog` WHERE `blog`.`id` = blog_comments.`id_post` ) AS `name`,
                        (SELECT `translate` FROM `blog` WHERE `blog`.`id` = blog_comments.`id_post` ) AS `translate` FROM `blog_comments` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 5000) {
                $error .= 'Недопустимая длина текста комментария!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `blog_comments` SET `text`='" . Cms::Input($_POST['text']) . "' WHERE `id`='" . $row['id'] . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Блоги', 'Редактирование комментария к посту ' . Functions::esc($row['name']));
                } //пишем лог админа, если включено

                Functions::redirect(Cms::setup('home') . '/blogs/comments/' . $row['id_post']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/edit_comments.tpl');
    }

    function del_comments($id) {
        $row = DB::run("SELECT `blog_comments`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog_comments.`refid` ) AS `namecat`,
                        (SELECT `name` FROM `blog` WHERE `blog`.`id` = blog_comments.`id_post` ) AS `name`,
                        (SELECT `translate` FROM `blog` WHERE `blog`.`id` = blog_comments.`id_post` ) AS `translate` FROM `blog_comments` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `blog_comments` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("OPTIMIZE TABLE `blog_comments`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Блоги', 'Удаление комментария к посту ' . Functions::esc($row['name']));
            } //пишем лог админа, если включено

            Functions::redirect(Cms::setup('home') . '/blogs/comments/' . $row['id_post']);
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/blogs/comments/' . $row['id_post']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => Cms::bbcode($row['text'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/blogs/del_comments.tpl');
    }

}
