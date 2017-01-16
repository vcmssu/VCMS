<?php

class Functions {

    public static function position($text, $chr) {
        $result = mb_strpos($text, $chr);

        return $result !== false ? $result : 100;
    }

    function seokeywords($contents, $symbol = 5, $words = 35) {
        $contents = preg_replace(array("'<[\/\!]*?[^<>]*?>'si", "'([\r\n])[\s]+'si", "'&[a-z0-9]{1,6};'si", "'( +)'si"), array("", "\\1 ", " ", " "), strip_tags($contents));
        $rearray = array("~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "+",
            "`", '"', "№", ";", ":", "?", "-", "=", "|", "\"", "\\", "/",
            "[", "]", "{", "}", "'", ",", ".", "<", ">", "\r\n", "\n", "\t", "«", "»", "quot");

        $adjectivearray = array("ые", "ое", "ие", "ий", "ая", "ый", "ой", "ми", "ых", "ее", "ую", "их", "ым",
            "как", "для", "что", "или", "это", "этих",
            "всех", "вас", "они", "оно", "еще", "когда",
            "где", "эта", "лишь", "уже", "вам", "нет",
            "если", "надо", "все", "так", "его", "чем",
            "при", "даже", "мне", "есть", "только", "очень",
            "сейчас", "точно", "обычно"
        );


        $contents = str_replace($rearray, " ", $contents);
        $keywordcache = explode(" ", $contents);
        $rearray = array();

        foreach ($keywordcache as $word) {
            if (strlen($word) >= $symbol && !is_numeric($word)) {
                $adjective = substr($word, -2);
                if (!in_array($adjective, $adjectivearray) && !in_array($word, $adjectivearray)) {
                    $rearray[$word] = (array_key_exists($word, $rearray)) ? ($rearray[$word] + 1) : 1;
                }
            }
        }

        arsort($rearray);
        $keywordcache = array_slice($rearray, 0, $words);
        $keywords = "";

        foreach ($keywordcache as $word => $count) {
            $keywords .= ", " . $word;
        }

        return substr($keywords, 1);
    }

    function close_tags($content) {
        $position = 0;
        $open_tags = array();
        //теги для игнорирования
        $ignored_tags = array(
            'br',
            'hr',
            'img'
        );

        while (($position = strpos($content, '<', $position)) !== FALSE) {
            //забираем все теги из контента
            if (preg_match("|^<(/?)([a-z\d]+)\b[^>]*>|i", substr($content, $position), $match)) {
                $tag = strtolower($match[2]);
                //игнорируем все одиночные теги
                if (in_array($tag, $ignored_tags) == FALSE) {
                    //тег открыт
                    if (isset($match[1]) AND $match[1] == '') {
                        if (isset($open_tags[$tag])) {
                            $open_tags[$tag] ++;
                        } else
                            $open_tags[$tag] = 1;
                    }
                    //тег закрыт
                    if (isset($match[1]) AND $match[1] == '/') {
                        if (isset($open_tags[$tag])) {
                            $open_tags[$tag] --;
                        }
                    }
                }
                $position += strlen($match[0]);
            } else {
                $position++;
            }
        }
        //закрываем все теги
        foreach ($open_tags as $tag => $count_not_closed) {
            $content .= str_repeat("</{$tag}>", $count_not_closed);
        }

        return $content;
    }

    //функция для определения размера папки
    function dir_size($f, $format = true) {
        if ($format) {
            $size = dir_size($f, false);
            if ($size <= 1024) {
                return $size . ' bytes';
            }
            //else if($size<=1024*1024) return round($size/(1024),2).' Kb'; 
            else if ($size <= 1024 * 1024 * 1024) {
                return round($size / (1024 * 1024), 2);
            }
            //else if($size<=1024*1024*1024*1024) return round($size/(1024*1024*1024),2).' Gb'; 
            //else if($size<=1024*1024*1024*1024*1024) return round($size/(1024*1024*1024*1024),2).' Tb'; //:))) 
            //else return round($size/(1024*1024*1024*1024*1024),2).' Pb'; // ;-) 
        } else {
            if (is_file($f)) {
                return filesize($f);
            }
            $size = 0;
            $dh = opendir($f);
            while (($file = readdir($dh)) !== false) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_file($f . '/' . $file)) {
                    $size += filesize($f . '/' . $file);
                } else {
                    $size += dir_size($f . '/' . $file, false);
                }
            }
            closedir($dh);
            return $size + filesize($f);
        }
    }

    function ending($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 == 1) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' раз';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' раза';
        } else {
            return $num . ' разик';
        }
    }

    function minute($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' минут';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' минуты';
        } else {
            return $num . ' минута';
        }
    }

    function hour($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' часов';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' часа';
        } else {
            return $num . ' час';
        }
    }

    function day($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' дней';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' дня';
        } else {
            return $num . ' день';
        }
    }

    function month($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' месяцев';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' месяца';
        } else {
            return $num . ' месяц';
        }
    }

    function ending_user($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' пользователей';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' пользователя';
        } else {
            return $num . ' пользователь';
        }
    }

    function ending_quest($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' посетителей';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' посетителя';
        } else {
            return $num . ' посетитель';
        }
    }

    function ending_money($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' рублей';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' рубля';
        } else {
            return $num . ' рубль';
        }
    }

    function ending_second($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' секунд';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' секунды';
        } else {
            return $num . ' секунда';
        }
    }

    function ending_board($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' объявлений';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' объявления';
        } else {
            return $num . ' объявление';
        }
    }

    function ending_age($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 == 1) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' лет';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' года';
        } else {
            return $num . ' год';
        }
    }

    function message($num) {
        $num100 = $num % 100;
        $num10 = $num % 10;
        if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) {
            return $num . ' сообщений';
        } else if ($num10 >= 2 && $num10 <= 4) {
            return $num . ' сообщения';
        } else {
            return $num . ' сообщение';
        }
    }

    function esc($text) {
        $text = htmlspecialchars_decode(htmlspecialchars_decode($text));
        return $text;
    }

    function _GET($key) {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    function _POST($key) {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    function IS_POST() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    function GET_METHOD() {
        $method = $_SERVER['REQUEST_METHOD'];

        if (self::IS_POST()) {
            if (isset($_SERVER['X-HTTP-METHOD-OVERRIDE'])) {
                $method = strtoupper($_SERVER['X-HTTP-METHOD-OVERRIDE']);
            }
        }

        return $method;
    }

    function _e($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    function _d($str, $default) {
        return $str ? _e($str) : _e($default);
    }

    function dd($value) {
        var_dump($value);
        die();
    }

    function IS_HTTPS() {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off';
    }

    function GET_HTTP_HOST() {
        $host = self::IS_HTTPS() ? 'https://' : 'http://';
        $host .= self::GET_HOST();
        return $host;
    }

    function GET_HOST() {
        $host = $_SERVER['HTTP_HOST'];

        $host = strtolower(preg_replace('/:\d+$/', '', trim($host)));

        if ($host && !preg_match('/^\[?(?:[a-zA-Z0-9-:\]_]+\.?)+$/', $host)) {
            throw new \UnexpectedValueException(sprintf('Invalid Host "%s"', $host));
        }

        return $host;
    }

    function GET_PATH_INFO($baseUrl = null) {
        static $pathInfo;

        if (!$pathInfo) {
            $pathInfo = $_SERVER['REQUEST_URI'];

            if (!$pathInfo) {
                $pathInfo = '/';
            }

            $schemeAndHttpHost = self::IS_HTTPS() ? 'https://' : 'http://';
            $schemeAndHttpHost .= $_SERVER['HTTP_HOST'];

            if (strpos($pathInfo, $schemeAndHttpHost) === 0) {
                $pathInfo = substr($pathInfo, strlen($schemeAndHttpHost));
            }

            if ($pos = strpos($pathInfo, '?')) {
                $pathInfo = substr($pathInfo, 0, $pos);
            }

            if (null != $baseUrl) {
                $pathInfo = substr($pathInfo, strlen($pathInfo));
            }

            if (!$pathInfo) {
                $pathInfo = '/';
            }
        }

        return $pathInfo;
    }

    function number($str) {
        $str = preg_replace("/[^0-9]/", '', $str);
        return $str;
    }

    function pagination($base_url, $start, $max_value, $num_per_page) {
        $pgcont = 5;
        $pgcont = (int) ($pgcont - ($pgcont % 2)) / 2;
        if ($start >= $max_value) {
            $start = max(0, (int) $max_value - (((int) $max_value % (int) $num_per_page) == 0 ? $num_per_page : ((int) $max_value % (int) $num_per_page)));
        } else {
            $start = max(0, (int) $start - ((int) $start % (int) $num_per_page));
        }
        $base_link = '<li><a class="pagenav" href="' . strtr($base_url, array(
                    '%' => '%%'
                )) . 'page=%d' . '">%s</a></li>';
        $pageindex = $start == 0 ? '' : sprintf($base_link, $start - $num_per_page, '<i class="fa fa-angle-left"></i>');
        if ($start > $num_per_page * $pgcont) {
            $pageindex .= sprintf($base_link, 0, '1');
        }
        if ($start > $num_per_page * ($pgcont + 1)) {
            $pageindex .= '<li><span style="font-weight: bold;"> ... </span></li>';
        }
        for ($nCont = $pgcont; $nCont >= 1; $nCont--) {
            if ($start >= $num_per_page * $nCont) {
                $tmpStart = $start - $num_per_page * $nCont;
                $pageindex .= sprintf($base_link, $tmpStart, $tmpStart / $num_per_page + 1);
            }
        }
        $pageindex .= '<li class="active"><a>' . ($start / $num_per_page + 1) . '</a></li> ';
        $tmpMaxPages = (int) (($max_value - 1) / $num_per_page) * $num_per_page;
        for ($nCont = 1; $nCont <= $pgcont; $nCont++) {
            if ($start + $num_per_page * $nCont <= $tmpMaxPages) {
                $tmpStart = $start + $num_per_page * $nCont;
                $pageindex .= sprintf($base_link, $tmpStart, $tmpStart / $num_per_page + 1);
            }
        }
        if ($start + $num_per_page * ($pgcont + 1) < $tmpMaxPages) {
            $pageindex .= '<li><span style="font-weight: bold;"> ... </span></li>';
        }
        if ($start + $num_per_page * $pgcont < $tmpMaxPages) {
            $pageindex .= sprintf($base_link, $tmpMaxPages, $tmpMaxPages / $num_per_page + 1);
        }
        if ($start + $num_per_page < $max_value) {
            $display_page = ($start + $num_per_page) > $max_value ? $max_value : ($start + $num_per_page);
            $pageindex .= sprintf($base_link, $display_page, '<i class="fa fa-angle-right"></i>');
        }
        return $pageindex;
    }

    function passgen($k_simb = 8, $types = 3) {
        $password = "";
        $small = "abcdefghijklmnopqrstuvwxyz";
        $large = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $numbers = "1234567890";
        mt_srand((double) microtime() * 1000000);
        for ($i = 0; $i < $k_simb; $i++) {
            $type = mt_rand(1, min($types, 3));
            switch ($type) {
                case 3:
                    $password .= $large[mt_rand(0, 25)];
                    break;
                case 2:
                    $password .= $small[mt_rand(0, 25)];
                    break;
                case 1:
                    $password .= $numbers[mt_rand(0, 9)];
                    break;
            }
        }
        return $password;
    }

    function redirect($url) {
        header('Location: ' . $url);

        $content = sprintf('<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="refresh" content="1;url=%1$s" /><title>Redirecting to %1$s</title></head><body>Redirecting to <a href="%1$s">%1$s</a>.</body></html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8'));

        echo $content;
        exit;
    }

    function name_replace($name) {
        //////////// Транслитируем имя ///////
        $trans1 = array("Ё", "Ж", "Ч", "Ш", "Щ", "Э", "Ю", "Я", "ё", "ж", "ч", "ш", "щ", "э", "ю", "я", "А", "Б", "В", "Г", "Д", "Е", "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ы", "а", "б", "в", "г", "д", "е", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ь", "Ь", "Ъ", "ъ", "ы");
        $trans2 = array("JO", "ZH", "CH", "SH", "SCH", "JE", "JY", "JA", "jo", "zh", "ch", "sh", "sch", "je", "jy", "ja", "A", "B", "V", "G", "D", "E", "Z", "I", "J", "K", "L", "M", "N", "O", "P", "R", "S", "T", "U", "F", "H", "C", "Y", "a", "b", "v", "g", "d", "e", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "f", "h", "c", "q", "Q", "_", "_", "y");
        $ftp = str_replace($trans1, $trans2, mb_strtolower($name));
        ////////// Вырезаем/заменяем различные неподходящие символы ////////
        $ftp = str_replace(' ', '-', $ftp);
        $ftp = str_replace('\'', '-', $ftp);
        $ftp = str_replace('_', '-', $ftp);
        $ftp = str_replace(',', '-', $ftp);
        $simb = array('?', '/', '|', '~', '+', '=', '%', '^', '&', '@', '!', '`', '*', '$', '#', '№', '"', ':', ';', '.');
        $ftp = str_replace($simb, "", $ftp);
        $ftp = str_replace("'", "", $ftp);
        return $ftp;
    }

    function replace($ftp) {
        ////////// Вырезаем/заменяем различные неподходящие символы ////////
        $ftp = str_replace(' ', '-', $ftp);
        $ftp = str_replace('\'', '-', $ftp);
        $ftp = str_replace('_', '-', $ftp);
        $ftp = str_replace(',', '-', $ftp);
        $simb = array('?', '/', '|', '~', '+', '=', '%', '^', '&', '@', '!', '`', '*', '$', '#', '№', '"', ':', ';', '.');
        $ftp = str_replace($simb, "", $ftp);
        $ftp = str_replace("'", "", $ftp);
        return $ftp;
    }

    //правильный вывод размера файла
    function size($size) {
        if ($size >= 1073741824) {
            $size = round($size / 1073741824 * 100) / 100 . ' Gb';
        } elseif ($size >= 1048576) {
            $size = round($size / 1048576 * 100) / 100 . ' Mb';
        } elseif ($size >= 1024) {
            $size = round($size / 1024 * 100) / 100 . ' Kb';
        } else {
            $size = round($size) . ' b';
        }
        return $size;
    }

    function fsize($path) {
        $fp = fopen($path, "r");
        $inf = stream_get_meta_data($fp);
        fclose($fp);
        foreach ($inf["wrapper_data"] as $v) {
            if (stristr($v, "content-length")) {
                $v = explode(":", $v);
                return trim($v[1]);
            }
        }
    }

    //функция времени
    function times($time = NULL) {
        if ($time == NULL) {
            $time = time();
        }
        $timep = "" . date("j M Y в H:i", $time) . "";
        $time_p[0] = date("j n Y", $time);
        $time_p[1] = date("H:i", $time);
        $timep = str_replace("Jan", "января", $timep);
        $timep = str_replace("Feb", "февраля", $timep);
        $timep = str_replace("Mar", "марта", $timep);
        $timep = str_replace("May", "мая", $timep);
        $timep = str_replace("Apr", "апр", $timep);
        $timep = str_replace("Jun", "июня", $timep);
        $timep = str_replace("Jul", "июля", $timep);
        $timep = str_replace("Aug", "августа", $timep);
        $timep = str_replace("Sep", "сентября", $timep);
        $timep = str_replace("Oct", "октября", $timep);
        $timep = str_replace("Nov", "ноября", $timep);
        $timep = str_replace("Dec", "декабря", $timep);
        return $timep;
    }

    function times_page() {
        list($msec, $sec) = explode(chr(32), microtime(1));
        return $msec + $sec;
    }

    function truncate($string, $length = 80, $etc = '...', $break_words = false, $middle = false) {
        if ($length == 0) {
            return '';
        }

        // no MBString fallback
        if (isset($string[$length])) {
            $length -= min($length, strlen($etc));
            if (!$break_words && !$middle) {
                $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length + 1));
            }
            if (!$middle) {
                return substr($string, 0, $length) . $etc;
            }

            return substr($string, 0, $length / 2) . $etc . substr($string, -$length / 2);
        }

        return $string;
    }

    function utf8_str_split($str) {
        // place each character of the string into and array
        $split = 1;
        $array = array();
        for ($i = 0; $i < strlen($str);) {
            $value = ord($str[$i]);
            if ($value > 127) {
                if ($value >= 192 && $value <= 223)
                    $split = 2;
                elseif ($value >= 224 && $value <= 239)
                    $split = 3;
                elseif ($value >= 240 && $value <= 247)
                    $split = 4;
            }else {
                $split = 1;
            }
            $key = NULL;
            for ($j = 0; $j < $split; $j++, $i++) {
                $key .= $str[$i];
            }
            array_push($array, $key);
        }
        return $array;
    }

    /**
     * Функция вырезки всех лишних символов
     * @param <type> $str
     * @return <type>
     */
    function clearstr($str) {
        $sru = 'ёйцукенгшщзхъфывапролджэячсмитьбю';
        $s1 = array_merge(self::utf8_str_split($sru), self::utf8_str_split(strtoupper($sru)), range('A', 'Z'), range('a', 'z'), range('0', '9'), array('&', ' ', '#', ';', '%', '?', ':', '(', ')', '-', '_', '=', '+', '[', ']', ',', '.', '/'));
        $codes = array();
        for ($i = 0; $i < count($s1); $i++) {
            $codes[] = ord($s1[$i]);
        }
        $str_s = self::utf8_str_split($str);
        for ($i = 0; $i < count($str_s); $i++) {
            if (!in_array(ord($str_s[$i]), $codes)) {
                $str = str_replace($str_s[$i], '', $str);
            }
        }
        return $str;
    }

    function pagination_text($total, $page, $url) {
        if ($page != 1) {
            $pervpage = ' <li><a href= "' . $url . 'page=' . ($page - 1) . '"><i class="fa fa-angle-left"></i></a></li> ';
        }
// Проверяем нужны ли стрелки вперед 
        if ($page != $total) {
            $nextpage = ' <li><a href="' . $url . 'page=' . ($page + 1) . '"><i class="fa fa-angle-right"></i></a></li>';
        }
        if ($page - 4 > 0) {
            $first = '<li><a href="' . $url . 'page=1">1</a><a>...</a></li>';
        }
        if ($page + 4 <= $total) {
            $last = '<li><a>...</a><a href="' . $url . 'page=' . $total . '">' . $total . '</a></li>';
        }
// Находим две ближайшие станицы с обоих краев, если они есть 
        if ($page - 2 > 0) {
            $page2left = ' <li><a href= "' . $url . 'page=' . ($page - 2) . '">' . ($page - 2) . '</a></li> ';
        }
        if ($page - 1 > 0) {
            $page1left = '<li><a href= "' . $url . 'page=' . ($page - 1) . '">' . ($page - 1) . '</a></li> ';
        }
        if ($page + 2 <= $total) {
            $page2right = ' <li><a href= "' . $url . 'page=' . ($page + 2) . '">' . ($page + 2) . '</a></li>';
        }
        if ($page + 1 <= $total) {
            $page1right = ' <li><a href="' . $url . 'page=' . ($page + 1) . '">' . ($page + 1) . '</a></li>';
        }
        return $pervpage . $first . $page2left . $page1left . '<li class="active"><a>' . $page . '</a></li>' . $page1right . $page2right . $last . $nextpage;
    }

}
