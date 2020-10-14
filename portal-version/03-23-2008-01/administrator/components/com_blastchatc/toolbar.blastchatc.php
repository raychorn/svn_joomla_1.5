<?php
/**
* toolbar.blastchatc.php
* @package BlastChat Client
* @copyright 2004-2007 BlastChat
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.3 $
* @author Peter Saitz <support@blastchat.com>
* @HomePage <www.blastchat.com>
**/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
	case 'save':
	case 'config':
		TOOLBAR_BLASTCHATC::_CONFIG();
		break;
	case 'removeusers':
	case 'users':
		TOOLBAR_BLASTCHATC::_USERS();
		break;
	default:
		TOOLBAR_BLASTCHATC::_DEFAULT();
		break;
}
?>