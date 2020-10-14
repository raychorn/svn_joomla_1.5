<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007-2008 by Bernard Gilly   *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {	
	
	case "config":
		MENUMXC::CONFIG();
		break;		
	case "usercomments":
		MENUMXC::SHOWCOMMENTS();
		break;		
	case "editcomment":
		MENUMXC::EDITCOMMENT();
		break;			
	case "admcomments":
		MENUMXC::SHOWADMCOMMENTS();
		break;		
	case "editadmcomment":
		MENUMXC::EDITADMCOMMENT();
		break;			
	case "badwords":
		MENUMXC::SHOWBADWORDS();
		break;		
	case "editbadword":
		MENUMXC::EDITBADWORD();
		break;				
	case "editlanguage":
		MENUMXC::EDITLANGUAGE();
		break;	
	case "editcss":
		MENUMXC::EDITCSS();
		break;			
	case "about":
	case "favoured":	
		MENUMXC::ABOUT();	
		break;		
	case "blockip":
		MENUMXC::SHOWBLOCKIP();
		break;		
	case "editblockip":
		MENUMXC::EDITBLOCKIP();
		break;	
	case "controlpanel":	
	default:
		MENUMXC::DEFAULTEMPTY();
}
$task = "";
?>