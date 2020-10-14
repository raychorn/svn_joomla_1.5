<?php
/* @version		$Id: purge.php 167 2008-01-24 22:41:05Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
jimport( 'joomla.application.component.controller' );
class purgeController extends JController {
	/*
	 * Empty the URL repository, and redirect to the pannel;
	 */
	function purge() {
		$model =& $this->getModel ('purge');
		$model->purge();
		$this->setRedirect( 'index.php?option=com_smartsef', 'URL repository is purged!');

	}
}
?>