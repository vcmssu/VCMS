<?php

/* профиль */
$router->add('profile', '/profile', 'ProfileController:index');
$router->add('profile_my', '/profile/my', 'ProfileController:my', 'GET|POST');
$router->add('profile_setup', '/profile/setup', 'ProfileController:setup', 'GET|POST');
$router->add('profile_security', '/profile/security', 'ProfileController:security', 'GET|POST');
$router->add('profile_history', '/profile/history', 'ProfileController:history');
$router->add('profile_notice', '/profile/notice', 'ProfileController:notice');
$router->add('profile_notice_clear', '/profile/notice/clear', 'ProfileController:notice_clear', 'GET|POST');
$router->add('profile_bookmark', '/profile/bookmark', 'ProfileController:bookmark');
$router->add('profile_bookmark_add', '/profile/bookmark/add?(a:all)', 'ProfileController:bookmark_add');
$router->add('profile_bookmark_edit', '/profile/bookmark/edit/(id:num)', 'ProfileController:bookmark_edit', 'GET|POST');
$router->add('profile_bookmark_del', '/profile/bookmark/del/(id:num)', 'ProfileController:bookmark_del', 'GET|POST');
$router->add('profile_mail', '/profile/mail', 'ProfileController:mail');
$router->add('profile_mail_id', '/profile/mail/(id:num)', 'ProfileController:mail_id', 'GET|POST');
$router->add('profile_mail_load', '/profile/mail/load/(id:num)', 'ProfileController:mail_load');
$router->add('profile_blacklist', '/profile/blacklist', 'ProfileController:blacklist');
$router->add('profile_blacklist_add', '/profile/blacklist/add/(id:num)', 'ProfileController:blacklist_add');
$router->add('profile_blacklist_del', '/profile/blacklist/del/(id:num)', 'ProfileController:blacklist_del');
$router->add('profile_friends', '/profile/friends', 'ProfileController:friends');
$router->add('profile_friends_add', '/profile/friends/add/(id:num)', 'ProfileController:friends_add');
$router->add('profile_friends_del', '/profile/friends/del/(id:num)', 'ProfileController:friends_del');
$router->add('profile_friends_yes', '/profile/friends/yes/(id:num)', 'ProfileController:friends_yes');
$router->add('profile_blog', '/profile/blog', 'ProfileController:blog');
$router->add('profile_blog_add', '/profile/blog/add', 'ProfileController:blog_add', 'GET|POST');
$router->add('profile_blog_edit', '/profile/blog/edit/(id:num)', 'ProfileController:blog_edit', 'GET|POST');
$router->add('profile_blog_del', '/profile/blog/del/(id:num)', 'ProfileController:blog_del', 'GET|POST');
$router->add('profile_gallery', '/profile/gallery', 'ProfileController:gallery');
$router->add('profile_gallery_add', '/profile/gallery/add', 'ProfileController:gallery_add', 'GET|POST');
$router->add('profile_gallery_id', '/profile/gallery/(id:num)', 'ProfileController:gallery', 'GET|POST');
$router->add('profile_gallery_add_photo', '/profile/gallery/(id:num)/add', 'ProfileController:gallery_add_photo', 'GET|POST');
$router->add('profile_gallery_edit_album', '/profile/gallery/edit/album/(id:num)', 'ProfileController:gallery_edit_album', 'GET|POST');
$router->add('profile_gallery_del_album', '/profile/gallery/del/album/(id:num)', 'ProfileController:gallery_del_album', 'GET|POST');
$router->add('profile_gallery_edit', '/profile/gallery/edit/(id:num)', 'ProfileController:gallery_edit', 'GET|POST');
$router->add('profile_gallery_del', '/profile/gallery/del/(id:num)', 'ProfileController:gallery_del', 'GET|POST');
$router->add('profile_library', '/profile/library', 'ProfileController:library');
$router->add('profile_library_edit', '/profile/library/edit/(id:num)', 'ProfileController:library_edit', 'GET|POST');
$router->add('profile_library_del', '/profile/library/del/(id:num)', 'ProfileController:library_del', 'GET|POST');
$router->add('profile_files', '/profile/files', 'ProfileController:files');
