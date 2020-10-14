<?php
/* @version		$Id: view.install.php 167 2008-01-24 22:41:05Z richard $
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

	function install( $tpl = null)	{
		$document =& JFactory::getDocument();
		$document->addStyleSheet( '/administrator/components/com_smartsef/includes/smartsef.css');

		$this->_layout = 'plugin';

		parent::display($tpl );
	}
}

?>