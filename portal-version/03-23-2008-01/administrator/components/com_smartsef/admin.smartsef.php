<?php
/**
* @version		$Id: admin.smartsef.php 206 2008-01-31 20:17:39Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org
* @license		GNU/GPL, see LICENSE.php
*
* The Smartsef bootstrap file;
*/
defined('_JEXEC') or die('Restricted access');

// Set the table directory
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartsef'.DS.'tables');


// Get the controller name, default is the smartsef cpannel controller;
$controllerName = JRequest::getCmd( 'control', 'cpannel' );

include_once ( JPATH_ADMINISTRATOR .DS. 'components'.DS.'com_smartsef'.DS.'includes' . DS . 'functions.php');
require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php');

$controllerName = $controllerName . 'Controller';
// Create the controller
$controller = new $controllerName();


// Perform the Request task
$controller->execute( JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();
?>