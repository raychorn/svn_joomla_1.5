<?php
/**
* admin.blastchatc.php
* @package BlastChat Client
* @copyright 2004-2007 BlastChat
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.3 $
* @author Peter Saitz <support@blastchat.com>
* @HomePage <www.blastchat.com>
**/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );


// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_blastchatc' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

/*
define global variables for BlastChat client
*/
global $mosConfig_absolute_path, $database, $mosConfig_live_site;
global $mosConfig_lang, $mainframe, $cur_template, $myss, $my, $_VERSION;
global $bc_site, $bc_time, $bc_Itemid, $bc_legacy;

//this variable is only for indication if we are under Joomla 1.5 legacy mode
$bc_legacy = false;

/*
Examples of creating link to blastchat client

Load client with parameters defined in admin backend for BlastChat component
http://www.yourwebsite.com/index.php?option=com_blastchatc

Load client with parameters defined in admin backend for BlastChat component, owerwrite detached option
Undetached
http://www.yourwebsite.com/index.php?option=com_blastchatc&d=0
Detached (if user has pop-up windows blocked, he will get option on screen to load chat Undetached
http://www.yourwebsite.com/index.php?option=com_blastchatc&d=1

Load client with parameters defined in admin backend for BlastChat component, but force to go to room with id
http://www.yourwebsite.com/index.php?option=com_blastchatc&rid=123
*/

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

if (!file_exists($mosConfig_absolute_path.'/components/com_blastchatc/defaults.blastchatc.php')) {
	echo "Missing file \"defaults.blastchatc.php\"";
	return;
}
require_once($mosConfig_absolute_path.'/components/com_blastchatc/defaults.blastchatc.php');

// Get the language file if it exists
if (file_exists($mosConfig_absolute_path.'/components/com_blastchatc/languages/'.$mosConfig_lang.'.php')) {
	include_once($mosConfig_absolute_path.'/components/com_blastchatc/languages/'.$mosConfig_lang.'.php');
}
if (file_exists($mosConfig_absolute_path.'/components/com_blastchatc/languages/english.php')) {
	include_once($mosConfig_absolute_path.'/components/com_blastchatc/languages/english.php');
}
if (file_exists($mosConfig_absolute_path.'/administrator/components/com_blastchatc/updatedb.blastchatc.php')) {
	include_once($mosConfig_absolute_path.'/administrator/components/com_blastchatc/updatedb.blastchatc.php');
}

$mosConfig_live_site = bc_getLiveSite($mosConfig_live_site);

//strip http or https from this website URL, global variable
//if you need this to be something else,assign another value to $mosConfig_live_site (do same for admin.blastchac.php file):
$bc_site = $mosConfig_live_site;
$bc_site = str_replace("http://", "", $bc_site);
$bc_site = str_replace("https://", "", $bc_site);

//time for user inactivity (similar definition in module.blastchatc.php file (user reports every 1 minute, this gives him 2 tries to report in and keep session)
// seems not to be used in this file, but included files use this variable
$bc_time = time() - 125;

//prepare variables dependent on system used
// $_VERSION - variable holding CMS information
// $_VERSION->PRODUCT - product used
// $_VERSION->RELEASE - release number of product used
// $_VERSION->DEV_LEVEL  - development number of product used
if (!isset($_VERSION)) {
	$_VERSION = & new JVersion();
}
$myss = bc_getSessionData();

$detached = mosGetParam($_REQUEST, 'd', 2); //overwrite admin backend configuration to open chat as detached or undetached
$bc_task = mosGetParam($_REQUEST, 'bc_task', null);
$rid = mosGetParam($_REQUEST, 'rid', 0);
$rsid = mosGetParam($_REQUEST, 'rsid', 0);
$bc_Itemid = mosGetParam($_REQUEST, 'Itemid', null);
$id = intval( mosGetParam( $_REQUEST, 'id', 0 ) );
$cid = mosGetParam( $_REQUEST, 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}

$query = "SELECT version FROM #__blastchatc WHERE url='$bc_site'";
$database->setQuery($query);
$version = null;
$version = $database->loadResult();
if ($version) {
	if (strcmp($version, "2.3") < 0) {
		$result = bc_updatedb();
		if ($result) {
			echo $result;
			return;
		}
	}
}

switch ($task) {
	case 'removeusers':
	case 'users':
		bc_showLocalUsers($task, $cid, $option);
		break;
	case 'save':
		bc_saveBC($task, $option);
		break;
	case 'updatedatabase':
		$result = bc_updatedb();
		if (!$result)
			echo _BC_DATABASE_UPDATED;
		else 
			echo $result;
		bc_showConfig($option);
		break;
	case 'remove':
		bc_removeBC( $id, $option );
		break;
	case 'credits':
		bc_showCredits($option);
		break;
	case 'config':
		bc_showConfig($option);
		break;
	case 'register':
		header( "Content-Type: text/html; charset=UTF-8" );
		if (!bc_check_mosconfig()) return;
		
		$row = new josBC_website($database);
		$row->loadByURL( $bc_site );
		if (!$row->url) {
			$row = bc_insert_newdata();
			if (!$row->url)
				return;
		}
		if (!$row->intra_id || $row->url != $bc_site || !$row->url) {
			$row = bc_insert_newdata();
			if (!$row->url)
				return;
		}	
		HTML_blastchatc::regHTML($row, 0, $task);
		break;
	default:
		HTML_blastchatc::defaultHTML();
		break;
	break;
}

function bc_removeBC( $id, $option ) {
	global $database, $acl, $my, $Itemid;

	if (!id) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	} else {
		$obj = new josBC_website( $database );
		$obj->load( $id );
		// delete room
		$obj->delete( $id );
		$msg = $obj->getError();
	}
	if (!$msg) {
		$msg = _BC_MENU_WEBSITE_DELETE;
	}
	mosRedirect( 'index2.php?option=com_blastchatc&task=config', $msg );
}

function bc_saveBC( $task, $option ) {
	global $database;
	
	$row = new josBC_website($database);

	$msg = _BC_MENU_CONFIG_SAVE;
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();

	mosRedirect( 'index2.php?option=com_blastchatc&task=config', $msg );
}

function bc_showLocalUsers($task, $cid, $option) {
	global $database, $mainframe;
	
	$query = "SELECT id"
	. "\n FROM #__blastchatc"
	;
	$database->setQuery( $query );
	$id = $database->loadResult();
	$filter_website	= $mainframe->getUserStateFromRequest( "filter_website{$option}", 'filter_website', $id );
	if (!$filter_website)
		$filter_website = $id;
	$row = new josBC_website($database);
	$row->load( $filter_website );
	if (!$row->url) {
		mosRedirect ("index2.php?option=com_blastchatc&task=register", _BC_MUSTREG);
	}
	include_once('users.php');
	HTML_blastchatc::regHTML($row, 1, "users");
}

function bc_showCredits($option) {
	HTML_blastchatc::creditsHTML();
}

function bc_showConfig($option) {
	global $database, $mainframe;
	
	$query = "SELECT id"
	. "\n FROM #__blastchatc"
	;
	$database->setQuery( $query );
	$id = $database->loadResult();
	$filter_website	= $mainframe->getUserStateFromRequest( "filter_website{$option}", 'filter_website', $id );
	if (!$filter_website)
		$filter_website = $id;
	$row = new josBC_website($database);
	$row->load( $filter_website );
	if (!$row->url) {
		mosRedirect ("index2.php?option=com_blastchatc&task=register", _BC_MUSTREG);
	}
	// get list of Groups for dropdown filter
	$query = "SELECT id AS value, url AS text"
	. "\n FROM #__blastchatc"
	;
	$database->setQuery( $query );
	$websites = $database->loadObjectList();
	$lists['website'] = mosHTML::selectList( $websites, 'filter_website', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_website" );
	HTML_blastchatc::configHTML($row, $option, $lists);
	HTML_blastchatc::regHTML($row, 1, "config");
}

function bc_check_mosconfig() {
	global $mosConfig_live_site;

	if (!$mosConfig_live_site) {
		echo "Error 0020 : "._BC_CONTACTWEBMASTER."\n<br><br>";
		echo "'&amp;mosConfig_live_site' "._BC_ERROR_MOSCONFIG;
		return false;
	}
	return true;
}

function bc_insert_newdata() {
	global $database, $mosConfig_live_site, $bc_site;
	
	$result = null;
	$intra_id = md5( $bc_site.uniqid(microtime(), 1 ) );
	$priv_key = md5( uniqid(microtime(), 1 ).$bc_site );
	
	$query = "INSERT INTO #__blastchatc (url, version, intra_id, priv_key) VALUES ('$bc_site', '2.3', '$intra_id', '$priv_key')";
	$database->setQuery($query);
	if (!$database->query()){
		echo "Error 0019 : "._BC_CONTACTWEBMASTER."\n<br><br>".$database->stderr(true);
		return null;
	} elseif (mysql_affected_rows() == 1) {
		$result = new josBC_website($database);
		$result->loadByURL( $bc_site );
		if (!$result->url) {
			echo "Error 0019 : "._BC_CONTACTWEBMASTER."\n<br><br>".$database->stderr(true);
			return null;
		}
	}
	return $result;
}

?>
