<?php 
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007-2008 by Bernard Gilly   *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function com_install() {
global $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang, $mosConfig_locale, $database, $_VERSION;

require( $mosConfig_absolute_path.'/administrator/components/com_maxcomment/version.php' );
require( $mosConfig_absolute_path.'/components/com_maxcomment/includes/common/languages.php' );

?>
<code><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td><div align="left">
<strong>Installation Process :</strong><br /><br />
<?php
  # Set up new icons for admin menu
  echo "Start correcting icons in administration backend.<br />";
  $database->setQuery("UPDATE #__components SET admin_menu_img='../administrator/components/com_maxcomment/images/maxcomment_icon.png' WHERE admin_menu_link='option=com_maxcomment'");
  $iconresult[0] = $database->query();
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/controlpanel.png' WHERE admin_menu_link='option=com_maxcomment&task=controlpanel'");
  $iconresult[1] = $database->query();  
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/config.png' WHERE admin_menu_link='option=com_maxcomment&task=config'");
  $iconresult[2] = $database->query();
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/language.png' WHERE admin_menu_link='option=com_maxcomment&task=admcomments'");
  $iconresult[3] = $database->query();
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/users.png' WHERE admin_menu_link='option=com_maxcomment&task=usercomments'");
  $iconresult[4] = $database->query();  
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/media.png' WHERE admin_menu_link='option=com_maxcomment&task=favoured'");
  $iconresult[5] = $database->query();  
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/edit.png' WHERE admin_menu_link='option=com_maxcomment&task=editcss'");
  $iconresult[6] = $database->query();
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/edit.png' WHERE admin_menu_link='option=com_maxcomment&task=editlanguage'");
  $iconresult[7] = $database->query();
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/warning.png' WHERE admin_menu_link='option=com_maxcomment&task=badwords'");
  $iconresult[8] = $database->query();
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/globe1.png' WHERE admin_menu_link='option=com_maxcomment&task=blockip'");
  $iconresult[9] = $database->query();  
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/search_text.png' WHERE admin_menu_link='option=com_maxcomment&task=supportwebsite'");
  $iconresult[10] = $database->query();
  $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/credits.png' WHERE admin_menu_link='option=com_maxcomment&task=about'");
  $iconresult[11] = $database->query();
  
  foreach ($iconresult as $i=>$icresult) {
  		$menulabel = ($i == 0)? 'menu' : 'submenu '.$i ;
		if ($icresult) {		
		  echo "<font color='green'>FINISHED:</font> Image of $menulabel has been corrected.<br />";
		} else {
		  echo "<font color='red'>ERROR:</font> Image of $menulabel could not be corrected.<br />";
		}
  }

  // Add plugins
  if ( $_VERSION->PRODUCT == 'Joomla!' ){	
	  if ( $_VERSION->RELEASE >= '1.5' ) {
		  $dir_plugin = 'plugins';
		  $botSystemPublished = '0';
		  $checkVersion = "Joomla";
	  }else{
		  $dir_plugin = 'mambots';
		  $botSystemPublished = '1';
		  $checkVersion = "Joomla";
	  }
  } else {
  	 $dir_plugin = 'mambots';
	 $botSystemPublished = '0';
	 $checkVersion = "Mambo";
  }
  
  echo "<br />Start install plugin.<br />";
  // content
  if ( is_writable( "$mosConfig_absolute_path/$dir_plugin/content/" ) ){
	$adminDir = dirname(__FILE__);
	@rename( $adminDir. "/mambots/content/maxcommentbot.php", "$mosConfig_absolute_path/$dir_plugin/content/maxcommentbot.php" );
	@rename( $adminDir. "/mambots/content/maxcommentbot.txt", "$mosConfig_absolute_path/$dir_plugin/content/maxcommentbot.xml" );
	// publish bot  
	$query = "INSERT INTO `#__".$dir_plugin."` VALUES ('', 'mXcommentBot', 'maxcommentbot', 'content', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '')";
	$database->setQuery( $query );
	if ( $database->query() ){
	  echo "<font color='green'>FINISHED:</font> <strong>Plugin Content</strong> has been installed and published.<br />";
	} else {
	  echo "<font color='red'>ERROR:</font> <strong>Plugin Content</strong> not be published.<br />";
	} 
  } else {
		echo "<font color='red'>ERROR:</font> <strong>Plugin Content</strong> not be installed.<br />";
		echo "The directory \"" . $mosConfig_absolute_path . "\"/$dir_plugin/content/ is not writeable<br />";
		echo "Please:<br />";
		echo "<ul><li>Uninstall mXcomment</li><li>Modify the file permissions</li><li>Reinstall</li></ul><br/>Thanks.";		
  }
  // system
  if ( $dir_plugin!='plugins' && $checkVersion!='Mambo' ) { // not in Joomla! > 1.5 & not in Mambo
	  if ( is_writable( "$mosConfig_absolute_path/$dir_plugin/system/" ) ){
		$adminDir = dirname(__FILE__);
		@rename( $adminDir. "/mambots/system/maxcommentsystem.php", "$mosConfig_absolute_path/$dir_plugin/system/maxcommentsystem.php" );
		@rename( $adminDir. "/mambots/system/maxcommentsystem.txt", "$mosConfig_absolute_path/$dir_plugin/system/maxcommentsystem.xml" );
		// publish bot  
		$query = "INSERT INTO `#__".$dir_plugin."` VALUES ('', 'mXcommentSystem', 'maxcommentsystem', 'system', 0, 0, $botSystemPublished, 0, 0, 0, '0000-00-00 00:00:00', '')";
		$database->setQuery( $query );		
		if ( $database->query() ){
		  echo "<font color='green'>FINISHED:</font> <strong>Plugin System</strong> has been installed and published.<br />";
		} else {
		  echo "<font color='red'>ERROR:</font> <strong>Plugin System</strong> not be published.<br />";
		} 		
	  } else { 
	  	  echo "<font color='red'>ERROR:</font> <strong>Plugin System</strong> not be installed.<br />";
		  echo "The directory \"" . $mosConfig_absolute_path . "\"/mambots/system/ is not writeable<br />";
          echo "Please:<br />";
		  echo "<ul><li>Uninstall mXcomment</li><li>Modify the file permissions</li><li>Reinstall</li></ul><br/>Thanks.";
	  }
  }
  // search
  if ( is_writable( "$mosConfig_absolute_path/$dir_plugin/search/" ) ){
	$adminDir = dirname(__FILE__);
	@rename( $adminDir. "/mambots/search/maxcomment.searchbot.php", "$mosConfig_absolute_path/$dir_plugin/search/maxcomment.searchbot.php" );
	@rename( $adminDir. "/mambots/search/maxcomment.searchbot.txt", "$mosConfig_absolute_path/$dir_plugin/search/maxcomment.searchbot.xml" );
	// publish bot  
	$query = "INSERT INTO `#__".$dir_plugin."` VALUES ('', 'mXcomment searchbot', 'maxcomment.searchbot', 'search', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '')";
	$database->setQuery( $query );
	if ( $database->query() ){
	  echo "<font color='green'>FINISHED:</font> <strong>Plugin Search</strong> has been installed and published.<br />";
	} else {
	  echo "<font color='red'>ERROR:</font> <strong>Plugin Search</strong> not be published.<br />";
	} 
  } else {
   	  echo "<font color='red'>ERROR:</font> <strong>Plugin Search</strong> not be installed.<br />";
	  echo "The directory \"" . $mosConfig_absolute_path . "\"/mambots/search/ is not writeable<br />";
	  echo "Please:<br />";
	  echo "<ul><li>Uninstall mXcomment</li><li>Modify the file permissions</li><li>Reinstall</li></ul><br/>Thanks.";  
  }
  
// Compliance with Joom!fish
if ( file_exists($mosConfig_absolute_path . "/administrator/components/com_joomfish/config.joomfish.php") ) {
	@rename( $mosConfig_absolute_path."/administrator/components/com_maxcomment/contentelements/mxcomment.xml", $mosConfig_absolute_path."/administrator/components/com_joomfish/contentelements/mxcomment.xml");
	@rmdir ( $mosConfig_absolute_path."/administrator/components/com_maxcomment/contentelements" ); 
} else {
	@unlink( $mosConfig_absolute_path."/administrator/components/com_maxcomment/contentelements/mxcomment.xml" ); 
	@rmdir ( $mosConfig_absolute_path."/administrator/components/com_maxcomment/contentelements" );
}

$defaultlang = findFirstLanguageConfig();

// UPGRADE 1.0.x -> 1.0.3
$MXCupgrades[0]['test'] = "SELECT `lang` FROM #__mxc_comments";
$MXCupgrades[0]['updates'][0] = "ALTER TABLE #__mxc_comments ADD `lang` VARCHAR( 10 ) DEFAULT '$defaultlang' NOT NULL AFTER `currentlevelrating`";
$MXCupgrades[0]['updates'][1] = "ALTER TABLE #__mxc_comments ADD `component` VARCHAR( 50 ) DEFAULT 'com_content' NOT NULL AFTER `lang`";
$MXCupgrades[0]['updates'][2] = "ALTER TABLE #__mxc_admcomments ADD `component` VARCHAR( 50 ) DEFAULT 'com_content' NOT NULL AFTER `currentlevelrating`";

$MXCupgrades[0]['message'] = "Upgrade to mXcomment 1.0.3";

// Apply Upgrades
foreach ($MXCupgrades AS $MXCupgrade) {
	$database->setQuery($MXCupgrade['test']);
	// if it fails test then apply upgrade
	if (!$database->query()) {
		echo "<br />Upgrade version.<br />";
		foreach($MXCupgrade['updates'] as $MXCScript) {
			$database->setQuery($MXCScript);
			if(!$database->query()) {
				// Upgrade failed
				echo("<font color='red'>".$MXCupgrade['message']." failed! SQL error:" . $database->stderr(true)."</font><br />");
			}
		}
		// Upgrade was successful
		echo "<font color='green'>".$MXCupgrade['message'].": Upgrade Applied Successfully!</font><br />";
	} 
}

// MENTIONS COPYRIGHT
$copyStart = 2007; 
$copyNow = date('Y');  
if ($copyStart == $copyNow) { 
	$copySite = $copyStart;
} else {
	$copySite = $copyStart." - ".$copyNow ;
} 
?>
</div>
</td></tr>
  <tr>
    <td><div align="left"><br /><img src="<?php echo $mosConfig_live_site."/administrator/components/com_maxcomment" ?>/images/maXcomment.png"><br /><br />
	<font color="green"><b>Installation mXcomment v.<?php echo _MAXCOMMENT_NUM_VERSION; ?> finished.</b></font>
	<br/>
	<?php 
	$query = "SELECT `subscribe` FROM #__akocomment";
	$database->setQuery( $query );
	if ($database->query()) {
		$query = "SELECT `rating` FROM #__akocomment";
		$database->setQuery( $query );
		if (!$database->query()) {
		?>
		<br />
		<form name="adminform" method="post" action=""><font color='red'>IMPORTANT : </font>Import existing comments and favoured of AkoComment Tweaked Special Edition 1.4.6
		  <input type="hidden" name="option" value="com_maxcomment">
		  <input name="task" type="hidden" value="import">
		  <br />
		  <input type="submit" name="Submit" value="Import now! (after you will not)">
		</form>
		
		<br />
	<?php 
		} 
	}
	?><br />Please, take a look on the <a href="<?php echo $mosConfig_live_site."/administrator/components/com_maxcomment/readme.html"; ?>" target="_blank" >readme file</a> before first use mXcomment.<br>
	<br />
	  Thank you for using mXcomment!<br /><br />
	  mXcomment &copy; <?php echo $copySite ; ?> by Bernard Gilly - <a href="http://www.visualclinic.fr" target="_blank" >www.visualclinic.fr</a> - All rights reserved
	  <br /><br />
    </div></td></tr>
</table></code>
<?php
}
?>