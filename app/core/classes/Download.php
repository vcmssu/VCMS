<?php

class Download {

    //для видео
    function autoscreen_video($file, $name, $width, $height) {
        $frame = 50; //берем 50-й кадр
        $mov = new ffmpeg_movie($file);
        $w = $mov->GetFrameWidth();
        $h = $mov->GetFrameHeight();
        $ff_frame = $mov->getFrame($frame);
        if ($ff_frame) {
            $gd_image = $ff_frame->toGDImage();
            if ($gd_image) {
                $des_img = imagecreatetruecolor($width, $height);
                $ratio = $w / $h;

                $s_img = $gd_image;
                imagecopyresampled($des_img, $s_img, 0, 0, 0, 0, $width, $height, $w, $h);
                imageGif($des_img, $name);
                imagedestroy($des_img);
                imagedestroy($s_img);
            }
        }
    }

    //Автоскрины к темам thm 
    function autoscreen_thm($theme, $g_preview_image_w, $g_preview_image_h, $name) {
        global $home;
        require $_SERVER['DOCUMENT_ROOT'] . '/system/inc/lib/tar.php';
        $thm = new Archive_Tar($theme);
        if (!$file = $thm->extractInString('Theme.xml') or ! $file = $thm->extractInString(pathinfo($theme, PATHINFO_FILENAME) . '.xml')) {
            $list = $thm->listContent();
            $all = sizeof($list);
            for ($i = 0; $i < $all; ++$i) {
                if (pathinfo($list[$i]['filename'], PATHINFO_EXTENSION) == 'xml') {
                    $file = $thm->extractInString($list[$i]['filename']);
                    break;
                }
            }
        }
        if (!$file) {
            preg_match('/<\?\s*xml\s*version\s*=\s*"1\.0"\s*\?>(.*)<\/.+>/isU', file_get_contents($theme), $arr);
            $file = trim($arr[0]);
        }

        $load = simplexml_load_string($file)->Standby_image['Source'] or $load = simplexml_load_string($file)->Desktop_image['Source'] or $load = simplexml_load_string($file)->Desktop_image['Source'];
        $image = $thm->extractInString(trim($load));
        $im = array_reverse(explode('.', $load));
        $im = 'imageCreateFrom' . str_ireplace('jpg', 'jpeg', trim($im[0]));
        file_put_contents($name, $image);
        $f = $im($name);
        $h = imagesy($f);
        $w = imagesx($f);
        $ratio = $w / $h;
        if ($g_preview_image_w / $g_preview_image_h > $ratio) {
            $g_preview_image_w = $g_preview_image_h * $ratio;
        } else {
            $g_preview_image_h = $g_preview_image_w / $ratio;
        }
        $new = imagecreatetruecolor($g_preview_image_w, $g_preview_image_h);
        imagecopyresized($new, $f, 0, 0, 0, 0, $g_preview_image_w, $g_preview_image_h, $w, $h);
        $icx_str = strtoupper(str_replace('http://', '', $home)); //Водяной знак в нижнем правом углу
        $icx_size = 1; // размер шрифта watermark строки
// определяем координаты вывода текста
        $icx_x_text = $g_preview_image_w - imagefontwidth($icx_size) * strlen($icx_str) - 3;
        $icx_y_text = $g_preview_image_h - imagefontheight($icx_size) - 3;
// определяем каким цветом на каком фоне выводить текст
        $icx_white = imagecolorallocate($new, 255, 255, 255);
        $icx_black = imagecolorallocate($new, 0, 0, 0);
        $icx_gray = imagecolorallocate($new, 127, 127, 127);
        if (imagecolorat($new, $icx_x_text, $icx_y_text) > $icx_gray) {
            $icx_color = $icx_black;
        }
        if (imagecolorat($new, $icx_x_text, $icx_y_text) < $icx_gray) {
            $icx_color = $icx_white;
        }
// выводим текст
        imagestring($new, $icx_size, $icx_x_text - 1, $icx_y_text - 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text + 1, $icx_y_text + 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text + 1, $icx_y_text - 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text - 1, $icx_y_text + 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text - 1, $icx_y_text, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text + 1, $icx_y_text, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text, $icx_y_text - 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text, $icx_y_text + 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text, $icx_y_text, $icx_str, $icx_color);
        imageGif($new, $name);
        imagedestroy($new);
    }

    //автоскрины к темам nth
    function autoscreen_nth($theme, $g_preview_image_w, $g_preview_image_h, $name) {
        global $home;
        require $_SERVER['DOCUMENT_ROOT'] . '/system/inc/lib/pclzip.lib.php';
        $nth = new PclZip($theme);
        $content = $nth->extract(PCLZIP_OPT_BY_NAME, 'theme_descriptor.xml', PCLZIP_OPT_EXTRACT_AS_STRING);
        if (!$content) {
            $content = $nth->extract(PCLZIP_OPT_BY_PREG, '\.xml$', PCLZIP_OPT_EXTRACT_AS_STRING);
        }
        $teg = simplexml_load_string($content[0]['content'])->wallpaper['src'] or $teg = simplexml_load_string($content[0]['content'])->wallpaper['main_display_graphics'];
        $image = $nth->extract(PCLZIP_OPT_BY_NAME, trim($teg), PCLZIP_OPT_EXTRACT_AS_STRING);
        $im = array_reverse(explode('.', $teg));
        $im = 'imageCreateFrom' . str_ireplace('jpg', 'jpeg', trim($im[0]));

        file_put_contents($name, $image[0]['content']);
        $f = $im($name);

        $h = imagesy($f);
        $w = imagesx($f);

        $ratio = $w / $h;
        if ($g_preview_image_w / $g_preview_image_h > $ratio) {
            $g_preview_image_w = $g_preview_image_h * $ratio;
        } else {
            $g_preview_image_h = $g_preview_image_w / $ratio;
        }

        $new = imagecreatetruecolor($g_preview_image_w, $g_preview_image_h);
        imagecopyresized($new, $f, 0, 0, 0, 0, $g_preview_image_w, $g_preview_image_h, $w, $h);
        $icx_str = strtoupper(str_replace('http://', '', $home)); //Водяной знак в нижнем правом углу
        $icx_size = 1; // размер шрифта watermark строки
// определяем координаты вывода текста
        $icx_x_text = $g_preview_image_w - imagefontwidth($icx_size) * strlen($icx_str) - 3;
        $icx_y_text = $g_preview_image_h - imagefontheight($icx_size) - 3;
// определяем каким цветом на каком фоне выводить текст
        $icx_white = imagecolorallocate($new, 255, 255, 255);
        $icx_black = imagecolorallocate($new, 0, 0, 0);
        $icx_gray = imagecolorallocate($new, 127, 127, 127);
        if (imagecolorat($new, $icx_x_text, $icx_y_text) > $icx_gray) {
            $icx_color = $icx_black;
        }
        if (imagecolorat($new, $icx_x_text, $icx_y_text) < $icx_gray) {
            $icx_color = $icx_white;
        }
// выводим текст
        imagestring($new, $icx_size, $icx_x_text - 1, $icx_y_text - 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text + 1, $icx_y_text + 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text + 1, $icx_y_text - 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text - 1, $icx_y_text + 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text - 1, $icx_y_text, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text + 1, $icx_y_text, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text, $icx_y_text - 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text, $icx_y_text + 1, $icx_str, $icx_white - $icx_color);
        imagestring($new, $icx_size, $icx_x_text, $icx_y_text, $icx_str, $icx_color);
        imageGif($new, $name);
        imagedestroy($new);
    }

    //водяной знак
    function watermark($im, $size) {
        $string = strtoupper(str_replace('http://', '', Cms::setup('home'))); //Водяной знак
        //$size = 3; //размер шрифта
        $z = getimagesize($im);
        if ($z[2] == '1') {
            $p = ImageCreateFromgif($im);
        }
        if ($z[2] == '2') {
            $p = ImageCreateFromjpeg($im);
        }
        if ($z[2] == '3') {
            $p = ImageCreateFrompng($im);
        }
        $d = imagecreatetruecolor($z[0], $z[1]);
        imagecopyresampled($d, $p, 0, 0, 0, 0, $z[0], $z[1], $z[0], $z[1]);
        $icx_x_text = $z[0] - imagefontwidth($size) * strlen($string) - 3;
        $icx_y_text = $z[1] - imagefontheight($size) - 3;
        // определяем каким цветом на каком фоне выводить текст
        $icx_white = imagecolorallocate($d, 255, 255, 255);
        $icx_black = imagecolorallocate($d, 0, 0, 0);
        $icx_gray = imagecolorallocate($d, 127, 127, 127);
        if (imagecolorat($d, $icx_x_text, $icx_y_text) > $icx_gray) {
            $color = $icx_black;
        }
        if (imagecolorat($d, $icx_x_text, $icx_y_text) < $icx_gray) {
            $color = $icx_white;
        }
        //выводим текст
        imagestring($d, $size, $icx_x_text - 1, $icx_y_text - 1, $string, $icx_white - $icx_color);
        imagestring($d, $size, $icx_x_text + 1, $icx_y_text + 1, $string, $icx_white - $icx_color);
        imagestring($d, $size, $icx_x_text + 1, $icx_y_text - 1, $string, $icx_white - $icx_color);
        imagestring($d, $size, $icx_x_text - 1, $icx_y_text + 1, $string, $icx_white - $icx_color);
        imagestring($d, $size, $icx_x_text - 1, $icx_y_text, $string, $icx_white - $icx_color);
        imagestring($d, $size, $icx_x_text + 1, $icx_y_text, $string, $icx_white - $icx_color);
        imagestring($d, $size, $icx_x_text, $icx_y_text - 1, $string, $icx_white - $icx_color);
        imagestring($d, $size, $icx_x_text, $icx_y_text + 1, $string, $icx_white - $icx_color);
        imagestring($d, $size, $icx_x_text, $icx_y_text, $string, $icx_color);
        //сохраняем
        if ($z[2] == '1') {
            imagegif($d, $im);
        }
        if ($z[2] == '2') {
            imagejpeg($d, $im, 100);
        }
        if ($z[2] == '3') {
            imagepng($d, $im);
        }
        //убираем мусор
        imagedestroy($d);
        imagedestroy($p);
        return true;
    }

    function load($url) {
        if (ini_get("zlib.output_compression")) {
            ini_set("zlib.output_compression", "Off");
        }
        $flxt = strtolower(substr(strrchr($url, "."), 1));

        if (($url == "") || (!file_exists($url))) {
            echo "Error: file <i>" . $url . "</i> not found.";
            exit;
        }

        switch ($flxt) {
            case "gif": $tpe = "image/gif";
                break;
            case "png": $tpe = "image/png";
                break;
            case "jpg": $tpe = "image/jpg";
                break;
            case "3gp": $tpe = "video/3gpp";
                break;
            case "jad": $tpe = "text/vnd.sun.j2me.app-descriptor";
                break;
            case "jar": $tpe = "application/java-archive";
                break;
            case "wml": $tpe = "text/vnd.wap.wml";
                break;
            case "wbmp": $tpe = "image/vnd.wap.wbmp";
                break;
            case "mid": $tpe = "audio/midi";
                break;
            case "mp3": $tpe = "audio/mp3";
                break;
            case "mp4": $tpe = "video/mp4";
                break;
            case "flv": $tpe = "video/x-flv";
                break;
            case "ics": $tpe = "text/calendar";
                break;
            case "pdf": $tpe = "application/pdf";
                break;
            case "exe": $tpe = "application/octet-stream";
                break;
            case "zip": $tpe = "application/zip";
                break;
            case "doc": $tpe = "application/msword";
                break;
            case "xls": $tpe = "application/vnd.ms-excel";
                break;
            case "ppt": $tpe = "application/vnd.ms-powerpoint";
                break;
            default: $tpe = "application/force-download";
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: " . $tpe);
        header("Content-Disposition: attachment; filename=\"" . basename($url) . "\";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($url));
        readfile($url);
    }

}
