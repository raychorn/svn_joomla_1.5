# $Id: install.sql 241 2008-03-09 22:46:55Z richard $
# smartsef SQL installation file
# --------------------------------------------------------
DROP TABLE IF EXISTS `#__smartsef_urls`;
CREATE TABLE  `#__smartsef_urls` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `url_sef` varchar(255) NOT NULL default '',
  `url_orginal` varchar(255) NOT NULL default '',
  `cache` text NOT NULL,
  `published` tinyint(3) unsigned NOT NULL default '0',
  `temp_key` varchar(10) NOT NULL default '',
  `vars` varchar(255) NOT NULL default '',
  `delete_locked` tinyint(1) unsigned NOT NULL,
  `valid` tinyint(3) unsigned NOT NULL,
  `remarks` text NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `block_rewrite` tinyint(1) unsigned NOT NULL default '0',
  `sef_tmp_url` varchar(255) NOT NULL default '',
  `checked_out` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `url_orginal` (`url_orginal`),
  KEY `url_sef` (`url_sef`)
) TYPE=MyISAM CHARACTER SET `utf8`;

DROP TABLE IF EXISTS `#__smartsef_router_setting`;
CREATE TABLE  `#__smartsef_router_setting` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `router_type` int(10) unsigned NOT NULL default '0',
  `rewrite_rule` int(10) unsigned NOT NULL default '0',
  `component_alias` varchar(255) NOT NULL default '',
  `component` varchar(45) NOT NULL default '',
   `bypass_post_redirect` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM CHARACTER SET `utf8`;

DROP TABLE IF EXISTS `#__smartsef_plugins`;
CREATE TABLE  `#__smartsef_plugins` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `published` tinyint(3) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  `author` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `version` varchar(10) NOT NULL,
  `author_url` varchar(255) NOT NULL,
  `plugin` varchar(45) NOT NULL,
  `checked_out` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM CHARACTER SET `utf8`;
INSERT INTO `#__smartsef_plugins` (`id`, `name`, `published`, `params`, `author`, `description`, `version`, `author_url`, `plugin`) VALUES
(1, 'Smartsefplugin-Newsfeeds', 1, 'url_prefix_path=newsfeeds\nCategory numbers allowed in URL=1\n\n', 'Richard@joomlatwork.com', 'Smartsef plugin for the newsfeeds SEF urls', '1.0', 'www.smartsef.org', 'plg_com_newsfeeds'),
(2, 'Smartsefplugin-weblinks', 1, '', 'Richard@joomlatwork.com', 'Smartsef plugin for the weblinks SEF urls', '1.0', 'www.smartsef.org', 'plg_com_weblinks'),
(3, 'Smartsefplugin-user', 1, '', 'Richard@joomlatwork.com', 'Smartsef plugin for the user SEF urls', '1.0', 'www.smartsef.org', 'plg_com_user'),
(4, 'Smartsefplugin-mailto', 1, '', 'Richard@joomlatwork.com', 'Smartsef plugin for the mailto SEF urls', '1.0', 'www.smartsef.org', 'plg_com_mailto'),
(5, 'Smartsefplugin-search', 1, '', 'Richard@joomlatwork.com', 'Smartsef plugin for the search SEF urls', '1.0', 'www.smartsef.org', 'plg_com_search'),
(6, 'Smartsefplugin-virtuemart 1.1', 1, 'url_prefix_path=shop\npage_alias_browse=\npage_alias_product_details=details\npage_alias_flypage=flyer\npage_alias_ask=question\nprint_alias=print\nurl_append_product_id=0\nurl_structure_product=1\n\n', 'Richard@joomlatwork.com', 'Smartsef plugin for the virtuemart 1.1 SEF urls ', '1.0', 'www.smartsef.org', 'plg_com_virtuemart'),
(7, 'Smartsefplugin-Contact', 1, 'url_prefix_path=contact\n\n', 'Richard@joomlatwork.com', 'Smartsef plugin for the contact SEF urls', '1.0', 'www.smartsef.org', 'plg_com_contact');


INSERT INTO `#__plugins` ( `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES ('System - Smartsef', 'smartsef', 'system', 0, 7, 1, 0, 0, 0, '0000-00-00 00:00:00', '');