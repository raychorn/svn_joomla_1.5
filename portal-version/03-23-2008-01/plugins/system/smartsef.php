<?php
/*
* @version		$Id: smartsef.php 240 2008-03-08 23:33:55Z richard $
* @package		Smartsef
* @subpackage	Plugin - System
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();


class  plgSystemsmartsef extends JPlugin {

	function plgSystemsmartsef(& $subject, $config) {
		parent::__construct($subject, $config);
	}

	/*
	 * Assign the new router for the SEF URL rewritting;
	 */

	function onAfterInitialise() {
		global $mainframe;
		if( $mainframe->isAdmin()) {
		 	return;
		}

		 // check if smartsef is enabled
		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'config'.DS.'configuration.php' );
		$sef_config =  new smartsef_configuration();


		if ( $sef_config->mode == 1) {
			$router =& $mainframe->getRouter();
			require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'includes'.DS.'mainrouter.php' );
			$router = new smartsefRouter();
		}
	}

	function onAfterRender() {


		global $mainframe;
		if($mainframe->isAdmin()) {
		 	return;
		}

		$is_inserted = FALSE;

		global $mainframe;
		$db =& JFactory::getDBO();

		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'config'.DS.'configuration.php' );
		$sef_config =  new smartsef_configuration();
		// Return for the admin part and if the sef is not enabled
		if($mainframe->isAdmin() | ( $sef_config->mode == 0)) {
		 	return;
		 }
		// check if there is any URL that must be rewritten...
		// Get the URL buffer of the router
		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'includes'.DS.'functions.php' );
		$tmp_key = mKey(10);

		$router =& $mainframe->getRouter();

		/*
		 * Check if the current cache needs to be cleanup;
		 */
		$cache_cleanup_ids = "";
		$cache_cleanup = FALSE;
		if ( count( $router->_buffer_smartsef)) {
			foreach ( $router->_buffer_smartsef as $cache_element ) {
				if ( $cache_element['published'] == 0) {
					if ( $cache_cleanup_ids == "") {
						$cache_cleanup_ids = $cache_element['id'];
					} else {
						$cache_cleanup_ids .= ',' . $cache_element['id'];
					}
				} else {
					$cache_cleanup == TRUE;
				}
			}
		}

		// Define an unique key, to identify the insertions and put these into the cache table of the requested URL;
		if (isset( $router->sef_repos['_sef_new_urls'])) {
			$new_urls = $router->sef_repos['_sef_new_urls'];
			$sql_insert_urls= array();
			$query_buffer = array();
			foreach ( $new_urls as $url_entry) {

				if ($url_entry['orginal'] != "" & $url_entry['rewrite'] != '') {
					// check if the record exists;
					$query = "SELECT id FROM #__smartsef_urls WHERE url_orginal = '" . $url_entry['orginal']. "'";
					$db->setQuery( $query );
					$id = $db->loadResult();
					if ( $id == "") {
						$vars = serialize(  $url_entry['vars']);
						if ( $url_entry['rewrite'] != '') {
							$query_buffer[] =  "('" . $tmp_key . "','" . $url_entry['orginal']. "','" . $url_entry['rewrite'] ."','" . $vars . "','1'," . $url_entry['priority']. ")";
						}

					} else {
						// key already exits but add it to the cache buffer;
						if ( $router->_cache_key_string != "" ) {
							$router->_cache_key_string .= ",";
						}
						$router->_cache_key_string .= $id;
					}
				}
			}
			if ( count($query_buffer) > 0 ) {
				$query = "INSERT INTO #__smartsef_urls( temp_key, url_orginal, url_sef, vars, published, ordering ) VALUES " . implode(",", $query_buffer);
				$db->setQuery( $query );
				if (!$db->query()) {
					die();
					JError::raiseError( 500, $db->getError() );
				}
				$query = "SELECT id FROM #__smartsef_urls WHERE temp_key = '" . $tmp_key . "'";
				$db->setQuery( $query );

				$keys = $db->loadAssocList();
				$key_string = "";
				foreach ( $keys as $cache_element ) {
					if ( $key_string != "" ) {
						$key_string .= ",";
					}
					$key_string .= $cache_element['id'];
				}
				// store the cache records;
				$router->_cache_key_string .= $key_string;
			}

		}
		if ( $router->_cache_key_string != "" & !$router->_is_404page) {
			// Create an unique string

			if ( $cache_cleanup_ids != "") {
				$input_str = $cache_cleanup_ids . ", " .$router->_cache_key_string ;
			} else {
				$input_str = $router->_cache_key_string ;
			}
			$Arr_ins = explode (",", $input_str );
			$Arr_ins = array_unique($Arr_ins);
			$router->_cache_key_string = implode(",", $Arr_ins);
			JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'tables');
			$smartsef_row =& JTable::getInstance('smartsef_urls', 'Table');
			if ( isset($router->sef_repos['_id']) ) {
				$smartsef_row->load( $router->sef_repos['_id'] );
				$smartsef_row->cache = $router->_cache_key_string;
				$smartsef_row->store();
			}
		}
		// TODO: future functionality to add a 404 logfile;

	}

}

?>