<?php

class DownloadModel extends Base {

    function index($id) {
        if (!$id) {
            $count = DB::run("SELECT COUNT(*) FROM `category` WHERE `refid`='0'")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT `category`.*, (SELECT COUNT(1) FROM `files` WHERE `files`.`path` LIKE CONCAT(`category`.`path`, '%') AND `size` > '0' AND `id_file`='0' AND `user`='0') AS `count`,
                (SELECT COUNT(1) FROM `files` WHERE `files`.`path` LIKE CONCAT(`category`.`path`, '%') AND `size` > '0' AND `time` > '" . intval(Cms::realtime() - Cms::setup('newfile')) . "' AND `id_file`='0' AND `user`='0') AS `countnew` FROM `category` WHERE `refid`='0' ORDER BY `realid` ASC LIMIT " . $this->page . ", " . $this->message);
                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $row;
                }
            }

            SmartySingleton::instance()->assign(array(
                'id' => $id,
                'count' => $count,
                'arrayrow' => $arrayrow,
                'pagenav' => Functions::pagination(Cms::setup('home') . '/download?', $this->page, $count, $this->message)
            ));
        } else {
            $count = DB::run("SELECT COUNT(*) FROM `category` WHERE `refid`='" . $id . "'")->fetchColumn();
            if ($count > 0) {
                $req = DB::run("SELECT `category`.*, (SELECT COUNT(1) FROM `files` WHERE `files`.`path` LIKE CONCAT(`category`.`path`, '%') AND `size` > '0' AND `id_file`='0' AND `user`='0') AS `count`,
                (SELECT COUNT(1) FROM `files` WHERE `files`.`path` LIKE CONCAT(`category`.`path`, '%') AND `size` > '0' AND `time` > '" . intval(Cms::realtime() - Cms::setup('newfile')) . "' AND `id_file`='0' AND `user`='0') AS `countnew` FROM `category` WHERE `refid`='" . $id . "' ORDER BY `realid` ASC LIMIT " . $this->page . ", " . $this->message);
                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow[] = $row;
                }
            }

            $cat = DB::run("SELECT * FROM `category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

            //файлы
            $count_files = DB::run("SELECT COUNT(*) FROM `files` WHERE `refid`='" . $id . "' AND `id_file`='0' AND `user`='0'")->fetchColumn();
            if ($count_files > 0) {
                $req_files = DB::run("SELECT `files`.*, (SELECT COUNT(1) FROM `files_comments` WHERE `files_comments`.`id_file`=`files`.`id`) AS `comments` FROM `files` WHERE `refid`='" . $id . "' AND `id_file`='0' AND `user`='0' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
                while ($row_files = $req_files->fetch(PDO::FETCH_ASSOC)) {
                    $arrayrow_files[] = $row_files;
                }
            }

            //обработка загрузки файла
            if ($_POST['upload'] && $this->user['level'] > 40 || $_POST['upload'] && $this->user['id'] && $cat['user'] == 1) {

                if (mb_strlen(Cms::Input($_POST['names'])) > 250) {
                    $error_file .= 'Недопустимая длина названия файла!<br/>';
                }

                if (mb_strlen(Cms::Input($_POST['text'])) > 5000) {
                    $error_file .= 'Недопустимая длина описания файла!<br/>';
                }

                $do_filefile = false;
                // Проверка загрузки с обычного браузера
                if ($_FILES['file']['size'] > 0) {
                    $do_filefile = true;
                    $ifnamefile = strtolower($_FILES['file']['name']);
                    $originalfile = $_FILES['file']['name'];
                    $typ = pathinfo($ifnamefile, PATHINFO_EXTENSION);
                    $rand = rand(11111, 99999); //случайное число	
                    //Конечное имя файла для сохранения без расширения
                    $fnamefile = Functions::name_replace($ifnamefile);
                    //Конечное имя файла для сохранения с расширением
                    $ftp = Functions::name_replace(Functions::truncate($ifnamefile, 200)) . '_' . $rand . '_' . strtoupper(str_replace('http://', '', Cms::setup('home'))) . '.' . $typ;
                    $fsizefile = $_FILES['file']['size'];
                }

                if ($cat['user'] == 1 && $do_filefile) {
                    // Список допустимых расширений файлов.
                    $al_ext = explode(', ', $cat['type']);
                    $ext = array_pop(explode(".", $originalfile));
                    // Проверка файла на наличие только одного расширения
                    if (count($ext) != 1) {
                        $error_file .= 'Запрещенный формат файла ' . $originalfile . '!<br/>';
                    }
                    // Проверка допустимых расширений файлов
                    if (!in_array($typ, $al_ext)) {
                        $error_file .= 'Не допустимый формат файла ' . $originalfile . '!<br/>';
                    }
                    // Проверка на допустимый размер файла
                    if ($fsizefile >= $cat['maxfilesize'] * 1024 * 1024) {
                        $error_file .= 'Недопустимый вес файла ' . $originalfile . '!<br/>';
                    }
                }

                if ($do_filefile == null) {
                    $error_file .= 'Вы не выбрали файл для загрузки!<br/>';
                }

                //скриншот
                $do_filescreen = false;
                // Проверка загрузки с обычного браузера
                if ($_FILES['screen']['size'] > 0) {
                    $do_filescreen = true;
                    $ifnamescreen = strtolower($_FILES['screen']['name']);
                    $typs = pathinfo($ifnamescreen, PATHINFO_EXTENSION);
                    $fnamescreen = Functions::passgen(25) . '.' . $typs;
                    $fsizescreen = $_FILES['screen']['size'];
                }
                //обработка файла
                if ($do_filescreen) {
                    // Список допустимых расширений файлов.
                    $al_ext = array(
                        'jpg',
                        'jpeg',
                        'gif',
                        'png'
                    );
                    $ext = explode(".", $fnamescreen);
                    // Проверка файла на наличие только одного расширения
                    if (count($ext) != 2) {
                        $error_file .= 'Запрещенный формат картинки скриншота!<br/>';
                    }
                    // Проверка допустимых расширений файлов
                    if (!in_array($ext[1], $al_ext)) {
                        $error_file .= 'Не допустимый формат картинки скриншота!<br/>';
                    }
                    // Проверка на допустимый размер файла
                    if ($fsizescreen >= Cms::setup('filesize_photo') * 1024 * 1024) {
                        $error_file .= 'Недопустимый вес скриншота!<br/>';
                    }
                }

                $reg = DB::run("select * from `files` where `file`='" . $ftp . "' AND `path`='" . $cat['path'] . "'");
                if ($reg->fetch(PDO::FETCH_NUM) != 0) {
                    $error_file .= 'Файл с таким названием уже существует в папке ' . $cat['name'] . '!<br/>';
                }

                if (!isset($error_file)) {
                    //загружаем файл
                    if ((move_uploaded_file($_FILES["file"]["tmp_name"], $cat['path'] . "" . $ftp)) == true) {
                        if ($typ == 'png' || $typ == 'jpg' || $typ == 'gif' || $typ == 'jpeg') {
                            //создаем превьюшку к картинке и только к картинке
                            $img = new SimpleImage();
                            $img->load($cat['path'] . '' . $ftp)->fit_to_width(Cms::setup('preview'))->save($cat['path'] . 'view_' . $ftp);
                            $img->load($cat['path'] . '' . $ftp)->fit_to_width(Cms::setup('previewsmall'))->save($cat['path'] . 'small_' . $ftp);
                            if (Cms::setup('watermark') == 1) {
                                Download::watermark($cat['path'] . 'view_' . $ftp, 10);
                                Download::watermark($cat['path'] . 'small_' . $ftp, 3);
                            }
                        }

                        //меняем id3-тег в звуковом файле
                        if ($typ == 'mp3' || $typ == 'wav' || $typ == 'ogg' || $typ == 'amr') {
                            $id3 = new MP3_Id();
                            $id3->read($cat['path'] . '' . $ftp);
                            $id3->comment = iconv('utf-8', 'windows-1251', strtoupper(str_replace('http://', '', Cms::setup('home'))));
                            $id3->write();
                        }

                        //вытаскиваем иконку из jar файла
                        if ($typ == 'jar') {
                            $archive2 = new JarInfo($cat['path'] . '' . $ftp);
                            $archive2->getIcon($cat['path'] . '' . $ftp . '.icon.png');
                        }

                        //создаем скрин для видео-файла
                        if ($typ == 'mp4' || $typ == 'avi' || $typ == '3gp' || $typ == 'wmv') {
                            if (Cms::setup('autoscreen_video') == 1 && class_exists('ffmpeg_movie')) {
                                Download::autoscreen_video($cat['path'] . '' . $ftp, $cat['path'] . '' . $ftp . '.GIF', 640, 480);
                                Download::autoscreen_video($cat['path'] . '' . $ftp, $cat['path'] . 'small_' . $ftp . '.GIF', Cms::setup('previewsmall'), Cms::setup('previewsmall2'));
                                if (Cms::setup('watermark') == 1) {
                                    Download::watermark($cat['path'] . '' . $ftp . '.GIF');
                                    Download::watermark($cat['path'] . 'small_' . $ftp . '.GIF');
                                }
                            }
                        }

                        //скриншот к темам формата nth
                        if (Cms::setup('autoscreen_nth') == 1) {
                            if ($typ == 'nth') {
                                Download::autoscreen_nth($cat['path'] . '' . $ftp, Cms::setup('previewsmall'), Cms::setup('previewsmall2'), $cat['path'] . '' . $ftp . '.GIF');
                            }
                        }
                        //скриншот к темам формата thm
                        if (Cms::setup('autoscreen_thm') == 1) {
                            if ($typ == 'thm') {
                                Download::autoscreen_thm($cat['path'] . '' . $cat['file'], Cms::setup('previewsmall'), Cms::setup('previewsmall2'), $cat['path'] . '' . $ftp . '.GIF');
                            }
                        }

                        if ($_POST['number'] == 1) {
                            $originalfile = preg_replace('/\d/', '', $originalfile);
                        }

                        if ($_POST['simvol'] == 1) {
                            $originalfile = preg_replace('/[-`~!#$%^&*()_=+\\\\|\\/\\[\\]{};:"\',<>?]+/', '', $originalfile);
                        }

                        if ($cat['user'] == 1 && $this->user['level'] < 40) {
                            if (!empty($_POST['names'])) {
                                DB::run("INSERT INTO `files` SET 
                                `id_user` = '" . $this->user['id'] . "', 
                                    `refid` = '" . $cat['id'] . "', 
                                        `name` = '" . Cms::Input($_POST['names']) . "', 
                                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['names'])) . "', 
                                                `text` = '" . Cms::Input($_POST['text']) . "', 
                                                    `time` = '" . Cms::realtime() . "',
                                                        `file` = '" . $ftp . "', 
                                                            `type` = '" . $typ . "', 
                                                                `size` = '" . Functions::size($fsizefile) . "', 
                                                                    `path` = '" . $cat['path'] . "', 
                                                                        `infolder` = '" . $cat['infolder'] . "',
                                                                            `user` = '1',
                                                                                `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                                                                    `description` = '" . Cms::Input($_POST['description']) . "'");
                            } else {
                                DB::run("INSERT INTO `files` SET 
                                `id_user` = '" . $this->user['id'] . "',
                                    `refid` = '" . $cat['id'] . "', 
                                        `name` = '" . substr(Cms::Input($originalfile), 0, -4) . "', 
                                            `translate` = '" . substr(Cms::Input($fnamefile), 0, -3) . "', 
                                                `text` = '" . Cms::Input($_POST['text']) . "', 
                                                    `time` = '" . Cms::realtime() . "',
                                                        `file` = '" . $ftp . "', 
                                                            `type` = '" . $typ . "', 
                                                                `size` = '" . Functions::size($fsizefile) . "', 
                                                                    `path` = '" . $cat['path'] . "', 
                                                                        `infolder` = '" . $cat['infolder'] . "',
                                                                            `user` = '1',
                                                                                `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                                                                    `description` = '" . Cms::Input($_POST['description']) . "'");
                            }
                        } else if ($this->user['level'] > 40) {
                            if (!empty($_POST['names'])) {
                                DB::run("INSERT INTO `files` SET 
                                `id_user` = '" . $this->user['id'] . "', 
                                    `refid` = '" . $cat['id'] . "', 
                                        `name` = '" . Cms::Input($_POST['names']) . "', 
                                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['names'])) . "', 
                                                `text` = '" . Cms::Input($_POST['text']) . "', 
                                                    `time` = '" . Cms::realtime() . "',
                                                        `file` = '" . $ftp . "', 
                                                            `type` = '" . $typ . "', 
                                                                `size` = '" . Functions::size($fsizefile) . "', 
                                                                    `path` = '" . $cat['path'] . "', 
                                                                        `infolder` = '" . $cat['infolder'] . "',
                                                                            `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                                                                `description` = '" . Cms::Input($_POST['description']) . "'");
                            } else {
                                DB::run("INSERT INTO `files` SET 
                                `id_user` = '" . $this->user['id'] . "',
                                    `refid` = '" . $cat['id'] . "', 
                                        `name` = '" . substr(Cms::Input($originalfile), 0, -4) . "', 
                                            `translate` = '" . substr(Cms::Input($fnamefile), 0, -3) . "', 
                                                `text` = '" . Cms::Input($_POST['text']) . "', 
                                                    `time` = '" . Cms::realtime() . "',
                                                        `file` = '" . $ftp . "', 
                                                            `type` = '" . $typ . "', 
                                                                `size` = '" . Functions::size($fsizefile) . "', 
                                                                    `path` = '" . $cat['path'] . "', 
                                                                        `infolder` = '" . $cat['infolder'] . "',
                                                                            `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                                                                `description` = '" . Cms::Input($_POST['description']) . "'");
                            }
                        }
                        $fid = DB::lastInsertId();
                        ;
                    }

                    //загружаем и обрабатываем скриншот
                    if ((move_uploaded_file($_FILES["screen"]["tmp_name"], $cat['path'] . "" . $fnamescreen)) == true) {
                        $img = new SimpleImage();
                        $img->load($cat['path'] . '' . $fnamescreen)->fit_to_width(Cms::setup('previewsmall'))->save($cat['path'] . 'small_' . $fnamescreen);

                        if (Cms::setup('watermark') == 1) {
                            Download::watermark($cat['path'] . '' . $fnamescreen, 10);
                            Download::watermark($cat['path'] . 'small_' . $fnamescreen, 3);
                        }

                        DB::run("UPDATE `files` SET `screen` = '" . $fnamescreen . "' WHERE `id` = '" . $fid . "'");
                    }
                    
                    Cms::addballs(Cms::setup('balls_add_download'));//прибавляем баллы

                    if (Cms::setup('adminlogs') == 1 && $this->user['level'] > 1) {
                        Cms::adminlogs('ЗЦ', 'Добавление файла ' . Cms::Input($originalfile));
                    } //пишем лог админа, если включено
                    if ($this->user['level'] > 40) {
                        Functions::redirect('/download/' . $id);
                    } else {
                        Functions::redirect(Cms::setup('home') . '/profile/files');
                    }
                }
            }

            //массовая загрузка файлов
            if ($_POST['mass'] && $this->user['level'] > 40) {

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

                    if (empty($do_file)) {
                        $error_mass = 'Вы должны выбрать минимум один файл!';
                    }

                    $reg = DB::run("select * from `files` where `file`='" . $ftp . "' AND `path`='" . $cat['path'] . "'");
                    if ($reg->fetch(PDO::FETCH_NUM) != 0) {
                        $error_file = 'Файл с таким названием уже существует в папке ' . Functions::esc($cat['name']) . '!';
                    }
                }

                if (!isset($error_mass)) {
                    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                        $do_file = false;
                        // Проверка загрузки с обычного браузера
                        if ($_FILES['file']['size'][$i] > 0) {
                            $do_file = true;
                            $ifnamefile = strtolower($_FILES['file']['name'][$i]);
                            $originalfile = $_FILES['file']['name'][$i];
                            $typ = pathinfo($ifnamefile, PATHINFO_EXTENSION);
                            $rand = rand(11111, 99999); //случайное число	
                            //Конечное имя файла для сохранения без расширения
                            $fnamefile = Functions::name_replace($ifnamefile);
                            //Конечное имя файла для сохранения с расширением
                            //$ftp = str_replace($typ, '', $ifnamefile);
                            $ftp = Functions::name_replace(Functions::truncate($ifnamefile, 200)) . '_' . $rand . '_' . strtoupper(str_replace('http://', '', Cms::setup('home'))) . '.' . $typ;
                            $fsizefile = $_FILES['file']['size'][$i];
                        }
                        //загружаем файл
                        if ((move_uploaded_file($_FILES["file"]["tmp_name"][$i], $cat['path'] . "" . $ftp)) == true) {
                            if ($typ == 'png' || $typ == 'jpg' || $typ == 'gif' || $typ == 'jpeg') {
                                //создаем превьюшку к картинке и только к картинке
                                $img = new SimpleImage();
                                $img->load($cat['path'] . '' . $ftp)->fit_to_width(Cms::setup('preview'))->save($cat['path'] . 'view_' . $ftp);
                                $img->load($cat['path'] . '' . $ftp)->fit_to_width(Cms::setup('previewsmall'))->save($cat['path'] . 'small_' . $ftp);
                                if (Cms::setup('watermark') == 1) {
                                    Download::watermark($cat['path'] . 'view_' . $ftp, 10);
                                    Download::watermark($cat['path'] . 'small_' . $ftp, 3);
                                }
                            }

                            //меняем id3-тег в звуковом файле
                            if ($typ == 'mp3' || $typ == 'wav' || $typ == 'ogg' || $typ == 'amr') {
                                $id3 = new MP3_Id();
                                $id3->read($cat['path'] . '' . $ftp);
                                $id3->comment = iconv('utf-8', 'windows-1251', strtoupper(str_replace('http://', '', Cms::setup('home'))));
                                $id3->write();
                            }

                            //вытаскиваем иконку из jar файла
                            if ($typ == 'jar') {
                                $archive2 = new JarInfo($cat['path'] . '' . $ftp);
                                $archive2->getIcon($cat['path'] . '' . $ftp . '.icon.png');
                            }

                            //создаем скрин для видео-файла
                            if ($typ == 'mp4' || $typ == 'avi' || $typ == '3gp' || $typ == 'wmv') {
                                if (Cms::setup('autoscreen_video') == 1 && class_exists('ffmpeg_movie')) {
                                    Download::autoscreen_video($cat['path'] . '' . $ftp, $cat['path'] . '' . $ftp . '.GIF', 640, 480);
                                    Download::autoscreen_video($cat['path'] . '' . $ftp, $cat['path'] . 'small_' . $ftp . '.GIF', Cms::setup('previewsmall'), Cms::setup('previewsmall2'));
                                    if (Cms::setup('watermark') == 1) {
                                        Download::watermark($cat['path'] . '' . $ftp . '.GIF');
                                        Download::watermark($cat['path'] . 'small_' . $ftp . '.GIF');
                                    }
                                }
                            }

                            //скриншот к темам формата nth
                            if (Cms::setup('autoscreen_nth') == 1) {
                                if ($typ == 'nth') {
                                    Download::autoscreen_nth($cat['path'] . '' . $ftp, Cms::setup('previewsmall'), Cms::setup('previewsmall2'), $cat['path'] . '' . $ftp . '.GIF');
                                }
                            }
                            //скриншот к темам формата thm
                            if (Cms::setup('autoscreen_thm') == 1) {
                                if ($typ == 'thm') {
                                    Download::autoscreen_thm($cat['path'] . '' . $cat['file'], Cms::setup('previewsmall'), Cms::setup('previewsmall2'), $cat['path'] . '' . $ftp . '.GIF');
                                }
                            }

                            if ($_POST['number'] == 1) {
                                $originalfile = preg_replace('/\d/', '', $originalfile);
                            }

                            if ($_POST['simvol'] == 1) {
                                $originalfile = preg_replace('/[-`~!#$%^&*()_=+\\\\|\\/\\[\\]{};:"\',<>?]+/', '', $originalfile);
                            }

                            DB::run("INSERT INTO `files` SET 
                                `id_user` = '" . $this->user['id'] . "',
                                    `refid` = '" . $cat['id'] . "', 
                                        `name` = '" . substr(Cms::Input($originalfile), 0, -4) . "', 
                                            `translate` = '" . substr(Cms::Input($fnamefile), 0, -3) . "', 
                                                `text` = '" . Cms::Input($_POST['text']) . "', 
                                                    `time` = '" . Cms::realtime() . "',
                                                        `file` = '" . $ftp . "', 
                                                            `type` = '" . $typ . "', 
                                                                `size` = '" . Functions::size($fsizefile) . "', 
                                                                    `path` = '" . $cat['path'] . "', 
                                                                        `infolder` = '" . $cat['infolder'] . "'");
                        }

                        if (Cms::setup('adminlogs') == 1) {
                            Cms::adminlogs('ЗЦ', 'Добавление файла ' . Cms::Input($originalfile));
                        } //пишем лог админа, если включено
                    }
                    Functions::redirect('/download/' . $id);
                }
            }

            SmartySingleton::instance()->assign(array(
                'id' => $id,
                'cat' => $cat,
                'error_file' => $error_file,
                'error_mass' => $error_mass,
                'moderation' => DB::run("SELECT COUNT(*) FROM `files` WHERE `user`='1'")->fetchColumn(),
                'pagenav' => Functions::pagination(Cms::setup('home') . '/download/' . $id . '?', $this->page, $count_files, $this->message)
            ));
        }

        if ($_POST['ok'] && $this->user['level'] > 40) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия категории!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) > 250) {
                $error .= 'Недопустимая длина описания категории!<br/>';
            }

            if ($_POST['user'] == 1) {
                if (empty($_POST['type'])) {
                    $error .= 'Вы не указали типы файлов для загрузки!<br/>';
                }

                if (empty($_POST['maxfilesize'])) {
                    $error .= 'Вы не указали максимальный размер 1 файла для загрузки!<br/>';
                }
            }

            //иконка к категории
            $do_filefile = false;
            // Проверка загрузки с обычного браузера
            if ($_FILES['icon']['size'] > 0) {
                $do_filefile = true;
                $ifnamefile = strtolower($_FILES['icon']['name']);
                $ifnamefile = str_replace(' ', '_', $ifnamefile);
                $typ = pathinfo($ifnamefile, PATHINFO_EXTENSION);
                $fnamefiles = pathinfo($ifnamefile, PATHINFO_FILENAME);
                //Конечное имя файла для сохранения без расширения
                $fnamefile = Functions::name_replace($fnamefiles);
                //Конечное имя файла для сохранения с расширением
                $ftp = $fnamefile . '.' . $typ;
                $fsizefile = $_FILES['icon']['size'];
            }
            //обработка файла
            if ($do_filefile) {
                // Список недопустимых расширений файлов.
                $al_ext = explode(", ", "png, jpg, jpeg, gif");
                $ext = explode(".", $ftp);
                // Проверка на допустимый размер файла
                if ($fsizefile >= 5 * 1024 * 1024) {
                    $error .= 'Недопустимый вес файла!<br/>';
                }
                // Проверка файла на наличие только одного расширения
                if (count($ext) != 2) {
                    $error .= 'Файл имеет двойное расширение!<br/>';
                }

                // Проверка недопустимых расширений файлов
                if (!in_array($typ, $al_ext)) {
                    $error .= 'Запрещенный тип файла!<br/>';
                }

                if ($typ == null) {
                    $error .= 'Файл не имеет расширения!<br/>';
                }
            }

            if (!isset($error)) {
                if ($_POST['user'] == 1) {
                    DB::run("INSERT INTO `category` SET 
                    `refid` = '" . $id . "', 
                        `name` = '" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                `text` = '" . Cms::Input($_POST['text']) . "',
                                    `user` = '" . Cms::Input($_POST['user']) . "',
                                        `type` = '" . Cms::Input($_POST['type']) . "',
                                            `maxfilesize` = '" . Cms::Input($_POST['maxfilesize']) . "',
                                                `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                                    `description` = '" . Cms::Input($_POST['description']) . "'");
                } else {
                    DB::run("INSERT INTO `category` SET 
                    `refid` = '" . $id . "', 
                        `name` = '" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                `text` = '" . Cms::Input($_POST['text']) . "',
                                    `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                        `description` = '" . Cms::Input($_POST['description']) . "'");
                }

                $fid = DB::lastInsertId();
                ;

                DB::run("UPDATE `category` SET `realid` = '" . $fid . "' WHERE `id`='" . $fid . "'");

                //создаем категорию, расставляем права на запись и т.д.
                $dirnew = Functions::name_replace(Cms::Input($_POST['name']));

                if (!$id) {
                    $d['path'] = 'files/download/';
                } else {
                    $d = DB::run("SELECT * FROM `category` WHERE `id` = " . $id)->fetch(PDO::FETCH_ASSOC);
                }

                chmod($d['path'], 0777);
                $dirnew = trim($d['path']) . trim($dirnew) . '/';
                mkdir($dirnew, 0777);
                chmod($dirnew, 0777);

                //загружаем и обрабатываем иконку
                if ((move_uploaded_file($_FILES["icon"]["tmp_name"], $dirnew . "" . $ftp)) == true) {
                    DB::run("UPDATE `category` SET `icon` = '" . $ftp . "' WHERE `id` = '" . $fid . "'");
                }

                DB::run("UPDATE `category` SET `path` = '" . $dirnew . "', `infolder` = '" . $d['path'] . "' WHERE `id`='" . $fid . "'");
                DB::run("OPTIMIZE TABLE `category`");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('ЗЦ', 'Создание категории ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено

                if (!$id) {
                    Functions::redirect('/download');
                } else {
                    Functions::redirect('/download/' . $fid);
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'id' => $id,
            'pat' => Cms::BreadcrumbDownload($id),
            'error' => $error,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'count_files' => $count_files,
            'arrayrow_files' => $arrayrow_files,
            'moderation' => DB::run("SELECT COUNT(*) FROM `files` WHERE `user`='1'")->fetchColumn(),
            'pagenav_category' => Functions::pagination(Cms::setup('home') . '/download/' . $id . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/index.tpl');
    }

    function setup($id) {
        $row = DB::run("SELECT * FROM `category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok'] && $this->user['level'] > 40) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 2 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия категории!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) < 0 || mb_strlen(Cms::Input($_POST['text'])) > 250) {
                $error .= 'Недопустимая длина описания категории!<br/>';
            }

            if ($_POST['user'] == 1) {
                if (empty($_POST['type'])) {
                    $error .= 'Вы не указали типы файлов для загрузки!<br/>';
                }

                if (empty($_POST['maxfilesize'])) {
                    $error .= 'Вы не указали максимальный размер 1 файла для загрузки!<br/>';
                }
            }

            //иконка к категории
            $do_filefile = false;
            // Проверка загрузки с обычного браузера
            if ($_FILES['icon']['size'] > 0) {
                $do_filefile = true;
                $ifnamefile = strtolower($_FILES['icon']['name']);
                $ifnamefile = str_replace(' ', '_', $ifnamefile);
                $typ = pathinfo($ifnamefile, PATHINFO_EXTENSION);
                $fnamefiles = pathinfo($ifnamefile, PATHINFO_FILENAME);
                //Конечное имя файла для сохранения без расширения
                $fnamefile = Functions::name_replace($fnamefiles);
                //Конечное имя файла для сохранения с расширением
                $ftp = $fnamefile . '.' . $typ;
                $fsizefile = $_FILES['icon']['size'];
            }
            //обработка файла
            if ($do_filefile) {
                // Список недопустимых расширений файлов.
                $al_ext = explode(", ", "png, jpg, jpeg, gif");
                $ext = explode(".", $ftp);
                // Проверка на допустимый размер файла
                if ($fsizefile >= 5 * 1024 * 1024) {
                    $error .= 'Недопустимый вес файла!<br/>';
                }
                // Проверка файла на наличие только одного расширения
                if (count($ext) != 2) {
                    $error .= 'Файл имеет двойное расширение!<br/>';
                }

                // Проверка недопустимых расширений файлов
                if (!in_array($typ, $al_ext)) {
                    $error .= 'Запрещенный тип файла!<br/>';
                }

                if ($typ == null) {
                    $error .= 'Файл не имеет расширения!<br/>';
                }
            }

            if (!isset($error)) {
                if ($row['user'] == 1) {
                    DB::run("UPDATE `category` SET 
                        `name` = '" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                `text` = '" . Cms::Input($_POST['text']) . "',
                                    `user` = '" . Cms::Input($_POST['user']) . "',
                                        `type` = '" . Cms::Input($_POST['type']) . "',
                                            `maxfilesize` = '" . Cms::Input($_POST['maxfilesize']) . "',
                                                `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                                    `description` = '" . Cms::Input($_POST['description']) . "' WHERE `id`='" . $row['id'] . "'");
                } else {
                    DB::run("UPDATE `category` SET 
                        `name` = '" . Cms::Input($_POST['name']) . "', 
                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                                `text` = '" . Cms::Input($_POST['text']) . "',
                                    `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                        `description` = '" . Cms::Input($_POST['description']) . "' WHERE `id`='" . $row['id'] . "'");
                }
                //загружаем и обрабатываем иконку
                if ((move_uploaded_file($_FILES["icon"]["tmp_name"], $row['path'] . "/" . $ftp)) == true) {
                    Cms::DelFile($row['path'] . "/" . $row['icon']);
                    DB::run("UPDATE `category` SET `icon` = '" . $ftp . "' WHERE `id` = '" . $row['id'] . "'");
                }

                DB::run("OPTIMIZE TABLE `category`");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('ЗЦ', 'Редактирование категории ' . Cms::Input($_POST['name']));
                } //пишем лог админа, если включено
                Functions::redirect('/download/' . $row['id']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'pat' => Cms::BreadcrumbDownload($id),
            'error' => $error
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/setup.tpl');
    }

    function del_category($id) {
        $row = DB::run("SELECT * FROM `category` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            Cms::DelDir($row['path']); // сносим папку
            DB::run("DELETE FROM `category` WHERE `path` LIKE '" . $row['path'] . "%'"); //// Сносим папки принадлежащие удаляемой папке

            $file = DB::run("SELECT * FROM `files` WHERE `path` LIKE '" . $row['path'] . "%'"); //// Сносим файлы принадлежащие удаляемой папке
            while ($file2 = $file->fetch(PDO::FETCH_ASSOC)) {
                DB::run("DELETE FROM `files` WHERE `id` = '" . $file2['id'] . "'");
                DB::run("DELETE FROM `files_comments` WHERE `id_file` = '" . $file2['id'] . "'");
            }
            DB::run("OPTIMIZE TABLE `category`");
            DB::run("OPTIMIZE TABLE `files`");
            DB::run("OPTIMIZE TABLE `files_comments`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('ЗЦ', 'Удаление категории ' . Functions::esc($row['name']));
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/download/' . $row['refid']);
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/download/' . $row['id']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'pat' => Cms::BreadcrumbDownload($id)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/del_category.tpl');
    }

    function edit($id) {
        $row = DB::run("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['name'])) < 3 || mb_strlen(Cms::Input($_POST['name'])) > 250) {
                $error .= 'Недопустимая длина названия файла!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) > 5000) {
                $error .= 'Недопустимая длина описания файла!<br/>';
            }

            $do_filefile = false;
            // Проверка загрузки с обычного браузера
            if ($_FILES['file']['size'] > 0) {
                $do_filefile = true;
                $ifnamefile = strtolower($_FILES['file']['name']);
                $typ = pathinfo($ifnamefile, PATHINFO_EXTENSION);
                $rand = rand(11111, 99999); //случайное число	
                //Конечное имя файла для сохранения без расширения
                $fnamefile = Functions::name_replace($ifnamefile);
                //Конечное имя файла для сохранения с расширением
                $ftp = Functions::name_replace(Functions::truncate($ifnamefile, 200)) . '_' . $rand . '_' . strtoupper(str_replace('http://', '', Cms::setup('home'))) . '.' . $typ;
                $fsizefile = $_FILES['file']['size'];
            }

            //скриншот
            $do_filescreen = false;
            // Проверка загрузки с обычного браузера
            if ($_FILES['screen']['size'] > 0) {
                $do_filescreen = true;
                $ifnamescreen = strtolower($_FILES['screen']['name']);
                $typs = pathinfo($ifnamescreen, PATHINFO_EXTENSION);
                $fnamescreen = Functions::passgen(25) . '.' . $typs;
            }
            //обработка файла
            if ($do_filescreen) {
                // Список допустимых расширений файлов.
                $al_ext = array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png'
                );
                $ext = explode(".", $fnamescreen);
                // Проверка файла на наличие только одного расширения
                if (count($ext) != 2) {
                    $error .= 'Запрещенный формат картинки скриншота!<br/>';
                }
                // Проверка допустимых расширений файлов
                if (!in_array($ext[1], $al_ext)) {
                    $error .= 'Не допустимый формат картинки скриншота!<br/>';
                }
            }

            $reg = DB::run("SELECT * FROM `files` WHERE `file`='" . $ftp . "' AND `path`='" . $row['path'] . "'");
            if ($reg->fetch(PDO::FETCH_NUM) != 0) {
                $error .= 'Файл с таким названием уже существует в папке ' . $row['name'] . '!';
            }

            if (!isset($error)) {
                //загружаем файл
                if ((move_uploaded_file($_FILES["file"]["tmp_name"], $row['path'] . "" . $ftp)) == true) {
                    //удаляем картинки
                    if ($row['type'] == 'jpg' || $row['type'] == 'png' || $row['type'] == 'jpeg' || $row['type'] == 'gif' || $row['type'] == 'bmp') {
                        Cms::DelFile($row['path'] . "small_" . $row['file']);
                        Cms::DelFile($row['path'] . "view_" . $row['file']);
                    }
                    //удаляем скрины к видео
                    if ($row['type'] == 'mp4' || $row['type'] == 'avi' || $row['type'] == '3gp') {
                        Cms::DelFile($row['path'] . "small_" . $row['file'] . ".GIF");
                        Cms::DelFile($row['path'] . "" . $row['file'] . ".GIF");
                    }
                    //темам
                    if ($row['type'] == 'nth' || $row['type'] == 'thm') {
                        Cms::DelFile($row['path'] . "" . $row['file'] . ".GIF");
                    }
                    //jar файлам
                    if ($row['type'] == 'jar') {
                        Cms::DelFile($row['path'] . "" . $row['file'] . ".icon.png");
                    }

                    //и сам основной файл
                    Cms::DelFile($row['path'] . "" . $row['file']);

                    if ($typ == 'png' || $typ == 'jpg' || $typ == 'gif' || $typ == 'jpeg') {
                        //создаем превьюшку к картинке и только к картинке
                        $img = new SimpleImage();
                        $img->load($row['path'] . '' . $ftp)->fit_to_width(Cms::setup('preview'))->save($row['path'] . 'view_' . $ftp);
                        $img->load($row['path'] . '' . $ftp)->fit_to_width(Cms::setup('previewsmall'))->save($row['path'] . 'small_' . $ftp);
                        if (Cms::setup('watermark') == 1) {
                            Download::watermark($row['path'] . 'view_' . $ftp, 10);
                            Download::watermark($row['path'] . 'small_' . $ftp, 3);
                        }
                    }

                    //меняем id3-тег в звуковом файле
                    if ($typ == 'mp3' || $typ == 'wav' || $typ == 'ogg' || $typ == 'amr') {
                        $id3 = new MP3_Id();
                        $id3->read($row['path'] . '' . $ftp);
                        $id3->comment = iconv('utf-8', 'windows-1251', strtoupper(str_replace('http://', '', Cms::setup('home'))));
                        $id3->write();
                    }

                    //вытаскиваем иконку из jar файла
                    if ($typ == 'jar') {
                        $archive2 = new JarInfo($row['path'] . '' . $ftp);
                        $archive2->getIcon($row['path'] . '' . $ftp . '.icon.png');
                    }

                    //создаем скрин для видео-файла
                    if ($typ == 'mp4' || $typ == 'avi' || $typ == '3gp' || $typ == 'wmv') {
                        if (Cms::setup('autoscreen_video') == 1 && class_exists('ffmpeg_movie')) {
                            Download::autoscreen_video($row['path'] . '' . $ftp, $row['path'] . '' . $ftp . '.GIF', 640, 480);
                            Download::autoscreen_video($row['path'] . '' . $ftp, $row['path'] . 'small_' . $ftp . '.GIF', Cms::setup('previewsmall'), Cms::setup('previewsmall2'));
                            if (Cms::setup('watermark') == 1) {
                                Download::watermark($row['path'] . '' . $ftp . '.GIF');
                                Download::watermark($row['path'] . 'small_' . $ftp . '.GIF');
                            }
                        }
                    }

                    //скриншот к темам формата nth
                    if (Cms::setup('autoscreen_nth') == 1) {
                        if ($typ == 'nth') {
                            Download::autoscreen_nth($row['path'] . '' . $ftp, Cms::setup('previewsmall'), Cms::setup('previewsmall2'), $row['path'] . '' . $ftp . '.GIF');
                        }
                    }
                    //скриншот к темам формата thm
                    if (Cms::setup('autoscreen_thm') == 1) {
                        if ($typ == 'thm') {
                            Download::autoscreen_thm($row['path'] . '' . $row['file'], Cms::setup('previewsmall'), Cms::setup('previewsmall2'), $row['path'] . '' . $ftp . '.GIF');
                        }
                    }

                    DB::run("UPDATE `files` SET `file` = '" . $ftp . "', `type` = '" . $typ . "', `size` = '" . Functions::size($fsizefile) . "' WHERE `id`='" . $row['id'] . "'");
                }

                //загружаем и обрабатываем скриншот
                if ((move_uploaded_file($_FILES["screen"]["tmp_name"], $row['path'] . "" . $fnamescreen)) == true) {
                    //удаляем скриншот
                    Cms::DelFile($row['path'] . "" . $row['screen']);
                    $img = new SimpleImage();
                    $img->load($row['path'] . '' . $fnamescreen)->fit_to_width(Cms::setup('previewsmall'))->save($row['path'] . 'small_' . $fnamescreen);
                    if (Cms::setup('watermark') == 1) {
                        Download::watermark($row['path'] . '' . $fnamescreen, 10);
                        Download::watermark($row['path'] . 'small_' . $fnamescreen, 3);
                    }
                    DB::run("UPDATE `files` SET `screen` = '" . $fnamescreen . "' WHERE `id` = '" . $row['id'] . "'");
                }

                //удаляем скриншот
                if ($_POST['del'] == 1) {
                    Cms::DelFile($row['path'] . "" . $row['screen']);
                    DB::run("UPDATE `files` SET `screen` = '' WHERE `id` = '" . $row['id'] . "'");
                }

                DB::run("UPDATE `files` SET 
                `name` = '" . Cms::Input($_POST['name']) . "', 
                    `translate` = '" . Functions::name_replace(Cms::Input($_POST['name'])) . "', 
                        `text` = '" . Cms::Input($_POST['text']) . "',
                            `loadcounts` = '" . Cms::Input($_POST['loadcounts']) . "',
                                `views` = '" . Cms::Input($_POST['views']) . "',
                                    `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                        `description` = '" . Cms::Input($_POST['description']) . "' WHERE `id`='" . $row['id'] . "'");

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('ЗЦ', 'Редактирование файла ' . Functions::esc($row['name']));
                } //пишем лог админа, если включено

                if ($row['id_file'] > 0) {
                    Functions::redirect('/download/file/' . $row['id_file']);
                } else {
                    Functions::redirect('/download/' . $row['id'] . '-' . $row['translate']);
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error,
            'pat' => Cms::BreadcrumbDownload($row['refid'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/edit.tpl');
    }

    function del($id) {
        $row = DB::run("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            //удаляем скриншот
            Cms::DelFile($row['path'] . "" . $row['screen']);
            //удалем картинки
            if ($row['type'] == 'jpg' || $row['type'] == 'png' || $row['type'] == 'jpeg' || $row['type'] == 'gif') {
                Cms::DelFile($row['path'] . "small_" . $row['file']);
                Cms::DelFile($row['path'] . "view_" . $row['file']);
                Cms::DelFile($row['path'] . "240x320_" . $row['file']);
                Cms::DelFile($row['path'] . "360x640_" . $row['file']);
                Cms::DelFile($row['path'] . "480x800_" . $row['file']);
                Cms::DelFile($row['path'] . "480x854_" . $row['file']);
                Cms::DelFile($row['path'] . "540x960_" . $row['file']);
            }
            //удаляем скрины к видео
            if ($row['type'] == 'mp4' || $row['type'] == 'avi' || $row['type'] == '3gp' || $row['type'] == 'wmv') {
                Cms::DelFile($row['path'] . "small_" . $row['file'] . ".GIF");
                Cms::DelFile($row['path'] . "" . $row['file'] . ".GIF");
            }
            //темам
            if ($row['type'] == 'nth' || $row['type'] == 'thm') {
                Cms::DelFile($row['path'] . "" . $row['file'] . ".GIF");
            }
            //и сам основной файл
            Cms::DelFile($row['path'] . "" . $row['file']);
            DB::run("DELETE FROM `files` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("DELETE FROM `files_comments` WHERE `id_file` = '" . $row['id'] . "'");
            DB::run("OPTIMIZE TABLE `files`");
            DB::run("OPTIMIZE TABLE `files_comments`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('ЗЦ', 'Удаление файла ' . Functions::esc($row['name']));
            } //пишем лог админа, если включено

            if ($row['id_file'] > 0) {
                Functions::redirect('/download/file/' . $row['id_file']);
            } else
                Functions::redirect('/download/' . $row['refid']);
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/download/' . $row['refid']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error,
            'pat' => Cms::BreadcrumbDownload($row['refid'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/del.tpl');
    }

    function file($id) {
        $row = DB::run("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        //обработка загрузки файла
        if ($_POST['upload']) {

            if (mb_strlen(Cms::Input($_POST['names'])) > 250) {
                $error_file .= 'Недопустимая длина названия файла!<br/>';
            }

            if (mb_strlen(Cms::Input($_POST['text'])) > 5000) {
                $error_file .= 'Недопустимая длина описания файла!<br/>';
            }

            $do_filefile = false;
            // Проверка загрузки с обычного браузера
            if ($_FILES['file']['size'] > 0) {
                $do_filefile = true;
                $ifnamefile = strtolower($_FILES['file']['name']);
                $originalfile = $_FILES['file']['name'];
                $typ = pathinfo($ifnamefile, PATHINFO_EXTENSION);
                $rand = rand(11111, 99999); //случайное число	
                //Конечное имя файла для сохранения без расширения
                $fnamefile = Functions::name_replace($ifnamefile);
                //Конечное имя файла для сохранения с расширением
                $ftp = Functions::name_replace(Functions::truncate($ifnamefile, 200)) . '_' . $rand . '_' . strtoupper(str_replace('http://', '', Cms::setup('home'))) . '.' . $typ;
                $fsizefile = $_FILES['file']['size'];
            }

            if ($do_filefile == null) {
                $error_file .= 'Вы не выбрали файл для загрузки!<br/>';
            }

            //скриншот
            $do_filescreen = false;
            // Проверка загрузки с обычного браузера
            if ($_FILES['screen']['size'] > 0) {
                $do_filescreen = true;
                $ifnamescreen = strtolower($_FILES['screen']['name']);
                $rand = rand(111111111111, 999999999999); //случайное число
                $ifname = explode(".", $ifnamescreen);
                $fnamescreen = $rand . '.' . $ifname[1];
            }
            //обработка файла
            if ($do_filescreen) {
                // Список допустимых расширений файлов.
                $al_ext = array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png'
                );
                $ext = explode(".", $fnamescreen);
                // Проверка файла на наличие только одного расширения
                if (count($ext) != 2) {
                    $error_file .= 'Запрещенный формат картинки скриншота!<br/>';
                }
                // Проверка допустимых расширений файлов
                if (!in_array($ext[1], $al_ext)) {
                    $error_file .= 'Не допустимый формат картинки скриншота!<br/>';
                }
            }

            $reg = DB::run("select * from `files` where `file`='" . $ftp . "' AND `path`='" . $row['path'] . "'");
            if ($reg->fetch(PDO::FETCH_NUM) != 0) {
                $error_file .= 'Файл с таким названием уже существует в папке ' . $row['name'] . '!<br/>';
            }

            if (!isset($error_file)) {
                //загружаем файл
                if ((move_uploaded_file($_FILES["file"]["tmp_name"], $row['path'] . "" . $ftp)) == true) {
                    if ($typ == 'png' || $typ == 'jpg' || $typ == 'gif' || $typ == 'jpeg') {
                        //создаем превьюшку к картинке и только к картинке
                        $img = new SimpleImage();
                        $img->load($row['path'] . '' . $ftp)->fit_to_width(Cms::setup('preview'))->save($row['path'] . 'view_' . $ftp);
                        $img->load($row['path'] . '' . $ftp)->fit_to_width(Cms::setup('previewsmall'))->save($row['path'] . 'small_' . $ftp);
                        if (Cms::setup('watermark') == 1) {
                            Download::watermark($row['path'] . 'view_' . $ftp, 10);
                            Download::watermark($row['path'] . 'small_' . $ftp, 3);
                        }
                    }

                    //меняем id3-тег в звуковом файле
                    if ($typ == 'mp3' || $typ == 'wav' || $typ == 'ogg' || $typ == 'amr') {
                        $id3 = new MP3_Id();
                        $id3->read($row['path'] . '' . $ftp);
                        $id3->comment = iconv('utf-8', 'windows-1251', strtoupper(str_replace('http://', '', Cms::setup('home'))));
                        $id3->write();
                    }

                    //вытаскиваем иконку из jar файла
                    if ($typ == 'jar') {
                        $archive2 = new JarInfo($row['path'] . '' . $ftp);
                        $archive2->getIcon($row['path'] . '' . $ftp . '.icon.png');
                    }

                    //создаем скрин для видео-файла
                    if ($typ == 'mp4' || $typ == 'avi' || $typ == '3gp' || $typ == 'wmv') {
                        if (Cms::setup('autoscreen_video') == 1 && class_exists('ffmpeg_movie')) {
                            Download::autoscreen_video($row['path'] . '' . $ftp, $row['path'] . '' . $ftp . '.GIF', 640, 480);
                            Download::autoscreen_video($row['path'] . '' . $ftp, $row['path'] . 'small_' . $ftp . '.GIF', Cms::setup('previewsmall'), Cms::setup('previewsmall2'));
                            if (Cms::setup('watermark') == 1) {
                                Download::watermark($row['path'] . '' . $ftp . '.GIF');
                                Download::watermark($row['path'] . 'small_' . $ftp . '.GIF');
                            }
                        }
                    }

                    //скриншот к темам формата nth
                    if (Cms::setup('autoscreen_nth') == 1) {
                        if ($typ == 'nth') {
                            Download::autoscreen_nth($row['path'] . '' . $ftp, Cms::setup('previewsmall'), Cms::setup('previewsmall2'), $row['path'] . '' . $ftp . '.GIF');
                        }
                    }
                    //скриншот к темам формата thm
                    if (Cms::setup('autoscreen_thm') == 1) {
                        if ($typ == 'thm') {
                            Download::autoscreen_thm($row['path'] . '' . $row['file'], Cms::setup('previewsmall'), Cms::setup('previewsmall2'), $row['path'] . '' . $ftp . '.GIF');
                        }
                    }

                    if ($_POST['number'] == 1) {
                        $originalfile = preg_replace('/\d/', '', $originalfile);
                    }

                    if ($_POST['simvol'] == 1) {
                        $originalfile = preg_replace('/[-`~!#$%^&*()_=+\\\\|\\/\\[\\]{};:"\',<>?]+/', '', $originalfile);
                    }

                    if (!empty($_POST['names'])) {
                        DB::run("INSERT INTO `files` SET 
                                `refid` = '" . $row['refid'] . "', 
                                    `id_file` = '" . $row['id'] . "', 
                                        `name` = '" . Cms::Input($_POST['names']) . "', 
                                            `translate` = '" . Functions::name_replace(Cms::Input($_POST['names'])) . "', 
                                                `text` = '" . Cms::Input($_POST['text']) . "', 
                                                    `time` = '" . Cms::realtime() . "',
                                                        `file` = '" . $ftp . "', 
                                                            `type` = '" . $typ . "', 
                                                                `size` = '" . Functions::size($fsizefile) . "', 
                                                                    `path` = '" . $row['path'] . "', 
                                                                        `infolder` = '" . $row['infolder'] . "',
                                                                            `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                                                                `description` = '" . Cms::Input($_POST['description']) . "'");
                    } else {
                        DB::run("INSERT INTO `files` SET 
                                `refid` = '" . $row['refid'] . "', 
                                    `id_file` = '" . $row['id'] . "',
                                        `name` = '" . substr(Cms::Input($originalfile), 0, -4) . "', 
                                            `translate` = '" . substr(Cms::Input($fnamefile), 0, -3) . "', 
                                                `text` = '" . Cms::Input($_POST['text']) . "', 
                                                    `time` = '" . Cms::realtime() . "',
                                                        `file` = '" . $ftp . "', 
                                                            `type` = '" . $typ . "', 
                                                                `size` = '" . Functions::size($fsizefile) . "', 
                                                                    `path` = '" . $row['path'] . "', 
                                                                        `infolder` = '" . $row['infolder'] . "',
                                                                            `keywords` = '" . Cms::Input($_POST['keywords']) . "',
                                                                                `description` = '" . Cms::Input($_POST['description']) . "'");
                    }
                    $fid = DB::lastInsertId();
                }

                //загружаем и обрабатываем скриншот
                if ((move_uploaded_file($_FILES["screen"]["tmp_name"], $row['path'] . "" . $fnamescreen)) == true) {
                    $img = new SimpleImage();
                    $img->load($row['path'] . '' . $fnamescreen)->fit_to_width(Cms::setup('previewsmall'))->save($row['path'] . 'small_' . $fnamescreen);

                    if (Cms::setup('watermark') == 1) {
                        Download::watermark($row['path'] . '' . $fnamescreen, 10);
                        Download::watermark($row['path'] . 'small_' . $fnamescreen, 3);
                    }

                    DB::run("UPDATE `files` SET `screen` = '" . $fnamescreen . "' WHERE `id` = '" . $fid . "'");
                }

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('ЗЦ', 'Добавление файла ' . Cms::Input($originalfile));
                } //пишем лог админа, если включено
                Functions::redirect('/download/file/' . $row['id']);
            }
        }

        //массовая загрузка файлов
        if ($_POST['mass']) {

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

                if (empty($do_file)) {
                    $error_mass .= 'Вы должны выбрать минимум один файл!<br/>';
                }

                $reg = DB::run("select * from `files` where `file`='" . $ftp . "' AND `path`='" . $row['path'] . "'");
                if ($reg->fetch(PDO::FETCH_NUM) != 0) {
                    $error_file .= 'Файл с таким названием уже существует в папке ' . Functions::esc($row['name']) . '!<br/>';
                }
            }

            if (!isset($error_mass)) {
                for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                    $do_file = false;
                    // Проверка загрузки с обычного браузера
                    if ($_FILES['file']['size'][$i] > 0) {
                        $do_file = true;
                        $ifnamefile = strtolower($_FILES['file']['name'][$i]);
                        $originalfile = $_FILES['file']['name'][$i];
                        $typ = pathinfo($ifnamefile, PATHINFO_EXTENSION);
                        $rand = rand(11111, 99999); //случайное число	
                        //Конечное имя файла для сохранения без расширения
                        $fnamefile = Functions::name_replace($ifnamefile);
                        //Конечное имя файла для сохранения с расширением
                        //$ftp = str_replace($typ, '', $ifnamefile);
                        $ftp = Functions::name_replace(Functions::truncate($ifnamefile, 200)) . '_' . $rand . '_' . strtoupper(str_replace('http://', '', Cms::setup('home'))) . '.' . $typ;
                        $fsizefile = $_FILES['file']['size'][$i];
                    }
                    //загружаем файл
                    if ((move_uploaded_file($_FILES["file"]["tmp_name"][$i], $row['path'] . "" . $ftp)) == true) {
                        if ($typ == 'png' || $typ == 'jpg' || $typ == 'gif' || $typ == 'jpeg') {
                            //создаем превьюшку к картинке и только к картинке
                            $img = new SimpleImage();
                            $img->load($row['path'] . '' . $ftp)->fit_to_width(Cms::setup('preview'))->save($row['path'] . 'view_' . $ftp);
                            $img->load($row['path'] . '' . $ftp)->fit_to_width(Cms::setup('previewsmall'))->save($row['path'] . 'small_' . $ftp);
                            if (Cms::setup('watermark') == 1) {
                                Download::watermark($row['path'] . 'view_' . $ftp, 10);
                                Download::watermark($row['path'] . 'small_' . $ftp, 3);
                            }
                        }

                        //меняем id3-тег в звуковом файле
                        if ($typ == 'mp3' || $typ == 'wav' || $typ == 'ogg' || $typ == 'amr') {
                            $id3 = new MP3_Id();
                            $id3->read($row['path'] . '' . $ftp);
                            $id3->comment = iconv('utf-8', 'windows-1251', strtoupper(str_replace('http://', '', Cms::setup('home'))));
                            $id3->write();
                        }

                        //вытаскиваем иконку из jar файла
                        if ($typ == 'jar') {
                            $archive2 = new JarInfo($row['path'] . '' . $ftp);
                            $archive2->getIcon($row['path'] . '' . $ftp . '.icon.png');
                        }

                        //создаем скрин для видео-файла
                        if ($typ == 'mp4' || $typ == 'avi' || $typ == '3gp' || $typ == 'wmv') {
                            if (Cms::setup('autoscreen_video') == 1 && class_exists('ffmpeg_movie')) {
                                Download::autoscreen_video($row['path'] . '' . $ftp, $row['path'] . '' . $ftp . '.GIF', 640, 480);
                                Download::autoscreen_video($row['path'] . '' . $ftp, $row['path'] . 'small_' . $ftp . '.GIF', Cms::setup('previewsmall'), Cms::setup('previewsmall2'));
                                if (Cms::setup('watermark') == 1) {
                                    Download::watermark($row['path'] . '' . $ftp . '.GIF');
                                    Download::watermark($row['path'] . 'small_' . $ftp . '.GIF');
                                }
                            }
                        }

                        //скриншот к темам формата nth
                        if (Cms::setup('autoscreen_nth') == 1) {
                            if ($typ == 'nth') {
                                Download::autoscreen_nth($row['path'] . '' . $ftp, Cms::setup('previewsmall'), Cms::setup('previewsmall2'), $row['path'] . '' . $ftp . '.GIF');
                            }
                        }
                        //скриншот к темам формата thm
                        if (Cms::setup('autoscreen_thm') == 1) {
                            if ($typ == 'thm') {
                                Download::autoscreen_thm($row['path'] . '' . $row['file'], Cms::setup('previewsmall'), Cms::setup('previewsmall2'), $row['path'] . '' . $ftp . '.GIF');
                            }
                        }

                        if ($_POST['number'] == 1) {
                            $originalfile = preg_replace('/\d/', '', $originalfile);
                        }
                        if ($_POST['simvol'] == 1) {
                            $originalfile = preg_replace('/[-`~!#$%^&*()_=+\\\\|\\/\\[\\]{};:"\',<>?]+/', '', $originalfile);
                        }
                        DB::run("INSERT INTO `files` SET 
                                `refid` = '" . $row['refid'] . "', 
                                    `id_file` = '" . $row['id'] . "', 
                                        `name` = '" . substr(Cms::Input($originalfile), 0, -4) . "', 
                                            `translate` = '" . substr(Cms::Input($fnamefile), 0, -3) . "', 
                                                `text` = '" . Cms::Input($_POST['text']) . "', 
                                                    `time` = '" . Cms::realtime() . "',
                                                        `file` = '" . $ftp . "', 
                                                            `type` = '" . $typ . "', 
                                                                `size` = '" . Functions::size($fsizefile) . "', 
                                                                    `path` = '" . $row['path'] . "', 
                                                                        `infolder` = '" . $row['infolder'] . "'");
                    }

                    if (Cms::setup('adminlogs') == 1) {
                        Cms::adminlogs('ЗЦ', 'Добавление файла ' . Cms::Input($originalfile));
                    } //пишем лог админа, если включено
                }
                Functions::redirect('/download/file/' . $row['id']);
            }
        }

        //доп файлы
        $count = DB::run("SELECT COUNT(*) FROM `files` WHERE `id_file`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `files`.*, (SELECT COUNT(1) FROM `files_comments` WHERE `files_comments`.`id_file`=`files`.`id`) AS `comments` FROM `files` WHERE `id_file`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error_file' => $error_file,
            'error_mass' => $error_mass,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pat' => Cms::BreadcrumbDownload($row['refid']),
            'pagenav' => Functions::pagination(Cms::setup('home') . '/download/file/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/file.tpl');
    }

    function view($id) {
        $row = DB::run("SELECT `files`.*, " . User::data('files') . ", (SELECT COUNT(*) FROM `files_comments` WHERE `id_file`='" . $id . "') AS `count` FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        $onefile = DB::run("SELECT * FROM `files` WHERE `id`='" . $row['id_file'] . "'")->fetch(PDO::FETCH_ASSOC);

        DB::run("UPDATE `files` SET `views` = '" . Cms::Int($row['views'] + 1) . "' WHERE `id` = '" . $row['id'] . "'");

        if ($row['type'] == 'jpg' || $row['type'] == 'jpeg' || $row['type'] == 'png' || $row['type'] == 'gif') {
            SmartySingleton::instance()->assign('Img', getimagesize(str_replace('../', './', $row['path'] . '' . $row['file'])));
        }
        //вытаскиваем инфу из видео-файла, на хостинге должен быть установлен ffmpeg
        if ($row['type'] == 'mp4' || $row['type'] == 'avi' || $row['type'] == '3gp' || $row['type'] == 'wmv') {
            if (class_exists('ffmpeg_movie')) {
                $media = new ffmpeg_movie(str_replace('../', './', $row['path'] . '' . $row['file']));
                SmartySingleton::instance()->assign('ffmpeg', class_exists('ffmpeg_movie'));
                SmartySingleton::instance()->assign('GetFrameWidth', $media->GetFrameWidth());
                SmartySingleton::instance()->assign('GetFrameHeight', $media->GetFrameHeight());
                SmartySingleton::instance()->assign('getFrameRate', $media->getFrameRate());
                SmartySingleton::instance()->assign('getVideoCodec', $media->getVideoCodec());
                SmartySingleton::instance()->assign('getBitRate', ceil(($media->getBitRate()) / 1024));
                if (Cms::Int($media->getDuration()) > 3599) {
                    $time = Cms::Int($media->getDuration() / 3600) . ":" . date('s', fmod($media->getDuration() / 60, 60)) . ":" . date('s', fmod($media->getDuration(), 3600));
                } elseif (Cms::Int($media->getDuration()) > 59) {
                    $time = Cms::Int($media->getDuration() / 60) . ":" . date('s', fmod($media->getDuration(), 60));
                } else {
                    $time = Cms::Int($media->getDuration()) . " сек.";
                }
                SmartySingleton::instance()->assign('time', $time);
            }
        }

        //для аудио-файлов
        if ($row['type'] == 'mp3' || $row['type'] == 'wav' || $row['type'] == 'amr' || $row['type'] == 'ogg') {
            // Создаем объект, читаем файл  
            $id3 = new MP3_Id();
            $result = $id3->read($row['path'] . '' . $row['file']);
            if (PEAR::isError($result) && $result->getCode() !== PEAR_MP3_ID_TNF) {
                die($result->getMessage() . "\n");
            }
            SmartySingleton::instance()->assign('bitrate', $id3->getTag('bitrate'));
            SmartySingleton::instance()->assign('length', $id3->getTag('length'));
            SmartySingleton::instance()->assign('artists', Functions::clearstr($id3->getTag('artists')));
            SmartySingleton::instance()->assign('album', $id3->getTag('album'));
            SmartySingleton::instance()->assign('year', $id3->getTag('year'));
            SmartySingleton::instance()->assign('comment', $id3->getTag('comment'));
            SmartySingleton::instance()->assign('genre', $id3->getTag('genre'));
        }

        //для jar файлов
        if ($row['type'] == 'jar') {
            $archive2 = new JarInfo(str_replace('../', './', $row['path'] . '' . $row['file']));
            if ($archive2->getVersion()) {
                SmartySingleton::instance()->assign('versionjar', $archive2->getVersion());
            }
            if ($archive2->getName()) {
                SmartySingleton::instance()->assign('namejar', $archive2->getName());
            }
            if ($archive2->getVendor()) {
                SmartySingleton::instance()->assign('vendorjar', $archive2->getVendor());
            }
            if ($archive2->getProfile()) {
                SmartySingleton::instance()->assign('profilejar', $archive2->getProfile());
            }
        }

        //доп файлы
        $count = DB::run("SELECT COUNT(*) FROM `files` WHERE `id_file`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `files`.*, (SELECT COUNT(1) FROM `files_comments` WHERE `files_comments`.`id_file`=`files`.`id`) AS `comments` FROM `files` WHERE `id_file`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($rows = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $rows;
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => Cms::bbcode($row['text']),
            'onefile' => $onefile,
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pat' => Cms::BreadcrumbDownload($row['refid']),
            'pagenav' => Functions::pagination(Cms::setup('home') . '/download/' . $row['id'] . '-' . $row['translate'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/view.tpl');
    }

    function comments($id) {
        $row = DB::run("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        Cms::comments('files_comments', 'id_file', $row['id'], $this->user['id'], 'captcha_comments_file', 'download/comments/' . $row['id']);

        $count = DB::run("SELECT COUNT(*) FROM `files_comments` WHERE `id_file`='" . $row['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `files_comments`.*, " . User::data('files_comments') . " FROM `files_comments` WHERE `id_file`='" . $row['id'] . "' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
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
            'pat' => Cms::BreadcrumbDownload($row['refid']),
            'pagenav' => Functions::pagination(Cms::setup('home') . '/download/comments/' . $row['id'] . '?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/comments.tpl');
    }

    function edit_comments($id) {
        $row = DB::run("SELECT `files_comments`.*, (SELECT `refid` FROM `files` WHERE `files`.`id`=`files_comments`.`id_file`) AS `refid`,
            (SELECT `name` FROM `files` WHERE `files`.`id`=`files_comments`.`id_file`) AS `name`,
            (SELECT `translate` FROM `files` WHERE `files`.`id`=`files_comments`.`id_file`) AS `translate` FROM `files_comments` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {

            if (mb_strlen(Cms::Input($_POST['text'])) < 2 || mb_strlen(Cms::Input($_POST['text'])) > 5000) {
                $error .= 'Недопустимая длина текста комментария!';
            }

            if (!isset($error)) {
                DB::run("UPDATE `files_comments` SET `text`='" . Cms::Input($_POST['text']) . "' WHERE `id`='" . $row['id'] . "'");
                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('ЗЦ', 'Редактирование комментария к файлу ' . Functions::esc($row['name']));
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('home') . '/download/comments/' . $row['id_file']);
            }
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'error' => $error,
            'pat' => Cms::BreadcrumbDownload($row['refid'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/edit_comments.tpl');
    }

    function del_comments($id) {
        $row = DB::run("SELECT `files_comments`.*, (SELECT `refid` FROM `files` WHERE `files`.`id`=`files_comments`.`id_file`) AS `refid`,
                        (SELECT `name` FROM `files` WHERE `files`.`id`=`files_comments`.`id_file`) AS `name`,
                        (SELECT `translate` FROM `files` WHERE `files`.`id`=`files_comments`.`id_file`) AS `translate` FROM `files_comments` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);

        if ($_POST['ok']) {
            DB::run("DELETE FROM `files_comments` WHERE `id` = '" . $row['id'] . "' LIMIT 1");
            DB::run("OPTIMIZE TABLE `files_comments`");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('ЗЦ', 'Удалил комментарий к файлу ' . Functions::esc($row['name']));
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('home') . '/download/comments/' . $row['id_file']);
        }

        if ($_POST['close']) {
            Functions::redirect(Cms::setup('home') . '/download/comments/' . $row['id_file']);
        }

        SmartySingleton::instance()->assign(array(
            'row' => $row,
            'text' => Cms::bbcode($row['text']),
            'pat' => Cms::BreadcrumbDownload($row['refid'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/del_comments.tpl');
    }

    function load($id) {
        $row = DB::run("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        DB::run("UPDATE `files` SET `loadcounts` = '" . Cms::Int($row['loadcounts'] + 1) . "', `timeload` = '" . Cms::realtime() . "' WHERE `id` = '" . $row['id'] . "'");
        if (isset($_POST['ok'])) {
            if ($row['type'] == 'jpg' || $row['type'] == 'jpeg' || $row['type'] == 'png' || $row['type'] == 'gif') {
                $pic = Cms::Input($_POST['pic']);
                $pics = explode('x', $pic);
                $newfile = $pic . '_' . $row['file'];

                $img = new SimpleImage();
                if ($_POST['pr'] == 1) {
                    $img->load($row['path'] . '' . $row['file'])->fit_to_width($pics[0])->save($row['path'] . '' . $newfile);
                } else {
                    $img->load($row['path'] . '' . $row['file'])->resize($pics[0], $pics[1])->save($row['path'] . '' . $newfile);
                }
                Download::load($row['path'] . $newfile);
            }
        } else {
            Download::load($row['path'] . $row['file']);
        }
    }

    function newfile() {
        $count_files = DB::run("SELECT COUNT(*) FROM `files` WHERE `size` > '0' AND `time` > '" . intval(Cms::realtime() - Cms::setup('newfile')) . "' AND `id_file`='0' AND `user`='0'")->fetchColumn();
        if ($count_files > 0) {
            $req_files = DB::run("SELECT `files`.*, (SELECT COUNT(1) FROM `files_comments` WHERE `files_comments`.`id_file`=`files`.`id`) AS `comments` FROM `files` WHERE `size` > '0' AND `time` > '" . intval(Cms::realtime() - Cms::setup('newfile')) . "' AND `id_file`='0' AND `user`='0' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row_files = $req_files->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow_files[] = $row_files;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count_files' => $count_files,
            'arrayrow_files' => $arrayrow_files,
            'moderation' => DB::run("SELECT COUNT(*) FROM `files` WHERE `user`='1'")->fetchColumn(),
            'pagenav' => Functions::pagination(Cms::setup('home') . '/download/new?', $this->page, $count_files, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/new.tpl');
    }

    function top() {
        $count_files = DB::run("SELECT COUNT(*) FROM `files` WHERE `id_file`='0' AND `user`='0'")->fetchColumn();
        if ($count_files > 0) {
            $req_files = DB::run("SELECT `files`.*, (SELECT COUNT(1) FROM `files_comments` WHERE `files_comments`.`id_file`=`files`.`id`) AS `comments` FROM `files` WHERE `id_file`='0' AND `user`='0' ORDER BY `views` DESC, `loadcounts` DESC LIMIT " . $this->page . ", 100");
            while ($row_files = $req_files->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow_files[] = $row_files;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count_files' => $count_files,
            'arrayrow_files' => $arrayrow_files,
            'moderation' => DB::run("SELECT COUNT(*) FROM `files` WHERE `user`='1'")->fetchColumn(),
            'pagenav' => Functions::pagination(Cms::setup('home') . '/download/top?', $this->page, $count_files, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/top.tpl');
    }

    function search($search) {
        $search = $search ? $search : Cms::Input($_POST['search']);

        if (empty($search) && isset($_POST['ok'])) {
            $error = 'Задан пустой поисковый запрос!';
        }

        if (isset($_POST['ok'])) {
            Functions::redirect('/download/search/' . Functions::replace($search));
        }

        if ($search) {
            $search = mb_strtolower(urldecode($search), 'UTF-8');

            if ($search && mb_strlen($search) < 3) {
                $error = 'Общая длина поискового запроса должна быть не менее 3 букв.';
            }

            if (!isset($error)) {
                $count_files = DB::run("SELECT COUNT(*) FROM `files` WHERE `id_file`='0' AND `user`='0' AND MATCH (name) AGAINST ('*" . $search . "*' IN BOOLEAN MODE)")->fetchColumn();
                if ($count_files > 0) {
                    $req_files = DB::run("SELECT `files`.*, (SELECT COUNT(1) FROM `files_comments` WHERE `files_comments`.`id_file`=`files`.`id`) AS `comments` FROM `files` WHERE `id_file`='0' AND `user`='0' AND MATCH (name) AGAINST ('*" . $search . "*' IN BOOLEAN MODE) ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
                    while ($row_files = $req_files->fetch(PDO::FETCH_ASSOC)) {
                        $arrayrow_files[] = $row_files;
                    }
                }
            }
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'search' => $search,
            'count_files' => $count_files,
            'arrayrow_files' => $arrayrow_files,
            'moderation' => DB::run("SELECT COUNT(*) FROM `files` WHERE `user`='1'")->fetchColumn(),
            'pagenav' => Functions::pagination(Cms::setup('home') . '/download/search/' . $search . '?', $this->page, $count_files, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/search.tpl');
    }

    function moderation() {

        $count_files = DB::run("SELECT COUNT(*) FROM `files` WHERE `user`='1'")->fetchColumn();
        if ($count_files > 0) {
            $req_files = DB::run("SELECT `files`.*, (SELECT COUNT(1) FROM `files_comments` WHERE `files_comments`.`id_file`=`files`.`id`) AS `comments` FROM `files` WHERE `user`='1' ORDER BY `id` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row_files = $req_files->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow_files[] = $row_files;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count_files' => $count_files,
            'arrayrow_files' => $arrayrow_files,
            'pagenav' => Functions::pagination(Cms::setup('home') . '/download/moderation?', $this->page, $count_files, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/download/moderation.tpl');
    }

    function moderation_yes($id) {
        $row = DB::query("SELECT * FROM `files` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        DB::run("UPDATE `files` SET `user` = '0' WHERE `id` = '" . $row['id'] . "'");
        if (Cms::setup('adminlogs') == 1) {
            Cms::adminlogs('ЗЦ', 'Промодерировал файл ' . Functions::esc($row['name']));
        } //пишем лог админа, если включено
        Functions::redirect(Recipe::getReferer());
    }

    function down($refid, $id) {
        $req = DB::run("SELECT * FROM `category` WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "' LIMIT 1");
        if ($req) {
            $res1 = $req->fetch(PDO::FETCH_ASSOC);
            $sort = $res1['realid'];
            $req = DB::run("SELECT * FROM `category` WHERE `realid` > '" . abs(intval($sort)) . "' ORDER BY `realid` ASC LIMIT 1");
            if ($req) {
                $res = $req->fetch(PDO::FETCH_ASSOC);
                $id2 = $res['id'];
                $sort2 = $res['realid'];
                DB::run("UPDATE `category` SET `realid` = '" . abs(intval($sort2)) . "' WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
                DB::run("UPDATE `category` SET `realid` = '" . abs(intval($sort)) . "' WHERE `id` = '" . abs(intval($id2)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
            }
        }
        Functions::redirect(Recipe::getReferer());
    }

    function up($refid, $id) {
        $req = DB::run("SELECT * FROM `category` WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "' LIMIT 1");
        if ($req) {
            $res1 = $req->fetch(PDO::FETCH_ASSOC);
            $sort = $res1['realid'];
            $req = DB::run("SELECT * FROM `category` WHERE `realid` < '" . abs(intval($sort)) . "' ORDER BY `realid` DESC LIMIT 1");
            if ($req) {
                $res = $req->fetch(PDO::FETCH_ASSOC);
                $id2 = $res['id'];
                $sort2 = $res['realid'];
                DB::run("UPDATE `category` SET `realid` = '" . abs(intval($sort2)) . "' WHERE `id` = '" . abs(intval($id)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
                DB::run("UPDATE `category` SET `realid` = '" . abs(intval($sort)) . "' WHERE `id` = '" . abs(intval($id2)) . "' AND `refid` = '" . abs(intval($refid)) . "'");
            }
        }
        Functions::redirect(Recipe::getReferer());
    }

}
