<?php
/* @version		$Id: mainrouter.php 240 2008-03-08 23:33:55Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

class smartsefRouter extends JRouterSite {

	var $sef_repos = NULL;
	var $sef_config = NULL;
	var $_subdir = NULL;
	var $_buffer_smartsef = NULL;
	var $_cache_key_string = NULL;
	var $_buffer_smartsef_plugins = NULL;
	var $_buffer_smartsef_router_setting = NULL;
	var $_is_post = null;
	var $_is_resolved = null;
	var $_is_404page = null;

	function smartsefRouter($options = array()) {
		parent:: __construct($options);
		$this->_mode = 1;
		$this->sef_repos = array();
		$this->url_orginal = null;
		// read the configuration file
		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'config'.DS.'configuration.php' );
		$this->sef_config =  new smartsef_configuration();
		$this->_buffer_smartsef = array();
		$this->_is_post = false;
		$this->_is_resolved = false;
		$this->_is_404page = false;

	}

	/*
	 * The parse function handles the incomming URL ;
	 */
	function parse( &$uri ){
		global $mainframe;

		$db =& JFactory::getDBO();
		$vars = array();
		$result = false;
		$is_present = FALSE;
		if(is_string($uri)) {
			$uri = JURI::getInstance($uri);
		}

		if ( count( $_POST) > 0) {
			// Establish the non-sef URL and return the POST
			// Don't rewrite the post
			$this->_is_post = true;
			$vars += parent::parse($uri);

			if ( isset($_POST['return']) ) {

				if ( !isset( $_POST['force_session'])) {
					// Virtuemart hack
					return $_REQUEST;
				}
			}
			// This should be within the router configuration;

			// Check if the POST must be return direct;
			if ( !empty($_REQUEST['option'] )) {
				$query = "SELECT bypass_post_redirect FROM #__smartsef_router_setting WHERE component='" . $_REQUEST['option'] . "'";
				$db->setQuery ( $query );
				$bypass = $db->loadResult();

				if ( $_REQUEST['option'] == 'com_user') {
					$bypass = true;
				}
				if ( !empty( $bypass )) {
					if ( $bypass == 1 ) {
						return $_REQUEST;
					}
				}
			}

		}

		// If the path is equal to "/" it means that the first element of the mainmenu is requested.
		// The URL can then be retrieved from the MENU where home is equal to 1;
		if($this->_mode == JROUTER_MODE_SEF) {

			if ( substr( $uri->_path, 0, 1) == "/" and strlen( $uri->_path) > 1 ) {
				//$uri->_path = substr( $uri->_path, 1, strlen($uri->_path) -1 );
			}
			$is_print = FALSE;
			$pos = strpos($uri->_uri,'index2.php' );
			if ( $pos> 0 ) {
				$is_print = TRUE;
				return ( $_POST );
			}
			// check the scriptname to retrieve sub-path's
			$sub_dir = str_replace( 'index.php', '', $_SERVER['SCRIPT_NAME']) ;
			$sub_dir = str_replace( 'index2.php', '', $sub_dir) ;
			$this->_subdir = $sub_dir;
			$remove_string = $uri->_scheme . '://' . $uri->_host . $sub_dir;
			$url2search = str_replace( $remove_string, '', $uri->_uri );

			if ( $url2search == "" | $url2search == 'index.php' ) {
				$url2search = "/";
				$uri->_path = $sub_dir ;

			}

			$query = "SELECT id, vars, cache, url_orginal FROM #__smartsef_urls WHERE published = '1' AND url_sef = '" . $url2search . "' ORDER BY ordering";
			$db->setQuery( $query );
	    	$sef_repository =  $db->loadObjectList();
	    	if ( count($sef_repository ) > 0) {
				$this->_is_resolved = true;
	    		$_SERVER['QUERY_STRING'] = str_replace('index.php?','',$sef_repository[0]->url_orginal );
	    		$vars = unserialize( $sef_repository[0]->vars);
				foreach ($vars as $element => $value) {
					if ($element =="" ) {
						unset( $vars[$element]);
					}
				}
				$this->setVars($vars);
				$this->url_orginal = $sef_repository[0]->url_orginal;

				$result = TRUE;
				$is_present = TRUE;
				//$uri = $this->_createURI($this->url_orginal );
				//$vars += parent::parse($uri);

	    		if ( isset($vars['Itemid'] )) {
					$menu  =& JSite::getMenu(true);
					$menu->setActive($vars['Itemid']);
				}

				// Build the cache
				if ($sef_repository[0]->cache != "") {
					$query = "SELECT url_orginal, url_sef, id, published, block_rewrite FROM #__smartsef_urls WHERE published = '1' AND id in ( " . $sef_repository[0]->cache . ") ORDER BY ordering" ;
					$db->setQuery( $query );
					$this->_buffer_smartsef = $db->loadAssocList('url_orginal');
				}
	    	} else {
				// First check if the URL is empty (- root request)
    			if($uri->_path == $sub_dir | $uri->_path == "" | $uri->_path == "/" )	{
					$vars   = array();
					$menu =& JSite::getMenu();
					$item = $menu->getDefault();

					//Set the information in the request
					$vars = $item->query;
					$url_request = $item->link . '&Itemid=' . $item->id;
					//Get the itemid
					$vars['Itemid'] = $item->id;

					// Set the active menu item
					$menu->setActive($vars['Itemid']);

					// Set the variables
					$this->setVars($vars);
					$new_url = "/";
					$result = true;

				}  else {
    				if (isset($uri->_query)) {
						// check if the URL exits as a none sef URL;
						if ( $is_print ) {
    						$query = "SELECT url_sef FROM #__smartsef_urls WHERE url_orginal = " . $uri->_query  . "'";
						} else {
							$query = "SELECT url_sef FROM #__smartsef_urls WHERE url_orginal = " . $uri->_query  . "'";
						}
						$db->setQuery( $query );
	    				$sef_url  = $db->loadResult();
						if ( $sef_url != "") {
							@ob_end_clean();
							if ( substr( $sef_url, 0, 1) != "/") {
								$sef_url = '/' . $sef_url;
							}
							$url_rewrite = $uri->_scheme . "://" . $uri->_host .  $sef_url;
							header( 'Location: ' . $url_rewrite  );
							header( 'HTTP/1.1 301 Moved Permanently' );
							$mainframe->close(0);
						}
						// if the URL is still not found try to rebuild it;
    					if ( $uri->_query != FALSE ) {
							$new_url = $this->build( $uri->_query, null);
		    		  		if ( $new_url->_path ==  NULL) {
		    		  			$result = FALSE;
		    		  		} else {
		    		  			$result = TRUE;
		    		  		}
    					} else {
    						$result = FALSE;
    					}
    				} else {
    					$result = FALSE;
    				}

				}
	    		if ( !$result ) {
					/*
					 * Check if the 404 page should be written to a logfile
					 */
					include_once ( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'includes' . DS . '404handler.php' );
	    			$vars = smartsef_404handler ( $this->sef_config, $url2search );
					$this->_is_404page = true;
					$this->setVars($vars);
					return $vars;
	    		} else {
	    			if ( ($new_url != NULL ) ) {
						// check if the URL already exits
						if ( !isset( $url_request)){
							$url_request = $uri->getQuery();
							$vars = $this->_create_vars ( $uri->_uri );
							$new_url = ltrim($new_url->_uri,'/');
						}

						$query = "SELECT count(*) FROM #__smartsef_urls WHERE url_sef = '" . $new_url  . "'";
						$db->setQuery( $query );
	    				$total = $db->loadResult();

						$query = "SELECT count(*) FROM #__smartsef_urls WHERE url_orginal = '" . $url_request  . "'";
						$db->setQuery( $query );
	    				$total_org  = $db->loadResult();



						if ( $total == 0 & $total_org == 0 ) {
		    				JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'tables');
							$smartsef_row =& JTable::getInstance('smartsef_urls', 'Table');
							foreach( $vars as $parameter => $value) {
								if ( $value == "") {
									unset($vars[$parameter]);
								}
							}
							if ( $is_print ) {
								$vars['tmpl'] = 'component';;
							}
							$smartsef_row->url_sef 		= $new_url;
							$smartsef_row->url_orginal 	= $url_request;
							$smartsef_row->vars			= serialize( $vars );
							$smartsef_row->published	= 1;
							$smartsef_row->ordering		= 99;
							if (!$smartsef_row->store()) {
								return JError::raiseWarning( 500, $smartsef_row->getError() );
							}
	    				}
						if (!headers_sent() ) {
							// Clean the output header;
							@ob_end_clean();
							if ( substr( $new_url, 0, 1) == "/") {
								$new_url = $this->_subdir . $new_url;
								// remove double slashes
								$new_url = str_replace('//','/', $new_url);
							}
							if ( $new_url != "/") {
								$new_url = $sub_dir . $new_url;
							}

							$url_rewrite = $uri->_scheme . "://" . $uri->_host . $new_url;
							header( 'Location: ' . $url_rewrite  );
							header( 'HTTP/1.1 301 Moved Permanently' );
							$mainframe->close(0);
						}
    				}
    			}
    		}
		}
		// SET the sefrepos array;
		$this->sef_repos['_vars'] = $this->_vars;
		$this->sef_repos['_sef_uri'] =  $uri;

		if ( $is_present ) {
			$this->sef_repos['_id'] = $sef_repository[0]->id;
		} else {
			$this->sef_repos['_cache'] = array();
			$this->sef_repos['_id'] = 0;
		}

		// Handle pagination
		if($start = JRequest::getVar('start', null, 'get', 'int'))
		{
			$this->setVar('limitstart', $start);
			unset($this->_vars['start']);
		}
		$uri->_vars = $vars;

		// check if a task is set (legacy mode)
		if ( isset($vars['task'])){
			global $task;
			$task= $vars['task'];
		}

		return $vars;
	}

	/*
	 * Build the SEF URL;
	 */
	function build( $url=null, $vars=NULL ){
		$is_menu = false;
		$db =& JFactory::getDBO();

		$url = str_replace('&amp;','&', $url);
		$org_url = $url;


		// check if the URL is part of the current requested URL;
		if (substr($url, 0,1 ) == '&' & $vars == NULL) {
			$url = str_replace("&amp;", "&", $url);
			$url_part = $url;
			$check_url = explode('&', $url);
			$org_vars = $this->_create_vars ( $this->url_orginal);

			foreach ( $check_url as $check_parameter ){
				$check_elements = explode ( '=',$check_parameter);
				if (isset($org_vars[$check_elements[0]]) ){
					unset( $org_vars[$check_elements[0]]);
				}
			}

			// build the orginal URL again;
			$url = 'index.php?';
			$first = true;
			if ( !empty($org_vars)) {
				foreach ($org_vars as $parameter => $value) {
					if ( $parameter != "" ) {
						if ( $first) {
							$url .=  $parameter.'='.$value;
							$first = false;
						} else {
							$url .= '&'. $parameter.'='.$value;
						}
					}
				}
			}
			$url .= $url_part;
			$org_url = $url;
		}
		if ( empty($vars)) {
			$org_url = $url;
			// check the cache
			if ( isset($this->_buffer_smartsef[$url])) {
				if (  $this->_buffer_smartsef[$url]['block_rewrite'] == 0 ) {
					$url_tmp = $this->_buffer_smartsef[$url]['url_sef'];
				} else {
					$url_tmp = $org_url;
				}
				$uri = $this->_createURI($url);
				// create the URI object

				$uri->setPath( $this->_subdir . $url_tmp);
				$uri->_query = "";
				$this->_buffer_smartsef[$url]['published'] = 0;
				return $uri;
			}
		}

		if ( strpos( $url, 'index.php') === false ) {
			$url = 'index.php?' . $url;
		}
		$uri =& $this->_createURI($url);

		$new_url = NULL;
		// URL alias is used for menu linked items like the blog category and sections
		$url_alias = "" ;
		/*
		 * This is used for the pathway module, set the URL to the current request if the URL is empty
		 * this because the breadcrump module tries to route a empty URL;
		 */

		$vars = $uri->_vars;

		if ( isset($vars['option']) & isset($vars['Itemid']) & count($vars) ==2 ) {
				unset ( $vars['option']);
		}
		if ( isset($vars['option']) ) {
			if ( $vars['option'] == 'com_content' & !isset($vars['id'])) {
				unset ( $vars['option']);
			}
		}
		$itemId = 0;
		$add_part ="";
		//
		foreach( $vars as $parameter => $value ) {
			if ( $value == "") {
				unset($vars[$parameter]);
			}
		}

		if (  isset($vars['Itemid']) & count($vars) == 1 ) {
			$itemId = $vars['Itemid'];
			//  this is a menu element;
			$is_menu = true;
		}
		if (  isset($vars['Itemid']) & isset($vars['limitstart']) & count($vars) == 2 ) {
			$itemId = $vars['Itemid'];
			$add_part = '&limitstart=' . $vars['limitstart'];
			$is_menu = true;
		}
		if (  isset($vars['Itemid']) & isset($vars['showall']) & count($vars) == 2 ) {
			$itemId = $vars['Itemid'];
			$add_part = '&showall=' . $vars['showall'];
			$is_menu = true;
		}
		if (  isset($vars['Itemid']) & isset($vars['type']) & isset($vars['format']) & count($vars) == 3 ) {
			$itemId = $vars['Itemid'];
			$add_part = '&format=' . $vars['format'] . '&type=' . $vars['type']  ;
			$is_menu = true;
		}
		if ( $itemId != 0) {
			$query = "SELECT link, alias FROM #__menu WHERE id = " . $itemId;
			$db->setQuery( $query );
	    	$menu_item =  $db->loadObjectList();
	    	if ( count($menu_item ) > 0) {
	    		$url = $menu_item[0]->link . '&Itemid=' . $itemId . $add_part;
	    		$url_alias = $menu_item[0]->alias;
	    	}
		}
		// create the URL if only the option is set;
		if (isset($vars['option']) & count($vars) == 1) {
			$url='index.php?option=' . $vars['option'];
			$org_url = $url;
		}
		$vars = $this->_create_vars ( $url );

		// remove the empty vars'
		$url = 'index.php?';
		if (!empty($vars)) {
			foreach( $vars as $parameter => $value) {
				if ( $value == "") {
					unset($vars[$parameter]);
				} else {
					// build the raw URL again, but without the empty parameters;
					$url .= '&'.$parameter . '=' . $value;
				}
			}
		}

		// here was the cache check
		// Check if the url is already within the SEF table;
		if ( $this->sef_config->enable_sefurl_lookup) {
			// select the id and the clean URL; and return the URI;

			$query = "SELECT id, url_sef, block_rewrite FROM #__smartsef_urls WHERE url_orginal='" . $org_url . "'";
			$db->setQuery( $query );
	    	$sef_repository =  $db->loadObjectList();
	    	if ( count ($sef_repository ) > 0 )	 {
				$uri = $this->_createURI($url);
	    		// create the URI object
	    		if ( $sef_repository[0]->block_rewrite == 0 ) {
					$uri->setPath(JURI::base(true).'/' . $sef_repository[0]->url_sef);
	    		} else {
	    			$uri->setPath(JURI::base(true). '/' . $org_url);
	    		}
				$uri->_query = "";
				if ( $this->_cache_key_string != "" ) {
					$this->_cache_key_string .= "," . $sef_repository[0]->id;
				} else {
					$this->_cache_key_string = $sef_repository[0]->id;
				}
				// $this->_buffer[$org_url] = $uri;
				return $uri;
	    	}
		}

		if ( isset($vars['view'])) {
			$vars['view'] = str_replace(';','',$vars['view']);
		}

		if ( isset($vars['view']) & !isset($vars['option'])) {
			if ( $vars['view'] == 'article') {
				$vars['option'] = 'com_content';
			}
		}
		/*
		 * Check if there is an option param present, if not, try to resolve the option parameter this because some core extension
		 * will not pass the option parameter directly to the router. Note: the only why to fetch the option parameter is through the
		 * category settings;
		 */
		if (!isset($vars['option']) & isset($vars['catid'])) {
			if ( !isset($this->_content_path_cat_aliases)) {
				$this->_set_path_aliases ();
			}
			$category_array = explode ( ':', $vars['catid']);
			$cat_id = $category_array[0];
			$option = $this->_content_path_cat_aliases[$cat_id]['sec_id'];
			if ( $option != NULL & !is_numeric($option)) {
				$vars['option'] = $option;
			}
		}
		if (!isset($vars['option']) & !isset($vars['catid'])) {
			// This is for the newfeeds..
			if (isset($vars['view'])) {
				if ( !isset($this->_content_path_cat_aliases)) {
					$this->_set_path_aliases ();
				}
				if ( $vars['view'] == 'category' & isset($vars['id'])) {
					$category_array = explode ( ':', $vars['id']);
					$cat_id = $category_array[0];
					$option = $this->_content_path_cat_aliases[$cat_id]['sec_id'];
					if ( $option != NULL & !is_numeric($option)) {
						$vars['option'] = $option;
					} else {
						// Assign it to the content
						$vars['option'] = 'com_content';
					}
				}
			}
		}
		$routed = false;
		if ( isset($vars['option'])) {

			if ( ($vars['option'] == "com_content") ) {
				if ( ($vars['view'] == 'category' | $vars['view'] == 'section') & !$this->sef_config->append_itemid_to_rawurl ) {
					/*
					 * Itemid must always be present for the Category and the section (for the parameters), if not get the item id active page;
					 */
					if (!isset($vars['Itemid'])) {
						$menu =& JSite::getMenu();
						$menu_item = $menu->getActive();
						$vars['Itemid'] = $menu_item->id;
						$url_alias = $menu_item->alias;
					}
				}

				// Initiate the content routing;
				switch ( $vars['view'] ) {
					case 'article':
					case 'section':
					case 'category':
					case 'frontpage':
						$new_url = $this->_build_article_url ( $vars, $url_alias, $is_menu, $url_alias );
						$routed = true;
						break;

				}
			} else {
				$component = $vars['option'];
				// Use the component routing handler if it exists

				// first check if there is an smartsef plugin for the routing;
				// if  use the smartsef routing plugin;
				$plg_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'plugins'.DS.'plg_' . $component . '.php';
				$routed = false;
				if ( file_exists( $plg_path)) {
					/*
					 * Lookup if the plugin is enabled.
					 * cache the results of the plugin lookup, 1 query is enough;
					 */
					if ( $this->_buffer_smartsef_plugins == NULL ) {
						$query = "SELECT plugin FROM #__smartsef_plugins WHERE published = 1";
						$db->setQuery ( $query) ;
						$this->_buffer_smartsef_plugins = $db->loadObjectList('plugin');
					}
					$plg_name = 'plg_' . $component ;
					$use_plugin = false;
					if ( count($this->_buffer_smartsef_plugins) > 0 ) {
						if ( isset($this->_buffer_smartsef_plugins[$plg_name])) {
							$use_plugin  = true;
						}
					}
					if ( $use_plugin ) {
						require_once $plg_path;
						$function	= substr($component, 4).'BuildRoute';
						$tmp_vars = $vars;
						$parts		= $function( $vars );
						//encode the route segments
						$parts = & $this->_encodeSegments($parts);
						if ( count($parts) != 0) {
							// Check if a result is return, if not no url is created and the menu alias is used
							$result  = implode('/', $parts);
							$new_url = ($result) ? $result : null;
						}
						$routed = true;
					}
				}
				if ( !$routed ) {
					// Check the component directory if there is a routing pluggin;
					// Check the setting for this local router
					$path = JPATH_BASE.DS.'components'.DS.$vars['option'].DS.'router.php';
					// Use the custom request handler if it exists

					if (file_exists($path)) {
						// check if the plugin is enabled;
						if ( $this->_buffer_smartsef_router_setting == NULL ) {
							$query = "SELECT rewrite_rule, component_alias, component FROM #__smartsef_router_setting ";
							$db->setQuery( $query );
							$this->_buffer_smartsef_router_setting = $db->loadObjectList('component');
						}
						if ( !isset($this->_buffer_smartsef_router_setting[$vars['option']])) {
							$rewrite_rule = 1; // default enabled;
						} else {
							$rewrite_rule = $this->_buffer_smartsef_router_setting[$vars['option']]->rewrite_rule;
						}
						if ( $rewrite_rule ==  1 ) {
							require_once $path;
							$function	= substr($component, 4).'BuildRoute';
							// $tmp_vars = $vars;
							//$parts		= $function($tmp_vars);
							$parts		= $function( $vars );

							//encode the route segments
							$parts = $this->_encodeSegments($parts);
							$result  = implode('/', $parts);
							$new_url  = ($result) ? $result : null;
							$routed = true;
						}
					}

					if ( !$routed ){
						$component = str_replace( 'com_', '', $vars['option'] );
						if (!class_exists( 'sef_' . $component )){
							 // Class not loaded try to fetch the class

							$paths = array(
									JPATH_BASE . DS. "administrator".DS."components".DS."com_$component".DS."sef_ext.php",
									JPATH_BASE . DS. "components". DS. "com_$component". DS. "sef_ext.php",
									JPATH_BASE . DS. "administrator". DS."components". DS."com_smartsef". DS."plugins". DS."sef_$component.php",
							);
							foreach ($paths as $path) {
								if (file_exists( $path ) && is_readable( $path ) && filesize( $path ) > 0) {
									@include_once( $path );
									if (class_exists( 'sef_' . $component )){
										break;
									}
								}
							}
						}
						if ( class_exists('sef_' . $component )) {
							// create the URL based on the orginal request;
							// check if the plugin is enabled;
							if ( $this->_buffer_smartsef_router_setting == NULL ) {
								$query = "SELECT rewrite_rule, component_alias, component FROM #__smartsef_router_setting ";
								$db->setQuery( $query );
								$this->_buffer_smartsef_router_setting = $db->loadObjectList('component');
							}
							if ( !isset($this->_buffer_smartsef_router_setting[$vars['option']])) {
								$rewrite_rule = 3; // default enabled;
							} else {
								$rewrite_rule = $this->_buffer_smartsef_router_setting[$vars['option']]->rewrite_rule;
							}
							if ( $rewrite_rule == 1 | $rewrite_rule == 3) {
								$class = 'sef_' . $component;
								$sef_ext = new $class();
								$alias = "" ;
								if ( $rewrite_rule == 1 ) {
									$alias = $this->_buffer_smartsef_router_setting[$vars['option']]->component_alias ;
								}
								$new_url = $sef_ext->create( str_replace('&','&amp;',$url ))  ;
								if ( strlen($new_url) > 0 & $alias != "" ) {
									if (substr($new_url,0,1) == '/') {
										$new_url = $alias . $new_url;
									} else {
										$new_url = $alias . '/' . $new_url;
									}
								}
								$routed = true;
							}
						}
					}

					if ( !$routed ) {
						if ( isset($vars['option']) ) {
							// The URL is still not rewrited. Check if the basic rewriting is required;

							if ( $this->_buffer_smartsef_router_setting == NULL ) {
								$query = "SELECT rewrite_rule, component_alias, component FROM #__smartsef_router_setting ";
								$db->setQuery( $query );
								$this->_buffer_smartsef_router_setting = $db->loadObjectList('component');
							}
							if ( !isset($this->_buffer_smartsef_router_setting[$vars['option']])) {
								$rewrite_rule = 2; // default enabled for the basic rewriting;
							} else {
								$rewrite_rule = $this->_buffer_smartsef_router_setting[$vars['option']]->rewrite_rule;
							}
							if ( $rewrite_rule == 2) {
								// check if the menu alias should be used;
								if ( !empty($url_alias) & $this->sef_config->use_title_alias_for_menus == 1 ){
									$new_url = $url_alias;
								} else {
									if ( $this->_buffer_smartsef_router_setting[$vars['option']]->component_alias != "") {
										$new_url = $this->_buffer_smartsef_router_setting[$vars['option']]->component_alias;
									} else {
										$new_url  = str_replace("com_", "" , $vars['option'] );
									}
								}
								$tmp_option = $vars['option'];
								unset($vars['option']);
								foreach ( $vars as $name => $value) {
									// Check if itemid must be added
									if ( $this->sef_config->append_itemid_to_sefurl == 1 & strtolower($name) == 'itemid') {
										$new_url .= "/" . $value;
									} elseif ( strtolower($name) != 'itemid') {
										$new_url .= "/" . $value;
									}
								}
								$vars['option'] = $tmp_option;
								$routed = true;
							}
						}
					}
					if ( !$routed ) {
						$new_url = $org_url;
					}
				}
			}
		}



		if ( $new_url == NULL) {
			if ($url_alias != "") {
				$new_url = $url_alias;
			} else {
				$new_url =  $org_url;
			}
		}
		if (!empty($this->_additional_parts_vars)) {
			foreach ( $this->_additional_parts_vars as $parameter => $value) {
				$new_url .= '/' . $value;
				$vars[$parameter] = $value;
			}
		}
		if ( $routed ) {
			$new_url = $this->_create_clean_url($new_url);
		}
		/*
		 * Check if the suffix is set
		 */
		if (strpos($new_url, '.') === FALSE & $new_url != '/' & substr($new_url, strlen($new_url)-1, 1) != '/' ) {
			$new_url .=  $this->sef_config->url_suffix_page;
		}
		// remove the slashes in the front;
		//$new_url = ltrim( $new_url,'/');

		$priority = $this->_set_link_priority ( $vars );
		$this->sef_repos['_sef_new_urls'][$url]=array('orginal'=> $org_url, 'rewrite' => $new_url, 'vars' => $vars, 'priority' => $priority );

		$uri = new JURI(  $this->_subdir . $new_url );
		// if its a post or when the URL was not primairly solved save the URL;
		if ( $this->_is_post | $this->_is_resolved == false ) {
			// This is a POST should be stored in the table;
			$query = "SELECT id FROM #__smartsef_urls WHERE url_orginal = '" . $org_url . "'";
			$db->setQuery( $query );
			$id = $db->loadResult();
			if ( $id == "") {
				$vars = serialize(  $vars );
				$query = "INSERT INTO #__smartsef_urls( url_orginal, url_sef, vars, published, ordering ) VALUES ('" . $org_url. "','" . $new_url ."','" . $vars . "','1', '99')";
				$db->setQuery( $query );
				$db->query();
				$this->_is_post = FALSE;
			}
		}

		/*
		 *
		 */
		return $uri;

	}




	function _create_clean_url ( $url ) {

		if ( $this->sef_config->url_lowercase ) {
			$url = strtolower ( $url );
		}
		// Replace the Joomla default space setting;
		if ( $this->sef_config->replace_joomla_space_char == '1') {
			$url = str_replace( '-', ' ', $url);
		}
		// remove the white spaces;
		$url =  preg_replace('/\s\s+/', ' ', $url );

		if ( $this->sef_config->character_space != "") {
			$url = str_replace( ' ', $this->sef_config->character_space, $url) ;
		}

		if ( $this->sef_config->url_remove_chars != "" ) {
			$len = strlen( $this->sef_config->url_remove_chars );
		    for ( $x=0; $x < $len; $x++) {
		    	$char = substr($this->sef_config->url_remove_chars, $x, 1);
		    	$url = str_replace( $char, "", $url );
		    }
		}

	   	$replace = array("&",">","?","$","%","@","#","+","^",":",";","|","[","]","{","}",",","'","`" );
   		foreach ($replace as $value) {
			if ($value != "") {
				$url = str_replace( $value, "", $url );
			}
   		}
   		$url = $this->unaccent(  $url );

   		// Remove all invalid characters
		if ( $this->sef_config->valid_regular_expresion != "") {
			$exp = '/[^' . $this->sef_config->valid_regular_expresion . ']/';
			$url = preg_replace($exp,'', $url);
		}

		if ( $this->sef_config->char_replacements != "") {
			 $char_replacements = utf8_decode( $this->sef_config->char_replacements) ;

			 if ( !isset( $this->char_replacement_array )) {
			 	 $this->char_replacement_array = array();
			 	 $elements = explode(',', $char_replacements );
			 	 foreach ($elements as $element ) {
			 	 	 @list($source, $destination) = explode('|', trim($element));
			 	 	 $this->char_replacement_array[trim($source)] = trim($destination);
			 	 }
			 }
			 $url = strtr($url, $this->char_replacement_array);
		}

		return $url;
	}

	function unaccent( $text ) {
	    $trans = get_html_translation_table( HTML_ENTITIES );
	    $search = array();
	    $replace = array();
	    foreach ($trans as $literal => $entity) {
		    if (ord( $literal ) >= 192) {
		        // Get the accented form of the letter
		        $search[] = $literal;
		        // Get e.g. 'E' from string '&Eaccute'
		        $replace[] = $entity[1];
		    }
	   	}
	    return str_replace( $search, $replace, $text );
	}

	function _build_article_url ( $vars, $url_alias="", $is_menu, $menu_alias ) {
		$db =& JFactory::getDBO();
		$url = NULL;
		$suffix_set = FALSE;

		// get the categories and the sections;
		if ( !isset($this->_content_path_cat_aliases)) {
			$this->_set_path_aliases ();
		}

		// check if option is set
		switch ( $vars['view']) {

			case 'article':
				if ( $is_menu & $this->sef_config->use_title_alias_for_menus == 1 ) {
					$url = $menu_alias;
				} else {
					// todo: assign for the menu aliases
					$cat_id = 0;
					if (isset($vars['catid']) ){
						$category_array = explode ( ':', $vars['catid']);
						$cat_id = $category_array[0];
					}
					$content_array = explode ( ':', $vars['id']);
	 				$id = $content_array[0];

	 				if (isset($content_array[1] ) & $cat_id != 0) {
						$title_alias = $content_array[1];
	 				} else {
	 					// The category ID is not present retrieve the title_alias and the catid;
						$query = "SELECT alias, title, catid FROM #__content WHERE id=" . $id;
						$db->setQuery( $query );
						$article =  $db->loadObjectList();
						$title_field = $this->sef_config->article_url_part;
						$title_alias = $article[0]->$title_field;
						$cat_id = $article[0]->catid;
	 				}
	 				$path = "";

	 				// Set the path according to the configuration settings
					// 0 -> article title
					// 1 -> category / article
					// 2 -> section / category / article
					// 3 -> menu / section / category / article
					// 4 -> menu alias;

					if ( $cat_id != 0) {
		 				if ( $this->_content_path_cat_aliases[$cat_id]['sec_' . $this->sef_config->section_url_part ] != "" ) {
		 					$section_path = $this->_content_path_cat_aliases[$cat_id]['sec_' . $this->sef_config->section_url_part];
		 				}
		 				if ( $this->_content_path_cat_aliases[$cat_id]['cat_' . $this->sef_config->category_url_part] != "") {
		 					$cat_path = $this->_content_path_cat_aliases[$cat_id]['cat_' . $this->sef_config->category_url_part];
		 				}
		 				switch ( $this->sef_config->url_paths_article ) {
		 					case 0:
		 						$url = $title_alias;
		 						break;
		 					case 1:
		 						$url = $cat_path . "/" .  $title_alias;
		 						break;
		 					case 2:
		 						$url = $section_path . "/" . $cat_path . "/" . $title_alias;
		 						break;
		 					case 3:
		 						if ( $url_alias != "" ) {
		 							$url = $url_alias . "/" . $section_path . "/" . $cat_path . "/" . $title_alias;
		 						} else {
		 							$url = $section_path . "/" . $cat_path . "/" . $title_alias;
		 						}
		 				}
					} else {
						// seems to be an uncategorized article, show the alias and the menu alias
						if ( $this->sef_config->url_paths_article == 3 & $url_alias !="") {
							$url = $url_alias . "/" . $title_alias;
						} else {
							$url = $title_alias;
						}
					}
					if (isset($vars['task'])) {
						if ( $vars['task'] == 'edit' ) {
							if ( $url != '') {
								$url .= "/" . $vars['task'];
							} else {
								$url = $vars['task'];
							}
						}
					}
				}
				if ( $this->sef_config->use_title_alias_fullpath == '1' & !empty($title_alias) ) {
					// Check if there is a path alias within the url.
					// if the title alias starts with /name  --> the URL be set to /name, etc...
					$use_alias = false;
					if ( InStrCount($title_alias, '/') | InStrCount($title_alias, $this->sef_config->url_suffix_page) ) {
					 	$use_alias = true;
					 	$title_alias = str_replace($this->sef_config->url_suffix_page, '', $title_alias);
					}

					if ( $use_alias) {
						if (substr($title_alias,0,1) == '/') {
							$url = substr($title_alias,1,strlen($title_alias)-2);
						} else {
							$url = $title_alias;
						}
					}
				}
				// Check if there are additional parameters
				if (isset($vars['showall'])) {
					if ( $vars['showall'] == 1) {
						$url .= '/' . $this->sef_config->url_part_showall;
					}
				}
				if (isset($vars['limitstart'])) {
					if ( $vars['limitstart'] != "") {
						$page = sprintf($this->sef_config->url_part_page, $vars['limitstart']+1);
						$url .= '/' . $page;
					}
				}
				if (isset($vars['layout'])) {
					$url .= $vars['layout'];
				}
				break;

			case 'section':
				if ( strpos( $vars['id'], ":")) {
					$id_array = explode(":", $vars['id']);
					$secid = $id_array[0];
				} else {
					$secid = $vars['id'];
				}
				switch ( $this->sef_config->url_paths_section ) {
					case 2:
						///menu/section
						if ( $url_alias != "") {
							$url = $url_alias . '/' . $this->_content_path_sec_aliases[$secid]['sec_' . $this->sef_config->section_url_part];
						} else {
							// to be sure ...
							$url = $this->_content_path_sec_aliases[$secid]['sec_' . $this->sef_config->section_url_part];
						}
						break;
					case 1:
						$url = $this->_content_path_sec_aliases[$secid]['sec_' . $this->sef_config->section_url_part];
						break;
					case 0:
						// section
						$url = $url_alias;
						break;
				}

				if ( $this->sef_config->url_paths_section & $url_alias != "") {
				//	$url = $url_alias;
				} elseif ( $vars['option'] == 'com_content') {
				//	$url = $this->_content_path_sec_aliases[$vars['id']]['sec_' . $this->sef_config->section_url_part];
				}
				$suffix_set = FALSE;
				if (isset( $vars['format']) & (isset( $vars['type'])) ) {
					$url .=  "/" . $vars['format'] . '.' . $vars['type'];
				}
				if (isset( $vars['format']) & (!isset( $vars['type'])) ) {
				 	$url .=  "/" .$vars['format']. '/';
				}
				if (isset ( $vars['type']) & !isset( $vars['format']) ) {
					$url .=  "/" . $vars['type'];
				}
				// Check the settings for the multi-page principle;
				// load the menu item id and get the parameters;
				if ( isset($vars['limitstart'])) {
					if (isset($vars['Itemid'])) {
						$menu =& JSite::getMenu();;
						$params =  $menu->getParams($vars['Itemid']);
						$nm_leading = $params->get('num_leading_articles', 0);
						$nm_intro 	= $params->get('num_intro_articles', 0);
						$total_articles = $nm_leading + $nm_intro;
						if ( $total_articles > 0 &  $vars['limitstart'] > 0 ) {
							$page = $vars['limitstart'] / $total_articles + 1;
							$page_str = sprintf($this->sef_config->url_part_page, $page );
							$url .= '/' . $page_str;

							$suffix_set = FALSE;
						}
					}
				}
				break;

			case 'category':
				if ( strpos( $vars['id'], ":")) {
					$id_array = explode(":", $vars['id']);
					$catid = $id_array[0];
				} else {
					$catid = $vars['id'];
				}
				switch ( $this->sef_config->url_paths_category ) {
					case 4:
						// /menu/section/category
						if ( $url_alias != "") {
							$url = $url_alias . "/" . $this->_content_path_cat_aliases[$catid]['sec_' . $this->sef_config->section_url_part] . "/" . $this->_content_path_cat_aliases[$catid]['cat_' .$this->sef_config->category_url_part];
						} else {
							// to make sure, but this may not be fetched....
							$url = $this->_content_path_cat_aliases[$catid]['sec_' . $this->sef_config->section_url_part] . "/" . $this->_content_path_cat_aliases[$catid]['cat_' .$this->sef_config->category_url_part];
						}
						break;
					case 3:
						// section/category
						$url = $this->_content_path_cat_aliases[$catid]['sec_' . $this->sef_config->section_url_part] . "/" . $this->_content_path_cat_aliases[$catid]['cat_' .$this->sef_config->category_url_part];
						break;

					case 2:
						// /menu/category
						if ( $url_alias != "") {
							$url = $url_alias . "/"  . $this->_content_path_cat_aliases[$catid]['cat_' .$this->sef_config->category_url_part];
						} else {
							// to make sure, but this may not be fetched....
							$url =  $this->_content_path_cat_aliases[$catid]['cat_' .$this->sef_config->category_url_part];
						}
						break;
					case 1:
						// /category
						$url =  $this->_content_path_cat_aliases[$catid]['cat_' .$this->sef_config->category_url_part];
						break;
					case 0:
						// /category
						$url =  $url_alias;
						break;
				}

				if (isset( $vars['format']) & (isset( $vars['type'])) ) {
					$url .=  "/" . $vars['format'] . '.' . $vars['type'];
				}
				if (isset( $vars['format']) & (!isset( $vars['type'])) ) {
				 	$url .=   "/" .$vars['format']. '/';
				}
				if (isset ( $vars['type']) & !isset( $vars['format']) ) {
					$url .=   "/" .$vars['type'];
				}
				// Check the settings for the multi-page principle;
				// load the menu item id and get the parameters;
				if ( isset($vars['limitstart'])) {
					if (isset($vars['Itemid'])) {
						$menu =& JSite::getMenu();;
						$params =  $menu->getParams($vars['Itemid']);
						$nm_leading = $params->get('num_leading_articles', 0);
						$nm_intro 	= $params->get('num_intro_articles', 0);
						// Divid the limit start by the
						$total_articles = $nm_leading + $nm_intro;
						if ( $total_articles > 0 &  $vars['limitstart'] > 0 ) {
							$page = $vars['limitstart'] / $total_articles + 1;
							$page_str = sprintf($this->sef_config->url_part_page, $page );
							$url .= '/' . $page_str;
							$suffix_set = FALSE;
						}
					}
				}
				break;

			case 'frontpage':
				// for the frontpage check if the page parameters are used, if not write the base URL

				$suffix_set = TRUE;
				if (isset( $vars['format']) & (isset( $vars['type'])) ) {
					$url =  $vars['format'] . '.' . $vars['type'];
				}
				if (isset( $vars['format']) & (!isset( $vars['type'])) ) {
				 	$url =  $vars['format']. '/';
				}
				if (isset ( $vars['type']) & !isset( $vars['format']) ) {
					$url .=  $vars['type'];
				}

				if ( isset($vars['limitstart'])) {
					if (isset($vars['Itemid'])) {
						$menu =& JSite::getMenu();;
						$params =  $menu->getParams($vars['Itemid']);
						$nm_leading = $params->get('num_leading_articles', 0);
						$nm_intro 	= $params->get('num_intro_articles', 0);
						// Divid the limit start by the
						$total_articles = $nm_leading + $nm_intro;
						if ( $total_articles > 0 &  $vars['limitstart'] > 0 ) {
							$page = $vars['limitstart'] / $total_articles + 1;
							$page_str = sprintf($this->sef_config->url_part_page, $page );
							if ( $url != NULL ) {
								$url .= '/' . $page_str;
							} else {
								$url = $page_str;
							}
							$suffix_set = FALSE;
						}
					}
				}
				if ( $url == "") {
					$url = "/";
				}
				break;
		}

		if ( $this->sef_config->append_itemid_to_sefurl == 1 &isset($vars['Itemid'])) {
			$url .= '/' . $vars['Itemid'];
		}

		if ( isset($vars['format'])) {
			if ( $vars['format'] == 'pdf') {
				$url .= $this->sef_config->url_suffix_pdf;
				$suffix_set = TRUE;
			}
			if  ( $vars['format'] == 'feed') {
				if ( isset( $vars['type']) ) {
					$suffix_set = TRUE;
				}
			}
		}
		if ( isset( $vars['print'])) {
			$url .= '/' . $this->sef_config->url_part_print;
		}


		// Check if the URL already exits, if so make the URL unique by adding the article ID to the URL
		if ( $this->sef_config->check_for_unique_article_urls ) {
			// Check if the SEF url already exits and if the article ID is the same article ID as the requested URL.
			if ( $vars['view'] == 'article' &isset($vars['id'])) {
				$content_array = explode ( ':', $vars['id']);
				if (count($content_array) > 1) {
			 		$id = $content_array[0];
				} else {
					$id =  $vars['id'];
				}
				// First check the cache for the URL;
				$is_unique = FALSE;

				if (!empty( $this->sef_repos['_sef_new_urls'])) {
					foreach ( $this->sef_repos['_sef_new_urls'] as $cached_url) {
						if ( $cached_url['rewrite'] == "/" . $url ) {
							// assign the ID to the URL;
							if (isset($cached_url['vars']['id'])) {
								$cached_id = explode ( ':',$cached_url['vars']['id']);
								if (count($cached_id) > 1) {
							 		$cache_id = $cached_id[0];
								} else {
									$cache_id =  $cached_url['vars']['id'];
								}
								if ( $cache_id != $id ){
									// means different content element, same URL assign the article ID to the URL
									if (strpos( $url, '.')) {
										$tmp_url = explode (".", $url);
										$url = $tmp_url[0] . $this->sef_config->unique_seperator . $id . "." .$tmp_url[1];
									} else {
									  $url .= $id;
									}
									$is_unique = true;
									break;
								}
							}
						}
					}
				}

		 		if ( !$is_unique) {
					$query = "SELECT vars, url_orginal, url_sef, id, published FROM #__smartsef_urls WHERE published = '1' AND url_sef = '/" . $url . "'";
					$db->setQuery( $query );
					$chk_rows = $db->loadAssocList('url_orginal');
					if ( count($chk_rows)) {
						foreach( $chk_rows as $sefrow ) {
							$tmp_vars = unserialize($sefrow['vars']);

							if (isset($tmp_vars['id']) ) {
								$cached_id = explode ( ':',$tmp_vars['id']);
								if (count($cached_id) > 1) {
							 		$cache_id = $cached_id[0];
								} else {
									$cache_id =  $tmp_vars['id'];
								}

								if ( $cache_id != $id ) {
									// assign the article ID to the URL;
									if (strpos( $url, '.')) {
										$tmp_url = explode (".", $url);
										$url = $tmp_url[0] . $this->sef_config->unique_seperator . $id . "." .$tmp_url[1];
									} else {
									  $url .= $id;
									}
									break;
								}
							}
						}
					}
		 		}
			}
		}
		return $url;
	}

	function _create_vars ( $url ) {
		$url_check = parse_url( $url) ;
		$vars = null;
		if ( isset( $url_check['query'])) {
			$url_parts = explode ('&' , $url_check['query']);
			$vars=array();
			foreach ( $url_parts as $element ) {
				if ( strpos($element,'=') == true ) {
					$content = explode('=', $element);
					$vars[$content[0]] = $content[1];
				}
			}
		}
		return ( $vars);
	}

	function _set_path_aliases () {
		$db =& JFactory::getDBO();
		$query = "SELECT c.id as cat_id, c.section as sec_id, c.title as cat_title, c.alias as cat_alias, s.title as sec_title, s.alias as sec_alias " .
				 " FROM #__categories c LEFT JOIN #__sections s ON c.section = s.id ";
		$db->setQuery( $query );
		$tmp_list =  $db->loadRowList();
		foreach ( $tmp_list as $element) {
			$this->_content_path_cat_aliases[$element[0]] = array( 'sec_id' => $element[1], 'cat_title' => $element[2], 'cat_alias' =>  $element[3], 'sec_title' => $element[4], 'sec_alias' => $element[5]);
			$this->_content_path_sec_aliases[$element[1]] = array( 'sec_id' => $element[1], 'sec_title' => $element[4], 'sec_alias' => $element[5]);
		}
		return true;
	}
	/*
	 * function _set_link_priority
	 *
	 * This function gives the ability to set the link priority for the internal Joomla URL, based on the past $vars
	 * Returns a priority
	 */
	function _set_link_priority ( $vars = null ){

		$priority = NULL;
		include_once(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_smartsef' . DS . 'includes' .DS. 'priority.php');

		if ( isset($vars['view'])) {

			switch ( $vars['view']) {
				case 'article':
					if ( isset($vars['Itemid']) ) {
						$priority = _SMARTSEF_ARTICLE_WITH_ITEMID;
					} else {
						$priority = _SMARTSEF_ARTICLE_WITH_NOITEMID;
					}
					break;
				case 'section':
					if ( isset($vars['layout'])) {
						if ( $vars['layout'] == 'blog') {
							if ( isset($vars['Itemid']) ) {
								$priority = _SMARTSEF_SECTION_BLOG_WITH_ITEMID;
							} else {
								$priority =  _SMARTSEF_SECTION_BLOG_WITH_NOITEMID;
							}
						} else {
							if ( isset($vars['Itemid']) ) {
								$priority = _SMARTSEF_SECTION_LIST_WITH_ITEMID;
							} else {
								$priority = _SMARTSEF_SECTION_LIST_WITH_NOITEMID;
							}
						}
					} else {
						$priority = _SMARTSEF_SECTION_LIST_WITH_ITEMID;
					}
					break;
				case 'category':
					if ( isset($vars['layout'])) {
						if ( $vars['layout'] == 'blog') {
							if ( isset($vars['Itemid']) ) {
								$priority = _SMARTSEF_CATEGORY_BLOG_WITH_ITEMID;
							} else {
								$priority = _SMARTSEF_CATEGORY_BLOG_WITH_NOITEMID;
							}
						} else {
							if ( isset($vars['Itemid']) ) {
								$priority = _SMARTSEF_CATEGORY_LIST_WITH_ITEMID;
							} else {
								$priority = _SMARTSEF_CATEGORY_LIST_WITH_NOITEMID;
							}
						}
					} else {
						if ( isset($vars['Itemid']) ) {
							$priority = _SMARTSEF_CATEGORY_LIST_WITH_ITEMID;
						} else {
							$priority = _SMARTSEF_CATEGORY_LIST_WITH_NOITEMID;
						}
					}
					break;
			}
		}
		if ( $priority == NULL  ) {
			if ( isset($vars['Itemid']) ) {
				$priority = _SMARTSEF_DEFAULT_ORDER_WITH_ITEMID;
			} else {
				$priority  = _SMARTSEF_DEFAULT_ORDER_WITH_NOITEMID;
			}
		}

		return $priority;


	}
}

function InStrCount($String,$Find,$CaseSensitive = false) {
    $i=0;
    $x=0;
    while (strlen($String)>=$i) {
     unset($substring);
     if ($CaseSensitive) {
      $Find=strtolower($Find);
      $String=strtolower($String);
     }
     $substring=substr($String,$i,strlen($Find));
     if ($substring==$Find) $x++;
     $i++;
    }
    return $x;
}

?>
