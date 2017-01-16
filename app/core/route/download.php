<?php

/* ЗЦ */
$router->add('download', '/download', 'DownloadController:index', 'GET|POST');
$router->add('download_id', '/download/(id:num)', 'DownloadController:index', 'GET|POST');
$router->add('download_up', '/download/setup/up/(id:num)/(id2:num)', 'DownloadController:up');
$router->add('download_down', '/download/setup/down/(id:num)/(id2:num)', 'DownloadController:down');
$router->add('download_setup', '/download/setup/(id:num)', 'DownloadController:setup', 'GET|POST');
$router->add('download_setup_del', '/download/setup/del/(id:num)', 'DownloadController:del_category', 'GET|POST');
$router->add('download_edit', '/download/edit/(id:num)', 'DownloadController:edit', 'GET|POST');
$router->add('download_del', '/download/del/(id:num)', 'DownloadController:del', 'GET|POST');
$router->add('download_view', '/download/(id:num)-(a:all)', 'DownloadController:view');
$router->add('download_comments', '/download/comments/(id:num)', 'DownloadController:comments', 'GET|POST');
$router->add('download_comments_edit', '/download/edit/comments/(id:num)', 'DownloadController:edit_comments', 'GET|POST');
$router->add('download_comments_del', '/download/del/comments/(id:num)', 'DownloadController:del_comments', 'GET|POST');
$router->add('download_load', '/download/load/(id:num)', 'DownloadController:load', 'GET|POST');
$router->add('download_file', '/download/file/(id:num)', 'DownloadController:file', 'GET|POST');
$router->add('download_new', '/download/new', 'DownloadController:newfile');
$router->add('download_top', '/download/top', 'DownloadController:top');
$router->add('download_search', '/download/search', 'DownloadController:search', 'GET|POST');
$router->add('download_search_result', '/download/search/(a:any)', 'DownloadController:search', 'GET|POST');
$router->add('download_moderation', '/download/moderation', 'DownloadController:moderation');
$router->add('download_moderation_yes', '/download/moderation/yes/(id:num)', 'DownloadController:moderation_yes');
