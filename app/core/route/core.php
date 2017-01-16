<?php

/* сайт */
$router->add('home', '/', 'MainController:index');
$router->add('captcha', '/captcha', 'MainController:captcha');
$router->add('preview', '/bbcode/ajax', 'MainController:bbcode_ajax', 'POST');
$router->add('online', '/online', 'MainController:online');
$router->add('online_guest', '/online/guest', 'MainController:guest');
$router->add('smiles', '/smiles', 'MainController:smiles', 'GET|POST');
$router->add('smiles_my', '/smiles/my', 'MainController:smiles_my', 'GET|POST');
$router->add('bbcode', '/bbcode', 'MainController:bbcode');

/* гостевая */
$router->add('guest', '/guest', 'GuestController:index', 'GET|POST');
$router->add('guest_edit', '/guest/edit/(id:num)', 'GuestController:edit', 'GET|POST');
$router->add('guest_del', '/guest/del/(id:num)', 'GuestController:del', 'GET|POST');

/* текстовая страница */
$router->add('pages', '/pages/(id:num)-(a:any)', 'PagesController:index');

/* реклама */
$router->add('ads', '/go/(id:num)', 'AdsController:index');
