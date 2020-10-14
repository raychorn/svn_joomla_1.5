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

function com_uninstall(){
	global $database, $mosConfig_absolute_path, $_VERSION;
	
	if ( $_VERSION->PRODUCT == 'Joomla!' ){	
	  if ( $_VERSION->RELEASE >= '1.5' ) {
		  $dir_plugin = 'plugins';
	  }else{
		  $dir_plugin = 'mambots';
	  }
	} else $dir_plugin = 'mambots';	 
	
	// uninstall bot
	$query = "DELETE FROM #__$dir_plugin WHERE element LIKE 'maxcomment%'";
	$database->setQuery( $query );
	$database->query();
	@unlink( "$mosConfig_absolute_path/$dir_plugin/content/maxcommentbot.php" );
	@unlink( "$mosConfig_absolute_path/$dir_plugin/content/maxcommentbot.xml" );
	@unlink( "$mosConfig_absolute_path/$dir_plugin/system/maxcommentsystem.php" );
	@unlink( "$mosConfig_absolute_path/$dir_plugin/system/maxcommentsystem.xml" );	
	@unlink( "$mosConfig_absolute_path/$dir_plugin/search/maxcomment.searchbot.php" );
	@unlink( "$mosConfig_absolute_path/$dir_plugin/search/maxcomment.searchbot.xml" );	
	echo "<p><strong>maXcomment was uninstalled successfully.</strong></p>";
	echo "Bot was uninstalled";
	
	// uninstall joomfish content element if exist
	if ( file_exists( $mosConfig_absolute_path."/administrator/components/com_joomfish/contentelements/mxcomment.xml" ) ) {
		@unlink( $mosConfig_absolute_path."/administrator/components/com_joomfish/contentelements/mxcomment.xml" );	
		echo "<p><strong>Joomfish maXcomment element was uninstalled successfully.</strong></p>";
		echo "Bot was uninstalled";
	}
	
}
?>