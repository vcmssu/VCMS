<?

function smarty_modifier_bbcode($text) {
    $bbcode = array(
        '/\[quote](.+)\[\/quote]/isU' => '<blockquote>$1</blockquote>',
        '/\[code](.+)\[\/code]/isU' => '<div class="code">$1</div>',
        '/\[b](.+)\[\/b]/isU' => '<strong>$1</strong>',
        '/\[i](.+)\[\/i]/isU' => '<em>$1</em>',
        '/\[u](.+)\[\/u]/isU' => '<u>$1</u>',
        '/\[s](.+)\[\/s]/isU' => '<s>$1</s>',
        '%\[img\]\b([\w-]+://[^\s()<>\[\]]+\.(jpg|png|gif|jpeg))\[/img\]%s' => '<img src="$1" class="img-responsive" alt="image"/>',
        '/\[url\=(.*?)\](.*?)\[\/url\]/s' => '<noindex><a rel="nofollow" href="$1" target="_blank">$2</a></noindex>',
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

?>