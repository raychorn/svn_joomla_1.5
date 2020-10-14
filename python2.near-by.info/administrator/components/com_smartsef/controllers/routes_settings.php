<?php
/* @version		$Id: routes_settings.php 203 2008-01-30 22:11:29Z richard $
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
jimport( 'joomla.application.component.controller' );
class routes_settingsController extends JController {

	function __construct() 	{
		parent::__construct();
	}

	function view( ) {
		$model =& $this->getModel ('routes_settings');

		// Build up the local routers;
		$model->check_state_routers();
		$view  = $this->getView  ( 'routes_settings','html');
		$view->setModel( $model, true );
		$view->view();
	}

	function save() {

		$model =& $this->getModel ('routes_settings');

		$model->save ( );
		$this->setRedirect('index.php?option=com_smartsef', JTEXT::_('VW_ROUTER_SAVED'));
	}

	function back() {
		$this->setRedirect('index.php?option=com_smartsef', JTEXT::_('VW_ROUTER_NOT_SAVED'));
	}

	function rebuild() {
		/*
		 * Rebuild the router settings by purging the router setting table, will be automaticly rebuild;
		 */
		$model =& $this->getModel ('routes_settings');
		$model->purge();
		/*
		 * Show the view again, this will rebuild the router setting table;
		 */
		$this->view();
	}
}
?>