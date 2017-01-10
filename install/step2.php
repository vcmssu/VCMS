<?php

echo '<div class="pod"><div class="head"><h3>Настройка подключения к MySQL</h3></div></div>';
if ($_POST['ok']) {
    $hostbd = trim($_POST['host']);
    $nameuser = trim($_POST['user']);
    $userpass = trim($_POST['pass']);
    $namebd = trim($_POST['bd']);

    if (empty($hostbd)) {
        $error .= 'Не указан адрес сервера!<br/>';
    }

    if (empty($nameuser)) {
        $error .= 'Не указано имя пользователя!<br/>';
    }

    if (empty($userpass)) {
        $error .= 'Не указан пароль пользователя!<br/>';
    }

    if (empty($namebd)) {
        $error .= 'Не указано название базы данных!<br/>';
    }

    if ($hostbd && $nameuser && $userpass && $namebd) {
        $dsn = "mysql:host=$hostbd;dbname=$namebd";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO:: MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        );
        try {
            $pdo = new PDO($dsn, $nameuser, $userpass, $opt);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    if (!isset($error)) {
        $text = "<?php\r\n\r\n$" . "hostbd=\"$hostbd\";\r\n" . "$" . "nameuser=\"$nameuser\";\r\n" . "$" . "userpass=\"$userpass\";\r\n" . "$" . "namebd=\"$namebd\";\r\n"
                . "\r\n";
        $fp = fopen("../app/core/inc.php", "w");
        fputs($fp, $text);
        fclose($fp);
        header('location: index.php?step=3');
    }
}

if (isset($error)) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
echo '<form action="index.php?step=2" method=' . htmlspecialchars("post") . '>
<p>*Адрес сервера, обычно localhost: <br/><input class="form-control" type="text" name="host" size="100" value="localhost"></p>';
echo '<p>*Имя пользователя: <br/><input class="form-control" type="text" name="user" size="100" value="' . htmlspecialchars($_POST['user']) . '"></p>';
echo '<p>*MySQL пароль: <br/><input class="form-control" type="text" name="pass" size="100" value="' . htmlspecialchars($_POST['pass']) . '"></p>';
echo '<p>*Название базы: <br/><input class="form-control" type="text" name="bd" size="100" value="' . htmlspecialchars($_POST['bd']) . '"></p>';
echo '<input type="submit" value="Продолжить" name="ok" class="btn btn-default"></form>';
