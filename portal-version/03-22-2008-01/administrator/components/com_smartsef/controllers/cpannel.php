<?php
/**
* @version		$Id: cpannel.php 59 2007-11-05 11:58:07Z richard $
* @package		Smartsef
* @subpackage	Admin
* @copyright	Copyright (C) 2005 - 2007 Smartsef.org 
* @license		GNU/GPL, see LICENSE.php
* 
* The Smartsef cpannel controller;
*/
 // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );
class cpannelcontroller extends JController {
 
 	function __construct()	{
		parent::__construct( );
			
	}
	
	/*
	 * Display the control pannel for the component;
	 */
	function display() 	{

		require_once(JPATH_COMPONENT.DS.'views'.DS.'desktop'.DS.'cpannel.php');
		
		cpannelSmartsef::cpannel(  );		
		
	}
}
?>
