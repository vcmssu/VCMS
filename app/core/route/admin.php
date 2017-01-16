<?php

$admin = Cms::setup('adminpanel');
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
$router->add('admin_logs_clear', $admin . '/logs/clear', 'AdminLogs:clear', 'GET|POST');
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