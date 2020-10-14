<?php
/**
* defaults.blastchatc.php
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

/*
adjust this function to return proper group id for current user
$uid - current user id
return - current user group id, integer OR ra string in format "1,2,3" in case your system can assign multiple groups to single member
*/

function bc_getUserGroup($uid = 0) {
	global $myss;

	$gid = 0;
	if ($uid) {
		/*replace following code with database call to retreive current user group id
		//example
		$query = "SELECT groupid FROM #__xxx "
		." WHERE userid=$myss->userid";
		$database->setQuery($query);
		$gid = $database->loadResult();
		if (!$gid)
		$gid = 0;

		//or example
		global $my;
		$query = "SELECT gid FROM #__xxx "
		." WHERE userid=$my->id";
		$database->setQuery($query);
		$gid = $database->loadResult();
		if (!$gid)
		$gid = 0;

		//or combine examples as you need
		*/
		$gid = $myss->gid;
	}
	return $gid;
}

/*
adjust this function to return proper current session information for current user
$version - variable hodling information about current CMS
return $myss - variable holding session data
	$myss->guest - 1 if user is guest (not member), 1 if user is logged in member of your website
	$myss->session_id - unique session identifier for current user
	$myss->userid - unique user id if logged in member, if user is guest then this should be set to 0 (zero)
	$myss->username - unique username of currently logged in member, set to empty string "" if guest
*/

function bc_getSessionData() {
	global $mainframe, $bc_legacy, $_VERSION, $database, $mosConfig_absolute_path;
	
	$myss = null;
	if ($_VERSION->PRODUCT == "Joomla!") {
		if ($_VERSION->RELEASE < "1.5") {
			//rel=1.0, dev=x
			$myss = $mainframe->_session;
		} else {
			//rel=1.5, dev=x
			if (!$mainframe->getCfg('legacy')) {
				//for full 1.5 installation, else is 1.5 legacy mode
				$database =& JFactory::getDBO();
			} else {
				$bc_legacy = true;
			}
			if (!$mosConfig_absolute_path) {
				$mosConfig_absolute_path = JPATH_ROOT;
			}
			$session =& JFactory::getSession();
			$myss =& JTable::getInstance( 'session', 'JTable' );
			$myss->load($session->getId());
		}
	} elseif ($_VERSION->PRODUCT == "Mambo") {
		if ($_VERSION->RELEASE < "4.6") {
			//rel=4.5, dev=x
			$myss = $mainframe->_session;
		} else {
			//rel=4.6, dev=x
			$myss =& mosSession::getCurrent();
		}
	}
	/*
		//example
		$query = "SELECT guest, sessionid AS session_id, id AS userid, username FROM #__xxx "
		." WHERE userid=$my->id";
		$database->setQuery($query);
		$myss = $database->loadObject();	
	*/
	return $myss;
}

function bc_getLiveSite($ls) {
	//if $mosConfig_live_site variable is not available, then create it from request data
	//$mosConfig_live_site - holds full URL of your website (no trailing slash at the end), examples: http://www.xxx.com or http://www.xxx.com/something
	//if you are getting this error, replace code "echo ...."  with  $mosConfig_live_site = "http://yourwebsitedomain";
	if (!$ls) {
		echo "\$mosConfig_live_site variable not defined by system, adjust dynamic.blastchatc.php bc_getLiveSite() function.";
		exit;
	}
	return $ls;
}

?>