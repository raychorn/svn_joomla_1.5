<?php
/* @version		$Id: install.smartsef.php 208 2008-02-02 10:47:21Z richard $
* @package		smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/

// Install the smarterror system plugin and start the smarterror control pannel;
// Check to ensure this file is within the rest of the framework

defined('JPATH_BASE') or die();
global $mainframe;

$file_destination_php = JPATH_PLUGINS.DS.'system'.DS.'smartsef.php';
$file_destination_xml = JPATH_PLUGINS.DS.'system'.DS.'smartsef.xml';

$file_orginal_php = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'install'.DS.'plugins'.DS.'smartsef.php';
$file_orginal_xml = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'install'.DS.'plugins'.DS.'smartsef.xml';

@copy ($file_orginal_php, $file_destination_php );
@copy ($file_orginal_xml, $file_destination_xml );

if (file_exists ($file_destination_php ) & file_exists ($file_destination_php ) ) {
	$mainframe->redirect( 'index.php?option=com_smartsef','SmartSEF extension and plugin is successfully installed' );
} else {
	$mainframe->redirect( 'index.php?option=com_smartsef','NOTICE: the SmartSEF system plugin is not successfully installed. Make sure that the plugin directory is writeable' );
}

?>