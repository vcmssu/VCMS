<?php

//обработка ссылок kWHTgn2b
function smarty_modifier_link($text) {
    $text = preg_replace('/(?<!href=")(http\:\/\/[^ <]+)(?!=<\/a>)/Dui', '<noindex><a rel="nofollow" href="$1" target="_blank" title="Перейти по ссылке ' . $text . '">$1</a></noindex>', $text);
    $text = preg_replace('/(?<!href=")(https\:\/\/[^ <]+)(?!=<\/a>)/Dui', '<noindex><a rel="nofollow" href="$1" target="_blank" title="Перейти по ссылке ' . $text . '">$1</a></noindex>', $text);
    return $text;
}

?>