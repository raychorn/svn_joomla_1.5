<?php
/**
* @version		$Id: plg_com_weblinks.php 230 2008-02-20 19:17:37Z richard $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

function WeblinksBuildRoute( $query )
{
	global $_weblinks_alias;
	$db =& JFactory::getDBO();

	$segments = array();
	// Fetch the parameter settings from the plugins, use global alias parameter for only 1 sql query;
	if ( $_weblinks_alias == NULL ) {
		$sql = "SELECT params FROM #__smartsef_plugins WHERE plugin='plg_com_weblinks'" ;
		$db->setQuery($sql );
		$params = $db->loadResult();
		if ( $params != NULL) {
			$params	= new JParameter( $params );
			$_weblinks_alias = $params->get( 'url_prefix_path');
		}
	}
	if ( $_weblinks_alias != NULL ) {
		$segments[] = $_weblinks_alias;
	} else {
		$segments[] = 'weblinks';
	}

	if(isset($query['catid']))
	{
		// remove the numbers, has no function overhere;
		$segments[] = preg_replace( '/[0-9]:/','', $query['catid']);
		unset($query['catid']);
	};

	if(isset($query['id']))
	{
		// remove the numbers, has no function overhere;
		$link = preg_replace( '/[0-9]:/','', $query['id']);
		if (isset( $query['type'])) {
			$link .= "." . $query['type'];
		}
		$segments[] = $link;
		unset($query['id']);
	};


	unset($query['view']);
	if ( count($segments) == 0) {
		$segments=$default_segments;
	}
	return $segments;
}

?>