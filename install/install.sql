--
-- Структура таблицы `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) auto_increment,
`login` varchar(32) NOT NULL,
`pass` varchar(150) NOT NULL,
`hashcode` varchar(150) NOT NULL,
`uLoginHash` varchar(150) NOT NULL,
`firstname` varchar(32) NOT NULL,
`lastname` varchar(32) NOT NULL,
`d` int(2) NOT NULL default '0',
`m` int(2) NOT NULL default '0',
`o` int(4) NOT NULL default '0',
`avatar` varchar(50) NOT NULL,
`balls` varchar(11) default '0',
`money` varchar(11) default '0',
`rating` varchar(11) default '0',
`phone` varchar(20) NOT NULL,
`email` varchar(32) NOT NULL,
`skype` varchar(32) NOT NULL,
`icq` int(10) NOT NULL,
`adress` varchar(250) NOT NULL,
`city` varchar(32) NOT NULL,
`level` int(3) NOT NULL default '1',
`date_reg` int(11) NOT NULL,
`date_last` int(11) NOT NULL,
`rest_code` varchar(32) NOT NULL,
`rest_time` int(11) NOT NULL,
`activation` varchar(32) NOT NULL,
`ban` enum('0', '1') NOT NULL default '0',
`bantime` int(11) NOT NULL,
`banprichina` varchar(1000) NOT NULL,
`about` varchar(500) NOT NULL,
`referer` varchar(1024) NOT NULL,
`news_send` enum('0', '1') NOT NULL default '1',
`mail` enum('0', '1') NOT NULL default '1',
`wall` enum('0', '1') NOT NULL default '1',
`skin` varchar(100) NOT NULL default 'default',
`message` int(3) NOT NULL default '20',
`timezone` varchar(100) NOT NULL default 'Europe/Moscow',
`counttema` int(11) NOT NULL default '0',
`countpost` int(11) NOT NULL default '0',
PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `mail`
--
DROP TABLE IF EXISTS `mail`;
CREATE TABLE IF NOT EXISTS `mail` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`text` varchar(5000) NOT NULL,
`read` int(1) NOT NULL default '0',
`status` int(1) default '1',
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user`(`id_user`),
KEY `user_id`(`user_id`)
) ENGINE=MyISAM  CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `mail_files`
--
DROP TABLE IF EXISTS `mail_files`;
CREATE TABLE IF NOT EXISTS `mail_files` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`id_mail` int(11) NOT NULL,
`file` varchar(500) NOT NULL,
`type` varchar(11) NOT NULL,
`size` varchar(11) NOT NULL,
`timeload` int(11) NOT NULL,
`loadcounts` int(11) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user`(`id_user`),
KEY `user_id`(`user_id`),
KEY `id_mail`(`id_mail`)
) ENGINE=MyISAM  CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `contacts`
--
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
`id` int(11) NOT NULL auto_increment,
`id_user` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `id_user`(`id_user`),
KEY `user_id`(`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Структура таблицы `blacklist`
--
DROP TABLE IF EXISTS `blacklist`;
CREATE TABLE IF NOT EXISTS `blacklist` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user`(`id_user`),
KEY `user_id`(`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `friends`
--
DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`status` enum('0', '1') NOT NULL default '0',
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user`(`id_user`),
KEY `user_id`(`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `group_access`
--
DROP TABLE IF EXISTS `group_access`;
CREATE TABLE IF NOT EXISTS `group_access` (
`id` int(11) auto_increment,
`level` int(11) NOT NULL,
`name` varchar(250) NOT NULL,
PRIMARY KEY  (`id`),
KEY `level` (`level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `blog_category`
--
DROP TABLE IF EXISTS `blog_category`;
CREATE TABLE IF NOT EXISTS `blog_category` (
`id` int(11) auto_increment,
`realid` int(11) NOT NULL,
`name` varchar(250) NOT NULL,
`translate` varchar(250) NOT NULL,
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `blog`
--
DROP TABLE IF EXISTS `blog`;
CREATE TABLE IF NOT EXISTS `blog` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`refid` int(11) NOT NULL,
`name` varchar(250) NOT NULL,
`translate` varchar(250) NOT NULL,
`text` text NOT NULL,
`time` int(11) NOT NULL,
`views` int(11) NOT NULL default '0',
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user` (`id_user`),
KEY `refid` (`refid`),
FULLTEXT `nt` (`name`, `text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `blog_comments`
--
DROP TABLE IF EXISTS `blog_comments`;
CREATE TABLE IF NOT EXISTS `blog_comments` (
`id` int(11) auto_increment,
`refid` int(11) NOT NULL,
`id_post` int(11) NOT NULL,
`id_user` int(11) NOT NULL,
`text` varchar(5000) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `refid` (`refid`),
KEY `id_post` (`id_post`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `category`
--
DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
`id` int(11) NOT NULL auto_increment,
`refid` int(11) NOT NULL,
`realid` int(11) NOT NULL,
`icon` varchar(50) NOT NULL,
`name` varchar(250) NOT NULL,
`translate` varchar(250) NOT NULL,
`text` varchar(250) NOT NULL,
`user` enum('0', '1') NOT NULL default '0',
`type` varchar(250) NOT NULL,
`maxfilesize` int(11) NOT NULL,
`path` varchar(1000) NOT NULL,
`infolder` varchar(1000) NOT NULL,
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
PRIMARY KEY (`id`),
KEY `refid` (`refid`),
KEY `path` (`path`),
KEY `infolder` (`infolder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `files`
--
DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
`id` int(11) NOT NULL auto_increment,
`id_user` int(11) NOT NULL,
`refid` int(11) NOT NULL,
`id_file` int(11) NOT NULL,
`name` varchar(250) NOT NULL,
`translate` varchar(250) NOT NULL,
`text` varchar(5000) NOT NULL,
`file` varchar(300) NOT NULL,
`type` varchar(5) NOT NULL,
`size` varchar(11) NOT NULL,
`path` varchar(1000) NOT NULL,
`infolder` varchar(1000) NOT NULL,
`screen` varchar(250) NOT NULL,
`time` int(11) NOT NULL,
`timeload` int(11) NOT NULL,
`loadcounts` int(11) NOT NULL,
`views` int(11) NOT NULL,
`vote` int(11) NOT NULL,
`status` int(1) NOT NULL,
`user` enum('0', '1') NOT NULL default '0',
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
PRIMARY KEY (`id`),
KEY `id_user` (`id_user`),
KEY `refid` (`refid`),
KEY `id_file` (`id_file`),
KEY `path` (`path`),
KEY `infolder` (`infolder`),
KEY `pl` (`views`, `loadcounts`),
FULLTEXT `s1` (`name`, `text`),
FULLTEXT `pi` (`path`, `infolder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `files_comments`
--
DROP TABLE IF EXISTS `files_comments`;
CREATE TABLE IF NOT EXISTS `files_comments` (
`id` int(11) auto_increment,
`id_file` int(11) NOT NULL,
`id_user` int(11) NOT NULL,
`text` varchar(5000) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_file` (`id_file`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `forum`
--
DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
`id` int(11) NOT NULL auto_increment,
`refid` int(11) NOT NULL,
`realid` int(11) NOT NULL,
`name` varchar(250) NOT NULL,
`translate` varchar(250) NOT NULL,
`text` varchar(250) NOT NULL,
`type` enum('0', '1', '2') NOT NULL default '0',
`counttema` int(11) NOT NULL default '0',
`countpost` int(11) NOT NULL default '0',
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
PRIMARY KEY (`id`),
KEY `refid` (`refid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `tema`
--
DROP TABLE IF EXISTS `tema`;
CREATE TABLE IF NOT EXISTS `tema` (
`id` int(11) NOT NULL auto_increment,
`id_razdel` int(11) NOT NULL,
`id_forum` int(11) NOT NULL,
`realid` int(11) NOT NULL default '0',
`id_user` int(11) NOT NULL,
`id_user_last` int(11) NOT NULL,
`id_post_last` int(11) NOT NULL,
`name` varchar(500) NOT NULL,
`translate` varchar(500) NOT NULL,
`text` text NOT NULL,
`time` int(11) NOT NULL,
`up` enum('0', '1') NOT NULL default '0',
`closed` enum('0', '1') NOT NULL default '0',
`views` int(11) NOT NULL default '0',
`countpost` int(11) NOT NULL default '0',
`type` enum('0', '1', '2') NOT NULL default '0',
PRIMARY KEY (`id`),
KEY `id_razdel` (`id_razdel`),
KEY `id_forum` (`id_forum`),
KEY `id_user` (`id_user`),
KEY `id_user_last` (`id_user_last`),
KEY `time` (`time`),
KEY `up` (`up`),
KEY `type` (`type`),
FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Структура таблицы `tema_vote`
--
DROP TABLE IF EXISTS `tema_vote`;
CREATE TABLE IF NOT EXISTS `tema_vote` (
`id` int(11) NOT NULL auto_increment,
`id_razdel` int(11) NOT NULL,
`id_forum` int(11) NOT NULL,
`id_tema` int(11) NOT NULL,
`id_user` int(11) NOT NULL,
`name` varchar(200) NOT NULL,
`count` int(11) NOT NULL,
`type` enum('1', '2') NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_razdel` (`id_razdel`),
KEY `id_forum` (`id_forum`),
KEY `id_tema` (`id_tema`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `tema_vote_us`
--
DROP TABLE IF EXISTS `tema_vote_us`;
CREATE TABLE IF NOT EXISTS `tema_vote_us` (
`id` int(11) NOT NULL auto_increment,
`id_razdel` int(11) NOT NULL,
`id_forum` int(11) NOT NULL,
`id_tema` int(11) NOT NULL,
`id_user` int(11) NOT NULL,
`vote` int(11) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_razdel` (`id_razdel`),
KEY `id_forum` (`id_forum`),
KEY `id_tema` (`id_tema`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `post`
--
DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
`id` int(11) NOT NULL auto_increment,
`id_razdel` int(11) NOT NULL,
`id_forum` int(11) NOT NULL,
`id_tema` int(11) NOT NULL,
`id_user` int(11) NOT NULL,
`text` text NOT NULL,
`cit` int(11) NOT NULL,
`time` int(11) NOT NULL,
`timeedit` int(11) NOT NULL,
`kedit` int(11) NOT NULL,
`id_user_edit` int(11) NOT NULL,
`vote` varchar(11) NOT NULL,
`type` enum('0', '1', '2') NOT NULL default '0',
PRIMARY KEY (`id`),
KEY `id_razdel` (`id_razdel`),
KEY `id_forum` (`id_forum`),
KEY `id_tema` (`id_tema`),
KEY `id_user` (`id_user`),
KEY `time` (`time`),
KEY `type` (`type`),
FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Структура таблицы `post_files`
--
DROP TABLE IF EXISTS `post_files`;
CREATE TABLE IF NOT EXISTS `post_files` (
`id` int(11) NOT NULL auto_increment,
`id_razdel` int(11) NOT NULL,
`id_forum` int(11) NOT NULL,
`id_tema` int(11) NOT NULL,
`id_post` int(11) NOT NULL,
`id_user` int(11) NOT NULL,
`file` varchar(500) NOT NULL,
`type` varchar(11) NOT NULL,
`size` varchar(11) NOT NULL,
`timeload` int(11) NOT NULL,
`loadcounts` int(11) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `id_razdel` (`id_razdel`),
KEY `id_forum` (`id_forum`),
KEY `id_tema` (`id_tema`),
KEY `id_post` (`id_post`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Структура таблицы `bookmark`
--
DROP TABLE IF EXISTS `bookmark`;
CREATE TABLE IF NOT EXISTS `bookmark` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`name` varchar(250) NOT NULL,
`url` varchar(1024) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user` (`id_user`),
FULLTEXT `url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `gallery`
--
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE IF NOT EXISTS `gallery` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`name` varchar(250) NOT NULL,
`translate` varchar(250) NOT NULL,
`text` varchar(500) NOT NULL,
`time` int(11) NOT NULL,
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `gallery_photo`
--
DROP TABLE IF EXISTS `gallery_photo`;
CREATE TABLE IF NOT EXISTS `gallery_photo` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`id_gallery` int(11) NOT NULL,
`name` varchar(250) NOT NULL,
`translate` varchar(250) NOT NULL,
`text` varchar(500) NOT NULL,
`photo` varchar(50) NOT NULL,
`size` varchar(11) NOT NULL,
`time` int(11) NOT NULL,
`views` int(11) NOT NULL default '0',
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user` (`id_user`),
KEY `id_gallery` (`id_gallery`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `news`
--
DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
`id` int(11) auto_increment,
`name` varchar(500) NOT NULL,
`translate` varchar(500) NOT NULL,
`text` text NOT NULL,
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
`status` enum('0', '1') NOT NULL default '0',
`comments` enum('0', '1') NOT NULL default '0',
`time` int(11) NOT NULL,
`timemail` int(11) NOT NULL,
`views` int(11) NOT NULL,
PRIMARY KEY  (`id`),
FULLTEXT KEY `s1` (`name`, `text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `news_comments`
--
DROP TABLE IF EXISTS `news_comments`;
CREATE TABLE IF NOT EXISTS `news_comments` (
`id` int(11) auto_increment,
`id_news` int(11) NOT NULL,
`id_user` int(11) NOT NULL,
`text` varchar(5000) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_news` (`id_news`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `guest`
--
DROP TABLE IF EXISTS `guest`;
CREATE TABLE IF NOT EXISTS `guest` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`name` varchar(32) NOT NULL,
`text` varchar(5000) NOT NULL,
`reply` varchar(5000) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `ads`
--
DROP TABLE IF EXISTS `ads`;
CREATE TABLE IF NOT EXISTS `ads` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`link` varchar(500) NOT NULL,
`name` varchar(500) NOT NULL,
`text` varchar(10000) NOT NULL,
`type` varchar(15) NOT NULL,
`style` varchar(3) NOT NULL,
`count` int(11) NOT NULL,
`target` int(1) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user`(`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `ads_stat`
--
DROP TABLE IF EXISTS `ads_stat`;
CREATE TABLE IF NOT EXISTS `ads_stat` (
`id` int(11) NOT NULL auto_increment,
`id_link` int(11) NOT NULL,
`ip` varchar(20) NOT NULL,
`country` varchar(64) NOT NULL,
`city` varchar(64) NOT NULL,
`browser` varchar(200) NOT NULL,
`region` varchar(100) NOT NULL,
`lat` varchar(11) NOT NULL,
`lng` varchar(11) NOT NULL,
`referer` varchar(1024) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `id_link`(`id_link`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Структура таблицы `pages`
--
DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
`id` int(11) auto_increment,
`name` varchar(500) NOT NULL,
`translate` varchar(500) NOT NULL,
`text` text NOT NULL,
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `adminlogs`
--
DROP TABLE IF EXISTS `adminlogs`;
CREATE TABLE IF NOT EXISTS `adminlogs` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`modul` varchar(500) NOT NULL,
`text` varchar(2000) NOT NULL,
`ip` varchar(20) NOT NULL,
`browser` varchar(500) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `notice`
--
DROP TABLE IF EXISTS `notice`;
CREATE TABLE IF NOT EXISTS `notice` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`text` text NOT NULL,
`url` varchar(1024) NOT NULL,
`status` enum('0', '1') NOT NULL default '1',
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user` (`id_user`),
KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `userlogs`
--
DROP TABLE IF EXISTS `userlogs`;
CREATE TABLE IF NOT EXISTS `userlogs` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`modul` varchar(500) NOT NULL,
`text` varchar(2000) NOT NULL,
`ip` varchar(20) NOT NULL,
`browser` varchar(500) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `history`
--
DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`ip` varchar(20) NOT NULL,
`browser` varchar(500) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `online`
--
DROP TABLE IF EXISTS `online`;
CREATE TABLE IF NOT EXISTS `online` (
`id_user` int(11) NOT NULL,
`ip` varchar(20) NOT NULL,
`browser` varchar(500) NOT NULL,
`referer` varchar(2500) NOT NULL,
`type` enum('1', '2') NOT NULL default '1',
`time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `antiflood`
--
DROP TABLE IF EXISTS `antiflood`;
CREATE TABLE IF NOT EXISTS `antiflood` (
`id` int(11) NOT NULL auto_increment,
`ip` varchar(20) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Структура таблицы `library_category`
--
DROP TABLE IF EXISTS `library_category`;
CREATE TABLE IF NOT EXISTS `library_category` (
`id` int(11) NOT NULL auto_increment,
`refid` int(11) NOT NULL,
`realid` int(11) NOT NULL,
`name` varchar(250) NOT NULL,
`translate` varchar(250) NOT NULL,
`text` varchar(250) NOT NULL,
`user` enum('0', '1') NOT NULL default '0',
`path` varchar(500) NOT NULL,
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
PRIMARY KEY (`id`),
KEY `refid` (`refid`),
KEY `path` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `library`
--
DROP TABLE IF EXISTS `library`;
CREATE TABLE IF NOT EXISTS `library` (
`id` int(11) auto_increment,
`id_user` int(11) NOT NULL,
`refid` int(11) NOT NULL,
`name` varchar(250) NOT NULL,
`translate` varchar(250) NOT NULL,
`autor` varchar(250) NOT NULL,
`text` longtext NOT NULL,
`time` int(11) NOT NULL,
`rating` varchar(5) NOT NULL default '0',
`views` int(11) NOT NULL default '0',
`path` varchar(500) NOT NULL,
`keywords` varchar(2500) NOT NULL,
`description` varchar(2500) NOT NULL,
PRIMARY KEY  (`id`),
KEY `id_user` (`id_user`),
KEY `refid` (`refid`),
KEY `path` (`path`),
FULLTEXT `naa` (`name`, `autor`, `text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `library_comments`
--
DROP TABLE IF EXISTS `library_comments`;
CREATE TABLE IF NOT EXISTS `library_comments` (
`id` int(11) auto_increment,
`refid` int(11) NOT NULL,
`id_user` int(11) NOT NULL,
`text` varchar(5000) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `refid` (`refid`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `library_rating`
--
DROP TABLE IF EXISTS `library_rating`;
CREATE TABLE IF NOT EXISTS `library_rating` (
`id` int(11) auto_increment,
`refid` int(11) NOT NULL,
`id_user` int(11) NOT NULL,
`rating` int(1) NOT NULL,
`time` int(11) NOT NULL,
PRIMARY KEY  (`id`),
KEY `refid` (`refid`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `setting`
--
DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
`id` int(10) unsigned NOT NULL
auto_increment,
`name` varchar(255) NOT NULL,
`value` text NOT NULL,
PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `setting` (`name`,`value`) VALUES ( 'home', 'http://vcms.su');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'skin', 'default');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'copy', '© 2016 VCMS.SU');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'namesite', 'VCMS - бесплатный движок для разработки сайтов');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'message', '18');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'antiflood', '30');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'adminpanel', '/admin');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'timezone', 'Europe/Moscow');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'emailadmin', '');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'keywords', '');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'description', 'VCMS - бесплатная CMS с открытым исходным кодом для разработки сайтов');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'filesize_photo', '5');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'gzip', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'output_compression_level', '3');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'compress', '3');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'adminlogs', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'userlogs', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'version', '1.0');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'copyright', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'copyright_photo', '');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'copyright_txt', 'VCMS.SU');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'copyright_type', 'bottom right');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'copyright_txt_font', 'Slants_Regular.ttf');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'copyright_txt_font_size', '12');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'copyright_txt_font_color', '#000000');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'sendmail', 'mail');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'smtpport', '587');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'smtphost', '');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'smtpusername', '');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'smtppassword', '');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'sitemap_changefreq', 'weekly');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'sitemap_priority', '0.5');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'sitemap_index', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'sitemap_txt', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'debugging_smarty', '0');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'registration', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'news', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'activation', '0');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'login_edit', '100');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'guest', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_width', '100');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_height', '45');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_font_size', '12');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_let_amount', '3');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_let_amount_fon', '10');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'highlight', '0');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_signup', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_add_theme', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_add_post', '0');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_comments_news', '0');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_comments_file', '0');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_comments_blog', '0');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_comments_library', '0');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'preview', '320');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'previewsmall', '240');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'previewsmall2', '170');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'watermark', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'autoscreen_video', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'autoscreen_nth', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'autoscreen_thm', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'newfile', '86400');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'filetype_forum', 'jpg, png, gif, bmp, ico, zip, rar, doc, docx, txt, mp4, avi, mkv, mpg, wmv, flv, mp3, wav, pdf, psd, mov, divx, flv, m4v, swf, ogg, rtf, xls, xlsx, ppt, pptx');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'filesize_forum', '10');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'filecount_forum', '5');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'time_forum', '86400');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'vote_forum', '5');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'autoclear_guest', '7');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'captcha_signup', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'counters', '');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'count_smiles', '15');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'lastthems', '3');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'gallerypreview', '250');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'adslimit', '3');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'count_txt', '5000');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'balls_add_theme', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'balls_add_post', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'balls_add_blog', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'balls_add_library', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'balls_add_download', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'forum_time_edit_post', '5');

--
-- Структура таблицы `smiles_user`
--
DROP TABLE IF EXISTS `smiles_user`;
CREATE TABLE IF NOT EXISTS `smiles_user` (
`id` int(11) NOT NULL auto_increment,
`id_user` int(11) NOT NULL,
`id_smile` int(1) NOT NULL,
PRIMARY KEY (`id`),
KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Структура таблицы `smiles`
--
DROP TABLE IF EXISTS `smiles`;
CREATE TABLE IF NOT EXISTS `smiles` (
`id` int(11) NOT NULL auto_increment,
`code` varchar(20) NOT NULL,
`photo` varchar(20) NOT NULL,
PRIMARY KEY (`id`),
KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Структура таблицы `zone`
--
DROP TABLE IF EXISTS `zone`;
CREATE TABLE IF NOT EXISTS `zone` (
  `zone_id` int(10) NOT NULL,
  `country_code` char(2) COLLATE utf8_bin NOT NULL,
  `zone_name` varchar(35) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=425 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `zone`
--

INSERT INTO `zone` (`zone_id`, `country_code`, `zone_name`) VALUES
(1, 'AD', 'Europe/Andorra'),
(2, 'AE', 'Asia/Dubai'),
(3, 'AF', 'Asia/Kabul'),
(4, 'AG', 'America/Antigua'),
(5, 'AI', 'America/Anguilla'),
(6, 'AL', 'Europe/Tirane'),
(7, 'AM', 'Asia/Yerevan'),
(8, 'AO', 'Africa/Luanda'),
(9, 'AQ', 'Antarctica/McMurdo'),
(10, 'AQ', 'Antarctica/Casey'),
(11, 'AQ', 'Antarctica/Davis'),
(12, 'AQ', 'Antarctica/DumontDUrville'),
(13, 'AQ', 'Antarctica/Mawson'),
(14, 'AQ', 'Antarctica/Palmer'),
(15, 'AQ', 'Antarctica/Rothera'),
(16, 'AQ', 'Antarctica/Syowa'),
(17, 'AQ', 'Antarctica/Troll'),
(18, 'AQ', 'Antarctica/Vostok'),
(19, 'AR', 'America/Argentina/Buenos_Aires'),
(20, 'AR', 'America/Argentina/Cordoba'),
(21, 'AR', 'America/Argentina/Salta'),
(22, 'AR', 'America/Argentina/Jujuy'),
(23, 'AR', 'America/Argentina/Tucuman'),
(24, 'AR', 'America/Argentina/Catamarca'),
(25, 'AR', 'America/Argentina/La_Rioja'),
(26, 'AR', 'America/Argentina/San_Juan'),
(27, 'AR', 'America/Argentina/Mendoza'),
(28, 'AR', 'America/Argentina/San_Luis'),
(29, 'AR', 'America/Argentina/Rio_Gallegos'),
(30, 'AR', 'America/Argentina/Ushuaia'),
(31, 'AS', 'Pacific/Pago_Pago'),
(32, 'AT', 'Europe/Vienna'),
(33, 'AU', 'Australia/Lord_Howe'),
(34, 'AU', 'Antarctica/Macquarie'),
(35, 'AU', 'Australia/Hobart'),
(36, 'AU', 'Australia/Currie'),
(37, 'AU', 'Australia/Melbourne'),
(38, 'AU', 'Australia/Sydney'),
(39, 'AU', 'Australia/Broken_Hill'),
(40, 'AU', 'Australia/Brisbane'),
(41, 'AU', 'Australia/Lindeman'),
(42, 'AU', 'Australia/Adelaide'),
(43, 'AU', 'Australia/Darwin'),
(44, 'AU', 'Australia/Perth'),
(45, 'AU', 'Australia/Eucla'),
(46, 'AW', 'America/Aruba'),
(47, 'AX', 'Europe/Mariehamn'),
(48, 'AZ', 'Asia/Baku'),
(49, 'BA', 'Europe/Sarajevo'),
(50, 'BB', 'America/Barbados'),
(51, 'BD', 'Asia/Dhaka'),
(52, 'BE', 'Europe/Brussels'),
(53, 'BF', 'Africa/Ouagadougou'),
(54, 'BG', 'Europe/Sofia'),
(55, 'BH', 'Asia/Bahrain'),
(56, 'BI', 'Africa/Bujumbura'),
(57, 'BJ', 'Africa/Porto-Novo'),
(58, 'BL', 'America/St_Barthelemy'),
(59, 'BM', 'Atlantic/Bermuda'),
(60, 'BN', 'Asia/Brunei'),
(61, 'BO', 'America/La_Paz'),
(62, 'BQ', 'America/Kralendijk'),
(63, 'BR', 'America/Noronha'),
(64, 'BR', 'America/Belem'),
(65, 'BR', 'America/Fortaleza'),
(66, 'BR', 'America/Recife'),
(67, 'BR', 'America/Araguaina'),
(68, 'BR', 'America/Maceio'),
(69, 'BR', 'America/Bahia'),
(70, 'BR', 'America/Sao_Paulo'),
(71, 'BR', 'America/Campo_Grande'),
(72, 'BR', 'America/Cuiaba'),
(73, 'BR', 'America/Santarem'),
(74, 'BR', 'America/Porto_Velho'),
(75, 'BR', 'America/Boa_Vista'),
(76, 'BR', 'America/Manaus'),
(77, 'BR', 'America/Eirunepe'),
(78, 'BR', 'America/Rio_Branco'),
(79, 'BS', 'America/Nassau'),
(80, 'BT', 'Asia/Thimphu'),
(81, 'BW', 'Africa/Gaborone'),
(82, 'BY', 'Europe/Minsk'),
(83, 'BZ', 'America/Belize'),
(84, 'CA', 'America/St_Johns'),
(85, 'CA', 'America/Halifax'),
(86, 'CA', 'America/Glace_Bay'),
(87, 'CA', 'America/Moncton'),
(88, 'CA', 'America/Goose_Bay'),
(89, 'CA', 'America/Blanc-Sablon'),
(90, 'CA', 'America/Toronto'),
(91, 'CA', 'America/Nipigon'),
(92, 'CA', 'America/Thunder_Bay'),
(93, 'CA', 'America/Iqaluit'),
(94, 'CA', 'America/Pangnirtung'),
(95, 'CA', 'America/Atikokan'),
(96, 'CA', 'America/Winnipeg'),
(97, 'CA', 'America/Rainy_River'),
(98, 'CA', 'America/Resolute'),
(99, 'CA', 'America/Rankin_Inlet'),
(100, 'CA', 'America/Regina'),
(101, 'CA', 'America/Swift_Current'),
(102, 'CA', 'America/Edmonton'),
(103, 'CA', 'America/Cambridge_Bay'),
(104, 'CA', 'America/Yellowknife'),
(105, 'CA', 'America/Inuvik'),
(106, 'CA', 'America/Creston'),
(107, 'CA', 'America/Dawson_Creek'),
(108, 'CA', 'America/Fort_Nelson'),
(109, 'CA', 'America/Vancouver'),
(110, 'CA', 'America/Whitehorse'),
(111, 'CA', 'America/Dawson'),
(112, 'CC', 'Indian/Cocos'),
(113, 'CD', 'Africa/Kinshasa'),
(114, 'CD', 'Africa/Lubumbashi'),
(115, 'CF', 'Africa/Bangui'),
(116, 'CG', 'Africa/Brazzaville'),
(117, 'CH', 'Europe/Zurich'),
(118, 'CI', 'Africa/Abidjan'),
(119, 'CK', 'Pacific/Rarotonga'),
(120, 'CL', 'America/Santiago'),
(121, 'CL', 'Pacific/Easter'),
(122, 'CM', 'Africa/Douala'),
(123, 'CN', 'Asia/Shanghai'),
(124, 'CN', 'Asia/Urumqi'),
(125, 'CO', 'America/Bogota'),
(126, 'CR', 'America/Costa_Rica'),
(127, 'CU', 'America/Havana'),
(128, 'CV', 'Atlantic/Cape_Verde'),
(129, 'CW', 'America/Curacao'),
(130, 'CX', 'Indian/Christmas'),
(131, 'CY', 'Asia/Nicosia'),
(132, 'CY', 'Asia/Famagusta'),
(133, 'CZ', 'Europe/Prague'),
(134, 'DE', 'Europe/Berlin'),
(135, 'DE', 'Europe/Busingen'),
(136, 'DJ', 'Africa/Djibouti'),
(137, 'DK', 'Europe/Copenhagen'),
(138, 'DM', 'America/Dominica'),
(139, 'DO', 'America/Santo_Domingo'),
(140, 'DZ', 'Africa/Algiers'),
(141, 'EC', 'America/Guayaquil'),
(142, 'EC', 'Pacific/Galapagos'),
(143, 'EE', 'Europe/Tallinn'),
(144, 'EG', 'Africa/Cairo'),
(145, 'EH', 'Africa/El_Aaiun'),
(146, 'ER', 'Africa/Asmara'),
(147, 'ES', 'Europe/Madrid'),
(148, 'ES', 'Africa/Ceuta'),
(149, 'ES', 'Atlantic/Canary'),
(150, 'ET', 'Africa/Addis_Ababa'),
(151, 'FI', 'Europe/Helsinki'),
(152, 'FJ', 'Pacific/Fiji'),
(153, 'FK', 'Atlantic/Stanley'),
(154, 'FM', 'Pacific/Chuuk'),
(155, 'FM', 'Pacific/Pohnpei'),
(156, 'FM', 'Pacific/Kosrae'),
(157, 'FO', 'Atlantic/Faroe'),
(158, 'FR', 'Europe/Paris'),
(159, 'GA', 'Africa/Libreville'),
(160, 'GB', 'Europe/London'),
(161, 'GD', 'America/Grenada'),
(162, 'GE', 'Asia/Tbilisi'),
(163, 'GF', 'America/Cayenne'),
(164, 'GG', 'Europe/Guernsey'),
(165, 'GH', 'Africa/Accra'),
(166, 'GI', 'Europe/Gibraltar'),
(167, 'GL', 'America/Godthab'),
(168, 'GL', 'America/Danmarkshavn'),
(169, 'GL', 'America/Scoresbysund'),
(170, 'GL', 'America/Thule'),
(171, 'GM', 'Africa/Banjul'),
(172, 'GN', 'Africa/Conakry'),
(173, 'GP', 'America/Guadeloupe'),
(174, 'GQ', 'Africa/Malabo'),
(175, 'GR', 'Europe/Athens'),
(176, 'GS', 'Atlantic/South_Georgia'),
(177, 'GT', 'America/Guatemala'),
(178, 'GU', 'Pacific/Guam'),
(179, 'GW', 'Africa/Bissau'),
(180, 'GY', 'America/Guyana'),
(181, 'HK', 'Asia/Hong_Kong'),
(182, 'HN', 'America/Tegucigalpa'),
(183, 'HR', 'Europe/Zagreb'),
(184, 'HT', 'America/Port-au-Prince'),
(185, 'HU', 'Europe/Budapest'),
(186, 'ID', 'Asia/Jakarta'),
(187, 'ID', 'Asia/Pontianak'),
(188, 'ID', 'Asia/Makassar'),
(189, 'ID', 'Asia/Jayapura'),
(190, 'IE', 'Europe/Dublin'),
(191, 'IL', 'Asia/Jerusalem'),
(192, 'IM', 'Europe/Isle_of_Man'),
(193, 'IN', 'Asia/Kolkata'),
(194, 'IO', 'Indian/Chagos'),
(195, 'IQ', 'Asia/Baghdad'),
(196, 'IR', 'Asia/Tehran'),
(197, 'IS', 'Atlantic/Reykjavik'),
(198, 'IT', 'Europe/Rome'),
(199, 'JE', 'Europe/Jersey'),
(200, 'JM', 'America/Jamaica'),
(201, 'JO', 'Asia/Amman'),
(202, 'JP', 'Asia/Tokyo'),
(203, 'KE', 'Africa/Nairobi'),
(204, 'KG', 'Asia/Bishkek'),
(205, 'KH', 'Asia/Phnom_Penh'),
(206, 'KI', 'Pacific/Tarawa'),
(207, 'KI', 'Pacific/Enderbury'),
(208, 'KI', 'Pacific/Kiritimati'),
(209, 'KM', 'Indian/Comoro'),
(210, 'KN', 'America/St_Kitts'),
(211, 'KP', 'Asia/Pyongyang'),
(212, 'KR', 'Asia/Seoul'),
(213, 'KW', 'Asia/Kuwait'),
(214, 'KY', 'America/Cayman'),
(215, 'KZ', 'Asia/Almaty'),
(216, 'KZ', 'Asia/Qyzylorda'),
(217, 'KZ', 'Asia/Aqtobe'),
(218, 'KZ', 'Asia/Aqtau'),
(219, 'KZ', 'Asia/Atyrau'),
(220, 'KZ', 'Asia/Oral'),
(221, 'LA', 'Asia/Vientiane'),
(222, 'LB', 'Asia/Beirut'),
(223, 'LC', 'America/St_Lucia'),
(224, 'LI', 'Europe/Vaduz'),
(225, 'LK', 'Asia/Colombo'),
(226, 'LR', 'Africa/Monrovia'),
(227, 'LS', 'Africa/Maseru'),
(228, 'LT', 'Europe/Vilnius'),
(229, 'LU', 'Europe/Luxembourg'),
(230, 'LV', 'Europe/Riga'),
(231, 'LY', 'Africa/Tripoli'),
(232, 'MA', 'Africa/Casablanca'),
(233, 'MC', 'Europe/Monaco'),
(234, 'MD', 'Europe/Chisinau'),
(235, 'ME', 'Europe/Podgorica'),
(236, 'MF', 'America/Marigot'),
(237, 'MG', 'Indian/Antananarivo'),
(238, 'MH', 'Pacific/Majuro'),
(239, 'MH', 'Pacific/Kwajalein'),
(240, 'MK', 'Europe/Skopje'),
(241, 'ML', 'Africa/Bamako'),
(242, 'MM', 'Asia/Yangon'),
(243, 'MN', 'Asia/Ulaanbaatar'),
(244, 'MN', 'Asia/Hovd'),
(245, 'MN', 'Asia/Choibalsan'),
(246, 'MO', 'Asia/Macau'),
(247, 'MP', 'Pacific/Saipan'),
(248, 'MQ', 'America/Martinique'),
(249, 'MR', 'Africa/Nouakchott'),
(250, 'MS', 'America/Montserrat'),
(251, 'MT', 'Europe/Malta'),
(252, 'MU', 'Indian/Mauritius'),
(253, 'MV', 'Indian/Maldives'),
(254, 'MW', 'Africa/Blantyre'),
(255, 'MX', 'America/Mexico_City'),
(256, 'MX', 'America/Cancun'),
(257, 'MX', 'America/Merida'),
(258, 'MX', 'America/Monterrey'),
(259, 'MX', 'America/Matamoros'),
(260, 'MX', 'America/Mazatlan'),
(261, 'MX', 'America/Chihuahua'),
(262, 'MX', 'America/Ojinaga'),
(263, 'MX', 'America/Hermosillo'),
(264, 'MX', 'America/Tijuana'),
(265, 'MX', 'America/Bahia_Banderas'),
(266, 'MY', 'Asia/Kuala_Lumpur'),
(267, 'MY', 'Asia/Kuching'),
(268, 'MZ', 'Africa/Maputo'),
(269, 'NA', 'Africa/Windhoek'),
(270, 'NC', 'Pacific/Noumea'),
(271, 'NE', 'Africa/Niamey'),
(272, 'NF', 'Pacific/Norfolk'),
(273, 'NG', 'Africa/Lagos'),
(274, 'NI', 'America/Managua'),
(275, 'NL', 'Europe/Amsterdam'),
(276, 'NO', 'Europe/Oslo'),
(277, 'NP', 'Asia/Kathmandu'),
(278, 'NR', 'Pacific/Nauru'),
(279, 'NU', 'Pacific/Niue'),
(280, 'NZ', 'Pacific/Auckland'),
(281, 'NZ', 'Pacific/Chatham'),
(282, 'OM', 'Asia/Muscat'),
(283, 'PA', 'America/Panama'),
(284, 'PE', 'America/Lima'),
(285, 'PF', 'Pacific/Tahiti'),
(286, 'PF', 'Pacific/Marquesas'),
(287, 'PF', 'Pacific/Gambier'),
(288, 'PG', 'Pacific/Port_Moresby'),
(289, 'PG', 'Pacific/Bougainville'),
(290, 'PH', 'Asia/Manila'),
(291, 'PK', 'Asia/Karachi'),
(292, 'PL', 'Europe/Warsaw'),
(293, 'PM', 'America/Miquelon'),
(294, 'PN', 'Pacific/Pitcairn'),
(295, 'PR', 'America/Puerto_Rico'),
(296, 'PS', 'Asia/Gaza'),
(297, 'PS', 'Asia/Hebron'),
(298, 'PT', 'Europe/Lisbon'),
(299, 'PT', 'Atlantic/Madeira'),
(300, 'PT', 'Atlantic/Azores'),
(301, 'PW', 'Pacific/Palau'),
(302, 'PY', 'America/Asuncion'),
(303, 'QA', 'Asia/Qatar'),
(304, 'RE', 'Indian/Reunion'),
(305, 'RO', 'Europe/Bucharest'),
(306, 'RS', 'Europe/Belgrade'),
(307, 'RU', 'Europe/Kaliningrad'),
(308, 'RU', 'Europe/Moscow'),
(309, 'RU', 'Europe/Simferopol'),
(310, 'RU', 'Europe/Volgograd'),
(311, 'RU', 'Europe/Kirov'),
(312, 'RU', 'Europe/Astrakhan'),
(313, 'RU', 'Europe/Saratov'),
(314, 'RU', 'Europe/Ulyanovsk'),
(315, 'RU', 'Europe/Samara'),
(316, 'RU', 'Asia/Yekaterinburg'),
(317, 'RU', 'Asia/Omsk'),
(318, 'RU', 'Asia/Novosibirsk'),
(319, 'RU', 'Asia/Barnaul'),
(320, 'RU', 'Asia/Tomsk'),
(321, 'RU', 'Asia/Novokuznetsk'),
(322, 'RU', 'Asia/Krasnoyarsk'),
(323, 'RU', 'Asia/Irkutsk'),
(324, 'RU', 'Asia/Chita'),
(325, 'RU', 'Asia/Yakutsk'),
(326, 'RU', 'Asia/Khandyga'),
(327, 'RU', 'Asia/Vladivostok'),
(328, 'RU', 'Asia/Ust-Nera'),
(329, 'RU', 'Asia/Magadan'),
(330, 'RU', 'Asia/Sakhalin'),
(331, 'RU', 'Asia/Srednekolymsk'),
(332, 'RU', 'Asia/Kamchatka'),
(333, 'RU', 'Asia/Anadyr'),
(334, 'RW', 'Africa/Kigali'),
(335, 'SA', 'Asia/Riyadh'),
(336, 'SB', 'Pacific/Guadalcanal'),
(337, 'SC', 'Indian/Mahe'),
(338, 'SD', 'Africa/Khartoum'),
(339, 'SE', 'Europe/Stockholm'),
(340, 'SG', 'Asia/Singapore'),
(341, 'SH', 'Atlantic/St_Helena'),
(342, 'SI', 'Europe/Ljubljana'),
(343, 'SJ', 'Arctic/Longyearbyen'),
(344, 'SK', 'Europe/Bratislava'),
(345, 'SL', 'Africa/Freetown'),
(346, 'SM', 'Europe/San_Marino'),
(347, 'SN', 'Africa/Dakar'),
(348, 'SO', 'Africa/Mogadishu'),
(349, 'SR', 'America/Paramaribo'),
(350, 'SS', 'Africa/Juba'),
(351, 'ST', 'Africa/Sao_Tome'),
(352, 'SV', 'America/El_Salvador'),
(353, 'SX', 'America/Lower_Princes'),
(354, 'SY', 'Asia/Damascus'),
(355, 'SZ', 'Africa/Mbabane'),
(356, 'TC', 'America/Grand_Turk'),
(357, 'TD', 'Africa/Ndjamena'),
(358, 'TF', 'Indian/Kerguelen'),
(359, 'TG', 'Africa/Lome'),
(360, 'TH', 'Asia/Bangkok'),
(361, 'TJ', 'Asia/Dushanbe'),
(362, 'TK', 'Pacific/Fakaofo'),
(363, 'TL', 'Asia/Dili'),
(364, 'TM', 'Asia/Ashgabat'),
(365, 'TN', 'Africa/Tunis'),
(366, 'TO', 'Pacific/Tongatapu'),
(367, 'TR', 'Europe/Istanbul'),
(368, 'TT', 'America/Port_of_Spain'),
(369, 'TV', 'Pacific/Funafuti'),
(370, 'TW', 'Asia/Taipei'),
(371, 'TZ', 'Africa/Dar_es_Salaam'),
(372, 'UA', 'Europe/Kiev'),
(373, 'UA', 'Europe/Uzhgorod'),
(374, 'UA', 'Europe/Zaporozhye'),
(375, 'UG', 'Africa/Kampala'),
(376, 'UM', 'Pacific/Johnston'),
(377, 'UM', 'Pacific/Midway'),
(378, 'UM', 'Pacific/Wake'),
(379, 'US', 'America/New_York'),
(380, 'US', 'America/Detroit'),
(381, 'US', 'America/Kentucky/Louisville'),
(382, 'US', 'America/Kentucky/Monticello'),
(383, 'US', 'America/Indiana/Indianapolis'),
(384, 'US', 'America/Indiana/Vincennes'),
(385, 'US', 'America/Indiana/Winamac'),
(386, 'US', 'America/Indiana/Marengo'),
(387, 'US', 'America/Indiana/Petersburg'),
(388, 'US', 'America/Indiana/Vevay'),
(389, 'US', 'America/Chicago'),
(390, 'US', 'America/Indiana/Tell_City'),
(391, 'US', 'America/Indiana/Knox'),
(392, 'US', 'America/Menominee'),
(393, 'US', 'America/North_Dakota/Center'),
(394, 'US', 'America/North_Dakota/New_Salem'),
(395, 'US', 'America/North_Dakota/Beulah'),
(396, 'US', 'America/Denver'),
(397, 'US', 'America/Boise'),
(398, 'US', 'America/Phoenix'),
(399, 'US', 'America/Los_Angeles'),
(400, 'US', 'America/Anchorage'),
(401, 'US', 'America/Juneau'),
(402, 'US', 'America/Sitka'),
(403, 'US', 'America/Metlakatla'),
(404, 'US', 'America/Yakutat'),
(405, 'US', 'America/Nome'),
(406, 'US', 'America/Adak'),
(407, 'US', 'Pacific/Honolulu'),
(408, 'UY', 'America/Montevideo'),
(409, 'UZ', 'Asia/Samarkand'),
(410, 'UZ', 'Asia/Tashkent'),
(411, 'VA', 'Europe/Vatican'),
(412, 'VC', 'America/St_Vincent'),
(413, 'VE', 'America/Caracas'),
(414, 'VG', 'America/Tortola'),
(415, 'VI', 'America/St_Thomas'),
(416, 'VN', 'Asia/Ho_Chi_Minh'),
(417, 'VU', 'Pacific/Efate'),
(418, 'WF', 'Pacific/Wallis'),
(419, 'WS', 'Pacific/Apia'),
(420, 'YE', 'Asia/Aden'),
(421, 'YT', 'Indian/Mayotte'),
(422, 'ZA', 'Africa/Johannesburg'),
(423, 'ZM', 'Africa/Lusaka'),
(424, 'ZW', 'Africa/Harare');