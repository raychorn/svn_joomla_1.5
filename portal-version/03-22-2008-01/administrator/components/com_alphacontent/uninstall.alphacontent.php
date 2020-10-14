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
	$query = "DELETE FROM #__$dir_plugin WHERE element LIKE 'alphacontentbot'";
	$database->setQuery( $query );
	$database->query();
	@unlink( "$mosConfig_absolute_path/$dir_plugin/content/alphacontentbot.php" );
	@unlink( "$mosConfig_absolute_path/$dir_plugin/content/alphacontentbot.xml" );
	echo "<p><strong>AlphaContent was uninstalled successfully.</strong></p>";
}
?>