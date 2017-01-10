<?php

class AdminTemplatesModel {

    function index() {

        if ($_POST['ok']) {

            $do_file = false;
            // Проверка загрузки с обычного браузера
            if ($_FILES['file']['size'] > 0) {
                $do_file = true;
                $ifname = strtolower($_FILES['file']['name']);
                //Определяем тип файла
                $type = pathinfo($ifname, PATHINFO_EXTENSION);
                //Конечное имя файла для сохранения с расширением
                $fname = Functions::name_replace(Functions::truncate($ifname, 500)) . '.' . $type;
            }
            //обработка файла
            if ($do_file) {
                // Список допустимых расширений файлов.
                $al_ext = array(
                    'zip'
                );
                $ext = explode(".", $fname);
                // Проверка файла на наличие только одного расширения
                if (count($ext) != 2) {
                    $error .= 'Запрещенный формат файла!<br/>';
                }
                // Проверка допустимых расширений файлов
                if (!in_array($ext[1], $al_ext)) {
                    $error .= 'Не допустимый формат файла!<br/>';
                }
            }

            if (!isset($error)) {
                //если нет ошибок - пишем в базу  
                if ((move_uploaded_file($_FILES['file']['tmp_name'], HOME . '/style/' . $fname)) == true) {

                    $archive = new PclZip(HOME . '/style/' . $fname);
                    $v_list = $archive->extract(PCLZIP_OPT_PATH, HOME . '/style/');
                    if ($v_list == 0) {
                        $error .= $archive->errorInfo(true);
                    }
                    unlink(HOME . '/style/' . $fname);
                }

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Редактор шаблонов', 'Загружен шаблон ' . $fname);
                } //пишем лог админа, если включено
                Functions::redirect(Cms::setup('adminpanel') . '/templates');
            }
        }

        $dir = opendir(HOME . '/style/');
        while ($skin = readdir($dir)) {
            if (($skin != '.') && ($skin != '..') && ($skin != '.svn') && ($skin != 'admin')) {
                $arrayrowskin[] = $skin;
            }
        }
        closedir($dir);

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'arrayrowskin' => $arrayrowskin
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/templates/index.tpl');
    }

    function del($temp) {
        if ($_POST['ok']) {
            Cms::DelDir(HOME . '/style/' . $temp);
            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Редактор шаблонов', 'Удален шаблон ' . $temp);
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('adminpanel') . '/templates');
        }

        if ($_POST['close']) {
            redirect(Cms::setup('adminpanel') . '/templates');
        }

        SmartySingleton::instance()->assign(array(
            'temp' => $temp
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/templates/del.tpl');
    }

    function view($temp) {

        //стили сайта    
        if ($handle = opendir(HOME . '/style/' . $temp . '/css')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if (substr($file, strlen($file) - 4) == ".css") {
                        $arrayrowcss[] = $file;
                    }
                }
            }
            closedir($handle);
        }

        SmartySingleton::instance()->assign(array(
            'dirview' => $temp,
            'arrayrowcss' => $arrayrowcss
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/templates/view.tpl');
    }

    function edit($temp) {
        $f = $_REQUEST['template'];

        if (file_get_contents(Cms::Input(HOME . '/style/' . $f))) {
            if (isset($_POST['ok'])) {
                chmod(HOME . '/style/' . $f, 0666);
                $fps = fopen(HOME . '/style/' . $f, 'w+'); // Открываем файл в режиме записи 
                $fp = gzwrite($fps, $_POST['text']); // Запись в файл
                fclose($fp); //Закрытие файла
                chmod(HOME . '/style/' . $f, 0644);

                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Редактор шаблонов', 'Отредактирован шаблон ' . $f);
                } //пишем лог админа, если включено

                Functions::redirect(Cms::setup('adminpanel') . '/templates/edit?template=' . $f);
            }
        } else {
            $error = 'Шаблона не обнаружено!';
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'skin' => explode('/', $f),
            'css_style' => count(explode('css', $f)),
            'dirview' => $f,
            'dir' => explode('/', Cms::Input($_SERVER['REQUEST_URI'])),
            'template' => file_get_contents(HOME . '/style/' . $f),
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/templates/edit.tpl');
    }

    function email($temp) {

        if ($temp) {

            $f = explode('edit', Cms::Input($_SERVER['REQUEST_URI']));

            if (isset($_POST['ok'])) {
                chmod(HOME . '/style/' . $f[1], 0666);
                $fps = fopen(HOME . '/style/' . $f[1], 'w+'); // Открываем файл в режиме записи 
                $fp = gzwrite($fps, $_POST['text']); // Запись в файл
                fclose($fp); //Закрытие файла
                chmod(HOME . '/style/' . $f[1], 0644);
                if (Cms::setup('adminlogs') == 1) {
                    Cms::adminlogs('Редактор шаблонов', 'Отредактирован шаблон письма ' . $f[1]);
                } //пишем лог админа, если включено
                Functions::redirect($_SERVER['REQUEST_URI']);
            }

            SmartySingleton::instance()->assign(array(
                'template' => file_get_contents(HOME . '/style/' . $f[1]),
                'email' => $f[1]
            ));
            SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/templates/email_edit.tpl');
        } else {
            if ($handle = opendir(HOME . '/style/' . Cms::setup('skin') . '/templates/mail')) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != "..") {
                        if (substr($file, strlen($file) - 4) == ".tpl") {
                            $arrayrowtemplate[] = $file;
                        }
                    }
                }
                closedir($handle);
            }

            SmartySingleton::instance()->assign(array(
                'arrayrowtemplate' => $arrayrowtemplate
            ));
            SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/templates/email.tpl');
        }
    }

}
