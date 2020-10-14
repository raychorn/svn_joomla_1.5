<?php
////////////////////////////////////////////////////////////////////
// FILE:         adminpopups_1.inc.php
//------------------------------------------------------------------
// PACKAGE:      adminpopups
// NAME:         Admin Popups (includes)
// DESCRIPTION:  Used to create HTML pages for admin popups
// VERSION:      1.0.1
// CREATED:      March 2008
// MODIFIED:     March 2008
//------------------------------------------------------------------
// AUTHOR:       NoNumber! (Peter van Westen)
// E-MAIL:       peter@nonumber.nl
// WEBSITE:      http://www.nonumber.nl
//------------------------------------------------------------------
// COPYRIGHT:    (C) 2008-2010 - NoNumber! - All Rights Reserved
// LICENSE:      GNU/GPL  [ http://www.gnu.org/copyleft/gpl.html ]
////////////////////////////////////////////////////////////////////

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

////////////////////////////////////////////////////////////////////
// SET ROOT PATHS CORRECTLY
////////////////////////////////////////////////////////////////////

	$file_root = ($file_root)?$file_root:dirname($_SERVER['SCRIPT_NAME']).'/';
	$admin_root = ($admin_root)?$admin_root:'administrator/';

	$_SERVER['PHP_SELF'] = str_replace( $file_root, $admin_root, $_SERVER['PHP_SELF'] );
	$_SERVER['SCRIPT_NAME'] = str_replace( $file_root, $admin_root, $_SERVER['SCRIPT_NAME'] );

	define( 'DS', DIRECTORY_SEPARATOR );
	define('JPATH_BASE', dirname( str_replace( str_replace( '/', DS, $file_root ), str_replace( '/', DS, $admin_root), __FILE__ ) ) );

////////////////////////////////////////////////////////////////////
// SET TEMPLATE AND OPTION
////////////////////////////////////////////////////////////////////

	$_REQUEST['tmpl'] = 'component';
	$_REQUEST['option'] = 'com_admin';
	// this option returns an empty html body if no task is set

////////////////////////////////////////////////////////////////////
// DO ALL THE ADMIN STUFF (copied from the aqdmin index.php)
////////////////////////////////////////////////////////////////////
	
	require_once( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	require_once( JPATH_BASE .DS.'includes'.DS.'helper.php' );
	require_once( JPATH_BASE .DS.'includes'.DS.'toolbar.php' );
	/* CREATE THE APPLICATION */
	$mainframe =& JFactory::getApplication('administrator');
	/* ROUTE THE APPLICATION */
	$mainframe->route();
	/* DISPATCH THE APPLICATION */
	$option = JAdministratorHelper::findOption();
	$mainframe->dispatch($option);
	/* RENDER THE APPLICATION */
	$mainframe->render();

////////////////////////////////////////////////////////////////////
?>