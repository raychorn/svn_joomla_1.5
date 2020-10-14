<?php
/**
* blastchatc.php
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

if (file_exists($mosConfig_absolute_path.'/administrator/components/com_blastchatc/blastchatc.class.php')) {
	include_once($mosConfig_absolute_path.'/administrator/components/com_blastchatc/blastchatc.class.php');
}
// Get the languages file if it exists
if (file_exists($mosConfig_absolute_path.'/components/com_blastchatc/languages/'.$mosConfig_lang.'.php')) {
	include_once($mosConfig_absolute_path.'/components/com_blastchatc/languages/'.$mosConfig_lang.'.php');
}
if (file_exists($mosConfig_absolute_path.'/components/com_blastchatc/languages/english.php')) {
	include_once($mosConfig_absolute_path.'/components/com_blastchatc/languages/english.php');
}

if (!file_exists($mosConfig_absolute_path.'/components/com_blastchatc/defaults.blastchatc.php')) {
	echo "Missing file \"defaults.blastchatc.php\"";
	return;
}
require_once($mosConfig_absolute_path.'/components/com_blastchatc/defaults.blastchatc.php');

if (!file_exists($mosConfig_absolute_path.'/components/com_blastchatc/module.blastchatc.php')) {
	echo "Missing file ".$mosConfig_absolute_path."/components/com_blastchatc/module.blastchatc.php";
	return;
}
require_once($mosConfig_absolute_path.'/components/com_blastchatc/module.blastchatc.php');

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

//getBlastChat data of your website from blastchatc table
$website = null;
$website = new josBC_website( $database );
$website->loadByURL( $bc_site );

if (!$website || !$website->intra_id || !$website->url || !$website->priv_key) {
	//if there is no information stored for your website in blastchatc table, or some is missing
	echo "Error 0002 : "._BC_CONTACTWEBMASTER."<br>";
	echo _BC_ERROR_0002." 'blastchatc' "._BC_ERROR_TABLE;
	return;
}

/* check - server to server communication for public access
*  keepsession - keep user session active with your website call
*  signoff - chatter logout from chat
*  updatelist - module data call
*  return null (stop precessing this file)
 */
$c_time = time();
$currentDate = date("Y-m-d\TH:i:s", $c_time);

if ($bc_task) {
	switch ($bc_task) {
		case 'updatelist':
			bc_userActivity();
			//call dynamic data update for module
			if (!file_exists($mosConfig_absolute_path.'/components/com_blastchatc/dynamic.blastchatc.php')) {
				echo "Missing file ".$mosConfig_absolute_path."/components/com_blastchatc/dynamic.blastchatc.php";
				return;
			}
			require_once($mosConfig_absolute_path.'/components/com_blastchatc/dynamic.blastchatc.php');
			bc_sendHeaders();
			echo "allowed".bc_getContent(bc_getParams(),1);
			break;
		case 'keepsession':
			//this is to keep user's session alive with your website
			bc_user_update($c_time);
			bc_global_count_update($c_time);
			bc_sendHeaders();
			echo "ok";
			break;
		case 'check':
			//check access to blastchat client being public
			bc_sendHeaders();
			echo "ok";
			break;
		case 'banner':
			include_once($mosConfig_absolute_path.'/components/com_blastchatc/banner.blastchatc.php');
			bc_loadBanner();
			break;
		case 'signoff':
			//user signedoff from chat, mark him as logged off
			if ($myss->guest) {
				//if user is a guest, go by session_id
				$query = "UPDATE #__blastchatc_users "
				." SET logged=0, roomid=0, room_serverid=0 "
				." WHERE session_id='$myss->session_id' "
				;
			} else {
				//if user is a member go by userid
				$query = "UPDATE #__blastchatc_users "
				." SET logged=0, roomid=0, room_serverid=0 "
				." WHERE serverid=$website->id AND userid=$myss->userid "
				;
			}
			$database->setQuery($query);
			$database->query();
			bc_global_count_update($c_time);
			bc_sendHeaders();
			echo "ok";
		break;
	}
	return;
}

//remove guest that has same session_id
$query = "DELETE FROM #__blastchatc_users WHERE userid=0 AND session_id='$myss->session_id'";
$database->setQuery($query);
$database->query();
bc_userActivity();

//get sec_code from blastchatc_users table for this user
$sec_code = '';
$bc_groupid = 0;
if (!$myss->guest) {
	$query = "SELECT sec_code FROM #__blastchatc_users "
	."\n WHERE serverid=$website->id AND userid=$myss->userid";
	$database->setQuery($query);
	$user  = null;
	$database->loadObject( $user );
	if (!$user) {
		//if a member is not in database, create his security code and add to table blastchatc_users
		//this is website url, userid, username and time dependent (if username changes, sec_code becomes invalid)
		$sec_code = md5( $bc_site.$myss->userid.$myss->username.uniqid(microtime(), 1 ) );
		$query = "INSERT INTO #__blastchatc_users (userid, serverid, sec_code, logged, last_entry, last_update, session_id) "
		." VALUES ($myss->userid, $website->id, '$sec_code', 1, '$currentDate', '$c_time', '$myss->session_id')";
		$database->setQuery($query);
		if (!$database->query()){
			echo "Error 0005 : "._BC_CONTACTWEBMASTER;
			echo "<br>".$database->stderr(true);
			return;
		}
	} else {
		//if we found member in table blastchatc, get his security code and update his information in table
		$sec_code = $user->sec_code;
		bc_user_update($c_time, $website->id, $currentDate);
	}
	$bc_groupid = bc_getUserGroup($myss->userid);
} else {
	//update not logged users (did not report in last 125 seconds using keepsession)
	$query = "UPDATE #__blastchatc_users SET session_id=sec_code, logged=0 WHERE session_id='$myss->session_id'";
	$database->setQuery($query);
	$database->query();
	$query = "INSERT INTO #__blastchatc_users (serverid, session_id, logged, last_entry, last_update) "
	." VALUES ($website->id, '$myss->session_id', 1, '$currentDate', '$c_time')";
	$database->setQuery($query);
	$database->query();
}

$time_key = time();

if ($detached == 2) {
	//overwrite not requested, load admin backend configuration for detached feature
	$detached = $website->detached;
}

//Create request for connection to blastchat server (iframe source)
$request = "https://www.blastchat.com/index2.php?option=com_blastchat&no_html=1"
."&task=client" //variable for internal blastchat use
."&ctask=enter" //variable for internal blastchat use
."&d=".$detached //
."&url=".$website->url //your website URL, for example yourserver.com or www.yourserver.com or test.yourserver.com/joomla or www.someserver.com/~username
."&intraid=".$website->intra_id//unique identifier that will be used to identify your website
."&userid=".$myss->userid //local userid of the user connecting to blastchat, if 0 user is considered a guest
."&usergid=".$bc_groupid //local user group id of the user connecting to blastchat, if 0 user has no goup assigned (currently only single group support)
."&nick=".urlencode($myss->username) //local username of the user connecting to blastchat, if empty user is considered a guest, urlencode for foreign characters (correction can be done in admin area of blastchat configuration)
."&rid=".$rid //force to go directly into this room id (you can find room id in admin area of blastchat
."&rsid=".$rsid //server id in reference to room id to go to
."&lang=".$mosConfig_lang //local website language
."&template=".$cur_template //current template name (for Joomla/Mambo users)
."&sec_code=".$sec_code //users security code
."&pub_key=".md5( $time_key.$website->priv_key ) //this will be recreated upon connection on blastchat server side using time_key and blastchat stored priv_key for your website, secutiry feature
."&time_key=".$time_key //used in public key generation, send for recreation purposes
."&bcItemid=".$bc_Itemid //current value of Itemid
."&bc_ver=".$website->version //BlastChat client version
."&prod=".$_VERSION->PRODUCT
."&rel=".$_VERSION->RELEASE
."&dev=".$_VERSION->DEV_LEVEL
;
?>

<?php if ($detached) { ?>
<div id="errmsg"></div>
<script language="javascript" type="text/javascript">
<!--
var mine = window.open("<?php echo $request;?>","BlastChat","WIDTH=<?php echo $website->d_width;?>, HEIGHT=<?php echo $website->d_height;?>, location=no, menubar=no, status=no, toolbar=no, scrollbars=no, resizable=yes");
if (!mine) {
	var objId = 'errmsg';
	var text = "<?php echo _BC_ERROR_NOPOPUP;?>";
	text = text + "<br>" + '<?php echo sprintf(_BC_OPENUNDETACHED, "<a href=\"index.php?option=com_blastchatc&d=0\">"._BC_OPENUNDETACHED_HERE."</a>");?>';
	if (document.layers) { //Netscape 4
	myObj = eval('document.' + objId);
	myObj.document.open();
	myObj.document.write(text);
	myObj.document.close();
	} else 	if ((document.all && !document.getElementById) || navigator.userAgent.indexOf("Opera") != -1) { //IE 4 & Opera
	myObj = eval('document.all.' + objId);
	myObj.innerHTML = text;
	} else if (document.getElementById) { //Netscape 6 & IE 5
	myObj = document.getElementById(objId);
	myObj.innerHTML = '';
	myObj.innerHTML = text;
	} else {
		alert('<?php echo _BC_OLDBROWSER;?>');
	}
}
//-->
</script>
<?php } else { ?>
<iframe NAME="blastchatc" ID="blastchatc" SRC="<?php echo $request;?>" HEIGHT="<?php echo $website->height;?>" WIDTH="<?php echo $website->width;?>" FRAMEBORDER="<?php echo $website->frame_border;?>" marginwidth="<?php echo $website->m_width;?>" marginheight="<?php echo $website->m_height;?>" SCROLLING="NO">
</iframe>
<?php } ?>
<!-- !!! Do not remove, tamper with, obstruct visibility or obstruct readability of following code unless you have received written permission to do so by owner of BlastChat !!! -->
<div align="center" style="width:100%; font-size: 10px; text-align:center; margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">Powered by <a href="http://www.blastchat.com" target="_blank" title="BlastChat - free chat for your website">BlastChat</a></div>
