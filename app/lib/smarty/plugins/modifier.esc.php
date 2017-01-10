<?php

function smarty_modifier_esc($text) {
    $text = htmlspecialchars_decode(htmlspecialchars_decode($text));
    return $text;
}

?>