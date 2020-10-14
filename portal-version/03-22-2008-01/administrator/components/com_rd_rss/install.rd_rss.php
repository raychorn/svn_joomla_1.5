<?php
/**
 * 
 * @version $Id: install.rd_rss.php,v 1.1.1.1 2005/12/20 15:49:40 deutz Exp $
 * @package RdRss
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * 
 * This is free software
 * 
 * changed to show all sections and categories as rss feed by Robert Deutz 
 *         joomla at run-digital dot com
 **/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// function com_install
function com_install() {
	global $database;
	global $mosConfig_live_site;
	
	$i = 0;
	$sucess = 1;
	
	// check if table rd_rss 
	$update = 0;
	$tables = $database->getTableList();
	
	foreach ($tables as $elm) {
		$update = $update + substr_count(strtolower($elm), '_rd_rss');	
	}

	if ($update) {
		// noting to do at the moment
	} else {	
		// first install 
		$database->setQuery( "CREATE TABLE `#__rd_rss` ("
		."     `id` int(11) unsigned NOT NULL auto_increment,"
		."     `catids` text NOT NULL,"
		."     `name` varchar(255) NOT NULL default '',"
		."     `published` tinyint(1) NOT NULL default '0',"
		."     `created` datetime NOT NULL default '0000-00-00 00:00:00',"
		."     `created_by` int(11) unsigned NOT NULL default '0',"
		."     `modified` datetime NOT NULL default '0000-00-00 00:00:00',"
		."     `modified_by` int(11) unsigned NOT NULL default '0',"
		."     `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',"
		."     `checked_out` int(11) unsigned NOT NULL default '0',"
		."     `state` tinyint(3) NOT NULL default '0',"
		."     `params` text NOT NULL,"
		."     PRIMARY KEY  (`id`)"
		."   ) TYPE=MyISAM ");
	
		$what[$i] = "Create Table #__rd_rss";
		$result[$i] = $database->query();
		$err=$database->getErrorMsg();
		if ($result[$i]) {$result[$i] = "sucess";} else {$result[$i] = "fail: $err";$sucess = 0;}
		$i++;

		$database->setQuery("INSERT INTO `#__rd_rss` " .
			"(`id`,`name`,`published`) " .
			" VALUES " .
			"(1,'FRONTPAGE','1')");
		$what[$i] = "Add Frontpage Rssfeed";
		$result[$i] = $database->query();
		$err=$database->getErrorMsg();
		if ($result[$i]) {$result[$i] = "sucess";} else {$result[$i] = "fail: $err";$sucess = 0;}
		$i++;

	}

	// Readmessage
	$msg = "";
	$msg .=  "<p style=\"font-size:1.3em;\">";
	$msg .= "<table width=\"100%\" border=\"0\">";
	$msg .= "<tr><td><br /><br />Installationresults:</td></tr>";
	// show installationresults
	for($zz = 0; $zz < $i ; $zz++) {
			$msg .= "<tr><td>ToDo: $what[$zz] Result: $result[$zz]";
			$msg .= "</td></tr>"; 
	}	
	$msg .= "<tr><td><br/><font class=\"small\">&copy; Copyright 2005 by Robert Deutz - <a href=\"http://www.run-digital.com\" target=\"_blank\">Run Digital</a></font><br/>";
	$msg .= "<br/>";
	$msg .= "</td></tr></table></center>";
	$msg .= "<hr>";
	return $msg;
	// if ($sucess) {return true;} {return false;}
}

/** EOF **/?>