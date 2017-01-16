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

        $sitemap = new Sitemap('sitemap/sitemap.xml');

        //новости
        $req = DB::run("SELECT * FROM `news` WHERE `status`='1' ORDER BY `id` DESC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/news/' . $row['id'] . '-' . $row['translate'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //категории ЗЦ
        $req = DB::run("SELECT * FROM `category` ORDER BY `realid` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/download/' . $row['id'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //файлы
        $req = DB::run("SELECT * FROM `files` WHERE `user`='0' ORDER BY `id` DESC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/download/' . $row['id'] . '-' . $row['translate'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //категории форума
        $req = DB::run("SELECT * FROM `forum` WHERE `refid`='0' AND `type`='0' ORDER BY `realid` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/forum/' . $row['id'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //подкатегории форума
        $req = DB::run("SELECT * FROM `forum` WHERE `refid`>'0' AND `type`='0' ORDER BY `realid` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/forum/' . $row['refid'] . '/' . $row['id'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //темы форума
        $req = DB::run("SELECT * FROM `tema` WHERE `type`='0' ORDER BY `id` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/forum/' . $row['id_razdel'] . '/' . $row['id_forum'] . '/' . $row['id'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //пользователи
        $req = DB::run("SELECT * FROM `users` ORDER BY `id` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/id' . $row['id'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //категории блогов
        $req = DB::run("SELECT * FROM `blog_category` ORDER BY `realid` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/blogs/' . $row['id'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //псоты блога
        $req = DB::run("SELECT * FROM `blog` ORDER BY `id` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/blogs/' . $row['refid'] . '/' . $row['id'] . '-' . $row['translate'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //галереи
        $req = DB::run("SELECT * FROM `gallery` ORDER BY `id` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/gallery/' . $row['id'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //фотографии
        $req = DB::run("SELECT * FROM `gallery_photo` ORDER BY `id` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/gallery/' . $row['id_gallery'] . '/' . $row['id'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //категории библиотеки
        $req = DB::run("SELECT * FROM `library_category` ORDER BY `id` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/library/' . $row['id'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
        }

        //статьи библиотеки
        $req = DB::run("SELECT * FROM `library` ORDER BY `id` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $url = Cms::setup('home') . '/library/' . $row['id'] . '-' . $row['translate'];
            $sitemapTXT .= "\r\n" . $url;
            $sitemap->addItem($url, time(), Cms::setup('sitemap_changefreq'), Cms::setup('sitemap_priority'));
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

        //Запись в файл
        if (Cms::setup('sitemap_txt') == 1) {
            $fp = fopen('sitemap/sitemap.txt', 'w+');
            if (!fwrite($fp, $sitemapTXT)) {
                echo 'Ошибка записи!';
            }
            fclose($fp);
        }

        if (Cms::setup('adminlogs') == 1) {
            Cms::adminlogs('Карта сайта', 'Сгенерирована карта сайта');
        } //пишем лог админа, если включено

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
