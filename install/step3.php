<?php

require '../app/core/classes/DB.php';
echo '<div class="pod"><div class="head"><h3>Импорт таблиц в базу данных</h3></div></div>';
chmod('../files/cache', 0777);
chmod('../files/download', 0777);
chmod('../files/news', 0777);
chmod('../files/upload', 0777);
chmod('../files/user', 0777);

$error = '';
set_magic_quotes_runtime(0);
// Читаем SQL файл и заносим его в базу данных
$query = fread(fopen('install.sql', 'r'), filesize('install.sql'));
$pieces = split_sql($query);
for ($i = 0; $i < count($pieces); $i++) {
    $pieces[$i] = trim($pieces[$i]);
    if (!empty($pieces[$i]) && $pieces[$i] != "#") {
        if (!DB::run($pieces[$i])) {
            $error = $error . DB::$pdo->error() . '<br />';
        }
    }
}


if (empty($error)) {
    echo '<font color="green">Oк</font> - Таблицы созданы. Права на папки установлены.<br/>
	    <p><a class="btn btn-default" href="index.php?step=4">Продолжить установку</a></p>';
} else {
    // Если были ошибки, выводим их
    echo $error;
    echo '<br /><font color="red">Error!</font><br />При создании таблиц возникла ошибка.<br />Продолжение невозможно.';
}