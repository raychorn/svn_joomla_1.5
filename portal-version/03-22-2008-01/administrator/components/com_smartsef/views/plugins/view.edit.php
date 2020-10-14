<?php
/**
* @version		$Id: view.edit.php 167 2008-01-24 22:41:05Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport( 'joomla.application.component.view');

class pluginsViewplugins extends JView {

	function edit ( $tpl = NULL  ) {


		$this->_layout = 'edit';
		$row = & $this->get( 'Editdata');
		$params = $row->params;
		// build the html select list for published
		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $row->published );

		$this->assignRef('row', $row );
		$this->assignRef('params', $params );
		$this->assignRef('lists', $lists);

		$this->_layout = 'plugin';

		parent::display($tpl );
	}

}
?>