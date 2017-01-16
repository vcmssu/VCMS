<?php

/* блог, категории */
$router->add('blog', '/blogs', 'BlogsController:index');
$router->add('blog_top', '/blogs/top', 'BlogsController:top');
$router->add('blog_search', '/blogs/search', 'BlogsController:search', 'GET|POST');
$router->add('blog_search_result', '/blogs/search/(a:any)', 'BlogsController:search', 'GET|POST');
$router->add('blog_category', '/blogs/category', 'BlogsController:category', 'GET|POST');
$router->add('blog_category_add', '/blogs/category/add', 'BlogsController:category_add', 'GET|POST');
$router->add('blog_category_edit', '/blogs/category/edit/(id:num)', 'BlogsController:category_edit', 'GET|POST');
$router->add('blog_category_del', '/blogs/category/del/(id:num)', 'BlogsController:category_del', 'GET|POST');
$router->add('blog_category_up', '/blogs/category/up/(id:num)', 'BlogsController:up');
$router->add('blog_category_down', '/blogs/category/down/(id:num)', 'BlogsController:down');
$router->add('blog_category_id', '/blogs/(id:num)', 'BlogsController:category_id');
$router->add('blog_post', '/blogs/(id:num)/(id2:num)-(a:any)', 'BlogsController:post');
$router->add('blog_edit', '/blogs/edit/(id:num)', 'BlogsController:edit', 'GET|POST');
$router->add('blog_del', '/blogs/del/(id:num)', 'BlogsController:del', 'GET|POST');
$router->add('blog_comments', '/blogs/comments/(id:num)', 'BlogsController:comments', 'GET|POST');
$router->add('blog_comments_edit', '/blogs/edit/comments/(id:num)', 'BlogsController:edit_comments', 'GET|POST');
$router->add('blog_comments_del', '/blogs/del/comments/(id:num)', 'BlogsController:del_comments', 'GET|POST');
