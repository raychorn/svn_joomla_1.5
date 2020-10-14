<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007 by Bernard Gilly        *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

$_MAMBOTS->registerFunction( 'onAfterStart', 'maXcommentSystem' );

function maXcommentSystem() {
	global $database, $mainframe, $option, $_MAMBOTS, $_VERSION;
	
	if( $option != 'com_frontpage' && $option != 'com_content' && $option != 'com_alphacontent' ) {
		return;
	}
	
	if ( $_VERSION->PRODUCT == 'Joomla!' ){	
	  if ( $_VERSION->RELEASE >= '1.5' ) {
		  $dir_plugin = 'plugins';
		  return;
	  }else{
		  $dir_plugin = 'mambots';
	  }
	} else $dir_plugin = 'mambots';	 
	
	
	$query = "SELECT ordering FROM #__$dir_plugin"
	. "\n WHERE element='maxcommentbot'"
	;
	$database->setQuery( $query );	
	$database->query();		
	$controlpos = $database->loadResult();
	
	if ( $controlpos < 10000 ) {
	
		$query = "UPDATE #__$dir_plugin"
		. "\n SET ordering = '9999'"
		. "\n WHERE element='mospaging'"
		;
	
		$database->setQuery( $query );	
		$database->query();		
	
		$query = "UPDATE #__$dir_plugin"
		. "\n SET ordering = '10000'"
		. "\n WHERE element='maxcommentbot'"
		;
		$database->setQuery( $query );
		$database->query();	
			
	}
}
?>