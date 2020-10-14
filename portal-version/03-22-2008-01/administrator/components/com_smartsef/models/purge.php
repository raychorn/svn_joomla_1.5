<?php
/**
* @version		$Id: purge.php 167 2008-01-24 22:41:05Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class purgeModelpurge extends Jmodel {

	function purge() {
		$this->_db->setQuery( $this->_buildPurgeQuery() );
		$this->_db->query();
		return;
	}

	function _buildPurgeQuery() 	{
		$where		= $this->_buildPurgeWhere();
		$query = ' DELETE FROM #__smartsef_urls '
			. $where;
		return $query;
	}

	function _buildPurgeWhere() 	{
		return ( " WHERE delete_locked = '0'");

	}

}

?>