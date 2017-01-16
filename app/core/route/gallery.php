<?php

/* галерея */
$router->add('gallery', '/gallery', 'GalleryController:index');
$router->add('gallery_id', '/gallery/(id:num)', 'GalleryController:index');
$router->add('gallery_photo', '/gallery/(id:num)/(id2:num)', 'GalleryController:photo');
$router->add('gallery_load', '/gallery/load/(id:num)', 'GalleryController:load');
$router->add('gallery_top', '/gallery/top', 'GalleryController:top');
$router->add('gallery_albums', '/gallery/albums', 'GalleryController:albums');
$router->add('gallery_edit_album', '/gallery/album/edit/(id:num)', 'GalleryController:edit_album', 'GET|POST');
$router->add('gallery_del_album', '/gallery/album/del/(id:num)', 'GalleryController:del_album', 'GET|POST');
$router->add('gallery_edit', '/gallery/edit/(id:num)', 'GalleryController:edit', 'GET|POST');
$router->add('gallery_del', '/gallery/del/(id:num)', 'GalleryController:del', 'GET|POST');
