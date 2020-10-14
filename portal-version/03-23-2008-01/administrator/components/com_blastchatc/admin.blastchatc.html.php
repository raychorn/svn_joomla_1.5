<?php
/**
* admin.blastchatc.html.php
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

class HTML_blastchatc {

function showlicense() {
	global $mosConfig_live_site;
	
	mosCommonHTML::loadOverlib();
?>
	<th nowrap>
		<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="<?php echo $mosConfig_live_site; ?>/components/com_blastchatc/images/somerights20.png"/></a>
		&nbsp;
		<?php echo mosToolTip( _BC_LICENSE_INFO, _BC_LICENSE_INFO_HEADER ); ?>
	</th>
<?php
}

function showBottomLicense() {
	global $mosConfig_live_site;
	
	mosCommonHTML::loadOverlib();
?>
	<tr>
	<td colspan="3" align="center">
		<br>
		<div style="display: block" align="center">
		<span xmlns:dc="http://purl.org/dc/elements/1.1/" property="dc:title">BlastChat client</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.blastchat.com" property="cc:attributionName" rel="cc:attributionURL">BlastChat</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License</a>.&nbsp;<?php echo mosToolTip( _BC_LICENSE_INFO, _BC_LICENSE_INFO_HEADER ); ?><br/>
		Permissions beyond the scope of this license may be available at <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.blastchat.com/client_license.html" rel="cc:morePermissions">http://www.blastchat.com/client_license.html</a>.
		</div>
		<div style="display: block" align="center">
			<a href="http://www.blastchat.com" target="_blank">BlastChat client 2.3</a>
		</div>
	</td>
	</tr>
<?php
}

function creditsHTML() {
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform"">
	<tr>
		<th nowrap width="100%"><span class="sectionname">&nbsp;BlastChat - <?php echo _BC_MENU_CREDITS;?></span></th>
		<?php HTML_blastchatc::showLicense(); ?>
	</tr>
</table>
	<table class="adminheading">
	<tr>
		<th class="credits">
		<?php echo _BC_MENU_CREDITS;?>
		</th>
	</tr>
	</table>

<table class="adminlist">
<tr>
	<th class="title">
	<?php echo _BC_USERNAME;?>
	</th>
	<th class="title">
	<?php echo _BC_NAME;?>
	</th>
	<th class="title">
	<?php echo _BC_WEBSITE;?>
	</th>
	<th width="100%" class="title">
	</th>
</tr>
<tr>
<td>dragontje124</td>
<td>Rik</td>
<td><a href="http://www.blastchat.com" target="_blank">www.blastchat.com</td>
<td>BlastChat test leader, responsible for testing client under different CMSs</td>
</tr>
<tr>
<td></td>
<td>Francesco</td>
<td><a href="http://www.joomlatopten.com" target="_blank">www.joomlatopten.com</td>
<td>Special thanks for preparing module draft and for module testing of improved Community Builder profiles connection, avatars, colors</td>
</tr>
</table>
<table width="100%">
<?php HTML_blastchatc::showBottomLicense(); ?>
</table>
<?php
}

function configHTML($website, $option, $lists=null) {
	global $mosConfig_live_site;
	?>
	<script language="javascript" type="text/javascript">
	<!--
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		// do field validation
		//if (form.name.value == "") {
			//alert( "You must provide a banner name." );
		//} else {
			submitform( pressbutton );
		//}
	}
	//-->
	</script>

<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform"">
	<tr>
		<th nowrap width="100%"><span class="sectionname">&nbsp;BlastChat - <?php echo _BC_MENU_CONFIG_C;?></span></th>
		<?php HTML_blastchatc::showLicense(); ?>
	</tr>
</table>
	<table class="adminheading">
	<tr>
		<th class="config">
		<?php echo _BC_MENU_CONFIG;?>
		</th>
	</tr>
	</table>

<form action="index2.php" method="POST" name="adminForm">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
<tr>
<td><?php echo _BC_WEBSITE; ?></td>
<td><?php echo $lists['website'];?></td>
</tr>
<tr>
<td><?php echo _BC_DETACHED; ?></td>
<td><input type="checkbox" name="detached" class="checkbox" size="20" <?php if ($website->detached) {?>checked<?php } ?> /></td>
<td><?php echo _BC_DETACHED_DES; ?></td>
</tr>
<tr>
<td><?php echo _BC_WIDTH; ?></td>
<td><input type="text" name="width" class="inputbox" size="20" value="<?php echo $website->width; ?>"></td>
<td><?php echo _BC_WIDTH_DES; ?></td>
</tr>
<tr>
<td><?php echo _BC_DWIDTH; ?></td>
<td><input type="text" name="d_width" class="inputbox" size="20" value="<?php echo $website->d_width; ?>"></td>
<td><?php echo _BC_DWIDTH_DES; ?></td>
</tr>
<tr>
<td><?php echo _BC_HEIGHT; ?></td>
<td><input type="text" name="height" class="inputbox" size="20" value="<?php echo $website->height; ?>"></td>
<td><?php echo _BC_HEIGHT_DES; ?></td>
</tr>
<tr>
<td><?php echo _BC_DHEIGHT; ?></td>
<td><input type="text" name="d_height" class="inputbox" size="20" value="<?php echo $website->d_height; ?>"></td>
<td><?php echo _BC_DHEIGHT_DES; ?></td>
</tr>
<tr>
<td><?php echo _BC_FRAMEBORDER; ?></td>
<td><input type="checkbox" name="frame_border" class="checkbox" size="20" <?php if ($website->frame_border) {?>checked<?php } ?> /></td>
<td><?php echo _BC_FRAMEBORDER_DES; ?></td>
</tr>
<tr>
<td><?php echo _BC_MWIDTH; ?></td>
<td><input type="text" name="m_width" class="inputbox" size="20" value="<?php echo $website->m_width; ?>"></td>
<td><?php echo _BC_MWIDTH_DES; ?></td>
</tr>
<tr>
<td><?php echo _BC_MHEIGHT; ?></td>
<td><input type="text" name="m_height" class="inputbox" size="20" value="<?php echo $website->m_height; ?>"></td>
<td><?php echo _BC_MHEIGHT_DES; ?></td>
</tr>
<tr>
<!--
<td colspan="3"><input class="blastchat_button" type="submit" id="submit" name="submit" value="<?php echo(_BC_UPDATE); ?>" /></td>
</tr>
-->
<tr>
<td colspan="3" style="color: red;">
<?php
	$compared = strcmp($website->version, "2.3");
	if ($compared < 0) {
		?>
		<a href="index2.php?option=com_blastchatc&task=updatedatabase" ><?php echo _BC_DATABASE_UPDATE." ".$website->version." -> 2.3";?></a>
		<?php
	} elseif ($compared == 0) {
		echo _BC_DATABASE_CURRENT." 2.3";
	} else {
		echo _BC_DATABASE_WRONG;
	}
?>
</td>
</tr>
</table>
<table width="100%">
<?php HTML_blastchatc::showBottomLicense(); ?>
</table>
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="id" value="<?php echo $website->id;?>" />
	<input type="hidden" name="boxchecked" value="1" />
	<input type="hidden" name="hidemainmenu" value="0" />
</form>

<?php
}

//type - 0 registration, 1 configuration
function regHTML($website, $type, $task) {
	global $_VERSION, $mosConfig_live_site, $mosConfig_lang, $cur_template, $mainframe;

	if (!$type) {
		//registration
		$intra_id = $website->intra_id;//set this to unique identifier that will be used to identify your intranet server
		$priv_key = $website->priv_key;//set this to unique identifier that will be used to identify your intranet server
		$ver = $website->version;
		$url = $website->url; //your server URL, for example http://www.yourserver.com or http://test.yourserver.com/mambo or http://www.someserver.com/~username
		$template = $cur_template; //current template name (for Mambo users)
		$lang = $mosConfig_lang; //local server language
		$bcItemid = mosGetParam($_REQUEST, 'Itemid');
	
		if (!$priv_key || !$intra_id || !$url) {
				echo "Error 0021 : "._BC_CONTACTWEBMASTER."\n";
				return;
		}	
	
		$request = "https://www.blastchat.com/index2.php"
			."?option=com_bcaccount"
			."&amp;cbctask=register"
			."&amp;url=".$url
			."&amp;intraid=".$intra_id
			."&amp;priv_key=".$priv_key
			."&amp;lang=".$lang
			."&amp;template=".$template
			."&amp;bcItemid=".$bcItemid
			."&amp;bc_ver=".$ver
			."&amp;prod=".$_VERSION->PRODUCT
			."&amp;rel=".$_VERSION->RELEASE
			."&amp;dev=".$_VERSION->DEV_LEVEL;
	} else {
		//configuration
		$request = "https://www.blastchat.com/index2.php?option=com_bcaccount&cbctask=bcaccount";
	}	

	$goingtodetach = mosGetParam($_REQUEST, 'd', 2);
	$detached = $mainframe->getUserStateFromRequest( "detached", 'd', 0 );
	$expanded = $mainframe->getUserStateFromRequest( "expanded", 'e', $website->adm_expand );
	
	$website->adm_expand = $expanded;
	$website->store();
	?>
<script language="JavaScript" type="text/javascript">
<!--
function expand() {
	this.location.href="index2.php?option=com_blastchatc&task=<?php echo $task;?>&e=1";
}

function collapse() {
	this.location.href="index2.php?option=com_blastchatc&task=<?php echo $task;?>&e=0";
}

function detach() {
	this.location.href="index2.php?option=com_blastchatc&task=<?php echo $task;?>&d=1";
}

function undetach() {
	this.location.href="index2.php?option=com_blastchatc&task=<?php echo $task;?>&d=0";
}
//-->
</script>
	<br>
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform"">
		<tr>
			<?php if (!$type) { ?>
				<th nowrap width="100%"><span class="sectionname">&nbsp;BlastChat - <?php echo _BC_MENU_REG;?></span></th>
			<?php } else { ?>
				<th nowrap width="100%"><span class="sectionname">&nbsp;BlastChat - <?php echo _BC_MENU_CONFIG_S;?></span></th>
			<?php } ?>
			<?php if (!$type) HTML_blastchatc::showLicense(); ?>
			<?php if ($type) { ?>
				<th nowrap>
				<?php
					$undetach_image = $mosConfig_live_site."/components/com_blastchatc/images/undetach.gif";
					$detach_image = $mosConfig_live_site."/components/com_blastchatc/images/detach.gif";
						if ($detached) {
							echo "<a href='javascript:undetach();' style='text-decoration : none;' title='"._BC_UNDETACH_DESC."'><img src='".$undetach_image."' border='no' alt='"._BC_UNDETACH."' /></a>&nbsp";
						} else {
							echo "<a href='javascript:detach();' style='text-decoration : none;' title='"._BC_DETACH_DESC."'><img src='".$detach_image."' border='no'alt='"._BC_DETACH."' /></a>&nbsp";
						}
					$expand_image = $mosConfig_live_site."/components/com_blastchatc/images/expandall.png";
					$collapse_image = $mosConfig_live_site."/components/com_blastchatc/images/collapseall.png";
						if ($expanded) {
							echo "<a href='javascript:collapse();' style='text-decoration : none;' title='"._BC_COLLAPSE_DESC."'><img src='".$collapse_image."' border='no'alt='"._BC_COLLAPSE."' /></a>&nbsp";
						} else {
							echo "<a href='javascript:expand();' style='text-decoration : none;' title='"._BC_EXPAND_DESC."'><img src='".$expand_image."' border='no' alt='"._BC_EXPAND."' /></a>&nbsp";							
						}
					?>
				</th>
				<?php } ?>
		</tr>
		<tr>

			<td colspan="2">
<?php if ($goingtodetach == 1) { ?>
<div id="errmsg"></div>
<script language="javascript" type="text/javascript">
<!--
var mine = window.open("<?php echo $request;?>","BlastChat","WIDTH=<?php echo $website->d_width;?>, HEIGHT=<?php echo $website->d_height;?>, location=no, menubar=no, status=no, toolbar=no, scrollbars=no, resizable=yes");
if (!mine) {
	var objId = 'errmsg';
	var text = "<?php echo _BC_ERROR_NOPOPUP;?>";
	text = text + "<br>" + '<?php echo sprintf(_BC_OPENUNDETACHED, "<a href=\"".$mosConfig_live_site."/index.php?option=com_blastchatc&d=0\">"._BC_OPENUNDETACHED_HERE."</a>");?>';
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
<?php } elseif ($goingtodetach == 0 || $detached == 0 || !$type) { ?>
<?php if ($expanded || !$type) { ?>
<iframe NAME="blastchatc" ID="blastchatc" SRC="<?php echo $request;?>" HEIGHT="480" WIDTH="100%" FRAMEBORDER="0" marginwidth="0" marginheight="0" SCROLLING="AUTO">
</iframe>
<?php } ?>
<?php } ?>
<!-- !!! Do not remove, tamper with, obstruct visibility or obstruct readability of following code unless you have received written permission to do so by owner of BlastChat !!! -->
<div align="center" style="width:100%; font-size: 10px; text-align:center; margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">Powered by <a href="http://www.blastchat.com" target="_blank" title="BlastChat - free chat for your website">BlastChat</a></div>
			</td>
		</tr>
	</table>
<?php
}

function defaultHTML()
{
		global $mosConfig_live_site;
		?>
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform"">
		<tr>
			<th nowrap width="100%"><span class="sectionname">&nbsp;BlastChat</span></th>
			<?php HTML_blastchatc::showLicense(); ?>
		</tr>
		<?php HTML_blastchatc::showBottomLicense(); ?>
	</table>
<?php	
}
}
