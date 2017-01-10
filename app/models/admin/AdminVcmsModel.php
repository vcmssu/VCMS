<?php

class AdminVcmsModel extends Base {

    function index() {
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/vcms/index.tpl');
    }

    function info() {
        SmartySingleton::instance()->assign(array(
            'php' => phpversion(),
            'mysql' => extension_loaded('mysql'),
            'pdo' => extension_loaded('pdo'),
            'gd' => extension_loaded('gd'),
            'zlib' => extension_loaded('zlib'),
            'iconv' => extension_loaded('iconv'),
            'mbstring' => extension_loaded('mbstring'),
            'xml' => extension_loaded('xml'),
            'XMLWriter' => extension_loaded('XMLWriter'),
            'ffmpeg' => extension_loaded('ffmpeg'),
        ));
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/vcms/info.tpl');
    }

    function license() {
        SmartySingleton::instance()->display(SMARTY_TEMPLATE_LOAD . '/templates/admin/vcms/license.tpl');
    }

}
