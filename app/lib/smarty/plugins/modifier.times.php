<?php

//функция времени

function smarty_modifier_times($time = NULL) {
    if ($time == NULL)
        $time = time();
    $timep = "" . date("j M, Y года, H:i", $time) . "";
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

?>