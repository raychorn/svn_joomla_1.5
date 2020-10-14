<?php
////////////////////////////////////////////////////////////////////
// FILE:         adminpopups_2.inc.php
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
// CREATE NEW BODY CONTENT
////////////////////////////////////////////////////////////////////
	
	$file_root = ($file_root)?$file_root:dirname($_SERVER['SCRIPT_NAME']).'/';
	$admin_root = ($admin_root)?$admin_root:'administrator/';
	for($i = 1; $i <= count(explode("/",$file_root))-1; $i++ ) {
		$path_to_admin .= '../';
	}
	$path_to_admin .= $admin_root;
	
	$html .= '<br />';
		
	/* Place the table in the html body */
	$_JRESPONSE->body[0] = str_replace('</body>',$html."\n</body>",$_JRESPONSE->body[0]);

	/* Correct reference to admin templates */
	$_JRESPONSE->body[0] = str_replace('href="templates', 'href="'.$path_to_admin.'templates',$_JRESPONSE->body[0]);
	
////////////////////////////////////////////////////////////////////
// DO LAST ADMIN STUFF (copied from the aqdmin index.php)
////////////////////////////////////////////////////////////////////

	/* RETURN THE RESPONSE */
	echo JResponse::toString($mainframe->getCfg('gzip'));

////////////////////////////////////////////////////////////////////
?>