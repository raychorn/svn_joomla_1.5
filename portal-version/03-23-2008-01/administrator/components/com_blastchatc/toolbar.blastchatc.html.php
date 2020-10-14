<?php
/**
* toolbar.blastchatc.html.php
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

/**
* @package Joomla
* @subpackage Users
*/
class TOOLBAR_BLASTCHATC {
	/**
	* Draws the menu to edit a user
	*/
	function _CONFIG() {
		mosMenuBar::startTable();
		mosMenuBar::deleteListX(_BC_DELETEWEBSITE);
		mosMenuBar::spacer();
		mosMenuBar::save();
		mosMenuBar::spacer();
		mosMenuBar::help( 'blastchatc', true );
		mosMenuBar::endTable();
	}

	function _USERS() {
		mosMenuBar::startTable();
		mosMenuBar::deleteList(_BC_DELETEUSER, 'removeusers');
		mosMenuBar::spacer();
		mosMenuBar::help( 'blastchatc', true );
		mosMenuBar::endTable();
	}

	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::help( 'blastchatc', true );
		mosMenuBar::endTable();
	}
}
?>
