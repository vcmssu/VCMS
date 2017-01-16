<?php

/* пользовательская часть */
$router->add('user_exit', '/user/exit', 'UserController:logout');
$router->add('user_login', '/user/login', 'UserController:login', 'GET|POST');
$router->add('user_signup', '/user/signup', 'UserController:signup', 'GET|POST');
$router->add('user_lostpass', '/user/lostpass', 'UserController:lostpass', 'GET|POST');
$router->add('user_reset', '/user/reset/(id:num)/(a:any)', 'UserController:lostpass');
$router->add('user_activation', '/user/activation/(id:num)/(a:any)', 'UserController:activation');
$router->add('user_id', '/id(id:num)', 'UserController:index');
$router->add('user', '/users', 'UserController:users');
$router->add('user_admin', '/users/admin', 'UserController:users_admin');
$router->add('user_ban', '/user/ban', 'UserController:ban');
