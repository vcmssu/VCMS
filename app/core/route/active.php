<?php

/* активность на сайте */
$router->add('active_guest', '/active/guest/(id:num)', 'ActiveController:guest');
$router->add('active_thems', '/active/thems/(id:num)', 'ActiveController:thems');
$router->add('active_posts', '/active/posts/(id:num)', 'ActiveController:posts');
$router->add('active_download', '/active/download/(id:num)', 'ActiveController:download');
$router->add('active_blogs', '/active/blogs/(id:num)', 'ActiveController:blogs');
$router->add('active_news_comments', '/active/news/comments/(id:num)', 'ActiveController:news_comments');
$router->add('active_download_comments', '/active/download/comments/(id:num)', 'ActiveController:download_comments');
$router->add('active_blogs_comments', '/active/blogs/comments/(id:num)', 'ActiveController:blogs_comments');
$router->add('active_gallery', '/active/gallery/(id:num)', 'ActiveController:gallery');
$router->add('active_library', '/active/library/(id:num)', 'ActiveController:library');
$router->add('active_library_comments', '/active/library/comments/(id:num)', 'ActiveController:library_comments');
