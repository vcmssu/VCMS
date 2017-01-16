<?php

//функция времени

function smarty_modifier_times($var) {
    $pl = function ($int, $arr) {
        if ($int > 10 && $int < 15) {
            $out = ' ' . $arr[2];
        } else {
            if (($int % 10) == 1) {
                $out = ' ' . $arr[0];
            } elseif (($int % 10) > 1 && ($int % 10) < 5) {
                $out = ' ' . $arr[1];
            } else {
                $out = ' ' . $arr[2];
            }
        }

        return $int . $out;
    };

    $label = time() - $var;

    $w = 'секунд';
    $arrSec = [$w . 'у', $w . 'ы', $w];
    $w = 'минут';
    $arrMin = [$w . 'у', $w . 'ы', $w];
    $w = 'час';
    $arrHour = [$w, $w . 'а', $w . 'ов'];
    $w = 'дн';
    $arrDays = ['день', $w . 'я', $w . 'ей'];
    $w = 'месяц';
    $arrMonths = [$w, $w . 'а', $w . 'ев'];
    $back = ' назад';

    if ($label == 0) {
        $out = 'только что';
    } elseif ($label < 60) {
        $out = $pl($label, $arrSec) . $back;
    } elseif ($label < 3600) {
        $out = $pl(intval($label / 60), $arrMin) . $back;
    } elseif ($label < (3600 * 24)) {
        $out = $pl(intval($label / 3600), $arrHour) . $back;
    } elseif ($label < (3600 * 24 * date('t'))) {
        $out = $pl(intval($label / (3600 * 24)), $arrDays) . $back;
    } elseif ($label < (3600 * 24 * (date('L') + 365))) {
        $out = $pl(intval($label / (3600 * 24 * 30)), $arrMonths) . $back;
    } else {
        $out = date('d.m.Y / H:i', $var);
    }

    return $out;
}
