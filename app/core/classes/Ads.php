<?php

class Ads {

    function head_index() {
        $req = DB::run("SELECT * FROM `ads` WHERE `count`>'0' AND `type`='head_index' OR `time`>'" . Cms::realtime() . "' AND `type`='head_index' ORDER BY rand() LIMIT " . Cms::setup('adslimit'))->fetchAll();
        return $req;
    }

    function head_no_index() {
        $req = DB::run("SELECT * FROM `ads` WHERE `count`>'0' AND `type`='head_no_index' OR `time`>'" . Cms::realtime() . "' AND `type`='head_no_index' ORDER BY rand() LIMIT " . Cms::setup('adslimit'))->fetchAll();
        return $req;
    }

    function head() {
        $req = DB::run("SELECT * FROM `ads` WHERE `count`>'0' AND `type`='head' OR `time`>'" . Cms::realtime() . "' AND `type`='head' ORDER BY rand() LIMIT " . Cms::setup('adslimit'))->fetchAll();
        return $req;
    }

    function foot() {
        $req = DB::run("SELECT * FROM `ads` WHERE `count`>'0' AND `type`='foot' OR `time`>'" . Cms::realtime() . "' AND `type`='foot' ORDER BY rand() LIMIT " . Cms::setup('adslimit'))->fetchAll();
        return $req;
    }

    function left() {
        $req = DB::run("SELECT * FROM `ads` WHERE `count`>'0' AND `type`='left' OR `time`>'" . Cms::realtime() . "' AND `type`='left' ORDER BY rand() LIMIT " . Cms::setup('adslimit'))->fetchAll();
        return $req;
    }

}
