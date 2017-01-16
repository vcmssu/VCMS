<?php

/* библиотека */
$router->add('library', '/library', 'LibraryController:index');
$router->add('library_id', '/library/(id:num)', 'LibraryController:index');
$router->add('library_add', '/library/add', 'LibraryController:add', 'GET|POST');
$router->add('library_add_id', '/library/add/(id:num)', 'LibraryController:add', 'GET|POST');
$router->add('library_add_articles', '/library/add/articles/(id:num)', 'LibraryController:articles', 'GET|POST');
$router->add('library_view', '/library/(id:num)-(a:any)', 'LibraryController:view', 'GET|POST');
$router->add('library_category_edit', '/library/category/edit/(id:num)', 'LibraryController:category_edit', 'GET|POST');
$router->add('library_category_del', '/library/category/del/(id:num)', 'LibraryController:category_del', 'GET|POST');
$router->add('library_category_up', '/library/category/up/(id:num)/(id2:num)', 'LibraryController:up');
$router->add('library_category_down', '/library/category/down/(id:num)/(id2:num)', 'LibraryController:down');
$router->add('library_edit', '/library/edit/(id:num)', 'LibraryController:edit', 'GET|POST');
$router->add('library_del', '/library/del/(id:num)', 'LibraryController:del', 'GET|POST');
$router->add('library_comments', '/library/comments/(id:num)', 'LibraryController:comments', 'GET|POST');
$router->add('library_comments_edit', '/library/edit/comments/(id:num)', 'LibraryController:edit_comments', 'GET|POST');
$router->add('library_comments_del', '/library/del/comments/(id:num)', 'LibraryController:del_comments', 'GET|POST');
$router->add('library_top', '/library/top', 'LibraryController:top');
$router->add('library_search', '/library/search', 'LibraryController:search', 'GET|POST');
$router->add('library_search_result', '/library/search/(a:any)', 'LibraryController:search', 'GET|POST');
$router->add('library_txt', '/library/txt/(id:num)', 'LibraryController:txt');
