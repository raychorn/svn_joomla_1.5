<?php
/**
* @version		$Id: toolbar.cpanel.html.php 9764 2007-12-30 07:48:11Z ircmaxell $
* @package		Joomla
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* @package		Joomla
* @subpackage	Admin
*/
class TOOLBAR_cpanel
{
	function _DEFAULT() {
		JToolBarHelper::title( JText::_( 'Control Panel' ), 'cpanel.png' );
		JToolBarHelper::help( 'screen.cpanel' );
	}
}