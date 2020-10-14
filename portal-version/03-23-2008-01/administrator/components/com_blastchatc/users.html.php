<?php
/**
* @version $Id: admin.users.html.php 3513 2006-05-15 20:52:25Z stingrey $
* @package Joomla
* @subpackage Users
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

/**
* @package Joomla
* @subpackage Users
*/
class HTML_BC_users {
	function showUsers( &$rows, $pageNav, $search, $option, $lists ) {
		?>
		<form action="index2.php" method="post" name="adminForm">

		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform"">
			<tr>
				<th nowrap width="100%"><span class="sectionname">&nbsp;BlastChat - <?php echo "Client side User Manager (local - admin backend)";?></span></th>
				<?php HTML_blastchatc::showLicense(); ?>
			</tr>
		</table>
		
		<table class="adminheading">
		<tr>
			<th class="user">
			User management
			</th>
			<td>
			<?php echo _BC_FILTER;?>:
			</td>
			<td width="right">
			<?php echo $lists['website'];?>
			</td>
			<td>
			<input type="text" name="search" value="<?php echo htmlspecialchars( $search );?>" class="inputbox" onChange="document.adminForm.submit();" />
			</td>
			<td width="right">
			<?php echo $lists['type'];?>
			</td>
			<td width="right">
			<?php echo $lists['logged'];?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="2%" class="title">
			#
			</th>
			<th width="3%" class="title">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title">
			<?php echo _BC_NAME;?>
			<br>
			<?php echo _BC_USERNAME;?>
			</th>
			<th width="1%" class="title" nowrap="nowrap">
			<?php echo _BC_LOGGEDIN;?>
			<br>
			<?php echo _BC_INCHAT;?>
			</th>
			<th width="1%" class="title">
			<?php echo _BC_ENABLED;?>
			<br>
			<?php echo _BC_CHATTING_U;?>
			</th>
			<th width="1%" class="title">
			<?php echo _BC_ID;?>
			<br>
			<?php echo _BC_INROOM;?>
			</th>
			<th width="15%" class="title">
			<?php echo _BC_GROUP;?>
			<br>
			<?php echo _BC_ROOMNAME;?>
			</th>
			<th width="15%" class="title">
			<?php echo _BC_EMAIL;?>
			<br>
			<?php echo _BC_SECURITYCODE;?>
			</th>
			<th width="10%" class="title">
			<?php echo _BC_LASTVISIT;?>
			<br>
			<?php echo _BC_LASTCHATENTRY;?>
			</th>
			<th width="10%" class="title">
			&nbsp;
			<br>
			<?php echo _BC_LASTCHATACTIVITY;?>
			</th>
		</tr>
		<?php
		$k = 0;
		if (count( $rows ) < 1) {
			?>
			<tr class="<?php echo "row0"; ?>">
				<td colspan="10">
				<?php echo _BC_NOUSERS;?>
				</td>
			</tr>
		<?php
		}
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	=& $rows[$i];

			$img 	= $row->block ? 'publish_x.png' : 'tick.png';
			$task 	= $row->block ? 'unblock' : 'block';
			$alt 	= $row->block ? 'Enabled' : 'Blocked';
			//$link 	= 'index2.php?option=com_blastchatc&amp;task=editA&amp;id='. $row->id. '&amp;hidemainmenu=1';
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $i+1+$pageNav->limitstart;?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id ); ?>
				</td>
				<td>
				<?php echo $row->name; ?>
				<br>
				<?php echo $row->username; ?>
				</td>
				<td align="center">
				<?php echo $row->loggedin ? '<img src="images/tick.png" width="12" height="12" border="0" title="'._BC_LOGGEDIN.'" alt="'._BC_LOGGEDIN.'" />': ''; ?>
				<br>
				<?php echo $row->bc_logged ? '<img src="images/tick.png" width="12" height="12" border="0" title="'._BC_INCHAT.'" alt="'._BC_INCHAT.'" />': '-'; ?>
				</td>
				<td align="center">
				<!--
				<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				-->
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" title="<?php echo $alt; ?>" alt="<?php echo $alt; ?>" />
				<!--
				</a>
				-->
				<br>
				<?php echo $row->bc_roomid ? '<img src="images/tick.png" width="12" height="12" border="0" title="'._BC_CHATTING.'" alt="'._BC_CHATTING.'" />': '-'; ?>
				</td>
				<td align="center">
				<?php echo $row->id; ?>
				<br>
				<?php echo $row->bc_roomid ? $row->bc_roomid : '-'; ?>
				</td>
				<td align="center">
				<?php echo $row->groupname; ?>
				<br>
				<?php echo $row->bc_roomname ? $row->bc_roomname : '-'; ?>
				</td>
				<td>
				<a href="mailto:<?php echo $row->email; ?>">
				<?php echo $row->email; ?>
				</a>
				<br>
				<?php echo $row->bc_sec_code ? $row->bc_sec_code : '-'; ?>
				</td>
				<td nowrap="nowrap">
				<?php echo mosFormatDate( $row->lastvisitDate, _CURRENT_SERVER_TIME_FORMAT ); ?>
				<br>
				<?php echo $row->bc_last_entry ? mosFormatDate( $row->bc_last_entry, _CURRENT_SERVER_TIME_FORMAT ) : '-'; ?>
				</td>
				<td nowrap="nowrap">
				&nbsp;
				<br>
				<?php echo $row->bc_last_update ? mosFormatDate( $row->bc_last_update, _CURRENT_SERVER_TIME_FORMAT ) : '-'; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		<?php echo $pageNav->getListFooter(); ?>
		</table>
				<table width="100%">
				<?php HTML_blastchatc::showBottomLicense(); ?>
				</table>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="users" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}
}
?>