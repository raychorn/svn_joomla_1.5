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

global $id, $option, $iconcpanel, $_VERSION, $mosConfig_absolute_path, $mosConfig_lang;

if ( $_VERSION->PRODUCT == 'Joomla!' ){	
	if ( $_VERSION->RELEASE >= '1.5' ) {
		$iconcpanel = 'default.png';
	}else{
		$iconcpanel = '../components/com_maxcomment/images/cpanel.png';
	}		
}else {
	$iconcpanel = '../components/com_maxcomment/images/cpanel.png';
}

// Get the right language if it exists
if (file_exists($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php")){
	include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php");
}else{
	include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/english.php");
}

class MENUMXC {

	function DEFAULTEMPTY() {
		mosMenuBar::startTable();
		mosMenuBar::divider();
		mosMenuBar::endTable();
	}

	function CONFIG() {
		global $iconcpanel, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_CPL_CONFIG ), 'config.png' );
			}
		}
		mosMenuBar::startTable();
		mosMenuBar::custom('', $iconcpanel, $iconcpanel, _MXC_CPANEL, false);
		mosMenuBar::spacer();
		mosMenuBar::save( 'savesettings' );
		mosMenuBar::spacer();
		mosMenuBar::cancel( 'cancelsettings' );
		mosMenuBar::endTable();
	}
	
	function SHOWCOMMENTS(){
		global $iconcpanel, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_COMMENTS ), 'generic.png' );
			}
		}		
		mosMenuBar::startTable();
		mosMenuBar::custom('', $iconcpanel, $iconcpanel, _MXC_CPANEL, false);
		mosMenuBar::spacer();
		mosMenuBar::publishList();
		mosMenuBar::spacer();
		mosMenuBar::unpublishList();
		mosMenuBar::spacer();
		mosMenuBar::editList('editcomment');
		mosMenuBar::spacer();
		mosMenuBar::deleteList( '', 'delcomment');
		mosMenuBar::spacer();
		mosMenuBar::addNew('editcomment', _MXC_NEW);
		mosMenuBar::endTable();	
	}
	
	function EDITCOMMENT() {
		global $iconcpanel, $id, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_COMMENTS . ' :: ' . _MXC_EDIT ), 'user.png' );
			}
		}				
		mosMenuBar::startTable();	
		mosMenuBar::save('savecomment', _MXC_SAVE);
		mosMenuBar::spacer();
		if ( $id ) {
			// for existing items the button is renamed `close`
			mosMenuBar::cancel( 'cancelcomment', _MXC_CLOSE );
		} else {
			mosMenuBar::cancel( 'cancelcomment' );
		}
		mosMenuBar::endTable();
	}
	
	function SHOWADMCOMMENTS(){
		global $iconcpanel, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_EDITORSCOMMENTS ), 'generic.png' );
			}
		}
		mosMenuBar::startTable();
		mosMenuBar::custom('', $iconcpanel, $iconcpanel, _MXC_CPANEL, false);
		mosMenuBar::spacer();
		mosMenuBar::publishList();
		mosMenuBar::spacer();
		mosMenuBar::unpublishList();
		mosMenuBar::spacer();
		mosMenuBar::editList('editadmcomment');
		mosMenuBar::spacer();
		mosMenuBar::deleteList( '', 'deladmcomment');
		mosMenuBar::spacer();
		mosMenuBar::addNew('editadmcomment', _MXC_NEW);
		mosMenuBar::endTable();	
	}
	
	function EDITADMCOMMENT() {
		global $iconcpanel, $id, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_EDITORSCOMMENTS . ' :: ' . _MXC_EDIT ), 'user.png' );
			}
		}				
		mosMenuBar::startTable();	
		mosMenuBar::save('saveadmcomment', _MXC_SAVE);
		mosMenuBar::spacer();
		if ( $id ) {
			// for existing items the button is renamed `close`
			mosMenuBar::cancel( 'canceladmcomment', _MXC_CLOSE );
		} else {
			mosMenuBar::cancel( 'canceladmcomment' );
		}
		mosMenuBar::endTable();
	}

	function SHOWBADWORDS(){
		global $iconcpanel, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_BADWORDS ), 'generic.png' );
			}
		}
		mosMenuBar::startTable();
		mosMenuBar::custom('', $iconcpanel, $iconcpanel, _MXC_CPANEL, false);
		mosMenuBar::spacer();
		mosMenuBar::publishList();
		mosMenuBar::spacer();
		mosMenuBar::unpublishList();
		mosMenuBar::spacer();
		mosMenuBar::editList('editbadword');
		mosMenuBar::spacer();
		mosMenuBar::deleteList( '', 'delbadword');
		mosMenuBar::spacer();
		mosMenuBar::addNew('editbadword', _MXC_NEW);
		mosMenuBar::endTable();	
	}
	
	function EDITBADWORD() {
		global $iconcpanel, $id, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_BADWORDS . ' :: ' . _MXC_EDIT ), 'user.png' );
			}
		}				
		mosMenuBar::startTable();	
		mosMenuBar::save('savebadword', _MXC_SAVE);
		mosMenuBar::spacer();
		if ( $id ) {
			// for existing items the button is renamed `close`
			mosMenuBar::cancel( 'cancelbadword', _MXC_CLOSE );
		} else {
			mosMenuBar::cancel( 'cancelbadword' );
		}
		mosMenuBar::endTable();
	}
	
	function EDITLANGUAGE() {
		global $iconcpanel, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_EDIT_LANGUAGE ), 'user.png' );
			}
		}				
		mosMenuBar::startTable();	
		mosMenuBar::custom( '', $iconcpanel, $iconcpanel, _MXC_CPANEL, false );
		mosMenuBar::spacer();
		mosMenuBar::save( 'savelanguage', _MXC_SAVE );
		mosMenuBar::endTable();
	}
	
	function EDITCSS() {
		global $iconcpanel, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_EDIT_CSS ), 'user.png' );
			}
		}				
		mosMenuBar::startTable();	
		mosMenuBar::custom( '', $iconcpanel, $iconcpanel, _MXC_CPANEL, false );
		mosMenuBar::spacer();
		mosMenuBar::save( 'savecss', _MXC_SAVE );
		mosMenuBar::endTable();
	}

	function ABOUT() {
		global $iconcpanel, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_CPL_ABOUT ), 'cpanel.png' );
				$btnback = 'back.png';
			}else $btnback = 'back_f2.png';
		}else $btnback = 'back_f2.png';	
		
		mosMenuBar::startTable();				
		mosMenuBar::custom('', $iconcpanel, $iconcpanel, _MXC_CPANEL, false);
		mosMenuBar::endTable();
	}	
	
	function SHOWBLOCKIP(){
		global $iconcpanel, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_BLOCKIPADDRESSES ), 'generic.png' );
			}
		}
		mosMenuBar::startTable();
		mosMenuBar::custom('', $iconcpanel, $iconcpanel, _MXC_CPANEL, false);
		mosMenuBar::spacer();
		mosMenuBar::publishList();
		mosMenuBar::spacer();
		mosMenuBar::unpublishList();
		mosMenuBar::spacer();
		mosMenuBar::editList('editblockip');
		mosMenuBar::spacer();
		mosMenuBar::deleteList( '', 'delblockip');
		mosMenuBar::spacer();
		mosMenuBar::addNew('editblockip', _MXC_NEW);
		mosMenuBar::endTable();	
	}
	
	function EDITBLOCKIP() {
		global $iconcpanel, $id, $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			if ( $_VERSION->RELEASE >= '1.5' ) {
				JToolBarHelper::title( JText::_( _MXC_BLOCKIPADDRESSES . ' :: ' . _MXC_EDIT ), 'user.png' );
			}
		}				
		mosMenuBar::startTable();	
		mosMenuBar::save('saveblockip', _MXC_SAVE);
		mosMenuBar::spacer();
		if ( $id ) {
			// for existing items the button is renamed `close`
			mosMenuBar::cancel( 'cancelblockip', _MXC_CLOSE );
		} else {
			mosMenuBar::cancel( 'cancelblockip' );
		}
		mosMenuBar::endTable();
	}

}
?>