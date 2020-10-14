<?php
/**
* @version		$Id: url_edit.php 203 2008-01-30 22:11:29Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
jimport( 'joomla.application.component.controller' );
class url_editController extends JController {

	function __construct() 	{
		parent::__construct();
	}


	function edit() {

		$model = $this->getModel('url_edit');

		$view  = $this->getView  ( 'url_edit','html');
		$view->setModel( $model, true );

		$view->edit(  );
	}

	function save () {
		$id  	= JRequest::getVar	('id', 0, 'method', 'int');
		$model 	= $this->getModel	('url_edit');
		if ( !$model->save( $id ) ) {
		 	return JError::raiseWarning( 500, 'Record Not Saved' );
			return JError::raiseWarning( 500, $url_record->getError() );
		}
		$this->setRedirect( 'index.php?option=com_smartsef&control=url_repos&task=view', JTEXT::_('VW_URL_SAVED'));
	}

	function cancel() {
		$this->setRedirect( 'index.php?option=com_smartsef&control=url_repos&task=view', JTEXT::_('VW_URL_NOT_SAVED'));
	}
}
?>