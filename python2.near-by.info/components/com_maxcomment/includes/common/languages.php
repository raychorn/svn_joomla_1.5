<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007-2008 by Bernard Gilly   *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function findFirstLanguageConfig () {
	global $mainframe, $mosConfig_absolute_path, $mosConfig_lang, $mosConfig_locale, $_VERSION;
	
	if ( $_VERSION->PRODUCT == 'Joomla!' ){	
		if ( $_VERSION->RELEASE >= '1.5' ) {
			$checkVersion = 1;
		}else{
			$checkVersion = 0;
		}		
	}else {
		$checkVersion = 0;
	}	
	
	// find the primary language used
	if ( file_exists( $mosConfig_absolute_path . "/administrator/components/com_joomfish/config.joomfish.php" ) ) {	
		// if Joom!fish installed
		require_once( $mosConfig_absolute_path . '/administrator/components/com_joomfish/joomfish.class.php' );			
		$activeLanguages = JoomFishManager::getActiveLanguages();
		$defaultlang = $activeLanguages[0]->iso;
	} else {
		if (  $checkVersion ) {
			
			$defaultlang = &JFactory::getLanguage();	
			$defaultlang = $defaultlang->getTag();
			if ( !$defaultlang ) {	
				$defaultlangarray = explode( "-", $defaultlang );
				$defaultlang = $defaultlangarray[0];
			} else $defaultlang = 'en';						
	
		} else {
			// default language
			$defaultlang = _LANGUAGE;
			if ( !$defaultlang ) {	
				$defaultlangarray = explode( "_", $mosConfig_locale );
				$defaultlang = $defaultlangarray[0];
			}
		}		
				
	}
	
	return $defaultlang;
}
?>