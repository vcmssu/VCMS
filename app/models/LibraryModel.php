<?php

class LibraryModel extends Base {

    function index($id) {
        if ($id) {
            $cat = DB::run("SELECT * FROM `library_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

            $count = DB::run("SELECT COUNT(*) FROM `library_category` WHERE `refid`='" . $cat['id'] . "'")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT `library_category`.*, (SELECT COUNT(*) FROM `library` WHERE `library`.`path` LIKE CONCAT(`library_category`.`path`, '%')) AS `count` FROM `library_category` WHERE `refid`='" . $cat['id'] . "' ORDER BY `realid` ASC LIMIT " . $this->page . ", " . $this->message);
                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $row;
                }
            }

            $countart = DB::run("SELECT COUNT(*) FROM `library` WHERE `refid`='" . $id . "'")->fetchColumn();
            if ($countart > 0) {
                $reqart = DB::run("SELECT `library`.*, " . User::data('library') . ", (SELECT COUNT(1) FROM `library_comments` WHERE `library_comments`.`refid`=`library`.`id`) AS `comments` FROM `library` WHERE `refid`='" . $id . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
                while ($rowart = $reqart->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrowart[] = $rowart;
                    $text[] = BBcode::delete($rowart['text']);
                }
            }

            SmartySingleton::instance()->assign(array(
                'cat' => $cat,
                'text' => $text,
                'count' => $count,
                'countart' => $countart,
                'arrayrow' => $arrayrow,
                'arrayrowart' => $arrayrowart,
                'pat' => Cms::BreadcrumbLibrary($id),
                'pagenav' => Functions::pagination('/library/' . $cat['id'] . '?', $this->page, $count, $this->message),
                'pagenav' => Functions::pagination('/library/' . $cat['id'] . '?', $this->page, $countart, $this->message)
            ));
        } else {
            $count = DB::run("SELECT COUNT(*) FROM `library_category` WHERE `refid`='0'")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT `library_category`.*, (SELECT COUNT(*) FROM `library` WHERE `library`.`path` LIKE CONCAT(`library_category`.`path`, '%')) AS `count` FROM `library_category` WHERE `refid`='0' ORDER BY `realid` ASC LIMIT " . $this->page . ", " . $this->message);
                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $row;
                }
            }

            SmartySingleton::instance()->assign(array(
                'count' => $count,
                'arrayrow' => $arrayrow,
                'pagenav' => Functions::pagination('/library?', $this->page, $count, $this->message)
            ));
        }
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/index.tpl');
    }

    function add($id) {
        $cat = DB::run("SELECT * FROM `library_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия категории!<br/>';
            }

            if (!isset($error)) {
                DB::run("INSERT INTO `library_category` SET 
                    `refid`='" . $cat['id'] . "', 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `user`='" . Cms::Input($_POST['user']) . "', 
                                `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                    `text` = '" . Cms::Input($_POST['text']) . "',
                                        `keywords`='" . Cms::Input($_POST['keywords']) . "', 
                                            `description`='" . Cms::Input($_POST['description']) . "'");

                $fid = DB::lastInsertId();

                if (!$id) {
                    $d['path'] = '/';
                } else {
                    $d = DB::run("SELECT * FROM `library_category` WHERE `id` = " . $id)->fetch(PDO::FETCH_ASSOC);
                }

                $dirnew = trim($d['path']) . trim($fid) . '/';

                DB::run("UPDATE `library_category` SET `realid`='" . $fid . "', `path`='" . $dirnew . "' WHERE `id`='" . $fid . "'");

                Cms::addballs(Cms::setup('balls_add_library')); //прибавляем баллы

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Библиотека', 'Создание новой категории ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                if ($cat['id']) {
                    Functions::redirect(Cms::setup('home') . '/library/' . $cat['id']);
                } else {
                    Functions::redirect(Cms::setup('home') . '/library');
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'cat' => $cat,
            'error' => $error,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pat' => Cms::BreadcrumbLibrary($id)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/add.tpl');
    }

    function articles($id) {
        $cat = DB::run("SELECT * FROM `library_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия статьи!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['autor'])) > 250) {
                $error .= 'Недопустимая длина автора!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 100000) {
                $error .= 'Недопустимая длина содержания статьи!<br/>';
            }

            if (!isset($error)) {
                if ($this->user['level'] == 1) {
                    DB::run("INSERT INTO `library` SET 
                    `id_user`='" . $this->user['id'] . "', 
                        `refid`='" . $cat['id'] . "', 
                            `name`='" . Cms::Input($_POST['name']) . "', 
                                `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                    `autor`='" . Cms::Input($_POST['autor']) . "', 
                                        `text`='" . Cms::Input($_POST['text']) . "', 
                                            `time`='" . Cms::realtime() . "',
                                                `path`='" . $cat['path'] . "',
                                                    `keywords`='" . Functions::seokeywords(Cms::Input($_POST['name'])) . "', 
                                                        `description`='" . BBcode::delete(Functions::truncate(Cms::Input($_POST['text']), 350)) . "'");
                } else {
                    DB::run("INSERT INTO `library` SET 
                    `id_user`='" . $this->user['id'] . "', 
                        `refid`='" . $cat['id'] . "', 
                            `name`='" . Cms::Input($_POST['name']) . "', 
                                `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                    `autor`='" . Cms::Input($_POST['autor']) . "', 
                                        `text`='" . Cms::Input($_POST['text']) . "', 
                                            `time`='" . Cms::realtime() . "',
                                                `path`='" . $cat['path'] . "',
                                                    `keywords`='" . Cms::Input($_POST['keywords']) . "', 
                                                        `description`='" . Cms::Input($_POST['description']) . "'");
                }

                $fid = DB::lastInsertId();
                Functions::redirect(Cms::setup('home') . '/library/' . $fid . '-' . Functions::name_replace(Cms::Input($_POST['name'])));
            }
        }

        SmartySingleton::instance()->assign(array(
            'cat' => $cat,
            'error' => $error,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pat' => Cms::BreadcrumbLibrary($id)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/articles.tpl');
    }

    function edit($id) {
        $row = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия статьи!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['autor'])) > 250) {
                $error .= 'Недопустимая длина автора!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 100000) {
                $error .= 'Недопустимая длина содержания статьи!<br/>';
            }

            if (!isset($error)) {
                DB::run("UPDATE `library` SET 
                            `name`='" . Cms::Input($_POST['name']) . "', 
                                `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                    `autor`='" . Cms::Input($_POST['autor']) . "', 
                                        `text`='" . Cms::Input($_POST['text']) . "', 
                                            `keywords`='" . Cms::Input($_POST['keywords']) . "', 
                                                `description`='" . Cms::Input($_POST['description']) . "' WHERE `id`='" . $row['id'] . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Библиотека', 'Редактирование статьи ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено

                Functions::redirect(Cms::setup('home') . '/library/' . $row['id'] . '-' . Functions::name_replace(Cms::Input($_POST['name'])));
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error,
            'pat' => Cms::BreadcrumbLibrary($row['refid'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/edit.tpl');
    }

    function del($id) {
        $row = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `library` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("DELETE FROM `library_comments` WHERE `refid` = '" . $row['id'] . "'");
            DB::run("OPTIMIZE TABLE `library`");
            DB::run("OPTIMIZE TABLE `library_comments`");


            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Библиотека', 'Удаление статьи ' . Cms::Input($_POST['name']));
            } //пишем лог админа, если включено

            Functions::redirect(Cms::setup('home') . '/library/' . $row['refid']);
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/library/' . $row['id'] . '-' . $row['translate']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error,
            'pat' => Cms::BreadcrumbLibrary($row['refid'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/del.tpl');
    }

    function view($id) {
        $row = DB::run("SELECT library.*, " . User::data('library') . ", (SELECT COUNT(*) FROM `library_rating` WHERE `library_rating`.`refid`=`library`.`id` AND `id_user`='" . $this->user['id'] . "') AS `voteus` FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::addviews('library', $row);

        //голосуем
        Cms::addrating('library', 'library_rating', $row['id'], $this->user['id']);

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
            'pages' => $pages,
            'text' => Cms::bbcode($page_text),
            'pat' => Cms::BreadcrumbLibrary($row['refid']),
            'count' => DB::run("SELECT COUNT(*) FROM `library_comments` WHERE `refid`='" . $row['id'] . "'")->fetchColumn(),
            'pagenav' => Functions::pagination_text($pages, $page, Cms::setup('home') . '/library/' . $row['id'] . '-' . $row['translate'] . '?')
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/view.tpl');
    }

    function category_edit($id) {
        $row = DB::run("SELECT * FROM `library_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error = 'Недопустимая длина названия категории!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `library_category` SET 
                        `name`='" . Cms::Input($_POST['name']) . "', 
                            `user`='" . Cms::Input($_POST['user']) . "', 
                                `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                    `text` = '" . Cms::Input($_POST['text']) . "',
                                        `keywords`='" . Cms::Input($_POST['keywords']) . "', 
                                            `description`='" . Cms::Input($_POST['description']) . "' WHERE `id`='" . $row['id'] . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Библиотека', 'Редактирование категории ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено

                if ($row['refid']) {
                    Functions::redirect(Cms::setup('home') . '/library/' . $row['refid']);
                } else {
                    Functions::redirect(Cms::setup('home') . '/library');
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error,
            'pat' => Cms::BreadcrumbLibrary($row['refid']),
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/category_edit.tpl');
    }

    function category_del($id) {
        $row = DB::run("SELECT * FROM `library_category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `library_category` WHERE `path` LIKE '" . $row['path'] . "%'");

            $art = DB::run("SELECT * FROM `library` WHERE `path` LIKE '" . $row['path'] . "%'");
            while ($lib = $art->fetch(PDO::FETCH_ASSOC)) {
                DB::run("DELETE FROM `library` WHERE `id` = '" . $lib['id'] . "'");
                DB::run("DELETE FROM `library_comments` WHERE `refid` = '" . $lib['id'] . "'");
            }

            DB::run("OPTIMIZE TABLE `library_category`");
            DB::run("OPTIMIZE TABLE `library`");
            DB::run("OPTIMIZE TABLE `library_comments`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Библиотека', 'Удаление категории ' . Cms::Input($row['name']));
            } //пишем лог админа, если включено

            if ($row['refid']) {
                Functions::redirect(Cms::setup('home') . '/library/' . $row['refid']);
            } else {
                Functions::redirect(Cms::setup('home') . '/library');
            }
        }

        if ($_POST['close']) {
            if ($row['refid']) {
                Functions::redirect(Cms::setup('home') . '/library/' . $row['refid']);
            } else {
                Functions::redirect(Cms::setup('home') . '/library');
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'pat' => Cms::BreadcrumbLibrary($row['refid']),
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/category_del.tpl');
    }

    function comments($id) {
        $row = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::comments('library_comments', 'refid', $row['id'], $this->user['id'], 'captcha_comments_library', 'library/comments/' . $row['id']);

        $count = DB::run("SELECT COUNT(*) FROM `library_comments` WHERE `refid`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `library_comments`.*, " . User::data('library_comments') . " FROM `library_comments` WHERE `refid`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
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
            'pat' => Cms::BreadcrumbLibrary($row['refid']),
            'pagenav' => Functions::pagination('/library/comments/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/comments.tpl');
    }

    function edit_comments($id) {
        $row = DB::run("SELECT `library_comments`.*,
            (SELECT `name` FROM `library` WHERE `library`.`id`=`library_comments`.`refid`) AS `name`,
            (SELECT `translate` FROM `library` WHERE `library`.`id`=`library_comments`.`refid`) AS `translate` FROM `library_comments` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 5000) {
                $error .= 'Недопустимая длина текста комментария!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `library_comments` SET `text`='" . Cms::Input($_POST['text']) . "' WHERE `id`='" . $row['id'] . "'");
                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Библиотека', 'Редактирование комментария к статье ' . Functions::esc($row['name']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/library/comments/' . $row['refid']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error,
            'pat' => Cms::BreadcrumbLibrary($row['refid'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/edit_comments.tpl');
    }

    function del_comments($id) {
        $row = DB::run("SELECT `library_comments`.*,
                        (SELECT `name` FROM `library` WHERE `library`.`id`=`library_comments`.`refid`) AS `name`,
                        (SELECT `translate` FROM `library` WHERE `library`.`id`=`library_comments`.`refid`) AS `translate` FROM `library_comments` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `library_comments` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("OPTIMIZE TABLE `library_comments`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Библиотека', 'Удалил комментарий к статье ' . Functions::esc($row['name']));
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/library/comments/' . $row['refid']);
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/library/comments/' . $row['refid']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => Cms::bbcode($row['text']),
            'pat' => Cms::BreadcrumbLibrary($row['refid'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/del_comments.tpl');
    }

    function top() {
        $countart = DB::run("SELECT COUNT(*) FROM `library`")->fetchColumn();
        if ($countart > 0) {
            $reqart = DB::run("SELECT `library`.*, " . User::data('library') . ", (SELECT COUNT(1) FROM `library_comments` WHERE `library_comments`.`refid`=`library`.`id`) AS `comments` FROM `library` ORDER BY `rating` DESC, `views` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rowart = $reqart->fetch(PDO::FETCH_ASSOC)) {
                $arrayrowart[] = $rowart;
                $text[] = BBcode::delete($rowart['text']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'text' => $text,
            'countart' => $countart,
            'arrayrowart' => $arrayrowart,
            'pagenav' => Functions::pagination('/library/top?', $this->page, $countart, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/top.tpl');
    }

    function search($search) {
        $search = $search ? $search : Cms::Input($_POST['search']);
        if (empty($search) && isset($_POST['ok'])) {
            $error = 'Задан пустой поисковый запрос!';
        }

        if (isset($_POST['ok'])) {
            Functions::redirect('/library/search/' . Functions::replace($search));
        }

        if ($search) {
            $search = mb_strtolower(urldecode($search), 'UTF-8');

            if ($search && mb_strlen($search) < 3) {
                $error = 'Общая длина поискового запроса должна быть не менее 3 букв.';
            }

            if (!isset($error)) {
                $countart = DB::run("SELECT COUNT(*) FROM `library` WHERE MATCH (name, autor, text) AGAINST ('*" . $search . "*' IN BOOLEAN MODE)")->fetchColumn();
                if ($countart > 0) {
                    $reqart = DB::run("SELECT `library`.*, " . User::data('library') . ", (SELECT COUNT(1) FROM `library_comments` WHERE `library_comments`.`refid`=`library`.`id`) AS `comments` FROM `library` WHERE MATCH (name, autor, text) AGAINST ('*" . $search . "*' IN BOOLEAN MODE) ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
                    while ($rowart = $reqart->fetch(PDO::FETCH_ASSOC)) {
                        $arrayrowart[] = $rowart;
                        $text[] = BBcode::delete($rowart['text']);
                    }
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'text' => $text,
            'error' => $error,
            'search' => $search,
            'countart' => $countart,
            'arrayrowart' => $arrayrowart,
            'pagenav' => Functions::pagination('/library/search/' . $search . '?', $this->page, $countart, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/library/search.tpl');
    }

    function down($refid, $id) {
        $req = DB::run("SELECT * FROM `library_category` WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "' LIMIT 1");
        if ($req) {
            $res1 = $req->fetch(PDO::FETCH_ASSOC);
            $sort = $res1['realid'];
            $req = DB::run("SELECT * FROM `library_category` WHERE `realid` > '" . abs(intval($sort)) . "' ORDER BY `realid` ASC LIMIT 1");
            if ($req) {
                $res = $req->fetch(PDO::FETCH_ASSOC);
                $id2 = $res['id'];
                $sort2 = $res['realid'];
                DB::run("UPDATE `library_category` SET `realid` = '" . abs(intval($sort2)) . "' WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
                DB::run("UPDATE `library_category` SET `realid` = '" . abs(intval($sort)) . "' WHERE `id` = '" . abs(intval($id2)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
            }
        }
        Functions::redirect(Recipe::getReferer());
    }

    function up($refid, $id) {
        $req = DB::run("SELECT * FROM `library_category` WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "' LIMIT 1");
        if ($req) {
            $res1 = $req->fetch(PDO::FETCH_ASSOC);
            $sort = $res1['realid'];
            $req = DB::run("SELECT * FROM `library_category` WHERE `realid` < '" . abs(intval($sort)) . "' ORDER BY `realid` DESC LIMIT 1");
            if ($req) {
                $res = $req->fetch(PDO::FETCH_ASSOC);
                $id2 = $res['id'];
                $sort2 = $res['realid'];
                DB::run("UPDATE `library_category` SET `realid` = '" . abs(intval($sort2)) . "' WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
                DB::run("UPDATE `library_category` SET `realid` = '" . abs(intval($sort)) . "' WHERE `id` = '" . abs(intval($id2)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
            }
        }
        Functions::redirect(Recipe::getReferer());
    }

    function txt($id) {
        $row = DB::run("SELECT * FROM `library` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $fp = fopen("files/library/" . $row['id'] . ".txt", "a"); // Открываем файл в режиме записи 
        $test = fwrite($fp, nl2br($row['text'])); // Запись в файл
        fclose($fp); //Закрытие файла
        Download::load('files/library/' . $row['id'] . '.txt');
    }

}
