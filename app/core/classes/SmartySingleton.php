<?php

require_once(HOME . '/app/lib/smarty/Autoloader.php');

class SmartySingleton {

    static private $instance;

    public static function instance() {
        if (!isset(self::$instance)) {
            Smarty_Autoloader::register();
            $smarty = new Smarty;
            //$smarty->caching = Smarty::CACHING_LIFETIME_CURRENT;
            $smarty->debugging = Cms::setup('debugging_smarty');
            self::$instance = $smarty;
        }
        return self::$instance;
    }

}
