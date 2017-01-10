<?php

require '../app/core/classes/DB.php';
echo '<div class="pod"><div class="head"><h3>Первоначальная настройка сайта</h3></div></div>';

if ($_POST['ok']) {
    $home = htmlspecialchars(trim($_POST['home']));
    $namesite = htmlspecialchars(trim($_POST['namesite']));
    $login = htmlspecialchars(trim($_POST['login']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    if (empty($home)) {
        $error .= 'Не указан адрес сайта!<br/>';
    }

    if (empty($namesite)) {
        $error .= 'Не указано название сайта!<br/>';
    }

    if (mb_strlen($login) < 3 || mb_strlen($login) > 32) {
        $error .= 'Недопустимая длина логина!<br/>';
    }

    if ($login && !preg_match("#^([A-zА-я0-9\-\_\ ])+$#ui", $login)) {
        $error .= 'Специальные символы в логине запрещены!<br/>';
    }

    if ($login && !preg_match("#^[a-z0-9]+$#i", $login)) {
        $error .= 'В логине разрешены только символы a-z и цифры!<br/>';
    }

    if (mb_strlen($password) < 6 || mb_strlen($password) > 32) {
        $error .= 'Недопустимая длина пароля!<br/>';
    }

    if (mb_strlen($email) < 5 || mb_strlen($email) > 32) {
        $error .= 'Недопустимая длина e-mail!<br/>';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error .= 'Недопустимые символы в e-mail<br/>';
    }

    if (!isset($error)) {
//если нет ошибок - пишем в базу
        DB::run("UPDATE `setting` SET `value` = '" . htmlspecialchars($home) . "' WHERE `name`='home'");
        DB::run("UPDATE `setting` SET `value` = '" . htmlspecialchars($namesite) . "' WHERE `name`='namesite'");
        DB::run("UPDATE `setting` SET `value` = '" . htmlspecialchars($cms) . "' WHERE `name`='version'");

        DB::run("INSERT INTO `users` SET 
                    `login` = '" . $login . "', 
                        `email` = '" . $email . "', 
                            `pass` = '" . crypt($password, '$6$rounds=5000$usesomesillystringforsalt$') . "', 
                                `hashcode` = '" . crypt($password . '' . time(), '$6$rounds=5000$usesomesillystringforsalt$') . "', 
                                    `date_reg` =  '" . time() . "', 
                                        `date_last` =  '" . time() . "'");

        $fid = DB::$pdo->lastInsertId();

        DB::run("UPDATE `users` SET `level` = '100' WHERE `id`='" . $fid . "'");

        //создаём нужные папки
        mkdir('../files/user/' . $fid);
        mkdir('../files/user/' . $fid . '/files');
        mkdir('../files/user/' . $fid . '/forum');
        mkdir('../files/user/' . $fid . '/gallery');

        setcookie('id_user', $fid, time() + 60 * 60 * 24 * 3, '/');
        setcookie('hashcode', crypt($password . '' . time(), '$6$rounds=5000$usesomesillystringforsalt$'), time() + 60 * 60 * 24 * 3, '/');
//удаляем папку инсталятора
        delcat('../install');
        header('location: /admin');
    }
}

if (isset($error)) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
echo '<form action="index.php?step=4" method=' . htmlspecialchars("post") . '>'
 . '<p>*Ссылка на главную страницу сайта, с http://: <br/><input class="form-control" type="text" name="home" value="http://' . htmlspecialchars($_SERVER['HTTP_HOST']) . '"></p>
<p>*Название сайта: <br/><input  class="form-control"type="text" name="namesite" value="' . htmlspecialchars($_POST['namesite']) . '"></p>';
echo '<h4>Создание администратора</h4>';
echo '<p>*Логин: <br/><input  class="form-control" type="text" name="login" value="' . htmlspecialchars($_POST['login']) . '"></p>';
echo '<p>*E-mail: <br/><input  class="form-control" type="text" name="email" value="' . htmlspecialchars($_POST['email']) . '"></p>';
echo '<p>*Пароль: <br/><input  class="form-control" type="text" name="password" value="' . htmlspecialchars($_POST['password']) . '"></p>';
echo '<br/><input type="submit" value="Закончить установку" name="ok" class="btn btn-default"></form>';
