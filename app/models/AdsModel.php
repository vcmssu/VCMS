<?php

class AdsModel {

    function view($id) {
        $row = DB::run("SELECT * FROM `ads` WHERE `id`='" . $id . "'")->fetch(PDO::FETCH_ASSOC);
        if (is_file(HOME.'/app/lib/sypex/SxGeo.php') && is_file(HOME.'/app/lib/sypex/SxGeoCity.dat')) {
            require_once HOME . '/app/lib/sypex/SxGeo.php';
            $SxGeo = new SxGeo(HOME . '/app/lib/sypex/SxGeoCity.dat');
            $stat = $SxGeo->getCityFull(Recipe::getClientIP());
            //записываем в бд для статистики переходов
            DB::run("INSERT INTO `ads_stat` SET 
                `id_link` = '" . $row['id'] . "', 
                    `ip` = '" . Cms::Input(Recipe::getClientIP()) . "', 
                        `country` = '" . Cms::Input($stat['country']['name_ru']) . "',
                            `browser` = '" . Cms::Input(Recipe::getBrowser()) . "', 
                                `region` = '" . Cms::Input($stat['region']['name_ru']) . "',
                                    `city` = '" . Cms::Input($stat['city']['name_ru']) . "', 
                                        `lat` = '" . Cms::Input($stat['city']['lat']) . "', 
                                            `lng` = '" . Cms::Input($stat['city']['lon']) . "',
                                                `referer` = '" . Cms::Input($_SERVER['HTTP_REFERER']) . "', 
                                                    `time` = '" . Cms::realtime() . "'");
        } else {
            //записываем в бд для статистики переходов
            DB::run("INSERT INTO `ads_stat` SET 
                `id_link` = '" . $row['id'] . "', 
                    `ip` = '" . Cms::Input(Recipe::getClientIP()) . "', 
                        `browser` = '" . Cms::Input(Recipe::getBrowser()) . "', 
                            `referer` = '" . Cms::Input($_SERVER['HTTP_REFERER']) . "', 
                                `time` = '" . Cms::realtime() . "'");
        }
        if ($row['count'] > 0) {
            DB::run("UPDATE `ads` SET `count` = '" . intval($row['count'] - 1) . "' WHERE `id` = '" . $row['id'] . "' AND `count`>'0'");
        }
        //и отправляем по рекламной ссылке
        Functions::redirect($row['link']);
    }

}
