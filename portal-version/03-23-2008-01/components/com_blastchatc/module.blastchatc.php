<?php
/**
* module.blastchatc.php
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

/* Support functions for dynamic BlastChat module*/

/*headers to force browser not to use cache
*/
function bc_sendHeaders() {
	//Headers are sent to prevent browsers from caching.. IE is still resistent sometimes
	header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
	header( "Cache-Control: no-store, no-cache, must-revalidate" );
	header( "Pragma: no-cache" );
	header( "Content-Type: text/html; charset=UTF-8" );
}

/* Function updates global user count for display purposes of a module
* return null
*/
function bc_global_count_update ($c_time) {
	global $database, $bc_site;

	$global_count = mosGetParam($_REQUEST, 'gcount', -1);

	if ($global_count > -1) {
		$query = "UPDATE #__blastchatc "
		." SET global_count='$global_count' "
		.", global_update='$c_time' "
		." WHERE url='$bc_site' "
		;
		$database->setQuery($query);
		$database->query();
	}
}

/* Function updates current user timestamp for display purposes of the module
* return null
*/
function bc_user_update($c_time, $website_id = 0, $currentDate = null) {
	global $database, $myss;

	$idle_time = mosGetParam($_REQUEST, 'idle_time', '');
	$rid = mosGetParam($_REQUEST, 'rid', 0);
	$rsid = mosGetParam($_REQUEST, 'rsid', 0);
	$rname = mosGetParam($_REQUEST, 'rname', '');

	$add_date = "";
	if ($currentDate) {
		$add_date = ", last_entry='$currentDate'";
	}
	
	if ($website_id) {
		//update upon chat entry
		$query = "UPDATE #__blastchatc_users "
		." SET session_id = '$myss->session_id' "
		." , logged='1' "
		." , last_update='$c_time' "
		." , idle='$idle_time' "
		." , roomid='$rid' "
		." , room_serverid='$rsid' "
		." , roomname='".mysql_real_escape_string($rname)."' "
		.$add_date
		." WHERE serverid=$website_id AND userid=$myss->userid";
		;
	} else {
		//keep session alive update
		$query = "UPDATE #__blastchatc_users "
		." SET session_id = '$myss->session_id' "
		." , logged='1' "
		." , last_update='$c_time' "
		." , idle='$idle_time' "
		." , roomid='$rid' "
		." , room_serverid='$rsid' "
		." , roomname='".mysql_real_escape_string($rname)."' "
		.$add_date
		;
		if ($myss->userid) {
			$query .= " WHERE userid=$myss->userid ";
		} else {
			$query .= " WHERE session_id='$myss->session_id' ";
		}
	}
	$database->setQuery($query);
	$database->query();
	if (!$database->getAffectedRows()) {
		if ($myss->guest) {
			//there is no entry for this guest, may be his session_id has changed
			$c_time = time();
			$currentDate = date("Y-m-d\TH:i:s", $c_time);
			$query = "INSERT INTO #__blastchatc_users (serverid, session_id, logged, last_entry, last_update) "
			." VALUES ($website_id, '$myss->session_id', 1, '$currentDate', '$c_time')";
			$database->setQuery($query);
			$database->query();
		}
	}
}

/* this function removes not active users, if user does not report in 125 seconds (report is set to every 60 seconds)
* return null
*/
function bc_userActivity() {
	global $database, $bc_time, $myss;
	
	//time for user inactivity (similar definition in blastchatc.php file (user reports every 1 minute, this gives him 2 tries to report in and keep session)
	$bc_time = time() - 125;
	
	//update not logged users (did not report in last 125 seconds using keepsession)
	$query = "UPDATE #__blastchatc_users SET session_id=sec_code, logged=0 WHERE logged=1 AND last_update<'$bc_time'";
	$database->setQuery($query);
	$database->query();
	//remove guests that are not logged in
	$query = "DELETE FROM #__blastchatc_users WHERE userid=0 AND logged=0";
	$database->setQuery($query);
	$database->query();
}

/* this function checks if user is chatting
* returns true or false
*/
function bc_isUserChatting($userid) {
	global $database, $bc_site;
	
	//get serverid
	$query = "SELECT id FROM #__blastchatc WHERE url='$bc_site'";
	$database->setQuery($query);
	$serverid = null;
	$serverid = $database->loadResult();
	
	if ($serverid) {
		//is user logged to chat?
		$query = "SELECT logged FROM #__blastchatc_users WHERE serverid=$serverid AND userid=$userid ";
		$database->setQuery($query);
		$logged = 0;
		$logged = $database->loadResult();
		if ($logged)
			return true;
		return false;
	}
	return false;
}

/* returns:
* result->global_count (cound of global chatters)
* result->global_update (last update time of global chatters count)
*/
function bc_getGlobalCount() {
	global $database, $bc_site;

	$query = "SELECT global_count, global_update "
	. "\n FROM #__blastchatc WHERE url='$bc_site'"
	;
	$database->setQuery( $query );
	$result = null;
	$database->loadObject( $result );
	return $result;
}

/*return list of chatters currently chatting
*/
function bc_getLocalChatters($bc_params) {
	global $database, $bc_site;

	if ($bc_params->cb_avatar || $bc_params->cb_s) {
		$cb_sex_field = "";
		if ($bc_params->cb_sfield) {
			$cb_sex_field = " , cb.".$bc_params->cb_sfield." AS cb_sfield ";
		}
		$query = "SELECT DISTINCT s.username, s.userid AS id, bcu.logged, bcu.last_update, bcu.roomid, bcu.room_serverid, bcu.roomname, bcu.idle, bcu.last_entry, cb.avatar, cb.avatarapproved ".$cb_sex_field." , u.lastvisitDate "
			."\n FROM #__session AS s "
			."\n LEFT JOIN #__blastchatc_users AS bcu ON (bcu.session_id=s.session_id) "
			."\n LEFT JOIN #__comprofiler AS cb ON (cb.user_id=s.userid) "
			."\n LEFT JOIN #__users AS u ON (u.id=s.userid) "
			;
	} else {
		$query = "SELECT DISTINCT s.username, s.userid AS id, bcu.logged, bcu.last_update, bcu.roomid, bcu.room_serverid, bcu.roomname, bcu.idle, bcu.last_entry, u.lastvisitDate "
			."\n FROM #__session AS s "
			."\n LEFT JOIN #__blastchatc_users AS bcu ON (bcu.session_id=s.session_id) "
			."\n LEFT JOIN #__users AS u ON (u.id=s.userid) "
			;
	}
	$query .= " WHERE s.guest=0 ";
	if ($bc_params->multisite) {
		//get serverid
		$query = "SELECT id FROM #__blastchatc WHERE url='$bc_site'";
		$database->setQuery($query);
		$serverid = null;
		$serverid = $database->loadResult();
		if (!$serverid) {
			return;
		}
		if ($bc_params->cb_avatar || $bc_params->cb_s) {
			$query = "SELECT DISTINCT s.username, s.userid AS id, bcu.logged, bcu.last_update, bcu.roomid, bcu.room_serverid, bcu.roomname, bcu.idle, bcu.last_entry, cb.avatar, cb.avatarapproved ".$cb_sex_field." , u.lastvisitDate "
				."\n FROM #__session AS s "
				."\n LEFT JOIN #__blastchatc_users AS bcu ON (bcu.session_id=s.session_id) "
				."\n LEFT JOIN #__comprofiler AS cb ON (cb.user_id = s.userid) "
				."\n LEFT JOIN #__users AS u ON (u.id=s.userid) "
				;
		} else {
			$query = "SELECT DISTINCT s.username, s.userid AS id, bcu.logged, bcu.last_update, bcu.roomid, bcu.room_serverid, bcu.roomname, bcu.idle, bcu.last_entry, u.lastvisitDate "
				."\n FROM #__session AS s "
				."\n LEFT JOIN #__blastchatc_users AS bcu ON (bcu.session_id=s.session_id) "
				."\n LEFT JOIN #__users AS u ON (u.id=s.userid) "
				;
		}
		$query .= " WHERE s.guest=0 AND bcu.serverid = '$serverid'";
	}
	
	$database->setQuery( $query );
	$chatters = $database->loadObjectList();
	return $chatters;
}

/*return list of visitors for count
*/
function bc_getChattersCount($bc_params) {
	global $database, $bc_site;

	$query = "SELECT s.guest, s.usertype, bcu.logged, bcu.last_update FROM #__session AS s "
		." LEFT JOIN #__blastchatc_users AS bcu ON (bcu.session_id=s.session_id) "
		;
	if ($bc_params->multisite) {
		//get serverid
		$query = "SELECT id FROM #__blastchatc WHERE url='$bc_site'";
		$database->setQuery($query);
		$result = null;
		$database->loadObject( $result );
		$serverid = $result->id;
		$query = "SELECT s.guest, s.usertype, bcu.logged, bcu.last_update FROM #__session AS s "
			." LEFT JOIN #__blastchatc_users AS bcu ON (bcu.session_id=s.session_id) "
			." WHERE bcu.serverid='$serverid' "
			;
	}
	
	$database->setQuery( $query );
	$chatters = $database->loadObjectList();
	return $chatters;
}
?>
