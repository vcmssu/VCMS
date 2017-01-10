<?php

class Base {

    function __construct() {
        $this->user = User::auth();
        $this->page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 0;

        if ($this->user['id']) {
            $this->message = $this->user['message'];
        } else {
            $this->message = Cms::setup('message');
        }

        //если забанен
        if ($this->user['ban'] == 1 && $this->user['bantime'] > Cms::realtime() && $_SERVER['REQUEST_URI'] != '/user/ban' && $_SERVER['REQUEST_URI'] != '/user/exit') {
            Functions::redirect(Cms::setup('home') . '/user/ban');
        }
    }

}
