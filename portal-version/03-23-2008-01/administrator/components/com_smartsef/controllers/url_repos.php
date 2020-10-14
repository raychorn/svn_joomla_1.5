<?php
/* @version		$Id: url_repos.php 220 2008-02-10 21:31:18Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
jimport( 'joomla.application.component.controller' );
class url_reposController extends JController {

	function __construct() 	{
		parent::__construct();
		$this->registerTask( 'unlock', 'lock' );
		$this->registerTask( 'unblock', 'block' );
		$this->registerTask( 'unpublish', 'publish' );
		$this->registerTask( 'add', 'edit' );
	}

	function back () {
		$this->setRedirect( 'index.php?option=com_smartsef');
	}

	// Display an overview of the available URL in the repos;
	function view () {
		$model =& $this->getModel ('url_repos');
		$view  = $this->getView  ( 'url_repos','html');
		$view->setModel( $model, true );
		//$model = $this->getModel('url_repos');
		$view->view(  );
	}

	function lock() {
		$cid 	= JRequest::getVar('cid', array(0), 'method', 'array');

		$model = $this->getModel('url_repos');
		foreach ( $cid as $id ) {
			$model->lock($id );
		}
		$this->setRedirect( 'index.php?option=com_smartsef&control=url_repos&task=view');
	}

	function block() {
		$cid 	= JRequest::getVar('cid', array(0), 'method', 'array');

		$model = $this->getModel('url_repos');
		foreach ( $cid as $id ) {
			$model->block($id );
		}
		$this->setRedirect( 'index.php?option=com_smartsef&control=url_repos&task=view');
	}

	function activate ( ) {
		// active the selected URL as the primary SEF link
		$cid 	= JRequest::getVar('cid', array(0), 'method', 'array');

		if ( count ( $cid) == 0 ) {
			// do nothing return;
			$this->setRedirect( 'index.php?option=com_smartsef&control=url_repos&task=view');
			return;
		}

		$id 	= $cid[0];
		$model = $this->getModel('url_repos');

		$model->activate ( $id );

		$this->setRedirect( 'index.php?option=com_smartsef&control=url_repos&task=view');

	}

	function publish() {
		$cid 	= JRequest::getVar('cid', array(0), 'method', 'array');

		$model = $this->getModel('url_repos');
		foreach ( $cid as $id ) {
			$model->publish($id );
		}
		$this->setRedirect( 'index.php?option=com_smartsef&control=url_repos&task=view');
	}
	function edit() {


		$this->addModelPath( JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_smartsef' . DS . 'models');
		$model = $this->getModel('url_edit', 'url_editModel');
		// url_editModelurl_edit

		$this->addViewPath ( JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_smartsef' . DS .'views' . DS . 'url_edit' );
		$view  = $this->getView  ( 'url_edit','html','url_editView');
		$view->setModel( $model, true );

		$view->edit(  );
	}

	function delete () {
		$cid 	= JRequest::getVar('cid', array(0), 'method', 'array');

		$model = $this->getModel('url_repos');
		foreach ( $cid as $id ) {
			$model->delete($id );
		}
		$this->setRedirect( 'index.php?option=com_smartsef&control=url_repos&task=view');

	}

}


?>
