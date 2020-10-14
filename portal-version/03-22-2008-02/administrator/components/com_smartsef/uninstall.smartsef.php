<?php
/* @version		$Id: uninstall.smartsef.php 205 2008-01-30 22:32:57Z richard $
* @package		smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
* Note: when the system plugins are removed a system error occured when uninstall, leaving the files
* cannot harm;
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
function com_uninstall() {
	global $mainframe;
	//$file_destination_php = JPATH_PLUGINS.DS.'system'.DS.'smartsef.php';
	//$file_destination_xml = JPATH_PLUGINS.DS.'system'.DS.'smartsef.xml';
	//@unlink($file_destination_php);
	//@unlink($file_destination_xml);
	//$mainframe->setRedirect( 'index.php?option=com_installer','Smartsef extension and plugin are succesfull uninstalled' );
	return true;
}

?>