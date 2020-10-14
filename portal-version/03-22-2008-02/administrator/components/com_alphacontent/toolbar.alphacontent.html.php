<?php
/*********************************************
* alphacontent - Mambo/Joomla! Component     *
* Copyright (C) 2005-2008 by Bernard Gilly   *
* Homepage   : www.visualclinic.fr           *
* Version    : 3.0                           *
* License    : DonationWare                  *
* 			 : All Rights Reserved           *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $_VERSION;

class MENUALPHA {

	function ALPHA() {
		global $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( 'AlphaContent' ), 'config.png' );
			}
		}
		mosMenuBar::startTable();
		mosMenuBar::save( 'savesettings' );
		mosMenuBar::spacer();
		mosMenuBar::cancel( 'cancelsettings' );
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

}
?>