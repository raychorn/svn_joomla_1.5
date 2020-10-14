<?php
/**
* @version		$Id: smartsef_plugins.php 235 2008-03-08 13:38:30Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
class Tablesmartsef_plugins extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id 	 		= null;
	var $name			= null;
	var $published		= null;
	var $params			= null;
	var $author			= null;
	var $description	= null;
	var $version		= null;
	var $checked_out	= null;
	var $author_url		= null;
	var $plugin			 = null;

	function Tablesmartsef_plugins (& $db) {
		parent::__construct('#__smartsef_plugins', 'id', $db);
	}

	function delete( $id, $plugin_name ){
		$k = $this->_tbl_key;
		if ( $id ) {
			$this->$k = intval( $id );
		}

		if ( parent::delete( $id )) {
   			$xmlfile = JPATH_SITE .DS."administrator".DS."components".DS."com_smartsef".DS."plugins".DS.$plugin_name.'.xml';
   			$phpfile = JPATH_SITE .DS."administrator".DS."components".DS."com_smartsef".DS."plugins".DS.$plugin_name.'.php';
			unlink ( $xmlfile );
			unlink ( $phpfile );
		}

	}
	function bind($array)	{
		if ( is_array( $array['params'] )) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}
		return parent::bind($array);
	}
}
