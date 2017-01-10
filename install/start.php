<?php

echo '<div class="pod"><div class="head"><h3>Добро пожаловать в мастер установки VCMS, версия ' . $cms . '</h3></div></div>';
echo '<div class="pod"><div class="head"><h4>Перед началом установки рекомендуем ознакомиться с лицензионным соглашением:</h4></div></div>';
$license = file_get_contents('../license.txt');
echo '<textarea rows="15" class="form-control">' . $license . '</textarea>';
echo '<a href="index.php?step=1" class="btn btn-default">Начать установку</a> <a href="http://vcms.su" class="btn btn-default">Отменить</a>';
