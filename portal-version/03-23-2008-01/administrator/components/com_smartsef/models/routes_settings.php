<?php
/* @version		$Id: routes_settings.php 235 2008-03-08 13:38:30Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
* Router setting controler. Check the behauviour of the available router and gives the ability to disable the
* local routers from the components available.
* This is only if there are no smartsef plugins available.
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport( 'joomla.application.component.model' );

class routes_settingsModelroutes_settings extends Jmodel {

	var $_data = null;


	function purge( ) {
		$query = 'TRUNCATE TABLE #__smartsef_router_setting';
		$this->_db->setQuery( $query );
		$this->_db->query();
	}

	function save( ) {
		$component_alias 		= JRequest::getVar('component_alias');
		$rewrite_rule 			= JRequest::getVar('rewrite_rule');
		$bypass_post_redirect 	= JRequest::getVar('bypass_post_redirect');

		foreach ( $component_alias as $alias => $value ) {

			$query = "UPDATE #__smartsef_router_setting SET component_alias='" . trim($value) . "', rewrite_rule='" . $rewrite_rule[$alias] . "', bypass_post_redirect='". $bypass_post_redirect[$alias] ."' WHERE id=" . $alias;
			$this->_db->setQuery( $query );
			$this->_db->query();
		}


	}

	function check_state_routers() {

		// Make a list of the available components
		// remove the components that are present as smartsef routers which are enabled;
		// Save for each component a local setting configuration file (if not already present;
		// --> set the router version -> 1.5 or 1.0x router;
		// config settings:
		// - enable local router
		// - alias name for the component if no router is present;
		$filter = "'com_smartsef', 'com_wrapper', 'com_content', 'com_config','com_media','com_installer','com_templates','com_plugins','com_modules','com_cpanel','com_cache','com_messages','com_menus','com_massmail','com_languages','com_users'";
		$query = 'SELECT distinct j.option, j.id from #__components as j WHERE j.option != "" AND j.option not in  ( ' . $filter . ')';

		$this->_db->setQuery( $query );
		$components = $this->_db->loadObjectList();

		foreach ( $components as $component ) {
			/*
			 * Check if there is a plugin or if there is a local router, check if there is a file with			 *
			 */
			$plg_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'plugins'.DS.'plg_' . $component->option . '.php';
			if (!file_exists( $plg_path)) {

				/*
				 * check if there is already a record available;
				 */
				$query = "select count(*) FROM #__smartsef_router_setting WHERE component = '" .$component->option . "'";
				$this->_db->setQuery( $query );
				$total = $this->_db->loadResult();
				if ( $total < 1 ) {
					// not a record present, created one with the default settings;
					// check if it's a 1.0 or 1.5 router available or if nothing is present;
					// -1 means no router present;
					$router_type = 0;
					$path = JPATH_SITE.DS.'components'.DS. $component->option.DS.'router.php';
					if ( file_exists ( $path )) {
						$router_type = 1;
					}
					if ( $router_type == 0) {
						$path = JPATH_SITE.DS.'components'.DS.$component->option.DS.'sef_ext.php';
						if ( file_exists ( $path )) {
							$router_type = 2;
						}
					}
					if ( $router_type != 0 ) {
						$rewrite_type = 1;
					} else {
						$rewrite_type = 2;
					}
					$com_alias = str_replace('com_', '', $component->option );
					$query = "INSERT INTO #__smartsef_router_setting ( router_type, rewrite_rule, component_alias, component, bypass_post_redirect ) VALUES ( '" . $router_type  . "', '" . $rewrite_type . "',' " . $com_alias."', '". $component->option. "', '0')";
					$this->_db->setQuery( $query );
					$this->_db->query();
				}
			} else {
				// remove it from the database (to clean up the settings)
				$query = "DELETE FROM #__smartsef_router_setting WHERE component = '" .$component->option . "'";
				$this->_db->setQuery( $query );
				$this->_db->Query();
			}
		}
	}

	function getData()	{
		if (empty($this->_data)){
			$query = "SELECT * FROM #__smartsef_router_setting";
			$this->_data = $this->_getList($query );
		}
		return $this->_data;
	}
}
?>