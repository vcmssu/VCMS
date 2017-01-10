<?php

$php = phpversion();
$mysql = extension_loaded('mysql');
$pdo = extension_loaded('pdo');
$gd = extension_loaded('gd');
$zlib = extension_loaded('zlib');
$iconv = extension_loaded('iconv');
$mbstring = extension_loaded('mbstring');
$xml = extension_loaded('xml');
$XMLWriter = extension_loaded('XMLWriter');
$ffmpeg = extension_loaded('ffmpeg');

echo '<div class="pod"><div class="head"><h3>Проверка настроек PHP</h3></div></div>';
echo '<div class="list">Версия PHP: ' . $php;
if ($php > '5.4') {
    echo ' <font color="green">OK</font>';
} else {
    $error = 2;
    echo ' <font color="red">Версия PHP устаревшая и не поддерживается системой!</font>';
}
echo '</div>';

echo '<div class="list">MySQL: ';
if ($mysql == 1) {
    echo ' <font color="green">OK</font>';
} else {
    $error = 2;
    echo ' <font color="red">Ошибка! Расширение MySQL не загружено!</font>';
}
echo '</div>';

echo '<div class="list">PDO: ';
if ($pdo == 1) {
    echo ' <font color="green">OK</font>';
} else {
    $error = 2;
    echo ' <font color="red">Ошибка! Расширение PDO не загружено!</font>';
}
echo '</div>';

echo '<div class="list">GD: ';
if ($gd == 1) {
    echo ' <font color="green">OK</font>';
} else {
    $error = 2;
    echo ' <font color="red">Ошибка! Расширение GD не загружено!</font>';
}
echo '</div>';

echo '<div class="list">ZLIB: ';
if ($zlib == 1) {
    echo ' <font color="green">OK</font>';
} else {
    $error = 1;
    echo ' <font color="red">Ошибка! Расширение ZLIB не загружено!</font>';
}
echo '</div>';

echo '<div class="list">ICONV: ';
if ($iconv == 1) {
    echo ' <font color="green">OK</font>';
} else {
    $error = 1;
    echo ' <font color="red">Ошибка! Расширение ICONV не загружено!</font>';
}
echo '</div>';

echo '<div class="list">Mbstring: ';
if ($mbstring == 1) {
    echo ' <font color="green">OK</font>';
} else {
    $error = 1;
    echo ' <font color="red">Ошибка! Расширение mbstring не загружено!</font>';
}
echo '</div>';

echo '<div class="list">XML: ';
if ($xml == 1) {
    echo ' <font color="green">OK</font>';
} else {
    $error = 1;
    echo ' <font color="red">Ошибка! Расширение XML не загружено!</font>';
}
echo '</div>';

echo '<div class="list">XMLWriter: ';
if ($XMLWriter == 1) {
    echo ' <font color="green">OK</font>';
} else {
    $error = 1;
    echo ' <font color="red">Ошибка! Расширение XMLWriter не загружено!</font>';
}
echo '</div>';

echo '<div class="list">FFMPEG: ';
if ($ffmpeg == 1) {
    echo ' <font color="green">OK</font>';
} else {
    $error = 1;
    echo ' <font color="red">Ошибка! Расширение FFMPEG не загружено!</font>';
}
echo '</div>';

if (empty($error)) {
    echo '<a href="index.php?step=2" class="btn btn-default">Продолжить установку</a>';
}

if ($error == 1) {
    echo '<div class="alert alert-danger">Внимание! Имеются ошибки в конфигурации. Вы можете продолжить инсталляцию, однако нормальная работа системы не гарантируется.</div><a href="index.php?step=2" class="btn btn-default">Продолжить установку</a>';
}

if ($error == 2) {
    echo '<div class="alert alert-danger">Внимание! Имеются критические ошибки. Вы не можете продолжить установку пока их не устраните.</div><a href="index.php?step=1" class="btn btn-default">Обновить данные</a>';
}

