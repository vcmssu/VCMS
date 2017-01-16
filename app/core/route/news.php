<?php

/* новости */
$router->add('news', '/news', 'NewsController:index');
$router->add('news_all', '/news/all', 'NewsController:all');
$router->add('news_view', '/news/(id:num)-(b:any)', 'NewsController:view');
$router->add('news_add', '/news/add', 'NewsController:add', 'GET|POST');
$router->add('news_edit', '/news/edit/(id:num)', 'NewsController:edit', 'GET|POST');
$router->add('news_del', '/news/del/(id:num)', 'NewsController:del', 'GET|POST');
$router->add('news_comments', '/news/comments/(id:num)', 'NewsController:comments', 'GET|POST');
$router->add('news_edit_comments', '/news/edit/comments/(id:num)', 'NewsController:edit_comments', 'GET|POST');
$router->add('news_del_comments', '/news/del/comments/(id:num)', 'NewsController:del_comments', 'GET|POST');
$router->add('news_mail', '/news/mail/(id:num)', 'NewsController:mail', 'GET|POST');
