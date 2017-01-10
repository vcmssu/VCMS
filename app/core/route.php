<?php

try {

    $router = new Router(Functions::GET_HTTP_HOST());
    $admin = Cms::setup('adminpanel');

    /* сайт */
    $router->add('home', '/', 'MainController:index');
    $router->add('captcha', '/captcha', 'MainController:captcha');
    $router->add('preview', '/bbcode/ajax', 'MainController:bbcode_ajax', 'POST');
    $router->add('online', '/online', 'MainController:online');
    $router->add('online_guest', '/online/guest', 'MainController:guest');
    $router->add('smiles', '/smiles', 'MainController:smiles', 'GET|POST');
    $router->add('smiles_my', '/smiles/my', 'MainController:smiles_my', 'GET|POST');
    $router->add('bbcode', '/bbcode', 'MainController:bbcode');

    $router->add('test', '/test', 'MainController:test');

    /* пользовательская часть */
    $router->add('user_exit', '/user/exit', 'UserController:logout');
    $router->add('user_login', '/user/login', 'UserController:login', 'GET|POST');
    $router->add('user_signup', '/user/signup', 'UserController:signup', 'GET|POST');
    $router->add('user_lostpass', '/user/lostpass', 'UserController:lostpass', 'GET|POST');
    $router->add('user_reset', '/user/reset/(id:num)/(a:any)', 'UserController:lostpass');
    $router->add('user_activation', '/user/activation/(id:num)/(a:any)', 'UserController:activation');
    $router->add('user_id', '/id(id:num)', 'UserController:index');
    $router->add('user', '/users', 'UserController:users', 'GET|POST');
    $router->add('user_ban', '/user/ban', 'UserController:ban');

    /* профиль */
    $router->add('profile', '/profile', 'ProfileController:index');
    $router->add('profile_my', '/profile/my', 'ProfileController:my', 'GET|POST');
    $router->add('profile_setup', '/profile/setup', 'ProfileController:setup', 'GET|POST');
    $router->add('profile_security', '/profile/security', 'ProfileController:security', 'GET|POST');
    $router->add('profile_history', '/profile/history', 'ProfileController:history');
    $router->add('profile_notice', '/profile/notice', 'ProfileController:notice');
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

    /* активность на сайте */
    $router->add('active_guest', '/active/guest/(id:num)', 'ActiveController:guest');
    $router->add('active_thems', '/active/thems/(id:num)', 'ActiveController:thems');
    $router->add('active_posts', '/active/posts/(id:num)', 'ActiveController:posts');
    $router->add('active_download', '/active/download/(id:num)', 'ActiveController:download');
    $router->add('active_blogs', '/active/blogs/(id:num)', 'ActiveController:blogs');
    $router->add('active_news_comments', '/active/news/comments/(id:num)', 'ActiveController:news_comments');
    $router->add('active_download_comments', '/active/download/comments/(id:num)', 'ActiveController:download_comments');
    $router->add('active_blogs_comments', '/active/blogs/comments/(id:num)', 'ActiveController:blogs_comments');

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

    /* гостевая */
    $router->add('guest', '/guest', 'GuestController:index', 'GET|POST');
    $router->add('guest_edit', '/guest/edit/(id:num)', 'GuestController:edit', 'GET|POST');
    $router->add('guest_del', '/guest/del/(id:num)', 'GuestController:del', 'GET|POST');

    /* текстовая страница */
    $router->add('pages', '/pages/(id:num)-(a:any)', 'PagesController:index');

    /* реклама */
    $router->add('ads', '/go/(id:num)', 'AdsController:index');

    /* админка */
    /* главная страница админки */
    $router->add('admin', $admin, 'AdminCore:index');

    /* различные настройки */
    $router->add('admin_setting', $admin . '/setting', 'AdminSetting:index', 'GET|POST');
    $router->add('admin_setting_other', $admin . '/setting/other', 'AdminSetting:other', 'GET|POST');
    $router->add('admin_setting_email', $admin . '/setting/email', 'AdminSetting:email', 'GET|POST');
    $router->add('admin_setting_counters', $admin . '/setting/counters', 'AdminSetting:counters', 'GET|POST');
    $router->add('admin_setting_forum', $admin . '/setting/forum', 'AdminSetting:forum', 'GET|POST');
    $router->add('admin_setting_smiles', $admin . '/setting/smiles', 'AdminSetting:smiles', 'GET|POST');
    $router->add('admin_setting_smiles_update', $admin . '/setting/smiles/update', 'AdminSetting:smiles_update');
    $router->add('admin_setting_zc', $admin . '/setting/zc', 'AdminSetting:zc', 'GET|POST');

    /* другие модули админки */

    /* пользователи */
    $router->add('admin_users', $admin . '/users', 'AdminUsers:index');
    $router->add('admin_users_edit', $admin . '/users/edit/(id:num)', 'AdminUsers:edit', 'GET|POST');
    $router->add('admin_users_del', $admin . '/users/del/(id:num)', 'AdminUsers:del', 'GET|POST');
    $router->add('admin_users_ban', $admin . '/users/ban/(id:num)', 'AdminUsers:ban', 'GET|POST');
    $router->add('admin_users_unban', $admin . '/users/unban/(id:num)', 'AdminUsers:unban', 'GET|POST');
    $router->add('admin_balls', $admin . '/users/balls', 'AdminUsers:balls', 'GET|POST');
    $router->add('admin_signup', $admin . '/users/signup', 'AdminUsers:signup', 'GET|POST');

    /* галерея */
    $router->add('admin_gallery', $admin . '/gallery', 'AdminGallery:index');
    $router->add('admin_gallery_add', $admin . '/gallery/add', 'AdminGallery:add', 'GET|POST');
    $router->add('admin_gallery_edit', $admin . '/gallery/edit/(id:num)', 'AdminGallery:edit', 'GET|POST');
    $router->add('admin_gallery_del', $admin . '/gallery/del/(id:num)', 'AdminGallery:del');
    $router->add('admin_gallery_del_photo', $admin . '/gallery/del/photo/(id:num)', 'AdminGallery:del_photo');
    $router->add('admin_gallery_id', $admin . '/gallery/(id:num)', 'AdminGallery:id', 'GET|POST');
    $router->add('admin_gallery_id_page', $admin . '/gallery/(id:num)/page=(page:num)', 'AdminGallery:id');

    /* текстовые страницы */
    $router->add('admin_pages', $admin . '/pages', 'AdminPages:index');
    $router->add('admin_pages_add', $admin . '/pages/add', 'AdminPages:add', 'GET|POST');
    $router->add('admin_pages_edit', $admin . '/pages/edit/(id:num)', 'AdminPages:edit', 'GET|POST');
    $router->add('admin_pages_del', $admin . '/pages/del/(id:num)', 'AdminPages:del');

    /* рекламный менеджер */
    $router->add('admin_ads', $admin . '/ads', 'AdminAds:index');
    $router->add('admin_ads_add', $admin . '/ads/add', 'AdminAds:add', 'GET|POST');
    $router->add('admin_ads_edit', $admin . '/ads/edit/(id:num)', 'AdminAds:edit', 'GET|POST');
    $router->add('admin_ads_del', $admin . '/ads/del/(id:num)', 'AdminAds:del', 'GET|POST');
    $router->add('admin_ads_stat', $admin . '/ads/(id:num)', 'AdminAds:stat');

    /* логи админа и уведомления */
    $router->add('admin_logs', $admin . '/logs', 'AdminLogs:index');
    $router->add('admin_notice', $admin . '/notice', 'AdminLogs:notice');

    /* редактор шаблонов */
    $router->add('admin_templates', $admin . '/templates', 'AdminTemplates:index', 'GET|POST');
    $router->add('admin_templates_view', $admin . '/templates/view/(a:any)', 'AdminTemplates:view');
    $router->add('admin_templates_edit', $admin . '/templates/edit?(a:all)', 'AdminTemplates:edit', 'GET|POST');
    $router->add('admin_templates_del', $admin . '/templates/del/(a:all)', 'AdminTemplates:del', 'GET|POST');
    $router->add('admin_templates_email', $admin . '/templates/email', 'AdminTemplates:email', 'GET|POST');
    $router->add('admin_templates_email_edit', $admin . '/templates/email/edit/(a:all)', 'AdminTemplates:email', 'GET|POST');

    /* карта сайта */
    $router->add('admin_sitemap', $admin . '/sitemap', 'AdminSitemap:index');
    $router->add('admin_sitemap_generate', $admin . '/sitemap/generate', 'AdminSitemap:generate');
    $router->add('admin_sitemap_setup', $admin . '/sitemap/setup', 'AdminSitemap:setup', 'GET|POST');
    $router->add('admin_sitemap_robots', $admin . '/sitemap/robots', 'AdminSitemap:robots', 'GET|POST');
    $router->add('admin_sitemap_del', $admin . '/sitemap/del/(a:all)', 'AdminSitemap:del');
    $router->add('admin_sitemap_edit', $admin . '/sitemap/edit/(a:all)', 'AdminSitemap:edit', 'GET|POST');
    
    /* VCMS */
    $router->add('admin_vcms', $admin . '/vcms', 'AdminVcms:index');
    $router->add('admin_vcms_info', $admin . '/vcms/info', 'AdminVcms:info');
    $router->add('admin_vcms_license', $admin . '/vcms/license', 'AdminVcms:license');

    /* конец админки */

    $route = $router->match(Functions::GET_METHOD(), Functions::GET_PATH_INFO());

    if (null == $route) {
        $route = new MatchedRoute('MainController:error404');
        SmartySingleton::instance()->assign(array(
            'route' => 1
        ));
    }

    list($class, $action) = explode(':', $route->getController(), 2);

    call_user_func_array(array(new $class($router), $action), $route->getParameters());
} catch (Exception $e) {

    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

    echo $e->getMessage();
    echo $e->getTraceAsString();
    exit;
}
