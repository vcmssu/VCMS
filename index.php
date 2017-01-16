<?php

ini_set('display_errors', '1');
error_reporting(E_ERROR);

define('HOME', dirname(__FILE__));
define('APP', 'app/controllers/');
define('CORE', 'app/core/');
define('LIB', 'app/lib/');

require_once CORE . 'core.php'; // подключаем файлы ядра
define('TIMESTART', Functions::times_page()); //время генерации страницы
require_once CORE . 'route.php'; //карта ссылок роутера

/* сжимаем HTML, если включено */
if (Cms::setup('compress') == 1) {
    Recipe::compressPage();
} //среднее сжатие
if (Cms::setup('compress') == 2) {
    Recipe::compressPageMax();
} //максимальное сжатие

/* автоочистка */
Cms::AutoClear();
