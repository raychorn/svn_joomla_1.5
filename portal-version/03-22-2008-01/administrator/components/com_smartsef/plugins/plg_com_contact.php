<?php
/**
* @version		$Id: plg_com_contact.php 235 2008-03-08 13:38:30Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
* Newsfeeds plugin for SmartSEF. The default newsfeeds router doesn't used the view and catid if its linked to the menu
* Customized this to the view;
*/
function contactBuildRoute( $query)
{
	global $_contact_alias;
	$db =& JFactory::getDBO();
	$segments = array();

	// Fetch the parameter settings from the plugins, use global alias parameter for only 1 sql query;
	if ( $_contact_alias == NULL ) {
		$sql = "SELECT params FROM #__smartsef_plugins WHERE plugin='plg_com_contact'" ;
		$db->setQuery($sql );
		$params = $db->loadResult();
		if ( $params != NULL) {
			$params	= new JParameter( $params );
			$_contact_alias = $params->get( 'url_prefix_path');
		}


	}
	if ( $_contact_alias != NULL ) {
		$segments[] = $_contact_alias;
	}


	if(isset($query['view']))
	{
		if( $query['view'] = 'category') {
			// get the category id;
			$cat_array = explode ( ':', $query['catid']);
	 		$catid = $cat_array[0];
			if ( !empty($catid)) {
				$sql = "SELECT alias FROM #__categories WHERE id = " . $catid;
				$db->setQuery($sql);
				$segments[] = $db->loadResult();
			}

		}
	};

	if(isset($query['id']))
	{
		// remove the numbers, has no function overhere;
		$contact_array = explode ( ':', $query['id']);
 		$id = $contact_array[0];
		if (!empty($id)) {
			// Get the contact name

			$sql = "SELECT alias FROM #__contact_details WHERE id=" . $id;
			$db->setQuery($sql);
			$segments[] = $db->loadResult();
		}
	};

	if ( isset( $query['format'])) {
		// Add to the lastest element the type

		$last_element = count($segments) - 1;
		$segments[$last_element] = $segments[$last_element] . '.' . $query['type'];
	}

	return $segments;
}
?>
