<?php
/**
* updatedb.blastchatc.php
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

function bc_updatedb() {
	global $database, $bc_site;

	$query = "SELECT version FROM #__blastchatc WHERE url='$bc_site'";
	$database->setQuery($query);
	$version = null;
	$version = $database->loadResult();
	$errmsg = null;
	if ($version) {
		$result = true;
		if (strcmp($version, "2.1") < 0) {
			$database->setQuery( "ALTER TABLE `#__blastchatc` DROP PRIMARY KEY" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc` ADD `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc` ADD UNIQUE(`url`)" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` ADD `serverid` INT(11) DEFAULT '0' NOT NULL AFTER `userid`" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` ADD `idle` INT(11) DEFAULT '0'" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "UPDATE #__blastchatc SET version='2.1', d_height='480'" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "UPDATE #__components SET name='BlastChat client 2.1' WHERE link='option=com_blastchatc'" );
			if ($result && !$database->query()) $result = false;
			
			if (!$result)
				$errmsg = "Error updating database: ".$database->stderr(true);
		}
		if (strcmp($version, "2.2") < 0) {
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` ADD `roomid` INT(11) NOT NULL DEFAULT '0'" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` ADD `room_serverid` INT(11) NOT NULL DEFAULT '0'" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` CHANGE `idle` `idle` VARCHAR(5) NULL" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` ADD `roomname` VARCHAR(100) NULL" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "UPDATE #__blastchatc SET version='2.2'" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "UPDATE #__components SET name='BlastChat client 2.2' WHERE link='option=com_blastchatc'" );
			if ($result && !$database->query()) $result = false;
			
			if (!$result)
				$errmsg = "Error updating database: ".$database->stderr(true);
		}
		if (strcmp($version, "2.3") < 0) {
			$database->setQuery( "SELECT id FROM #__blastchatc ORDER BY id DESC" );
			$rows = null;
			$rows = $database->loadObjectList();
			foreach ($rows as $row) {
				$newid = $row->id + 1;
				$database->setQuery( "UPDATE #__blastchatc SET id=$newid WHERE id=$row->id" );
				if ($result && !$database->query()) $result = false;
				$database->setQuery( "UPDATE #__blastchatc_users SET serverid=$newid WHERE serverid=$row->id" );
				if ($result && !$database->query()) $result = false;
			}

			$database->setQuery( "ALTER TABLE `#__blastchatc` CHANGE `version` `version` VARCHAR( 20 ) NOT NULL DEFAULT '2.3' " );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc` CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT " );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc` ADD `adm_expand` BINARY( 1 ) DEFAULT '1' NOT NULL" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "UPDATE `#__blastchatc_users` SET session_id=sec_code WHERE session_id IS NULL" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` DROP INDEX `session_id` " );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` CHANGE `session_id` `session_id` VARCHAR( 200 ) NOT NULL default '0'" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` ADD PRIMARY KEY ( `session_id` )" );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` DROP INDEX `userid_logged_last_update` ,ADD INDEX `userid_logged_last_update` ( `userid` , `logged` , `last_update`, `session_id` ) " );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` ADD INDEX `serverid` ( `serverid` , `userid` , `sec_code` ) " );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "ALTER TABLE `#__blastchatc_users` ADD `last_entry` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'" );
			if ($result && !$database->query()) $result = false;
			//following code is important for dynamic module, to make select queries use indexes
			$database->setQuery( "ALTER TABLE `#__session` ADD INDEX `blastchatc` ( `usertype` , `guest` , `session_id`, `userid` ) " );
			if ($result && !$database->query()) $result = false;
			$database->setQuery( "UPDATE `#__components` SET name='BlastChat client' WHERE link LIKE 'option=com_blastchatc'" );
			$database->query();
			$database->setQuery( "UPDATE `#__blastchatc` SET version='2.3'" );
			if ($result && !$database->query()) $result = false;
			
			if (!$result)
				$errmsg = _BC_ERROR_0004.": ".$database->stderr(true);
		}
	}
	return $errmsg;
}
?>
