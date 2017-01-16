<?php

class ActiveModel extends Base {

    function guest($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `guest` WHERE `id_user`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `guest`.*, " . User::data('guest') . " FROM `guest` WHERE `id_user`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
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
            'pagenav' => Functions::pagination('/active/guest/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/guest.tpl');
    }

    function thems($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if (empty($this->user['id'])) {
            $filter = " AND `type` = '0'";
        } else if ($this->user['id'] && $this->user['level'] == 1) {
            $filter = " AND `type` != '2'";
        }

        $count = DB::run("SELECT COUNT(*) FROM `tema` WHERE `id_user`='" . $row['id'] . "'$filter")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `tema`.*,
                                    `users`.`login`
                                        FROM `tema` LEFT JOIN `users` ON `tema`.`id_user_last` = `users`.`id` WHERE `id_user`='" . $row['id'] . "'$filter ORDER BY `realid` = 0, `realid`, `up` DESC, `time` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
                $starts[] = max(0, (int) $rows['countpost'] - (((int) $rows['countpost'] % (int) $this->message) == 0 ? $this->message : ((int) $rows['countpost'] % (int) $this->message)));
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'starts' => $starts,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/active/thems/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/thems.tpl');
    }

    function posts($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if (empty($this->user['id'])) {
            $filter = " AND `type` = '0'";
        } else if ($this->user['id'] && $this->user['level'] == 1) {
            $filter = " AND `type` != '2'";
        }

        $count = DB::run("SELECT COUNT(*) FROM `post` WHERE `id_user`='" . $row['id'] . "'$filter")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT post. * , " . User::data('post') . ",
                (SELECT `name` FROM `tema` WHERE `tema`.`id` = post.`id_tema`) AS `nametema`,
                (SELECT COUNT(*) FROM `post_files` WHERE `post_files`.`id_post` = post.`id`) AS `count_file` FROM `post`
                WHERE `id_user`='" . $row['id'] . "'$filter ORDER BY `id` DESC  LIMIT " . $this->page . ", " . $this->message);
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
            'row' => $row,
            'text' => $text,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/active/posts/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/posts.tpl');
    }

    function download($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        //файлы
        $count = DB::run("SELECT COUNT(*) FROM `files` WHERE `id_user`='" . $row['id'] . "' AND `id_file`='0' AND `user`='0'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `files`.*, (SELECT COUNT(1) FROM `files_comments` WHERE `files_comments`.`id_file`=`files`.`id`) AS `comments` FROM `files` WHERE `id_user`='" . $row['id'] . "' AND `id_file`='0' AND `user`='0' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'count_files' => $count,
            'arrayrow_files' => $arrayrow,
            'pagenav' => Functions::pagination('/active/download/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/download.tpl');
    }

    function blogs($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        //файлы
        $count = DB::run("SELECT COUNT(*) FROM `blog` WHERE `id_user`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `blog`. * , (SELECT `name` FROM `blog_category` WHERE `blog_category`.`id` = blog.`refid` ) AS `namecat`,
                            (SELECT `login` FROM `users` WHERE `users`.`id` = blog.`id_user` ) AS `login`,
                            (SELECT COUNT(*) FROM `blog_comments` WHERE `blog_comments`.`id_post` = blog.`id` ) AS `count` FROM `blog` WHERE `id_user`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/active/blogs/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/blogs.tpl');
    }

    function news_comments($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `news_comments` WHERE `id_user`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `news_comments`.*, " . User::data('news_comments') . " FROM `news_comments` WHERE `id_user`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
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
            'pagenav' => Functions::pagination('/active/news/comments/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/news_comments.tpl');
    }

    function download_comments($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `files_comments` WHERE `id_user`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `files_comments`.*, " . User::data('files_comments') . " FROM `files_comments` WHERE `id_user`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
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
            'pagenav' => Functions::pagination('/active/download/comments/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/download_comments.tpl');
    }

    function blogs_comments($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `blog_comments` WHERE `id_user`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `blog_comments`.*, " . User::data('blog_comments') . " FROM `blog_comments` WHERE `id_user`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
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
            'pagenav' => Functions::pagination('/active/blogs/comments/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/blogs_comments.tpl');
    }

    function gallery($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `gallery_photo` WHERE `id_user`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `gallery_photo`.*, (SELECT `name` FROM `gallery` WHERE `gallery`.`id`=`gallery_photo`.`id_gallery`) AS `namealbum`FROM `gallery_photo` WHERE `id_user`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/active/gallery/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/gallery.tpl');
    }

    function library($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $countart = DB::run("SELECT COUNT(*) FROM `library` WHERE `id_user`='" . $row['id'] . "'")->fetchColumn();
        if ($countart > 0) {
            $reqart = DB::run("SELECT `library`.*, " . User::data('library') . ", (SELECT COUNT(1) FROM `library_comments` WHERE `library_comments`.`refid`=`library`.`id`) AS `comments` FROM `library` WHERE `id_user`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rowart = $reqart->fetch(PDO::FETCH_ASSOC)) {
                $arrayrowart[] = $rowart;
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'countart' => $countart,
            'arrayrowart' => $arrayrowart,
            'pagenav' => Functions::pagination('/active/library/' . $row['id'] . '?', $this->page, $countart, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/library.tpl');
    }

    function library_comments($id) {
        $row = DB::run("SELECT * FROM `users` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        $count = DB::run("SELECT COUNT(*) FROM `library_comments` WHERE `id_user`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `library_comments`.*, " . User::data('library_comments') . " FROM `library_comments` WHERE `id_user`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
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
            'pagenav' => Functions::pagination('/active/library/library/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/active/library_comments.tpl');
    }

}
