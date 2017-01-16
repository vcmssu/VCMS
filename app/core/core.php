<?php

ob_start();

//сессия
session_start();
session_name("VCMS");

spl_autoload_register(function ($class) {
    $dirs = array(
        HOME . '/app/core/classes/',
        HOME . '/app/controllers/',
        HOME . '/app/controllers/admin/',
        HOME . '/app/models/',
        HOME . '/app/models/admin/',
    );
    foreach ($dirs as $dir) {
        if (is_file($dir . $class . '.php')) {
            require_once($dir . $class . '.php');
        }
    }
});

if (User::auth()) {
    $message = User::$user['message'];
    $skin = User::$user['skin'];
} else {
    $message = Cms::setup('message');
    $skin = Cms::setup('skin');
}

SmartySingleton::instance()->template_dir = HOME . '/style/' . $skin . '/templates/';
SmartySingleton::instance()->compile_dir = HOME . '/style/' . $skin . '/templates_c/';
SmartySingleton::instance()->config_dir = HOME . '/style/' . $skin . '/configs/';
SmartySingleton::instance()->cache_dir = HOME . '/files/cache/';

define('SMARTY_TEMPLATE_LOAD', HOME . '/style/' . $skin);

SmartySingleton::instance()->assign(array(
    'setup' => Cms::setting(),
    'realtime' => Cms::realtime(),
    'message' => $message,
    'home' => Cms::setup('home'),
    'panel' => Cms::setup('adminpanel'),
    'skin' => $skin,
    'user' => User::auth(),
    'url' => Cms::setup('home') . '' . $_SERVER['REQUEST_URI']
));

/* определяем устройство и пишем в сессию */
if (empty($_SESSION['device'])) {
    if (Recipe::isMobile()) {
        $_SESSION['device'] = 'wap';
    } else {
        $_SESSION['device'] = 'web';
    }
}