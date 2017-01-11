<?php

class BBcode {

    function bb($text) {
        $bbcode = array(
            '/\[quote\](.*?)\[\/quote\]/s' => '<blockquote>$1</blockquote>',
            '/\[code](.+)\[\/code]/isU' => '<div class="code">$1</div>',
            '/\[b](.+)\[\/b]/isU' => '<strong>$1</strong>',
            '/\[i](.+)\[\/i]/isU' => '<em>$1</em>',
            '/\[u](.+)\[\/u]/isU' => '<u>$1</u>',
            '/\[s](.+)\[\/s]/isU' => '<s>$1</s>',
            '%\[img\]\b([\w-]+://[^\s()<>\[\]]+\.(jpg|png|gif|jpeg))\[/img\]%s' => '<img src="$1" class="img-responsive" alt="image"/>',
            '/\[url\=(.*?)\](.*?)\[\/url\]/s' => '<noindex><a rel="nofollow" href="$1">$2</a></noindex>',
            '/\[size=(.+)](.+)\[\/size]/isU' => '<span style="font-size:$1px">$2</span>',
            '/\[center](.+)\[\/center]/isU' => '<div style="text-align: center;">$1</div>',
            '/\[color=(.+)](.+)\[\/color]/isU' => '<span style="color:$1">$2</span>',
            '/^[http|https]+:\/\/(?:www\.)?(?:youtube.com)\/(?:watch\?(?=.*v=([\w\-]+))(?:\S+)?|([\w\-]+))$/' => '<iframe width="100%" height="320" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
            '/[http|https]+:\/\/(?:www\.|)youtu\.be\/([a-zA-Z0-9_\-]+)/i' => '<iframe width="100%" height="320" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
            '/(?:https:\/\/)?(?:www\.)?vimeo\.com\/(\d{1,10})/i' => '<iframe width="100%" height="320" src="http://player.vimeo.com/video/$1" frameborder="0" allowfullscreen mozallowfullscreen webkitallowfullscreen></iframe>',
            '/[http|https]+:\/\/(?:www\.|)rutube\.ru\/video\/embed\/([a-zA-Z0-9_\-]+)/i' => '<iframe width="100%" height="320" src="//rutube.ru/play/embed/$1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>',
            '/[http|https]+:\/\/(?:www\.|)rutube\.ru\/tracks\/([a-zA-Z0-9_\-]+)(&.+)?/i' => '<iframe width="100%" height="320" src="//rutube.ru/play/embed/$1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>',
            '/[http|https]+:\/\/(?:www\.|)rutube\.ru\/video\/([a-zA-Z0-9_\-]+)\//i' => '<iframe width="100%" height="320" src="//rutube.ru/play/embed/$1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>');
        return preg_replace(array_keys($bbcode), array_values($bbcode), $text);
    }

    function smiles($t) {
        $home = Cms::setup('home');
        $querysmiles = DB::run("SELECT * FROM `smiles` ORDER BY `id` ASC");
        while ($rowsmiles = $querysmiles->fetch(PDO::FETCH_ASSOC)) {
            $code[] = $rowsmiles['code'];
            $smile_url[] = '<img src="' . $home . '/files/smiles/' . $rowsmiles['photo'] . '" alt="smile" title="' . $rowsmiles['photo'] . '" />';
        }
        $t = str_replace($code, $smile_url, $t);
        return $t;
    }

    function delsmiles($t) {
        $home = Cms::setup('home');
        $querysmiles = DB::run("SELECT * FROM `smiles` ORDER BY `id` ASC");
        while ($rowsmiles = $querysmiles->fetch(PDO::FETCH_ASSOC)) {
            $code[] = $rowsmiles['code'];
        }
        $t = str_replace($code, '', $t);
        return $t;
    }

    function delete($text) {
        $text = self::delsmiles($text);
        $bbcode = array(
            '/\[quote\](.*?)\[\/quote\]/s' => '',
            '/\[code](.+)\[\/code]/isU' => '',
            '/\[b](.+)\[\/b]/isU' => '$1',
            '/\[i](.+)\[\/i]/isU' => '$1',
            '/\[u](.+)\[\/u]/isU' => '$1',
            '/\[s](.+)\[\/s]/isU' => '$1',
            '%\[img\]\b([\w-]+://[^\s()<>\[\]]+\.(jpg|png|gif|jpeg))\[/img\]%s' => '',
            '/\[url\=(.*?)\](.*?)\[\/url\]/s' => '',
            '/\[size=(.+)](.+)\[\/size]/isU' => '$1',
            '/\[center](.+)\[\/center]/isU' => '$1',
            '/\[color=(.+)](.+)\[\/color]/isU' => '',
            '/^[http|https]+:\/\/(?:www\.)?(?:youtube.com)\/(?:watch\?(?=.*v=([\w\-]+))(?:\S+)?|([\w\-]+))$/' => '',
            '/[http|https]+:\/\/(?:www\.|)youtu\.be\/([a-zA-Z0-9_\-]+)/i' => '',
            '/(?:https:\/\/)?(?:www\.)?vimeo\.com\/(\d{1,10})/i' => '',
            '/[http|https]+:\/\/(?:www\.|)rutube\.ru\/video\/embed\/([a-zA-Z0-9_\-]+)/i' => '',
            '/[http|https]+:\/\/(?:www\.|)rutube\.ru\/tracks\/([a-zA-Z0-9_\-]+)(&.+)?/i' => '',
            '/[http|https]+:\/\/(?:www\.|)rutube\.ru\/video\/([a-zA-Z0-9_\-]+)\//i' => '');
        return preg_replace(array_keys($bbcode), array_values($bbcode), $text);
    }

}
