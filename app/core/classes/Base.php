<?php

class Base {

    function __construct() {
        $this->user = User::auth();
        $this->page = isset($_REQUEST['page']) ? Cms::Int($_REQUEST['page']) : 0;

        if ($this->user['id']) {
            $this->message = $this->user['message'];
        } else {
            $this->message = Cms::setup('message');
        }

        //если забанен
        if ($this->user['ban'] == 1 && $this->user['bantime'] > Cms::realtime() && Cms::Input($_SERVER['REQUEST_URI']) != '/user/ban' && Cms::Input($_SERVER['REQUEST_URI']) != '/user/exit') {
            Functions::redirect(Cms::setup('home') . '/user/ban');
        }
    }

}
