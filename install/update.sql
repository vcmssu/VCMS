ALTER TABLE `category` ADD `user` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `text`;
ALTER TABLE `files` ADD `user` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `status`;
ALTER TABLE `files` ADD INDEX(`user`);
ALTER TABLE `news` ADD `timemail` INT(11) NOT NULL AFTER `time`;

INSERT INTO `setting` (`name`,`value`) VALUES ( 'count_txt', '5000');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'balls_add_theme', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'balls_add_post', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'balls_add_blog', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'balls_add_library', '1');
INSERT INTO `setting` (`name`,`value`) VALUES ( 'balls_add_download', '1');

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