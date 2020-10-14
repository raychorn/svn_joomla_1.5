<?php
/**
* @version $Id: admin.users.php 4797 2006-08-28 05:08:06Z eddiea $
* @package Joomla
* @subpackage Users
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

global $Itemid, $mosConfig_absolute_path;
//require_once( $mainframe->getPath( 'admin_html' ) );
//require_once( $mainframe->getPath( 'class' ) );
require_once( 'users.html.php' );
require_once( $mosConfig_absolute_path.'/components/com_blastchatc/module.blastchatc.php' );

bc_userActivity();

switch ($task) {
	case 'removeusers':
		bc_removeUsers( $cid, $option );
		break;
	default:
		bc_showUsers( $option );
		break;
}

function bc_showUsers( $option ) {
	global $database, $mainframe, $my, $acl, $mosConfig_list_limit, $bc_legacy, $_VERSION;

	$filter_type	= $mainframe->getUserStateFromRequest( "filter_type{$option}", 'filter_type', 0 );
	$filter_website	= $mainframe->getUserStateFromRequest( "filter_website{$option}", 'filter_website', 1 );
	$filter_logged	= intval( $mainframe->getUserStateFromRequest( "filter_logged{$option}", 'filter_logged', 0 ) );
	$limit 			= intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit ) );
	$limitstart 	= intval( $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 ) );
	$search 		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	if (get_magic_quotes_gpc()) {
		$filter_type	= stripslashes( $filter_type );
		$search			= stripslashes( $search );
	}
	$where 			= array();

	if (isset( $search ) && $search!= "") {
		$searchEscaped = $database->getEscaped( trim( strtolower( $search ) ) );
		$where[] = "(a.username LIKE '%$searchEscaped%' OR a.email LIKE '%$searchEscaped%' OR a.name LIKE '%$searchEscaped%')";
	}
	if ( $filter_website ) {
		$where[] = "bcu.serverid = $filter_website";
	}
	if ( $filter_type ) {
		if ( $filter_type == 'Public Frontend' ) {
			$where[] = "(a.usertype = 'Registered' OR a.usertype = 'Author' OR a.usertype = 'Editor'OR a.usertype = 'Publisher')";
		} elseif ( $filter_type == 'Public Backend' ) {
			$where[] = "(a.usertype = 'Manager' OR a.usertype = 'Administrator' OR a.usertype = 'Super Administrator')";
		} else {
			$where[] = "a.usertype = LOWER( " . $database->Quote( $filter_type ) . " )";
		}
	}
	if ( $filter_logged == 1 ) {
		$where[] = "s.userid = a.id";
	} elseif ($filter_logged == 2) {
		$where[] = "s.userid = a.id AND bcu.logged = 1 ";
	} elseif ($filter_logged == 3) {
		$where[] = "s.userid = a.id AND bcu.logged = 1 AND bcu.roomid != 0";
	}

	// exclude any child group id's for this user
	$pgids = $acl->get_group_children( $my->gid, 'ARO', 'RECURSE' );

	mosArrayToInts( $pgids );
	if (is_array( $pgids ) && count( $pgids ) > 0) {
		$where[] = '( a.gid != '  . implode( ' OR a.gid != ', $pgids ) . ' )';
	}

	$query = "SELECT COUNT(a.id)"
	. "\n FROM #__users AS a";

	if ($filter_logged == 1 || $filter_logged == 2) {
		$query .= "\n INNER JOIN #__session AS s ON s.userid = a.id";
	}
	$query .= "\n LEFT JOIN #__blastchatc_users AS bcu ON bcu.userid = a.id"; //add blastchatc users data

	$query .= ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : '' )
	;
	$database->setQuery( $query );
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$query = "SELECT a.*, g.name AS groupname "
	." , bcu.sec_code AS bc_sec_code "
	." , bcu.logged AS bc_logged "
	." , bcu.last_entry AS bc_last_entry "
	." , bcu.last_update AS bc_last_update "
	." , bcu.idle AS bc_idle "
	." , bcu.roomid AS bc_roomid "
	." , bcu.roomname AS bc_roomname "
	. "\n FROM #__users AS a";
	//. "\n INNER JOIN #__core_acl_aro AS aro ON aro.value = a.id"	// map user to aro
	//. "\n INNER JOIN #__core_acl_groups_aro_map AS gm ON gm.aro_id = aro.aro_id"	// map aro to group
	if (!$bc_legacy) {
		$query .= "\n INNER JOIN #__core_acl_aro_groups AS g ON g.group_id = a.gid";
	} else {
		$query .= "\n INNER JOIN #__core_acl_aro_groups AS g ON g.id = a.gid";
	}
	$query .= "\n LEFT JOIN #__blastchatc_users AS bcu ON bcu.userid = a.id"; //add blastchatc users data

	if ($filter_logged == 1 || $filter_logged == 2 || $filter_logged == 3) {
		$query .= "\n INNER JOIN #__session AS s ON s.userid = a.id";
	}

	$query .= (count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
	. "\n GROUP BY a.id"
	;
	
	if ($_VERSION->PRODUCT == "Mambo") {
		$query .= "\n LIMIT ".$pageNav->limitstart.", ".$pageNav->limit;
		$database->setQuery( $query );
	} else {
		$database->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	}
	$rows = $database->loadObjectList();

	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	$template = 'SELECT COUNT(s.userid) FROM #__session AS s WHERE s.userid = ';
	$n = count( $rows );
	for ($i = 0; $i < $n; $i++) {
		$row = &$rows[$i];
		$query = $template . (int) $row->id;
		$database->setQuery( $query );
		$row->loggedin = $database->loadResult();
	}

	// get list of Groups for dropdown filter
	$query = "SELECT id AS value, url AS text"
	. "\n FROM #__blastchatc"
	;
	$database->setQuery( $query );
	$websites = $database->loadObjectList();
	$lists['website'] = mosHTML::selectList( $websites, 'filter_website', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_website" );
	// get list of Groups for dropdown filter
	$query = "SELECT name AS value, name AS text"
	. "\n FROM #__core_acl_aro_groups"
	. "\n WHERE name != 'ROOT'"
	. "\n AND name != 'USERS'"
	;
	$types[] = mosHTML::makeOption( '0', '- Select Group -' );
	$database->setQuery( $query );
	$types = array_merge( $types, $database->loadObjectList() );
	$lists['type'] = mosHTML::selectList( $types, 'filter_type', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_type" );

	// get list of Log Status for dropdown filter
	$logged[] = mosHTML::makeOption( 0, '- Select Log Status - ');
	$logged[] = mosHTML::makeOption( 1, 'Logged In');
	$logged[] = mosHTML::makeOption( 2, 'In chat');
	$logged[] = mosHTML::makeOption( 3, 'Chatting');
	$lists['logged'] = mosHTML::selectList( $logged, 'filter_logged', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_logged" );

	HTML_BC_users::showUsers( $rows, $pageNav, $search, $option, $lists );
}

function bc_removeUsers( $cid, $option ) {
	global $database, $acl, $my, $mosConfig_live_site;
	global $Itemid;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	
	if ( count( $cid ) ) {
		$obj = new josBC_user( $database );
		foreach ($cid as $id) {
			$obj->load( $id );
			// delete user
			$obj->delete( $id );
			$msg = $obj->getError();
		}
	}
	
	if (!$msg) {
		$msg = _BC_MENU_USERS_DELETE;
	}
	
	mosRedirect( 'index2.php?option=com_blastchatc&task=users', $msg );
}
?>