<?php
/**
* @version		$Id: plg_com_search.php 235 2008-03-08 13:38:30Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/

function searchBuildRoute($query)
{
	global $_search_alias;
	$db =& JFactory::getDBO();

	$segments = array();
	// Fetch the parameter settings from the plugins, use global alias parameter for only 1 sql query;
	if ( $_search_alias == NULL ) {
		$sql = "SELECT params FROM #__smartsef_plugins WHERE plugin='plg_com_search'" ;
		$db->setQuery($sql );
		$params = $db->loadResult();
		if ( $params != NULL) {
			$params	= new JParameter( $params );
			$_search_alias = $params->get( 'url_prefix_path');
		}
	}
	if ( $_search_alias != NULL ) {
		$segments[] = $_search_alias;
	} else {
		$segments[] = 'search';
	}
	if (isset($query['Itemid'])) {
		unset($query['Itemid']);
	}
	if (isset($query['option'] )) {
		unset($query['option']);
	}

	foreach ( $query as $name => $value) {
		$segments[] = $value;
	}

	// check if there are filters set for the search
	if (isset( $_POST['areas'])) {
		foreach ( $_POST['areas'] as $filter ) {
			$segments[] = $filter;
		}
	}
	return $segments;
}


?>