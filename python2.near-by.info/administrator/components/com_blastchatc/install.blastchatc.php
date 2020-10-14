<?php
/**
* install.blastchat.php
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

function com_install()
{
	global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_lang, $database;

	// Get the languages file if it exists
	if (file_exists($mosConfig_absolute_path.'/components/com_blastchatc/languages/'.$mosConfig_lang.'.php'))
		include_once($mosConfig_absolute_path.'/components/com_blastchatc/languages/'.$mosConfig_lang.'.php');
	if (file_exists($mosConfig_absolute_path.'/components/com_blastchatc/languages/english.php'))
		include_once($mosConfig_absolute_path.'/components/com_blastchatc/languages/english.php');
	if (file_exists($mosConfig_absolute_path.'/administrator/components/com_blastchatc/updatedb.blastchatc.php'))
		include_once($mosConfig_absolute_path.'/administrator/components/com_blastchatc/updatedb.blastchatc.php');
	else
		return "File does not exist";

	//Set up icons for admin area
	$result = null;
	$menu_config = _BC_MENU_CONFIG;
	$menu_config_alt = _BC_BLASTCHAT." - "._BC_MENU_CONFIG;
	$menu_users = _BC_MENU_USERS;
	$menu_users_alt = _BC_BLASTCHAT." - "._BC_MENU_USERS;
	$menu_reg = _BC_MENU_REG;
	$menu_reg_alt = _BC_BLASTCHAT." - "._BC_MENU_REG;
	$menu_credits = _BC_MENU_CREDITS;
	$menu_credits_alt = _BC_BLASTCHAT." - "._BC_MENU_CREDITS;
	$database->setQuery("UPDATE #__components SET admin_menu_img='../components/com_blastchatc/images/config.png', name='$menu_config', admin_menu_alt='$menu_config_alt' WHERE admin_menu_link='option=com_blastchatc&task=config'");
	if (!$database->query()) {
		$result = "Error 0010 : "._BC_CONTACTWEBMASTER."\n<br><br>".$database->stderr(true);
	} else {
		$database->setQuery("UPDATE #__components SET admin_menu_img='../components/com_blastchatc/images/credits.png', name='$menu_reg', admin_menu_alt='$menu_reg_alt' WHERE admin_menu_link='option=com_blastchatc&task=register'");
		if (!$database->query()) {
			$result = "Error 0011 : "._BC_CONTACTWEBMASTER."\n<br><br>".$database->stderr(true);
		} else {
			$database->setQuery("UPDATE #__components SET admin_menu_img='../components/com_blastchatc/images/con_info.png', name='$menu_users', admin_menu_alt='$menu_users_alt' WHERE admin_menu_link='option=com_blastchatc&task=users'");
			if (!$database->query()) {
				$result = "Error 0012 : "._BC_CONTACTWEBMASTER."\n<br><br>".$database->stderr(true);
			} else {
				$database->setQuery("UPDATE #__components SET admin_menu_img='../components/com_blastchatc/images/credits.png', name='$menu_credits', admin_menu_alt='$menu_credits_alt' WHERE admin_menu_link='option=com_blastchatc&task=credits'");
				if (!$database->query()) {
					$result = "Error 0012 : "._BC_CONTACTWEBMASTER."\n<br><br>".$database->stderr(true);
			} else {
				//$result = _BC_INSTAL;
				@ini_set( "max_execution_time", "60" );
				$database->setQuery( "CREATE TABLE IF NOT EXISTS `#__blastchatc` (
					`id` int(11) NOT NULL auto_increment,
					`url` varchar(100) default NULL,
					`version` varchar(20) NOT NULL default '2.3',
					`intra_id` varchar(100) default NULL,
					`priv_key` varchar(100) default NULL,
					`detached` binary(1) NOT NULL default '0',
					`adm_expand` binary(1) NOT NULL default '1',
					`width` varchar(6) NOT NULL default '100%',
					`height` varchar(6) NOT NULL default '480',
					`d_width` varchar(6) NOT NULL default '640',
					`d_height` varchar(6) NOT NULL default '480',
					`frame_border` binary(1) NOT NULL default '0',
					`m_width` varchar(6) NOT NULL default '0',
					`m_height` varchar(6) NOT NULL default '0',
					`global_count` int(11) NOT NULL default '0',
					`global_update` int(11) NOT NULL default '0',
					PRIMARY KEY ( `id` ),
					UNIQUE KEY (`url`)
					);
					");
				if (!$database->query()) {
					$result = "Error 0013 : "._BC_CONTACTWEBMASTER."\n<br><br>".$database->stderr(true);
				} else {
					$database->setQuery( "CREATE TABLE IF NOT EXISTS `#__blastchatc_users` (
						`userid` int(11) default '0',
						`serverid` int(11) default '0',
						`sec_code` varchar(100) default NULL,
						`session_id` varchar(200) NOT NULL default 0,
						`logged` binary(1) NOT NULL default '0',
						`last_entry` datetime NOT NULL default '0000-00-00 00:00:00',
						`last_update` int(11) NOT NULL default '0',
						`idle` varchar(5) default NULL,
						`roomid` INT(11) NOT NULL default '0',
						`room_serverid` INT(11) NOT NULL default '0',
						`roomname` VARCHAR(100) default NULL,
						PRIMARY KEY (`session_id`),
						UNIQUE KEY `sec_code` (`sec_code`),
						KEY `userid_logged_last_update` (`userid`,`logged`,`last_update`,`session_id`),
						KEY `serverid` (`serverid`,`userid`,`sec_code`)
						);
						");
					if (!$database->query()) {
						$result = "Error 0014 : "._BC_CONTACTWEBMASTER."\n<br><br>".$database->stderr(true);
					} else {
						//following code is important for dynamic module, to make select queries use indexes
						$database->setQuery( "ALTER TABLE `#__session` ADD INDEX `blastchatc` ( `usertype` , `guest` , `session_id`, `userid` ) " );
						if (!$database->query()) {
							$result = "Error 0015 : "._BC_CONTACTWEBMASTER."\n<br><br>".$database->stderr(true);
						} else {
							if (!$result) {
								$result = bc_updatedb();
							}
	?>
	<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
	
							<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform"">
								<tr>
									<th width="100%"><span class="sectionname">&nbsp;<?php echo "BlastChat - free chat for your website";?></span></th>
									<th align="right" nowrap>
										<a rel="license" target="_blank" href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="<?php echo $mosConfig_live_site; ?>/components/com_blastchatc/images/somerights20.png"/></a>
										&nbsp;
										<?php echo mosToolTip( _BC_LICENSE_INFO, _BC_LICENSE_INFO_HEADER ); ?>
									</th>
								</tr>
							</table>
							<table class="adminlist">
								<tr>
									<td>
									<b>com_blastchatc
									<br><br>
									<?php if ($result) { ?>
										BlastChat client 2.3 - <?php echo _BC_INSTAL_FAIL;?>
										<br>
										<?php echo $result;?>
									<?php } else { ?>
										BlastChat client 2.3 - <?php echo _BC_INSTAL;?>
									<?php } ?>
									</b>
									</td>
								</tr>
							<?php if (!$result) { ?>
								<tr>
									<td colspan="2">[&nbsp;<a href="index2.php?option=com_blastchatc&task=register" style="font-size: 16px; font-weight: bold"><?php echo _BC_REGNOW;?>&nbsp;...</a>&nbsp;]</td>
								</tr>
							<?php } ?>
							</table>
							<br><br>
	<?php
						}
					}
					}
				}
			}
		}
	}
	return $result;
}

?>