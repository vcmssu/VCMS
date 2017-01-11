<?php

class MainModel extends Base {

    function index() {
        $news = DB::run("SELECT `news`.*, (SELECT COUNT(1) FROM `news_comments` WHERE `news_comments`.`id_news`=`news`.`id`) AS `count` FROM `news` WHERE `status`='1' ORDER BY `id` DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        SmartySingleton::instance()->assign(array(
            'news' => $news,
            'text' => BBcode::delete($news['text'])
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/index.tpl');
    }

    function online() {
        $count = DB::run("SELECT COUNT(*) FROM `online` WHERE `type`='1'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `online`.*, (SELECT `login` FROM `users` WHERE `users`.`id`=`online`.`id_user`) AS `login`,
                (SELECT `avatar` FROM `users` WHERE `users`.`id`=`online`.`id_user`) AS `avatar` FROM `online` WHERE `type`='1' ORDER BY `time` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/online?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/online/index.tpl');
    }

    function guest() {
        $count = DB::run("SELECT COUNT(*) FROM `online` WHERE `type`='2'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT * FROM `online` WHERE `type`='2' ORDER BY `time` DESC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/online/guest?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/online/guest.tpl');
    }

    function smiles() {
        if (empty($_SESSION['referer'])) {
            $_SESSION['referer'] = Recipe::getReferer();
        }

        if ($_POST['ok']) {
            for ($i = 0; $i < count($_POST['select']); $i++) {
                if (DB::run("SELECT COUNT(*) FROM `smiles_user` WHERE `id_user`='" . $this->user['id'] . "' AND `id_smile` = '" . intval($_POST['select'][$i]) . "'")->fetchColumn() == 0) {
                    DB::run("INSERT INTO `smiles_user` SET 
                            `id_user` = '" . $this->user['id'] . "', 
                                `id_smile` = '" . intval($_POST['select'][$i]) . "'");
                }
            }
            Functions::redirect(Recipe::getReferer());
        }

        $count = DB::run("SELECT COUNT(*) FROM `smiles`")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `smiles`.*, (SELECT `id_smile` FROM `smiles_user` WHERE `smiles_user`.`id_smile`=`smiles`.`id` AND `id_user`='" . $this->user['id'] . "') AS `idsmile` FROM `smiles` ORDER BY `id` ASC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/smiles?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/smiles.tpl');
    }

    function smiles_my() {
        if (empty($_SESSION['referer'])) {
            $_SESSION['referer'] = Recipe::getReferer();
        }

        if ($_POST['ok']) {
            for ($i = 0; $i < count($_POST['select']); $i++) {
                if (DB::run("SELECT COUNT(*) FROM `smiles_user` WHERE `id_user`='" . $this->user['id'] . "' AND `id` = '" . intval($_POST['select'][$i]) . "'")->fetchColumn() > 0) {
                    DB::run("DELETE FROM `smiles_user` WHERE `id` = '" . intval($_POST['select'][$i]) . "' AND `id_user` = '" . $this->user['id'] . "' LIMIT 1");
                }
            }
            Functions::redirect(Recipe::getReferer());
        }

        $count = DB::run("SELECT COUNT(*) FROM `smiles_user` WHERE `id_user` = '" . $this->user['id'] . "'")->fetchColumn();
        if ($count > 0) {
            $req = DB::run("SELECT `smiles_user`.*, 
                            `smiles`.`code`, `smiles`.`photo`
                                FROM `smiles` LEFT JOIN `smiles_user` ON `smiles`.`id` = `smiles_user`.`id_smile` WHERE `id_user` = '" . $this->user['id'] . "' ORDER BY `id` ASC LIMIT " . $this->page . ", " . $this->message);
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $arrayrow[] = $row;
            }
        }

        SmartySingleton::instance()->assign(array(
            'count' => $count,
            'arrayrow' => $arrayrow,
            'pagenav' => Functions::pagination('/smiles/my?', $this->page, $count, $this->message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/smiles_my.tpl');
    }

    function bbcode() {
        if (empty($_SESSION['referer'])) {
            $_SESSION['referer'] = Recipe::getReferer();
        }
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/modules/user/bbcode.tpl');
    }

    function bbcode_ajax() {
        $message = isset($_POST['data']) ? $_POST['data'] : '';
        SmartySingleton::instance()->assign(array(
            'message' => Cms::bbcode($message)
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/previews.tpl');
    }

    function captcha() {
        $width = Cms::setup('captcha_width'); //Ширина изображения
        $height = Cms::setup('captcha_height'); //Высота изображения
        $font_size = Cms::setup('captcha_font_size'); //Размер шрифта
        $let_amount = Cms::setup('captcha_let_amount'); //Количество символов, которые нужно набрать
        $fon_let_amount = Cms::setup('captcha_let_amount_fon'); //Количество символов, которые находятся на фоне
        $path_fonts = LIB . '/font/'; //Путь к шрифтам


        $letters = array(
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'j',
            'k',
            'm',
            'n',
            'p',
            'q',
            'r',
            's',
            't',
            'u',
            'v',
            'w',
            'x',
            'y',
            'z',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '9'
        );
        $colors = array(
            '10',
            '30',
            '50',
            '70',
            '90',
            '110',
            '130',
            '150',
            '170',
            '190',
            '210'
        );

        $src = imagecreatetruecolor($width, $height);
        $fon = imagecolorallocate($src, 255, 255, 255);
        imagefill($src, 0, 0, $fon);

        $fonts = array();
        $dir = opendir($path_fonts);
        while ($fontName = readdir($dir)) {
            if ($fontName != "." && $fontName != "..") {
                $fonts[] = $fontName;
            }
        }
        closedir($dir);

        for ($i = 0; $i < $fon_let_amount; $i++) {
            $color = imagecolorallocatealpha($src, rand(0, 255), rand(0, 255), rand(0, 255), 100);
            $font = $path_fonts . $fonts[rand(0, sizeof($fonts) - 1)];
            $letter = $letters[rand(0, sizeof($letters) - 1)];
            $size = rand($font_size - 2, $font_size + 2);
            imagettftext($src, $size, rand(0, 45), rand($width * 0.1, $width - $width * 0.1), rand($height * 0.2, $height), $color, $font, $letter);
        }

        for ($i = 0; $i < $let_amount; $i++) {
            $color = imagecolorallocatealpha($src, $colors[rand(0, sizeof($colors) - 1)], $colors[rand(0, sizeof($colors) - 1)], $colors[rand(0, sizeof($colors) - 1)], rand(20, 40));
            $font = $path_fonts . $fonts[rand(0, sizeof($fonts) - 1)];
            $letter = $letters[rand(0, sizeof($letters) - 1)];
            $size = rand($font_size * 2.1 - 2, $font_size * 2.1 + 2);
            $x = ($i + 1) * $font_size + rand(4, 7);
            $y = (($height * 2) / 3) + rand(0, 5);
            $cod[] = $letter;
            imagettftext($src, $size, rand(0, 15), $x, $y, $color, $font, $letter);
        }

        $cod = implode('', $cod);

        setcookie('code', $cod, time() + 60 * 60 * 24, '/');

        // предотвращаем кэширование на стороне пользователя
        header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        header("Content-type: image/gif");
        imagegif($src);
        imagedestroy($src);
    }

}
