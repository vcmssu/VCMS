<?php

class AdminSitemapModel {

    function index() {

        $dir = opendir('./sitemap');
        while ($row = readdir($dir)) {
            if (($row != '.') && ($row != '..') && ($row != '.svn') && ($row != 'index.xml')) {
                $arrayrow[] = $row;
            }
        }
        closedir($dir);

        SmartySingleton::instance()->assign(array(
            'arrayrow' => $arrayrow
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/sitemap/index.tpl');
    }

    function generate() {

        // Поможет при длительном выполнении скрипта
        set_time_limit(0);
        // create sitemap
        $sitemap = new Sitemap('sitemap/sitemap.xml');

        $scheme = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';

        $scheme = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';

        $host = str_replace($scheme, '', Cms::setup('home')); // Хост сайта

        $urls = array(); // Здесь будут храниться собранные ссылки
        $content = NULL; // Рабочая переменная
        // Здесь ссылки, которые не должны попасть в sitemap.xml
        $nofollow = array(
            '/search/',
            '/404/',
            '/go/'
        );
        // Первой ссылкой будет главная страница сайта, ставим ей 0, т.к. она ещё не проверена
        $urls[$scheme . $host] = '0';
        // Разрешённые расширения файлов, чтобы не вносить в карту сайта ссылки на медиа файлы. Также разрешены страницы без разрешения, у меня таких страниц подавляющее большинство.
        $extensions[] = 'php';
        $extensions[] = 'aspx';
        $extensions[] = 'htm';
        $extensions[] = 'html';
        $extensions[] = 'asp';
        $extensions[] = 'cgi';
        $extensions[] = 'pl';
        // Корневая директория сайта, значение можно взять из $_SERVER['DOCUMENT_ROOT'].'/';
        $engine_root = 'sitemap/';

        // Функция для сбора ссылок
        function sitemap_geturls($page, $host, $scheme, $nofollow, $extensions, $urls) {
            //Возможно уже проверяли эту страницу
            if ($urls[$page] == 1) {
                continue;
            }
            //Получаем содержимое ссылки. если недоступна, то заканчиваем работу функции и удаляем эту страницу из списка
            $content = file_get_contents($page);
            if (!$content) {
                unset($urls[$page]);
                return false;
            }
            //Отмечаем ссылку как проверенную (мы на ней побывали)
            $urls[$page] = 0;
            //Проверяем не стоит ли запрещающий индексировать ссылки на этой странице мета-тег с nofollow|noindex|none
            if (preg_match('/<[Mm][Ee][Tt][Aa].*[Nn][Aa][Mm][Ee]=.?("|\'|).*[Rr][Oo][Bb][Oo][Tt][Ss].*?("|\'|).*?[Cc][Oo][Nn][Tt][Ee][Nn][Tt]=.*?("|\'|).*([Nn][Oo][Ff][Oo][Ll][Ll][Oo][Ww]|[Nn][Oo][Ii][Nn][Dd][Ee][Xx]|[Nn][Oo][Nn][Ee]).*?("|\'|).*>/', $content)) {
                $content = NULL;
            }
            //Собираем все ссылки со страницы во временный массив, с помощью регулярного выражения.
            preg_match_all("/<[Aa][\s]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/", $content, $tmp);
            $content = NULL;
            //Добавляем в массив links все ссылки не имеющие аттрибут nofollow
            foreach ($tmp[0] as $k => $v) {
                if (!preg_match('/<.*[Rr][Ee][Ll]=.?("|\'|).*[Nn][Oo][Ff][Oo][Ll][Ll][Oo][Ww].*?("|\'|).*/', $v)) {
                    $links[$k] = $tmp[1][$k];
                }
            }
            unset($tmp);
            //Обрабатываем полученные ссылки, отбрасываем "плохие", а потом и с них собираем...
            for ($i = 0; $i < count($links); $i++) {
                //Если не установлена схема и хост ссылки, то подставляем наш хост
                if (!strstr($links[$i], $scheme . $host)) {
                    if (isset($urlinfo['host']) AND $urlinfo['host'] . '/' != $host)
                        $links[$i] = $links[$i];
                    else
                        $links[$i] = $scheme . $host . $links[$i];
                }
                //Убираем якори у ссылок
                $links[$i] = preg_replace("/#.*/X", "", $links[$i]);
                //Узнаём информацию о ссылке
                $urlinfo = @parse_url($links[$i]);
                if (!isset($urlinfo['path'])) {
                    $urlinfo['path'] = NULL;
                }
                //Если хост совсем не наш, ссылка на главную, на почту или мы её уже обрабатывали - то заканчиваем работу с этой ссылкой
                if ((isset($urlinfo['host']) AND $urlinfo['host'] != $host) OR $urlinfo['path'] == '/' OR isset($urls[$links[$i]]) OR strstr($links[$i], '@')) {
                    continue;
                }
                //Если ссылка в нашем запрещающем списке, то также прекращаем с ней работать
                $nofoll = 0;
                if ($nofollow != NULL) {
                    foreach ($nofollow as $of) {
                        if (strstr($links[$i], $of)) {
                            $nofoll = 1;
                            break;
                        }
                    }
                }
                if ($nofoll == 1) {
                    continue;
                }
                //Если задано расширение ссылки и оно не разрешёно, то ссылка не проходит
                $ext = end(explode('.', $urlinfo['path']));
                $noext = 0;
                if ($ext != '' AND strstr($urlinfo['path'], '.') AND count($extensions) != 0) {
                    $noext = 1;
                    foreach ($extensions as $of) {
                        if ($ext == $of) {
                            $noext = 0;
                            continue;
                        }
                    }
                }
                if ($noext == 1) {
                    continue;
                }
                //Заносим ссылку в массив и отмечаем непроверенной (с неё мы ещё не забирали другие ссылки)
                $urls[$links[$i]] = 0;
                //Проверяем ссылки с этой страницы
                sitemap_geturls($links[$i], $host, $scheme, $nofollow, $extensions, $urls);
            }
            return true;
        }

        // (START!) Первоначальный старт функции для проверки главной страницы и последующих
        sitemap_geturls($scheme . $host, $host, $scheme, $nofollow, $extensions, $urls);

        $sitemapTXT = NULL;

        // Добавляем каждую ссылку
        foreach ($urls as $k => $v) {
            $sitemapXML .= "\r\n<url><loc>{$k}</loc><changefreq>" . Cms::setup('sitemap_changefreq') . "</changefreq><priority>" . Cms::setup('sitemap_priority') . "</priority></url>";
            $sitemapTXT .= "\r\n" . $k;
            $sitemap->addItem($k, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        $sitemap->write();
        if (Cms::setup('sitemap_index') == 1) {
            $sitemapFileUrls = $sitemap->getSitemapUrls(Cms::setup('home') . '/sitemap/');
            $index = new Index('sitemap/sitemap_index.xml');
            foreach ($sitemapFileUrls as $sitemapUrl) {
                $index->addSitemap($sitemapUrl);
            }
            $index->write();
        }

        $sitemapTXT = trim(strtr($sitemapTXT, array(
            '%2F' => '/',
            '%3A' => ':',
            '%3F' => '?',
            '%3D' => '=',
            '%26' => '&',
            '%27' => "'",
            '%22' => '"',
            '%3E' => '>',
            '%3C' => '<',
            '%23' => '#',
            '&' => '&'
        )));


        //Запись в файл
        if (Cms::setup('sitemap_txt') == 1) {
            $fp = fopen($engine_root . 'sitemap.txt', 'w+');
            if (!fwrite($fp, $sitemapTXT)) {
                echo 'Ошибка записи!';
            }
            fclose($fp);
        }

        if (Cms::setup('adminlogs') == 1)
            Cms::adminlogs('Карта сайта', 'Сгенерирована карта сайта'); //пишем лог админа, если включено

        Functions::redirect(Cms::setup('adminpanel') . '/sitemap');
    }

    function del($temp) {

        unlink('sitemap/' . $temp);

        if (Cms::setup('adminlogs') == 1)
            Cms::adminlogs('Карта сайта', 'Удалён файл ' . $temp); //пишем лог админа, если включено

        Functions::redirect(Cms::setup('adminpanel') . '/sitemap');
    }

    function edit($temp) {

        $f = explode('edit', $_SERVER['REQUEST_URI']);

        if (file_get_contents(HOME . '/sitemap/' . $f[1])) {
            if (isset($_POST['ok'])) {
                chmod(HOME . '/sitemap/' . $f[1], 0666);
                $fps = fopen(HOME . '/sitemap/' . $f[1], 'w+'); // Открываем файл в режиме записи 
                $fp = gzwrite($fps, $_POST['text']); // Запись в файл
                fclose($fp); //Закрытие файла
                chmod(HOME . '/sitemap/' . $f[1], 0644);

                if (Cms::setup('adminlogs') == 1)
                    Cms::adminlogs('Редактор', 'Отредактирован файл ' . $f[1]); //пишем лог админа, если включено

                Functions::redirect(Cms::setup('adminpanel') . '/sitemap/edit' . $f[1]);
            }
        } else {
            $error = 'Файла не обнаружено!';
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'file' => $temp,
            'template' => file_get_contents(HOME . '/sitemap/' . $f[1]),
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/sitemap/edit.tpl');
    }

    function robots() {

        if (file_get_contents(HOME . '/robots.txt')) {
            if (isset($_POST['ok'])) {
                chmod(HOME . '/robots.txt', 0666);
                $fps = fopen(HOME . '/robots.txt', 'w+'); // Открываем файл в режиме записи 
                $fp = gzwrite($fps, $_POST['text']); // Запись в файл
                fclose($fp); //Закрытие файла
                chmod(HOME . '/robots.txt', 0644);

                if (Cms::setup('adminlogs') == 1)
                    Cms::adminlogs('Редактор', 'Отредактирован файл robots.txt'); //пишем лог админа, если включено

                Functions::redirect(Cms::setup('adminpanel') . '/sitemap/robots');
            }
        } else {
            $error = 'Файла не обнаружено!';
        }

        SmartySingleton::instance()->assign(array(
            'error' => $error,
            'template' => file_get_contents(HOME . '/robots.txt'),
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/sitemap/robots.tpl');
    }

    function setup() {

        if (isset($_POST['submit'])) {
            if (isset($_POST['address'])) {
                $xml = simplexml_load_file('http://maps.google.com/maps/api/geocode/xml?address=' . $_POST['address'] . '&sensor=false');
                $coordinaty[1] = $xml->result->geometry->location->lat;
                $coordinaty[0] = $xml->result->geometry->location->lng;
            }

            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['sitemap_changefreq']) . "' WHERE `name`='sitemap_changefreq'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['sitemap_priority']) . "' WHERE `name`='sitemap_priority'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['sitemap_index']) . "' WHERE `name`='sitemap_index'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['sitemap_txt']) . "' WHERE `name`='sitemap_txt'");

            if (Cms::setup('adminlogs') == 1)
                Cms::adminlogs('Карта сайта', 'Отредактированы настройки генерации карты сайта'); //пишем лог админа, если включено
            Functions::redirect(Cms::setup('adminpanel') . '/sitemap/setup');
            exit;
        }

        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/sitemap/setup.tpl');
    }

}
