<?php
/**
* @version		$Id: plg_com_newsfeeds.php 230 2008-02-20 19:17:37Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
* Newsfeeds plugin for SmartSEF. The default newsfeeds router doesn't used the view and catid if its linked to the menu
* Customized this to the view;
*/
function NewsfeedsBuildRoute( $query)
{
	global $_newsfeeds_alias;
	$db =& JFactory::getDBO();
	$segments = array();

	// Fetch the parameter settings from the plugins, use global alias parameter for only 1 sql query;
	if ( $_newsfeeds_alias == NULL ) {
		$sql = "SELECT params FROM #__smartsef_plugins WHERE plugin='plg_com_newsfeeds'" ;
		$db->setQuery($sql );
		$params = $db->loadResult();
		if ( $params != NULL) {
			$params	= new JParameter( $params );
			$_newsfeeds_alias = $params->get( 'url_prefix_path');
		}
	}
	if ( $_newsfeeds_alias != NULL ) {
		$segments[] = $_newsfeeds_alias;
	}


	if(isset($query['view']))
	{
		if(empty($query['Itemid'])) {
			$segments[] = $query['view'];
		}

		unset($query['view']);
	};

	if(isset($query['catid']))
	{
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
		unset($query['id']);;
	};

	return $segments;
}
?>
