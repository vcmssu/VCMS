<?php

class GalleryModel extends Base {

    function index($id) {
        if ($id) {
            $row = DB::run("SELECT * FROM `gallery` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

            $count = DB::run("SELECT COUNT(*) FROM `gallery_photo` WHERE `id_gallery`='" . $row['id'] . "'")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT `gallery_photo`.*, (SELECT `name` FROM `gallery` WHERE `gallery`.`id`=`gallery_photo`.`id_gallery`) AS `namealbum` FROM `gallery_photo` WHERE `id_gallery`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT $this->page, " . $this->message);
                while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $rows;
                }
            }

            SmartySingleton::instance()->assign(array(
                'row' => $row,
                'count' => $count,
                'arrayrow' => $arrayrow,
                'pagenav' => Functions::pagination('/gallery/' . $row['id'] . '?', $this->page, $count, $this->message)
            ));
        } else {
            $count = DB::run("SELECT COUNT(*) FROM `gallery_photo`")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT `gallery_photo`.*, (SELECT `name` FROM `gallery` WHERE `gallery`.`id`=`gallery_photo`.`id_gallery`) AS `namealbum` FROM `gallery_photo` ORDER BY `id` DESC LIMIT $this->page, " . $this->message);
                while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $rows;
                }
            }

            SmartySingleton::instance()->assign(array(
                'count' => $count,
                'arrayrow' => $arrayrow,
                'pagenav' => Functions::pagination('/gallery?', $this->page, $count, $this->message)
            ));
        }
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/gallery/index.tpl');
    }

    function photo($id, $id2) {
        $row = DB::run("SELECT gallery_photo. * , (SELECT `name` FROM `gallery` WHERE `gallery`.`id` = gallery_photo.`id_gallery` ) AS `namealbum`, " . User::data('gallery_photo') . " FROM `gallery_photo` WHERE `id`='" . $id2 . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::addviews('gallery_photo', $row);

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => Cms::bbcode($row['text']),
            'Img' => getimagesize('files/user/' . $row['id_user'] . '/gallery/' . $row['id_gallery'] . '/' . $row['photo']),
            'back' => DB::run("SELECT * FROM `gallery_photo` WHERE `id`<'" . abs(intval($row['id'])) . "' ORDER BY `id` DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC),
            'next' => DB::run("SELECT * FROM `gallery_photo` WHERE `id`>'" . abs(intval($row['id'])) . "' ORDER BY `id` ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/gallery/photo.tpl');
    }

    function top() {
        $count = DB::run("SELECT COUNT(*) FROM `gallery_photo`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `gallery_photo`.*, (SELECT `name` FROM `gallery` WHERE `gallery`.`id`=`gallery_photo`.`id_gallery`) AS `namealbum` FROM `gallery_photo` ORDER BY `views` DESC LIMIT $this->page, " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/gallery/top?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/gallery/top.tpl');
    }

    function albums() {
        $count = DB::run("SELECT COUNT(*) FROM `gallery`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT gallery. * , (SELECT COUNT(*) FROM `gallery_photo` WHERE `gallery_photo`.`id_gallery` = gallery.`id` ) AS `count` FROM `gallery` ORDER BY `time` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/gallery/albums?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/gallery/albums.tpl');
    }

    function edit_album($id) {
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

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Фотогалерея', 'Редактирование альбома ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/gallery/albums');
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/gallery/edit_album.tpl');
    }

    function del_album($id) {
        $row = DB::run("SELECT * FROM `gallery` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            Cms::DelDir('files/user/' . $row['id_user'] . '/gallery/' . $row['id']);

            DB::run("DELETE FROM `gallery` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("DELETE FROM `gallery_photo` WHERE `id_gallery` = '" . $row['id'] . "'");
            DB::run("OPTIMIZE TABLE `gallery`");
            DB::run("OPTIMIZE TABLE `gallery_photo`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Фотогалерея', 'Удаление альбома ' . $row['name']);
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/gallery');
        }

        if ($_POST['close']) {

            Functions::redirect(Cms::setup('home') . '/gallery/albums');
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/gallery/del_album.tpl');
    }

    function edit($id) {
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

                if ((move_uploaded_file($_FILES["file"]["tmp_name"], HOME . '/files/user/' . $row['id_user'] . '/gallery/' . $row['id_gallery'] . '/' . $fnamephoto)) == true) {
                    Cms::DelFile(HOME . '/files/user/' . $row['id_user'] . '/gallery/' . $row['id_gallery'] . '/small-' . $row['photo']);
                    Cms::DelFile(HOME . '/files/user/' . $row['id_user'] . '/gallery/' . $row['id_gallery'] . '/' . $row['photo']);

                    $img = new SimpleImage();
                    $img->load(HOME . '/files/user/' . $row['id_user'] . '/gallery/' . $row['id_gallery'] . '/' . $fnamephoto)->fit_to_width(Cms::setup('gallerypreview'))->save(HOME . '/files/user/' . $row['id_user'] . '/gallery/' . $row['id_gallery'] . '/small-' . $fnamephoto);

                    DB::run("UPDATE `gallery_photo` SET `photo` = '" . $fnamephoto . "', `size`='" . Functions::size($fsize) . "' WHERE `id`= '" . $row['id'] . "'");
                }

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Фотогалерея', 'Редактирование фотографии ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/gallery/' . $row['id_gallery']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/gallery/edit.tpl');
    }

    function del($id) {
        $row = DB::run("SELECT gallery_photo. * , (SELECT `name` FROM `gallery` WHERE `gallery`.`id` = gallery_photo.`id_gallery` ) AS `namealbum` FROM `gallery_photo` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            Cms::DelFile('files/user/' . $row['id_user'] . '/gallery/' . $row['id_gallery'] . '/small-' . $row['photo']);
            Cms::DelFile('files/user/' . $row['id_user'] . '/gallery/' . $row['id_gallery'] . '/' . $row['photo']);

            DB::run("DELETE FROM `gallery_photo` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("OPTIMIZE TABLE `gallery_photo`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Фотогалерея', 'Удаление фотографии ' . $row['name']);
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/gallery/' . $row['id_gallery']);
        }

        if ($_POST['close']) {

            Functions::redirect(Cms::setup('home') . '/gallery/' . $row['id_gallery']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/gallery/del.tpl');
    }

    function load($id) {
        $row = DB::run("SELECT * FROM `gallery_photo` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        Download::load('files/user/' . $row['id_user'] . '/gallery/' . $row['id_gallery'] . '/' . $row['photo']);
    }

}
