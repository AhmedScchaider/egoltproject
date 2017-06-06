CREATE TABLE IF NOT EXISTS `#__egoltproject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `jed` varchar(255) NOT NULL,
  `imageurl` varchar(255) NOT NULL,
  `published` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__egoltproject_compats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(100) NOT NULL,
  `imageurl` varchar(255) NOT NULL,
  `published` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__egoltproject_compats_lg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(7) NOT NULL,
  `compat_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `compat_id` (`compat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__egoltproject_downloads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `compat_id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `license_id` int(10) unsigned NOT NULL,
  `uname` varchar(255) NOT NULL,
  `version` varchar(15) NOT NULL DEFAULT '1.0',
  `status` tinyint(4) NOT NULL DEFAULT '5',
  `dtype` int(4) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `hit` int(10) unsigned NOT NULL DEFAULT '0',
  `demo` varchar(255) NOT NULL,
  `demo_gallery` varchar(255) NOT NULL,
  `jed` varchar(255) NOT NULL,
  `pubdate` datetime NOT NULL,
  `published` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `license_id` (`license_id`),
  KEY `project_id` (`project_id`,`compat_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__egoltproject_downloads_langs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `download_id` int(10) unsigned NOT NULL,
  `lang_code` char(7) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `langfile` varchar(255) NOT NULL,
  `pubdate` datetime NOT NULL,
  `hit` int(10) NOT NULL DEFAULT '0',
  `published` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `download_id` (`download_id`,`lang_code`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__egoltproject_downloads_lg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(7) NOT NULL,
  `download_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `doc_cat` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `download_id` (`download_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__egoltproject_lg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(7) NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `intro` text NOT NULL,
  `fulltext` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__egoltproject_licenses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `published` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__egoltproject_licenses_lg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(7) NOT NULL,
  `license_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `license_id` (`license_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__egoltproject_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `download_id` int(10) unsigned NOT NULL,
  `logname` varchar(255) NOT NULL,
  `logemail` varchar(255) NOT NULL,
  `logip` char(16) NOT NULL,
  `logdate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`,`download_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__egoltproject_reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `download_id` int(10) unsigned NOT NULL,
  `lang_code` char(7) NOT NULL,
  `comment` text NOT NULL,
  `commenter` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `pubdate` datetime NOT NULL,
  `published` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`download_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;




INSERT IGNORE INTO `#__egoltproject` (`id`, `alias`, `jed`, `imageurl`, `published`) VALUES
(1, 'myproject', 'http://extensions.joomla.org/extensions/directory-a-documentation/downloads/20302', 'egoltproject_big.png', 1);

INSERT IGNORE INTO `#__egoltproject_compats` (`id`, `alias`, `imageurl`, `published`) VALUES
(2, 'j25', 'j25.png', 1);

INSERT IGNORE INTO `#__egoltproject_compats_lg` (`id`, `lang_code`, `compat_id`, `name`, `notes`) VALUES
(2, 'en-GB', 2, 'Joomla! 2.5', '<p style="text-align: justify;">Joomla is one of the world’ s most popular open source CMS (content management system). With millions of websites running on Joomla, the software is used by individuals, small &amp; medium-sized businesses, and large organizations worldwide to easily create &amp; build a variety of websites &amp; web-enabled applications.</p>');

INSERT IGNORE INTO `#__egoltproject_downloads` (`id`, `project_id`, `compat_id`, `user_id`, `license_id`, `uname`, `version`, `status`, `dtype`, `filename`, `hit`, `demo`, `demo_gallery`, `jed`, `pubdate`, `published`) VALUES
(1, 1, 2, 42, 2, 'com_xxxxmyproject', '1.0', 1, 1, 'test.zip', 16, 'http://www.egolt.com', '', 'http://extensions.joomla.org/extensions/directory-a-documentation/downloads/20302', '2012-04-09 05:06:56', 1);

INSERT IGNORE INTO `#__egoltproject_downloads_langs` (`id`, `download_id`, `lang_code`, `user_id`, `langfile`, `pubdate`, `hit`, `published`) VALUES
(1, 1, 'en-GB', 42, 'test_lang.zip', '2012-04-09 05:13:09', 1, 1);

INSERT IGNORE INTO `#__egoltproject_downloads_lg` (`id`, `lang_code`, `download_id`, `title`, `notes`, `doc_cat`) VALUES
(1, 'en-GB', 1, 'My Project Component', '<p>This is component of My Project for joomla 2.5 .</p>', 0);

INSERT IGNORE INTO `#__egoltproject_lg` (`id`, `lang_code`, `project_id`, `title`, `intro`, `fulltext`) VALUES
(1, 'en-GB', 1, 'My Project', '<p>This is intro of my project.</p>', '<p>This is full text of my project.</p>');

INSERT IGNORE INTO `#__egoltproject_licenses` (`id`, `alias`, `published`) VALUES
(2, 'gpl_2', 1);

INSERT IGNORE INTO `#__egoltproject_licenses_lg` (`id`, `lang_code`, `license_id`, `name`, `notes`) VALUES
(2, 'en-GB', 2, 'GPL', '<p>This is description of gpl license.</p>');

INSERT IGNORE INTO `#__egoltproject_logs` (`id`, `project_id`, `download_id`, `logname`, `logemail`, `logip`, `logdate`) VALUES
(1, 1, 1, 'Soheil Novinfard', 'test@test.com', '127.0.0.1', '2012-04-09'),
(2, 1, 1, 'Mark Ones', 'test2@test2.com', '127.0.0.1', '2012-04-09');

INSERT IGNORE INTO `#__egoltproject_reviews` (`id`, `download_id`, `lang_code`, `comment`, `commenter`, `email`, `website`, `pubdate`, `published`) VALUES
(1, 1, 'en-GB', 'Excellent, Fully documented.', 'Ahmad Kaya', '', '', '2012-04-09 06:58:05', 1);
