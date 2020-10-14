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

global $_VERSION, $_MAMBOTS;

// Check for compatibility version
$mxc_checkversion = "";
if ( $_VERSION->PRODUCT == 'Joomla!' ){	
	if ( $_VERSION->RELEASE >= '1.5' ) {
		$mxc_checkversion = "Joomla!1.5.x";
	}
}
switch ( $mxc_checkversion ) {
	case "Joomla!1.5.x":
		$mainframe->registerEvent( 'onSearch', 'botSearchmaXcomment' );
		break;
	default:
		$_MAMBOTS->registerFunction( 'onSearch', 'botSearchmaXcomment' );
}


/**
* Weblink Search method
*
* The sql must return the following fields that are used in a common display
* routine: href, title, section, created, text, browsernav
* @param string Target search string
* @param string mathcing option, exact|any|all
* @param string ordering option, newest|oldest|popular|alpha|category
*/
function botSearchmaXcomment( $text, $phrase='', $ordering='' ) {
	global $database, $mosConfig_absolute_path, $mosConfig_lang, $my, $_MAMBOTS, $_VERSION;

	// Get the right language if it exists
	if (file_exists($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php")){
		include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php");
	}else{
		include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/english.php");
	}
	
	// Check for compatibility version
	$mxc_checkversion = "";
	if ( $_VERSION->PRODUCT == 'Joomla!' ){	
		if ( $_VERSION->RELEASE >= '1.5' ) {
			$mxc_checkversion = "Joomla!1.5.x";
		}
	}

	if ( $mxc_checkversion!='' ){	
		$dir_plugin = 'plugins';
	} else $dir_plugin = 'mambots';

	// check if param query has previously been processed
	if ( !isset($_MAMBOTS->_search_mambot_params['maxcomment']) ) {
		// load mambot params info
		$query = "SELECT params"
		. "\n FROM #__$dir_plugin"
		. "\n WHERE element = 'maxcomment.searchbot'"
		. "\n AND folder = 'search'"
		;
		$database->setQuery( $query );
		$database->loadObject($mambot);	
			
		// save query to class variable
		$_MAMBOTS->_search_mambot_params['maxcomment'] = $mambot;
	}
	
	// pull query data from class variable
	$mambot = $_MAMBOTS->_search_mambot_params['maxcomment'];	
	
	$botParams = new mosParameters( $mambot->params );
	
	$limit = $botParams->def( 'search_limit', 50 );
	
	$text = trim( $text );
	if ($text == '') {
		return array();
	}
	$section 	= _MXC_COMMENTS;
	
	switch ( $ordering ) {
		case 'oldest':
			$order = 'a.date ASC';
			break;
			
		case 'alpha':
			$order = 'a.title ASC';
			break;

		case 'category':
		case 'newest':
		case 'popular':
		default:
			$order = 'a.date DESC';
	}

	$query = "SELECT a.title AS title,"
	. "\n a.comment AS text,"
	. "\n a.date AS created,"
	. "\n CONCAT( " . $database->Quote( $section ) . ", '' ) AS section,"
	. "\n '0' AS browsernav,"
	. "\n CONCAT( 'index.php?option=com_content&task=view&id=', a.contentid, '#comment', a.id ) AS href"
	. "\n FROM #__mxc_comments AS a"
	. "\n WHERE ( a.title LIKE '%$text%'"
	. "\n OR a.comment LIKE '%$text%' )"
	. "\n AND a.published = '1'"
	. "\n AND a.status = '0'"
	. "\n ORDER BY $order"
	;
	$database->setQuery( $query, 0, $limit );
	$rows = $database->loadObjectList();

	return $rows;
}
?>