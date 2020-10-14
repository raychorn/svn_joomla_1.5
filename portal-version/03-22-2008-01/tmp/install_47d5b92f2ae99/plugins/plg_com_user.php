<?php
/**
* @version		$Id: plg_com_user.php 230 2008-02-20 19:17:37Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/

function UserBuildRoute( $query)
{
	global $_user_alias;
	$db =& JFactory::getDBO();
	$tmp_query = $query;
	$segments = array();
	// Fetch the parameter settings from the plugins, use global alias parameter for only 1 sql query;
	if ( $_user_alias == NULL ) {
		$sql = "SELECT params FROM #__smartsef_plugins WHERE plugin='plg_com_user'" ;
		$db->setQuery($sql );
		$params = $db->loadResult();
		if ( $params != NULL) {
			$params	= new JParameter( $params );
			$_user_alias = $params->get( 'url_prefix_path');
		}
	}
	if ( $_user_alias != NULL ) {
		$segments[] = $_user_alias;
	} else {
		$segments[] = 'user';
	}

	if(isset($tmp_query['view'])){
		$segments[] = $query['view'];
		unset( $tmp_query['view']);
	};
	if(isset($tmp_query['task'])){
		$segments[] = $tmp_query['task'];
		unset($tmp_query['task']);
	};
	if (isset($tmp_query)) {
		foreach( $tmp_query as $param => $value ) {
			$segments[] = $value;
		}
	}

	return $segments;
}


?>