<?php
function smarty_modifier_video($text){
 global $setup;
$bbcode = array(
    '/^[http|https]+:\/\/(?:www\.)?(?:youtube.com)\/(?:watch\?(?=.*v=([\w\-]+))(?:\S+)?|([\w\-]+))$/' => '<iframe width="'.$setup['playerwidth'].'" height="'.$setup['playerheight'].'" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
    '/[http|https]+:\/\/(?:www\.|)youtu\.be\/([a-zA-Z0-9_\-]+)/i' => '<iframe width="'.$setup['playerwidth'].'" height="'.$setup['playerheight'].'" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
    '/(?:https:\/\/)?(?:www\.)?vimeo\.com\/(\d{1,10})/i' => '<iframe width="'.$setup['playerwidth'].'" height="'.$setup['playerheight'].'" src="http://player.vimeo.com/video/$1" frameborder="0" allowfullscreen mozallowfullscreen webkitallowfullscreen></iframe>',
    '/[http|https]+:\/\/(?:www\.|)rutube\.ru\/video\/embed\/([a-zA-Z0-9_\-]+)/i' => '<iframe width="'.$setup['playerwidth'].'" height="'.$setup['playerheight'].'" src="//rutube.ru/play/embed/$1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>',
    '/[http|https]+:\/\/(?:www\.|)rutube\.ru\/tracks\/([a-zA-Z0-9_\-]+)(&.+)?/i' => '<iframe width="'.$setup['playerwidth'].'" height="'.$setup['playerheight'].'" src="//rutube.ru/play/embed/$1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>',
    '/[http|https]+:\/\/(?:www\.|)rutube\.ru\/video\/([a-zA-Z0-9_\-]+)\//i' => '<iframe width="'.$setup['playerwidth'].'" height="'.$setup['playerheight'].'" src="//rutube.ru/play/embed/$1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>');
 	return preg_replace(array_keys($bbcode),array_values($bbcode),$url);    
}
?>