<?php 
/*********************************************
* alphacontent - Mambo/Joomla! Component     *
* Copyright (C) 2005-2008 by Bernard Gilly   *
* Homepage   : www.visualclinic.fr           *
* Version    : 3.0                           *
* License    : DonationWare                  *
* 			 : All Rights Reserved           *
*********************************************/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function com_install() {
global $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang, $database, $_VERSION;

// Get the right language if it exists
if (file_exists($mosConfig_absolute_path . "/administrator/components/com_alphacontent/languages/" . $mosConfig_lang . ".php")){
     include_once($mosConfig_absolute_path . "/administrator/components/com_alphacontent/languages/" . $mosConfig_lang . ".php");
     }else{
     include_once($mosConfig_absolute_path . "/administrator/components/com_alphacontent/languages/english.php");
     }

require( $mosConfig_absolute_path . '/administrator/components/com_alphacontent/version.php' );

?>
<code><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td><div align="left">
  <p><img src="<?php echo $mosConfig_live_site ; ?>/administrator/components/com_alphacontent/images/alphacontent.jpg"></p>
  <p><strong>Installation Process :</strong><br />
        <br />
        <?php
# Set up new icons for admin menu
echo "Start correcting icons in administration backend.<br />";
	 
//add new admin menu images
if ( is_writable( $mosConfig_absolute_path . "/includes/js/ThemeOffice/" ) ){
	$adminDir = dirname(__FILE__);
	@copy( $adminDir . "/images/alpha_icon.png", $mosConfig_absolute_path . "/includes/js/ThemeOffice/alpha_icon.png" );
	$pathIcon = "js/ThemeOffice/alpha_icon.png";
} else $pathIcon = "../administrator/components/com_alphacontent/images/alpha_icon.png";

/*
if ( file_exists( $mosConfig_absolute_path . "/includes/js/ThemeOffice/alpha_icon.png" ) ) {
	$pathIcon = "js/ThemeOffice/alpha_icon.png";
} else $pathIcon = "../administrator/components/com_alphacontent/images/alpha_icon.png";
*/

$database->setQuery( "SELECT id FROM #__components WHERE admin_menu_link = 'option=com_alphacontent'" );
$id = $database->loadResult();	
$database->setQuery( "UPDATE #__components SET admin_menu_img = '". $pathIcon ."', admin_menu_link = 'option=com_alphacontent' WHERE id=$id");
if ( $database->query() ) {		
  echo "<font color='green'>FINISHED:</font> Image of menu has been corrected.<br />";
} else {
  echo "<font color='red'>ERROR:</font> Image of menu could not be corrected.<br />";
}

// Add plugins
if ( $_VERSION->PRODUCT == 'Joomla!' ){	
  if ( $_VERSION->RELEASE >= '1.5' ) {
	  $dir_plugin = 'plugins';
  }else{
	  $dir_plugin = 'mambots';
  }
} else {
	$dir_plugin = 'mambots';
}

echo "<br />Start install plugin.<br />";
// content
if ( is_writable( "$mosConfig_absolute_path/$dir_plugin/content/" ) ){
	$adminDir = dirname(__FILE__);
	@rename( $adminDir. "/mambots/content/alphacontentbot.php", "$mosConfig_absolute_path/".$dir_plugin."/content/alphacontentbot.php" );
	@rename( $adminDir. "/mambots/content/alphacontentbot.xml", "$mosConfig_absolute_path/".$dir_plugin."/content/alphacontentbot.xml" );
	// publish bot  
	$query = "INSERT INTO `#__$dir_plugin` VALUES ('', 'AlphaContentBot', 'alphacontentbot', 'content', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '')";
	$database->setQuery( $query );
	if ( $database->query() ){
	  echo "<font color='green'>FINISHED:</font> <strong>Plugin Content</strong> has been installed and published.<br />";
	} else {
	  echo "<font color='red'>ERROR:</font> <strong>Plugin Content</strong> not be published.<br />";
	} 
} else {
	echo "<font color='red'>ERROR:</font> <strong>Plugin Content</strong> not be installed.<br />There was a problem with your installation<br />";
	echo "The directory $mosConfig_absolute_path/$dir_plugin/content/ is not writeable<br />";
	echo "<strong>Please:</strong<br />";
	echo "<ul><li>Uninstall AlphaContent</li>
       <li>Modify the file permissions</li>
       <li>Reinstall</li></ul>
       <br />Thanks.
        ";
}

// UPGRADE 3.0.2 -> 3.0.3
$ACupgrades[0]['test'] = "SELECT `cid` FROM #__alphacontent_rating";
$ACupgrades[0]['updates'][0] = "ALTER TABLE #__alphacontent_rating ADD `cid` INT( 11 ) DEFAULT '0' NOT NULL AFTER `component`";
$ACupgrades[0]['updates'][1] = "ALTER TABLE #__alphacontent_rating ADD `rid` INT( 11 ) DEFAULT '0' NOT NULL AFTER `cid`";
$ACupgrades[0]['message'] = "Upgrade to AlphaContent 3.0.3";

// Apply Upgrades
foreach ($ACupgrades AS $ACupgrade) {
	$database->setQuery($ACupgrade['test']);
	// if it fails test then apply upgrade
	if (!$database->query()) {
		echo "<br />Upgrade version.<br />";
		foreach($ACupgrade['updates'] as $ACScript) {
			$database->setQuery($ACScript);
			if(!$database->query()) {
				// Upgrade failed
				echo("<font color='red'>".$ACupgrade['message']." failed! SQL error:" . $database->stderr(true)."</font><br />");
			}
		}
		// Upgrade was successful
		echo "<font color='green'>".$ACupgrade['message'].": Upgrade Table Applied Successfully!</font><br />";
	} 
}

// MENTIONS COPYRIGHT
$copyStart = 2005; 
$copyNow = date('Y');  
if ($copyStart == $copyNow) { 
	$copySite = $copyStart;
} else {
	$copySite = $copyStart." - ".$copyNow ;
} 
?>
</p>
</div>
</td></tr>
  <tr>
    <td><div align="left"><br /><br />
	<font color="green"><b>Installation AlphaContent v.<?php echo _ALPHACONTENT_NUM_VERSION; ?> finished.</b></font>
	<br>
	Please, take a look on the <a href="<?php echo $mosConfig_live_site ; ?>/administrator/components/com_alphacontent/readme.html" target="_blank" >readme</a> file before start.<br/>
	  Thank you for using AlphaContent!<br /><br />
	  AlphaContent &copy; <?php echo $copySite ; ?> by Bernard Gilly - <a href="http://www.visualclinic.fr" target="_blank">www.visualclinic.fr</a> - All rights reserved
	  <br /><br />
    </div></td></tr>
</table></code>
<?php
}
?>