<?php

/* форум */
$router->add('forum', '/forum', 'ForumController:index');
$router->add('forum_id', '/forum/(id:num)', 'ForumController:index');
$router->add('forum_id2', '/forum/(id:num)/(id2:num)', 'ForumController:forum');
$router->add('forum_add', '/forum/setup/add', 'ForumController:add_forum', 'GET|POST');
$router->add('forum_add_id', '/forum/setup/add/(id:num)', 'ForumController:add_forum', 'GET|POST');
$router->add('forum_setup', '/forum/setup/(id:num)', 'ForumController:setup', 'GET|POST');
$router->add('forum_setup_del', '/forum/setup/del/(id:num)', 'ForumController:setup_del', 'GET|POST');
$router->add('forum_tema_closed', '/forum/setup/tema/closed/(id:num)', 'ForumController:closed');
$router->add('forum_tema_open', '/forum/setup/tema/open/(id:num)', 'ForumController:open');
$router->add('forum_tema_up', '/forum/setup/tema/up/(id:num)', 'ForumController:tema_up');
$router->add('forum_tema_down', '/forum/setup/tema/down/(id:num)', 'ForumController:tema_down');
$router->add('forum_tema_setup', '/forum/setup/tema/(id:num)', 'ForumController:tema_setup', 'GET|POST');
$router->add('forum_tema_del', '/forum/setup/tema/del/(id:num)', 'ForumController:tema_del', 'GET|POST');
$router->add('forum_post_setup', '/forum/setup/post/(id:num)', 'ForumController:post_setup', 'GET|POST');
$router->add('forum_post_del', '/forum/setup/post/del/(id:num)', 'ForumController:post_del', 'GET|POST');
$router->add('forum_post_reply', '/forum/(id:num)/(id2:num)/(id3:num)/reply/(id4:num)', 'ForumController:post_reply', 'GET|POST');
$router->add('forum_post_quote', '/forum/(id:num)/(id2:num)/(id3:num)/quote/(id4:num)', 'ForumController:post_quote', 'GET|POST');
$router->add('forum_post', '/forum/(id:num)/(id2:num)/(id3:num)/post/(id4:num)', 'ForumController:post');
$router->add('forum_add_theme', '/forum/(id:num)/(id2:num)/add', 'ForumController:add', 'GET|POST');
$router->add('forum_theme', '/forum/(id:num)/(id2:num)/(id3:num)', 'ForumController:theme', 'GET|POST');
$router->add('forum_load_file', '/forum/(id:num)/(id2:num)/(id3:num)/load/(id4:num)', 'ForumController:load');
$router->add('forum_up', '/forum/setup/up/(id:num)/(id2:num)', 'ForumController:up');
$router->add('forum_down', '/forum/setup/down/(id:num)/(id2:num)', 'ForumController:down');
$router->add('forum_new_thems', '/forum/new/thems', 'ForumController:new_thems');
$router->add('forum_new_posts', '/forum/new/posts', 'ForumController:new_posts');
$router->add('forum_search', '/forum/search', 'ForumController:search', 'GET|POST');
$router->add('forum_search_result', '/forum/search/(a:any)', 'ForumController:search', 'GET|POST');
$router->add('forum_theme_files', '/forum/(id:num)/(id2:num)/(id3:num)/files', 'ForumController:files', 'GET|POST');
$router->add('forum_theme_vote', '/forum/(id:num)/(id2:num)/(id3:num)/vote', 'ForumController:vote', 'GET|POST');
$router->add('forum_theme_vote_edit', '/forum/(id:num)/(id2:num)/(id3:num)/vote/edit', 'ForumController:vote_edit', 'GET|POST');
$router->add('forum_theme_vote_del', '/forum/(id:num)/(id2:num)/(id3:num)/vote/del', 'ForumController:vote_del', 'GET|POST');
$router->add('forum_theme_vote_all', '/forum/(id:num)/(id2:num)/(id3:num)/vote/all', 'ForumController:vote_all');
