<?php
/**
* @version		$Id: plg_com_mailto.php 230 2008-02-20 19:17:37Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/

function mailtoBuildRoute( $query)
{
	global $_mailto_alias;

	$db =& JFactory::getDBO();
	$host = "";
	if (isset($_SERVER['HTTP_HOST'])) {
		$host = $_SERVER['HTTP_HOST'];
	}
	$segments = array();

	// Fetch the parameter settings from the plugins, use global alias parameter for only 1 sql query;
	if ( $_mailto_alias == NULL ) {
		$sql = "SELECT params FROM #__smartsef_plugins WHERE plugin='plg_com_mailto'" ;
		$db->setQuery($sql );
		$params = $db->loadResult();
		if ( $params != NULL) {
			$params	= new JParameter( $params );
			$_mailto_alias = $params->get( 'url_prefix_path');
		}
	}
	if ( $_mailto_alias != NULL) {
		$segments[] = $_mailto_alias;
	} else {
		// set the default;
		$segments[] = 'mailto';
	}

	if(isset($query['link'])){
		// limit the string length with a substr of 25 this because the standard joomla string is sometimes more then 255 chars..
		$link =  str_replace('http://', '', base64_decode($query['link']));
		$link =  str_replace( $host, '', $link);
		if (substr($link,0,1) == '/') {
			$link = substr( $link, 1, strlen($link)-1);
		}
		$segments[]=rtrim($link,'/');

	};
	return $segments;
}


?>