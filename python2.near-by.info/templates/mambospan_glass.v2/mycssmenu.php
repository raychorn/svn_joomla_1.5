<?php /* mycssmenu.php based on mod_mainmenu.class.php,v 1.13 */
/**
* recoded by Konlong
* produces two variable strings in unordered list format
*  	$mycssONLY_PRI_menu => just the top level items of the menu
*  	$mycssPRI_SUB_menu => menus with submenu list (nested)
*
*
*  One variable string with the primary unordered list first followed by any sub-menu lists
*	  $mycssPRI_SUB_LAYERED => menus with submenu list (layered)
*
*
*  And a simple string of links separated with "::"
*  	$mycssPATHmenu => just the top level items of the menu with a separator  "::" between items
*
*NOTE: ONLY "$mycssPRI_SUB_LAYERED" Is wrapped in a division tag '<div id="navhorzcontainer">' for
*     primary levels and '<div id="navsubhorzcontainer">' for the sub-levels.
*     The other variables are divisionless
*     and it is up to the template designer to assign a division.
*
*     The id's used are :
*
*				<ul id="navlist">  for Primary levels
*				<li id="active">  for active or chosen item on a Primary level
*				<ul id="subnavlist">  for Sub levels
*				<li id="subactive">  for active or chosen item on a Sub level
*
* This file sould be placed in your templates own directory
* & the following should be at the top of your index.php
*
* <?php
* defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
* require($mosConfig_absolute_path."/templates/XXXXXX/mycssmenu.php");
* ?>
*
* NOTE: replace 'XXXXXX' with the name of your template
*
**/

/* $Id: mod_mainmenu.class.php,v 1.13 2004/01/13 20:36:55 ronbakker Exp $ */
/**
* Menu handling functions
* @package Mambo Open Source
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.13 $
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
if (defined( '_VALID_MYCSSMENU' )) return;

/**
* Menu List
*/
	global $database, $my, $cur_template, $Itemid;
	global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_shownoauth;
	
	$menutype = @$params->menutype ? $params->menutype : 'mainmenu';
  $class_sfx = @$params->class_suffix ? $params->class_suffix : '';

	$mycssONLY_PRI_menu = "\n";
	$mycssPRI_SUB_menu = "\n";
	$mycssPRI_SUB_LAYERED = "\n";
	$PRI_SUB_LAYERED = array();
	$PRI_SUB_LAYERED[0] = "\n".'<div id="navhorzcontainer">';
	$mycssPATHmenu = "";
	/* If a user has signed in, get their user type */
	$intUserType = 0;
	if($my->gid){
		switch ($my->usertype)
		{
			case 'Super Administrator':
			$intUserType = 0;
			break;
			case 'Administrator':
			$intUserType = 1;
			break;
			case 'Editor':
			$intUserType = 2;
			break;
			case 'Registered':
			$intUserType = 3;
			break;
			case 'Author':
			$intUserType = 4;
			break;
			case 'Publisher':
			$intUserType = 5;
			break;
			case 'Manager':
			$intUserType = 6;
			break;
		}
	}
	else
	{
		/* user isn't logged in so make their usertype 0 */
		$intUserType = 0;
	}
	
	if ($mosConfig_shownoauth) {
		$sql = "SELECT m.* FROM #__menu AS m"
		. "\nWHERE menutype='$menutype' AND published='1'"
		//. "\nAND utaccess >= '$intUserType' "
		. "\nORDER BY parent,ordering";
	} else {
		$sql = "SELECT m.* FROM #__menu AS m"
		. "\nWHERE menutype='$menutype' AND published='1' AND access <= '$my->gid'"
		//. "\nAND utaccess >= '$intUserType' "
		. "\nORDER BY parent,ordering";
	}
	$database->setQuery( $sql	);
	
	$rows = $database->loadObjectList( 'id' );
	echo $database->getErrorMsg();
	
	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ($rows as $v ) {
		$pt = $v->parent;
		$list = @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
	
	// second pass - collect 'open' menus
	$open = array( $Itemid );
	$count = 20; // maximum levels - to prevent runaway loop
	$x_id = $Itemid;
	while (--$count) {
		if (isset($rows[$x_id]) && $rows[$x_id]->parent > 0) {
			$x_id = $rows[$x_id]->parent;
			$open[] = $x_id;
		} else {
			break;
		}
	}
	cssRecurseMenu( 0, 0, $children, $open, $class_sfx, $mycssONLY_PRI_menu, $mycssPRI_SUB_menu, $PRI_SUB_LAYERED, $mycssPATHmenu );
	
$mycssHORZmenu_content = $mycssONLY_PRI_menu .= "\n";
$mycssVIRTmenu_content = $mycssPRI_SUB_menu .= "\n";
$PRI_SUB_LAYERED[0] .= "\n".'</div>jml';
$mycssHORZwSUBmenu_content = $mycssPRI_SUB_LAYERED .= implode("\n", $PRI_SUB_LAYERED) ."\n";
$mycssPATHmenu_content = $mycssPATHmenu = substr($mycssPATHmenu,0,strlen($mycssPATHmenu)-4);

define( '_VALID_MYCSSMENU', true );
/**
* Utility function to recursively work through a hierarchial menu
*/
function cssRecurseMenu( $p_id, $level, &$children, &$open, $class_sfx, &$navOnlyPrimary, &$navPrimary_Subs, &$navPrimary_Sub_layered, &$navPATH) {
	global $Itemid;
	if (@$children[$p_id]) {
		
    if ($level)
		{
			$navPrimary_Subs .= "\n".'<ul id="subnavlist">';
			$navPrimary_Sub_layered[$level] = "\n".'<div id="navsubhorzcontainer"><ul id="navlist">';
		} else
		{
			$navPrimary_Subs .= "\n".'<ul id="navlist">';
			$navOnlyPrimary .= "\n".'<ul id="navlist">';
			$navPrimary_Sub_layered[$level] .= "\n".'<ul id="navlist">';
		}
		foreach ($children[$p_id] as $row) {
			
			$idclass = '';
			$navPrimary_Subs .= "\n<li";
			$navPrimary_Sub_layered[$level] .= "\n<li";
			if (!$level)
			{
				$navOnlyPrimary .= "\n<li";
			}
			if ($Itemid == $row->id)
			{
				if ($level)
				{
					$navPrimary_Subs .= ' id="subactive"';
					$idclass = 'id="subcurrent"';
					$navPrimary_Sub_layered[$level] .= 'id="subactive"';
				} else
				{
					$navPrimary_Subs .= ' id="active"';
					$navOnlyPrimary .= ' id="active"';
					$navPrimary_Sub_layered[$level] .= ' id="active"';
					$idclass = 'id="current"';
				}
			}
			$navPrimary_Subs .= '>';
			$navPrimary_Sub_layered[$level] .= '>';
			if (!$level)
			{
				$navOnlyPrimary .= ">";
			}
//			$nav_cont .= (in_array( $row->id, $open ) ? '-X-': ''); //testing code
			if (in_array( $row->id, $open ))
			{
				$navPATH .= $row->name . ' :: ';
				
			}
			$navLink = cssGetMenuLink( $row, $level, $class_sfx, $idclass);// id_class no used at present all anchor classes set to images
			$navPrimary_Subs .= $navLink.'</li>';
			$navPrimary_Sub_layered[$level] .= $navLink.'</li>';
			if (!$level)
			{
				$navOnlyPrimary .= $navLink.'</li>';
			}
			
			if (in_array( $row->id, $open )) {
				cssRecurseMenu( $row->id, $level+1, $children, $open, $class_sfx, $navOnlyPrimary, $navPrimary_Subs, $navPrimary_Sub_layered, $navPATH);
			}
		}
		$navPrimary_Subs .= "\n</ul>";
		$navPrimary_Sub_layered[$level] .= "\n</ul>\n</div>";
		if (!$level)
		{
			$navOnlyPrimary .= "\n</ul>";
		}
	}
}

/**
* Utility function for writing a menu link
*/
function cssGetMenuLink( $mitem, $level=0, $class_sfx='', $idclass='') {
	// id_class no used at present all anchor classes set to images
	global $Itemid, $mosConfig_live_site;
	$txt = '';
	
	switch ($mitem->type) {
		case 'separator';
		// do nothing
		break;
		
		case 'url':
		if (eregi( "index.php\?", $mitem->link )) {
			//$mitem->link .= "&Returnid=$Itemid";
			if (!eregi( "Itemid=", $mitem->link )) {
				$mitem->link .= "&Itemid=$mitem->id";
			}
		}
		break;
		
		default:
		$mitem->link .= "&Itemid=$mitem->id";
		break;
	}
	
	$mitem->link = str_replace( '&', '&amp;', $mitem->link );
	
	if (strcasecmp(substr($mitem->link,0,4),"http")) {
		$mitem->link = sefRelToAbs($mitem->link);
	}
	
	$menuclass = "mainlevel$class_sfx";
	if ($level > 0) {
		$menuclass = "sublevel$class_sfx";
	}
	$menuclass = "images";
	switch ($mitem->browserNav) {
		// cases are slightly different
		case 1:
		// open in a new window
		$txt = "<a href=\"$mitem->link\" target=\"_window\" class=\"$menuclass\" $idclass>$mitem->name</a>";
		break;
		
		case 2:
		// open in a popup window
		$txt = "<a href=\"#\" onClick=\"javascript: window.open('$mitem->link', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\" class=\"$menuclass\" $idclass>$mitem->name</a>";
		break;
		
		case 3:
		// don't link it
		$txt = "<span class=\"$menuclass\" $idclass>$mitem->name</span>";
		break;
		
		default:	// formerly case 2
		// open in parent window
		$txt = "<a href=\"$mitem->link\" class=\"$menuclass\" $idclass>$mitem->name</a>";
		break;
	}
	
	return $txt;
}
?>
