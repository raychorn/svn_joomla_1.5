<?php
/**
* @version		$Id: config.php 220 2008-02-10 21:31:18Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.controller');
class configController extends JController {

 	function __construct()	{
		parent::__construct( );
	}

	function edit() {

		$model = $this->getModel('config');
		$view  = $this->getView ( 'config','html');
		$model->_set_configuration ();

		$view->assignRef('smartsef_config', $model->_configuration);

		$view->edit();
	}

	function cancel() {
		// Go directly to the smartsef cpannel
		$this->setRedirect('index.php?option=com_smartsef', JTEXT::_('VW_CONFIG_NOT_SAVED'));
	}

	function save() {
		// saves the configuration file;
		// get the model
		$model = $this->getModel('config');
		if ( $model->_save_configuration() ) {
			$this->setRedirect('index.php?option=com_smartsef', JTEXT::_('VW_CONFIG_SAVED'));
		} else {
			$this->setRedirect('index.php?option=com_smartsef', JTEXT::_('VW_CONFIG_ERROR'));
		}
	}

	function apply() {
		// save the configuration and remove the URL repository;
		$model = $this->getModel('config');
		$model->_save_configuration();
		$this->setRedirect('index.php?option=com_smartsef&control=config&task=edit', JTEXT::_('VW_CONFIG_SAVED'));

	}
	function applypurge() {
		// save the configuration and remove the URL repository;

		$model = $this->getModel('config');
		if ( $model->_save_configuration() ) {
			$msg =  JTEXT::_('VW_CONFIG_SAVED');
		} else {
			$msg = JTEXT::_('VW_CONFIG_ERROR');
		}
		// Cleanup the repository;

		include_once(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_smartsef' . DS . 'models' .DS. 'purge.php');

		$purge_model =& new purgeModelpurge();
		$purge_model->purge();

		$this->setRedirect('index.php?option=com_smartsef&control=config&task=edit', $msg);

	}
	function savepurge() {
		// saves and purge the configuration;
		// save the configuration and remove the URL repository;
		$model = $this->getModel('config');
		if ( $model->_save_configuration() ) {
			$msg =  JTEXT::_('VW_CONFIG_SAVED');
		} else {
			$msg = JTEXT::_('VW_CONFIG_ERROR');
		}
		include_once(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_smartsef' . DS . 'models' .DS. 'purge.php');
		$purge_model =& new purgeModelpurge();
		$purge_model->purge();

		$this->setRedirect('index.php?option=com_smartsef',$msg );


	}
}
?>