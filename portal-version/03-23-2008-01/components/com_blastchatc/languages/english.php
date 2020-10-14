<?php
/**
* english.php
* @package BlastChat client 2.3
* @copyright 2004-2007 BlastChat
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.3 $
* @author BlastChat <support@blastchat.com>
* @encoding UTF-8
* @HomePage <www.blastchat.com>
**/

/**
* Credit to translators
* Name:
* Email:
* URL: 
**/

/**
1. Please, adjust file name and revision in top section in your language file
2. Please, use UTF-8 encoding of your language file, othervice specifically mention what encoding is used and mark it in file name as well. (i.e. english_WIN.php or something similar)
3. Feel free to fill in your credentials in "Credit to translators" section. If that is already filled, keep previous translator's data in and copy/paste new section for yourself.
4. Please, submit your new translated file to support [at] blastchat.com or upload it to Downloads area at www.blastchat.com into designated section
**/

//New in version 2.3
if (!defined('_BC_NAME')) DEFINE('_BC_NAME','Name');
if (!defined('_BC_USERNAME')) DEFINE('_BC_USERNAME','Username');
if (!defined('_BC_EMAIL')) DEFINE('_BC_EMAIL','Email');
if (!defined('_BC_NOUSERS')) DEFINE('_BC_NOUSERS','Users are created in blastchat system when a member of your site enters chat from your website\'s frontend (not admin backend).');
if (!defined('_BC_LOGGEDIN')) DEFINE('_BC_LOGGEDIN','Logged In');
if (!defined('_BC_INCHAT')) DEFINE('_BC_INCHAT','In Chat');
if (!defined('_BC_ENABLED')) DEFINE('_BC_ENABLED','Enabled');
if (!defined('_BC_CHATTING_U')) DEFINE('_BC_CHATTING_U','Chatting');
if (!defined('_BC_ID')) DEFINE('_BC_ID','ID');
if (!defined('_BC_INROOM')) DEFINE('_BC_INROOM','In&nbsp;room');
if (!defined('_BC_GROUP')) DEFINE('_BC_GROUP','Group');
if (!defined('_BC_ROOMNAME')) DEFINE('_BC_ROOMNAME','Room name');
if (!defined('_BC_SECURITYCODE')) DEFINE('_BC_SECURITYCODE','Security&nbsp;code');
if (!defined('_BC_LASTVISIT')) DEFINE('_BC_LASTVISIT','Last&nbsp;Visit');
if (!defined('_BC_LASTCHATENTRY')) DEFINE('_BC_LASTCHATENTRY','Last&nbsp;Chat&nbsp;Entry');
if (!defined('_BC_LASTCHATACTIVITY')) DEFINE('_BC_LASTCHATACTIVITY','Last Chat Activity');
if (!defined('_BC_FILTER')) DEFINE('_BC_FILTER','Filter');
if (!defined('_BC_DETACH')) DEFINE('_BC_DETACH','Detach');
if (!defined('_BC_DETACH_DESC')) DEFINE('_BC_DETACH_DESC','Detach server side configuration window');
if (!defined('_BC_UNDETACH')) DEFINE('_BC_UNDETACH','UnDetach');
if (!defined('_BC_UNDETACH_DESC')) DEFINE('_BC_UNDETACH_DESC','UnDetach server side configuration window');
if (!defined('_BC_EXPAND')) DEFINE('_BC_EXPAND','Expand');
if (!defined('_BC_EXPAND_DESC')) DEFINE('_BC_EXPAND_DESC','Expand server side configuration window');
if (!defined('_BC_COLLAPSE')) DEFINE('_BC_COLLAPSE','Collapse');
if (!defined('_BC_COLLAPSE_DESC')) DEFINE('_BC_COLLAPSE_DESC','Collapse server side configuration window');
if (!defined("_BC_WEBSITE")) DEFINE("_BC_WEBSITE", "Website");
if (!defined("_BC_DELETEWEBSITE")) DEFINE("_BC_DELETEWEBSITE", "(This will delete all data from blastchatc and blastchatc_users table related to this website, and it will make your registration with BlastChat service invalid.)");
if (!defined("_BC_DELETEUSER")) DEFINE("_BC_DELETEUSER", "(This will delete selected user(s).)");
if (!defined("_BC_OLDBROWSER")) DEFINE("_BC_OLDBROWSER", "This website uses DHTML. We recommend you upgrade your browser.");
if (!defined("_BC_OPENUNDETACHED")) DEFINE("_BC_OPENUNDETACHED", "Click %s to load chat undetached.");
if (!defined("_BC_OPENUNDETACHED_HERE")) DEFINE("_BC_OPENUNDETACHED_HERE", "here"); //filling %s in previous definition
if (!defined("_BC_ERROR_0004")) DEFINE("_BC_ERROR_0004", "Error updating database");
if (!defined("_BC_MENU_CONFIG_C")) DEFINE("_BC_MENU_CONFIG_C","Client side Configuration (local - admin backend)");
if (!defined("_BC_MENU_CONFIG_S")) DEFINE("_BC_MENU_CONFIG_S","Server side Configuration (remote - blastchat account)");
if (!defined("_BC_MUSTREG")) DEFINE("_BC_MUSTREG","First, you must register your website");
if (!defined("_BC_REGNOW")) DEFINE("_BC_REGNOW","REGISTER your website now for free");
if (!defined("_BC_MENU_USERS_DELETE")) DEFINE("_BC_MENU_USERS_DELETE", "User(s) deleted");
if (!defined("_BC_MENU_WEBSITE_DELETE")) DEFINE("_BC_MENU_WEBSITE_DELETE", "Website deleted");
if (!defined("_BC_MENU_CREDITS")) DEFINE("_BC_MENU_CREDITS","Credits");
//for Mambo sites which ar emissing this definition
if (!defined("_CURRENT_SERVER_TIME_FORMAT")) DEFINE( '_CURRENT_SERVER_TIME_FORMAT', '%Y-%m-%d %H:%M:%S' );

	/** new for module  */
	if (!defined('_BC_NEVER')) DEFINE('_BC_NEVER','Never');
	if (!defined("_BC_USER_LASTCHATENTRY")) DEFINE("_BC_USER_LASTCHATENTRY", "<br><br><b>Last chat entry:</b><br>%s");
	if (!defined('_BC_WE_HAVE')) DEFINE('_BC_WE_HAVE', 'We have ');
	if (!defined('_BC_AND')) DEFINE('_BC_AND', ' and ');
	if (!defined('_BC_GUEST_COUNT')) DEFINE('_BC_GUEST_COUNT','%s guest');
	if (!defined('_BC_GUESTS_COUNT')) DEFINE('_BC_GUESTS_COUNT','%s guests');
	if (!defined('_BC_MEMBER_COUNT')) DEFINE('_BC_MEMBER_COUNT','%s member');
	if (!defined('_BC_MEMBERS_COUNT')) DEFINE('_BC_MEMBERS_COUNT','%s members');
	if (!defined('_BC_ONLINE')) DEFINE('_BC_ONLINE',' online');
	if (!defined('_BC_NONE')) DEFINE('_BC_NONE','No Users Online');
	/**change in module **/
	if (!defined("_BC_USER_LASTLOGIN")) DEFINE("_BC_USER_LASTLOGIN", "<br><b>Last login:</b><br>%s");
	if (!defined("_BC_MEMBER")) DEFINE("_BC_MEMBER", "<b>Member &quot;%s&quot;</b>");



//New in version 2.2
if (!defined("_BC_LICENSE_INFO_HEADER")) DEFINE("_BC_LICENSE_INFO_HEADER", "Exception");
if (!defined("_BC_MENU_CONFIG_SAVE")) DEFINE("_BC_MENU_CONFIG_SAVE", "Configuration saved");
if (!defined("_BC_DATABASE_UPDATED")) DEFINE("_BC_DATABASE_UPDATED","Database updated");
	//New for module 2.2
	if (!defined("_BC_JOINCHAT")) DEFINE("_BC_JOINCHAT", "Join chat");
	if (!defined("_BC_CHATLINK")) DEFINE("_BC_CHATLINK", "Join chat");
	if (!defined("_BC_CBLINK")) DEFINE("_BC_CBLINK", "Show profile");
	if (!defined("_BC_SMFLINK")) DEFINE("_BC_SMFLINK", "Show profile");
	if (!defined("_BC_USER_INSIDE_CHAT")) DEFINE("_BC_USER_INSIDE_CHAT", "<br>Inside chat [%s&nbsp;idle].");
	if (!defined("_BC_USER_NOT_CHATTING")) DEFINE("_BC_USER_NOT_CHATTING", "<br>Not chatting.");
	if (!defined("_BC_USER_CHATTING_IN")) DEFINE("_BC_USER_CHATTING_IN", "<br>Chatting in the room &quot;%s&quot; [%s&nbsp;idle].");
	if (!defined("_BC_CHATTING")) DEFINE("_BC_CHATTING", "chatting");
	if (!defined("_BC_GLOBALSTATUS")) DEFINE("_BC_GLOBALSTATUS", "global status");
	if (!defined("_BC_LASTUPDATE")) DEFINE("_BC_LASTUPDATE", "<br><br>Last update:<br>%s");
	if (!defined("_BC_GLOBALCOUNT")) DEFINE("_BC_GLOBALCOUNT", "There are %s chatters online.");


//New in version 2.1
if (!defined("_BC_DATABASE_UPDATE")) DEFINE("_BC_DATABASE_UPDATE","Update database from version");
if (!defined("_BC_DATABASE_CURRENT")) DEFINE("_BC_DATABASE_CURRENT","Database at current version");
if (!defined("_BC_DATABASE_WRONG")) DEFINE("_BC_DATABASE_WRONG","Incorrect database version");
if (!defined("_BC_INSTAL_FAIL")) DEFINE("_BC_INSTAL_FAIL","Installation failed");

//New in version 2.0
//component menus
if (!defined("_BC_MENU_USERS")) DEFINE("_BC_MENU_USERS","Users");
if (!defined("_BC_MENU_CONFIG")) DEFINE("_BC_MENU_CONFIG","Configuration");
if (!defined("_BC_MENU_REG")) DEFINE("_BC_MENU_REG","Registration");

//registration
if (!defined("_BC_DETACHED")) DEFINE("_BC_DETACHED","Detached");
if (!defined("_BC_DETACHED_DES")) DEFINE("_BC_DETACHED_DES","Default menu link to component will open BlastChat client as Detached");
if (!defined("_BC_WIDTH")) DEFINE("_BC_WIDTH","Width");
if (!defined("_BC_WIDTH_DES")) DEFINE("_BC_WIDTH_DES","Default frame width");
if (!defined("_BC_HEIGHT")) DEFINE("_BC_HEIGHT","Height");
if (!defined("_BC_HEIGHT_DES")) DEFINE("_BC_HEIGHT_DES","Default frame height");
if (!defined("_BC_DWIDTH")) DEFINE("_BC_DWIDTH","Detached Width");
if (!defined("_BC_DWIDTH_DES")) DEFINE("_BC_DWIDTH_DES","Default detached frame width");
if (!defined("_BC_DHEIGHT")) DEFINE("_BC_DHEIGHT","Detached Height");
if (!defined("_BC_DHEIGHT_DES")) DEFINE("_BC_DHEIGHT_DES","Default detached frame height");
if (!defined("_BC_FRAMEBORDER")) DEFINE("_BC_FRAMEBORDER","Frame border");
if (!defined("_BC_FRAMEBORDER_DES")) DEFINE("_BC_FRAMEBORDER_DES","Default frame border");
if (!defined("_BC_MWIDTH")) DEFINE("_BC_MWIDTH","Margin width");
if (!defined("_BC_MWIDTH_DES")) DEFINE("_BC_MWIDTH_DES","Default frame margin width");
if (!defined("_BC_MHEIGHT")) DEFINE("_BC_MHEIGHT","Margin height");
if (!defined("_BC_MHEIGHT_DES")) DEFINE("_BC_MHEIGHT_DES","Default frame margin height");

if (!defined("_BC_INSTAL")) DEFINE("_BC_INSTAL","Installation successful");
if (!defined("_BC_UNINSTAL")) DEFINE("_BC_UNINSTAL","uninstallation successful");

if (!defined("_BC_NEXT")) DEFINE("_BC_NEXT","Next");
if (!defined("_BC_RESULT")) DEFINE("_BC_RESULT","Result");
if (!defined("_BC_UPDATE")) DEFINE("_BC_UPDATE","Update");

if (!defined("_BC_CONTACTWEBMASTER")) DEFINE("_BC_CONTACTWEBMASTER", "Error has occured, contact your webmaster");
if (!defined("_BC_NOT_IMPLEMENTED")) DEFINE("_BC_NOT_IMPLEMENTED", "Not yet implemented");

if (!defined("_BC_ERROR_MOSCONFIG")) DEFINE("_BC_ERROR_MOSCONFIG", "value is invalid, correct problem or contact BlastChat support for help");
if (!defined("_BC_ERROR_TABLE")) DEFINE("_BC_ERROR_TABLE", "table");
if (!defined("_BC_ERROR_NOPOPUP")) DEFINE("_BC_ERROR_NOPOPUP", "Can not detach chat window, your browser is blocking pop-up windows.");
if (!defined("_BC_ERROR_0002")) DEFINE("_BC_ERROR_0002", "Incorrect data in");
if (!defined("_BC_ERROR_0003")) DEFINE("_BC_ERROR_0003", "Inconsistent data in");

if (!defined("_BC_LICENSE_INFO")) DEFINE("_BC_LICENSE_INFO", "Exception: You may install and use this component on a commercial site, any other commercial use is prohibited, like offering installation of this component for a fee (for example as a part of a web hosting package).");
?>