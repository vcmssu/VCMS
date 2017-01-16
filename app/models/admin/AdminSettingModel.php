<?php

class AdminSettingModel extends Base {

    function index() {

        if (isset($_POST['submit'])) {
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['home']) . "' WHERE `name`='home'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['namesite']) . "' WHERE `name`='namesite'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['message']) . "' WHERE `name`='message'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['adminpanel']) . "' WHERE `name`='adminpanel'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['copy']) . "' WHERE `name`='copy'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['adminlogs']) . "' WHERE `name`='adminlogs'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['timezone']) . "' WHERE `name`='timezone'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['skin']) . "' WHERE `name`='skin'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['compress']) . "' WHERE `name`='compress'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['emailadmin']) . "' WHERE `name`='emailadmin'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['antiflood']) . "' WHERE `name`='antiflood'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['autoclear_guest']) . "' WHERE `name`='autoclear_guest'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['keywords']) . "' WHERE `name`='keywords'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['description']) . "' WHERE `name`='description'");
            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Настройки сайта', 'Отредактированы основные настройки сайта');
            } //пишем лог админа, если включено
            Functions::redirect(Cms::setup('adminpanel') . '/setting');
            exit;
        }

        $dir = opendir(HOME . '/style/');
        while ($skin = readdir($dir)) {
            if (($skin != '.') && ($skin != '..') && ($skin != '.svn') && ($skin != 'admin')) {
                $arrayrowskin[] = $skin;
            }
        }
        closedir($dir);

        $req = DB::run("SELECT * FROM `zone` ORDER BY `zone_name` ASC");
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $arrayrow[] = $row;
        }

        SmartySingleton::instance()->assign(array(
            'arrayrow' => $arrayrow,
            'arrayrowskin' => $arrayrowskin
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/setting/index.tpl');
    }

    function other() {

        if (isset($_POST['submit'])) {
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['guest']) . "' WHERE `name`='guest'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['captcha_comments_news']) . "' WHERE `name`='captcha_comments_news'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['captcha_comments_file']) . "' WHERE `name`='captcha_comments_file'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['captcha_comments_blog']) . "' WHERE `name`='captcha_comments_blog'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['captcha_comments_library']) . "' WHERE `name`='captcha_comments_library'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['highlight']) . "' WHERE `name`='highlight'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['adslimit']) . "' WHERE `name`='adslimit'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['gallerypreview']) . "' WHERE `name`='gallerypreview'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['count_txt']) . "' WHERE `name`='count_txt'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['captcha_width']) . "' WHERE `name`='captcha_width'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['captcha_height']) . "' WHERE `name`='captcha_height'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['captcha_font_size']) . "' WHERE `name`='captcha_font_size'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['captcha_let_amount']) . "' WHERE `name`='captcha_let_amount'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Int($_POST['captcha_let_amount_fon']) . "' WHERE `name`='captcha_let_amount_fon'");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Настройки сайта', 'Изменены Дополнительные настройки');
            } //пишем лог админа, если включено

            Functions::redirect(Cms::setup('adminpanel') . '/setting/other');
        }
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/setting/other.tpl');
    }

    function email() {

        if (isset($_POST['submit'])) {
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['sendmail']) . "' WHERE `name`='sendmail'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['smtpport']) . "' WHERE `name`='smtpport'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['smtphost']) . "' WHERE `name`='smtphost'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['smtpusername']) . "' WHERE `name`='smtpusername'");
            DB::run("UPDATE `setting` SET `value` = '" . Cms::Input($_POST['smtppassword']) . "' WHERE `name`='smtppassword'");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Настройки сайта', 'Изменена настройка отправки писем');
            } //пишем лог админа, если включено

            Functions::redirect(Cms::setup('adminpanel') . '/setting/email');
        }
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/setting/email.tpl');
    }

    function counters() {

        if (isset($_POST['submit'])) {
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['counters'] . "' WHERE `name`='counters'");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Настройки сайта', 'Изменены счетчики');
            } //пишем лог админа, если включено

            Functions::redirect(Cms::setup('adminpanel') . '/setting/counters');
        }
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/setting/counters.tpl');
    }

    function forum() {

        if (isset($_POST['submit'])) {
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['filetype_forum'] . "' WHERE `name`='filetype_forum'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['filesize_forum'] . "' WHERE `name`='filesize_forum'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['filecount_forum'] . "' WHERE `name`='filecount_forum'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['time_forum'] . "' WHERE `name`='time_forum'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['vote_forum'] . "' WHERE `name`='vote_forum'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['captcha_add_theme'] . "' WHERE `name`='captcha_add_theme'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['captcha_add_post'] . "' WHERE `name`='captcha_add_post'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['lastthems'] . "' WHERE `name`='lastthems'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['forum_time_edit_post'] . "' WHERE `name`='forum_time_edit_post'");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Настройки сайта', 'Изменены настройки форума');
            } //пишем лог админа, если включено

            Functions::redirect(Cms::setup('adminpanel') . '/setting/forum');
        }
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/setting/forum.tpl');
    }

    function smiles() {
        $count = DB::run("SELECT COUNT(*) FROM `smiles`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT * FROM `smiles` ORDER BY `id` ASC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination(Cms::setup('adminpanel') . '/setting/smiles?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/setting/smiles.tpl');
    }

    function smiles_update() {
        DB::run("TRUNCATE TABLE `smiles`");
        $dir = scandir('files/smiles');
        natsort($dir);
        foreach ($dir as $v) {
            $ext = Recipe::getFileExtension($v);
            $c = str_replace('.' . $ext, '', $v);
            $c = ':' . $c . ':';
            if (($v != '.') && ($v != '..') && ($v != '.svn') && ($v != 'Thumbs.db')) {
                DB::run("INSERT INTO `smiles` SET `code`='" . $c . "', `photo`='" . $v . "'");
            }
        }

        if (Cms::setup('adminlogs') == 1) {
            Cms::adminlogs('Настройки сайта', 'Обновлена база смайлов');
        } //пишем лог админа, если включено
        Functions::redirect(Cms::setup('adminpanel') . '/setting/smiles');
    }

    function zc() {

        if (isset($_POST['submit'])) {
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['preview'] . "' WHERE `name`='preview'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['previewsmall'] . "' WHERE `name`='previewsmall'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['previewsmall2'] . "' WHERE `name`='previewsmall2'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['watermark'] . "' WHERE `name`='watermark'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['autoscreen_video'] . "' WHERE `name`='autoscreen_video'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['autoscreen_nth'] . "' WHERE `name`='autoscreen_nth'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['autoscreen_thm'] . "' WHERE `name`='autoscreen_thm'");
            DB::run("UPDATE `setting` SET `value` = '" . $_POST['newfile'] . "' WHERE `name`='newfile'");

            if (Cms::setup('adminlogs') == 1) {
                Cms::adminlogs('Настройки сайта', 'Изменены настройки загруз центра');
            } //пишем лог админа, если включено

            Functions::redirect(Cms::setup('adminpanel') . '/setting/zc');
        }
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/setting/zc.tpl');
    }

}
