<?php
/**
* uninstall.blastchatc.php
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

if (!defined('_BC_BLASTCHAT')) DEFINE("_BC_BLASTCHAT","BlastChat Client");

function com_uninstall()
{
	global $mosConfig_absolute_path, $mosConfig_lang, $database;

	// Get the languages file if it exists
	if (file_exists($mosConfig_absolute_path.'/components/com_blastchatc/languages/'.$mosConfig_lang.'.php'))
		include_once($mosConfig_absolute_path.'/components/com_blastchatc/languages/'.$mosConfig_lang.'.php');
	if (file_exists($mosConfig_absolute_path.'/components/com_blastchatc/languages/english.php'))
		include_once($mosConfig_absolute_path.'/components/com_blastchatc/languages/english.php');

	$database->setQuery( "ALTER TABLE `#__session` DROP INDEX `blastchatc`" );
	$database->query();

	return _BC_BLASTCHAT." "._BC_UNINSTAL;
}		
?>