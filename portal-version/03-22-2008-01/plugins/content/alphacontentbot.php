<?php
/*********************************************
* alphacontent - Mambo/Joomla! Component     *
* Copyright (C) 2005-2007 by Bernard Gilly   *
* Homepage   : www.visualclinic.fr           *
* Version    : 3.0                           *
* License    : DonationWare                  *
* 			 : All Rights Reserved           *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mainframe, $task, $view, $_MAMBOTS, $_VERSION, $ac_checkversion;

// Check for compatibility version
$ac_checkversion = "";
if ( $_VERSION->PRODUCT == 'Joomla!' ){	
	if ( $_VERSION->RELEASE >= '1.5' ) {
		$ac_checkversion = "Joomla!1.5.x";
	}
}

switch ( $ac_checkversion ) {
	case "Joomla!1.5.x":
		$mainframe->registerEvent( 'onPrepareContent', 'showAlphaTree150' );
		break;
	default:
		$_MAMBOTS->registerFunction( 'onPrepareContent', 'showAlphaTree100' );
}

function showAlphaTree100( $published , &$row, &$params, $page=0 ) {
	global $option, $database, $ac_checkversion, $_MAMBOTS;

	if ( $ac_checkversion!='' ){	
		$dir_plugin = 'plugins';
	} else $dir_plugin = 'mambots';
	
	// check if param query has previously been processed
	if ( !isset($_MAMBOTS->_search_mambot_params['alphacontent']) ) {
		// load mambot params info
		$query = "SELECT params"
		. "\n FROM #__$dir_plugin"
		. "\n WHERE element = 'alphacontentbot'"
		. "\n AND folder = 'content'"
		;
		$database->setQuery( $query );
		$database->loadObject($mambot);	
			
		// save query to class variable
		$_MAMBOTS->_content_mambot_params['alphacontent'] = $mambot;
	}
	
	// pull query data from class variable
	$mambot    = $_MAMBOTS->_content_mambot_params['alphacontent'];		
	$botParams = new mosParameters( $mambot->params );	
	$excludeID = $botParams->def( 'excludeID', '' );	
	$listexclude = @explode ( ",", $excludeID );	
	
	if ( $option=='com_alphacontent' || !isset( $row->title_alias ) || in_array ( $row->id, $listexclude ) ) return;
	
	displayAlphaTree( $row, $params, $page );
}

function showAlphaTree150( &$row, &$params, $page=0 ) {
	global $option, $database, $ac_checkversion, $_MAMBOTS;

	if ( $ac_checkversion!='' ){	
		$dir_plugin = 'plugins';
	} else $dir_plugin = 'mambots';
	
	// check if param query has previously been processed
	if ( !isset($_MAMBOTS->_search_mambot_params['alphacontent']) ) {
		// load mambot params info
		$query = "SELECT params"
		. "\n FROM #__$dir_plugin"
		. "\n WHERE element = 'alphacontentbot'"
		. "\n AND folder = 'content'"
		;
		$database->setQuery( $query );
		$database->loadObject($mambot);	
			
		// save query to class variable
		$_MAMBOTS->_content_mambot_params['alphacontent'] = $mambot;
	}
	
	// pull query data from class variable
	$mambot    = $_MAMBOTS->_content_mambot_params['alphacontent'];		
	$botParams = new mosParameters( $mambot->params );	
	$excludeID = $botParams->def( 'excludeID', '' );	
	$listexclude = @explode ( ",", $excludeID );
	
	if ( $option=='com_alphacontent' || !isset( $row->title_alias ) || in_array ( $row->id, $listexclude ) ) return;
	
	displayAlphaTree( $row, $params, $page );
}

function displayAlphaTree( &$row, &$params, $page=0 ) {
	global $database, $mainframe, $option, $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang, $mosConfig_sef, $ac_checkversion, $task, $view, $my, $Itemid;
	
	@session_start('alphacontent');	
		
	$ratingbarIsReady = 0;
	$mapIsDefined = 0;

	// Get the right language if it exists
	if (file_exists($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/".$mosConfig_lang.".php")){
		 include_once($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/".$mosConfig_lang.".php");
	}else{
		 include_once($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/english.php");
	}
	
	require( $mosConfig_absolute_path.'/administrator/components/com_alphacontent/alphacontent_config.php' );

	
	if ( $task=='view' || $view=='article' ) {	
		
		if ( !(class_exists( "ALPHACONTENT" ) ) ) {
			require( $mosConfig_absolute_path.'/components/com_alphacontent/alphacontent.class.php' );
		}
		
		// determine if AlphaContent is in frontpage	
		switch ( $ac_checkversion ) {		
			case "Joomla!1.5.x":
				$query = "SELECT * FROM #__menu WHERE `link`='index.php?option=com_alphacontent' AND `type`='component' AND `home`='1' AND `published`='1'";
				break;		
			default:
				$query = "SELECT * FROM #__menu WHERE `menutype`='mainmenu' AND `link`='index.php?option=com_alphacontent' AND `type`='component' AND `ordering`='1' AND `published`='1'";
		}
		$database->setQuery( $query );
		$rows = $database->loadObjectList();
		$isFrontPage = count($rows);
				
		//determine section and category if exists
		switch ( $option ) {
			case 'com_weblink':
			case 'com_content':
				$section = $row->sectionid;
				$cat     = $row->catid;
				break;
			default:
		}
		
		// Get instance if several Directories
		$query = "SELECT id FROM #__menu WHERE `link`='index.php?option=com_alphacontent' AND `published`='1'";
		$database->setQuery( $query );
		$rowsMnu = $database->loadObjectList();
		
		if ( $rowsMnu ) {

			foreach ( $rowsMnu as $rowMnu ) {
				$menu = new mosMenu( $database );
				$menu->load( $rowMnu->id );
				$paramsDirectory = new mosParameters( $menu->params );
				$paramsDirectory->def( 'pageclass_sfx', '' );
				$paramsDirectory->def( 'sefAliasNameComponent', '' );
				$paramsDirectory->def( 'page_title', 1 );
				$paramsDirectory->def( 'header', $menu->name );
				$paramsDirectory->def( 'back_button', $mainframe->getCfg( 'back_button' ));
				$paramsDirectory->def( 'content_type', $content_type );
				$paramsDirectory->def( 'include_archived', $include_archived );
				$paramsDirectory->def( 'sec_id', $select_section_ID );
				$paramsDirectory->def( 'cat_id', $select_category_ID );			
				$paramsDirectory->def( 'show_weblinks', $ac_insertweblink );
				
				$secid                 = $paramsDirectory->get( 'sec_id' );
				$catid                 = $paramsDirectory->get( 'cat_id' );
				$sefAliasNameComponent = $paramsDirectory->get( 'sefAliasNameComponent' );
				$directoryNameInstance = $paramsDirectory->get( 'header' );
				$_Itemid               = $rowMnu->id ;	
				
				if ( $paramsDirectory->get( 'cat_id' )!='' ) {
					$temp = explode(",", $paramsDirectory->get( 'cat_id' ) );
					if ( in_array( $cat, $temp ) ) {
						break;
					}
				}			
			}		
			
			// check if AlphaContent request
			if ( 
				strpos(@$_SERVER['HTTP_REFERER'], "com_alphacontent")                == true                    || 
				strpos(@$_SERVER['HTTP_REFERER'], "/".$sefAliasNameComponent."/")    == true && $mosConfig_sef  || 
				strpos(@$_SERVER['HTTP_REFERER'], "/".$sefAliasNameComponent.".html")== true && $mosConfig_sef  || 
				strpos(@$_SERVER['HTTP_REFERER'], "/".$sefAliasNameComponent.".htm") == true && $mosConfig_sef  || 
				strpos(@$_SERVER['HTTP_REFERER'], "/".$sefAliasNameComponent.".php") == true && $mosConfig_sef  || 
				@$_SERVER['HTTP_REFERER']==$mosConfig_live_site.'/'                          && $isFrontPage    || 
				strpos(@$_SERVER['HTTP_REFERER'], "com_frontpage")                   == true && $isFrontPage    ||
				isset($_SESSION['alphacontent_current_page']) && $_SESSION['alphacontent_current_article']==$row->id
				&& isset($_SESSION['alphacontent_init']) && $_SESSION['alphacontent_init']=='true'				||
				@$_SESSION['alphacontent_current_page']>=0 && @$_GET['limitstart']!=''	                        ||				
				@$_SERVER['HTTP_REFERER'] == @$_SESSION['alphacontent_current_url'] 
				) {
				
				$_SESSION['alphacontent_current_page'] = $page;
				$_SESSION['alphacontent_current_article'] = $row->id;
				$_SESSION['alphacontent_current_url'] = @$_SERVER['HTTP_REFERER'];
				
				if ( $showletters=='1' ){ 
					ALPHACONTENT::displaysearchletter( 'all', $section, $cat, $_Itemid );				
				}			
				ALPHACONTENT::displaycategorie( $section, $cat, $catid, 'all', $_Itemid, $paramsDirectory, 1 );
				// If user can submit in section
				if ( $ac_showsubmitlink && $my->gid >= $ac_gid_submit ) {
					$ac_submitlink = "index.php?option=com_content&amp;task=new&amp;sectionid=$section&amp;Itemid=$Itemid";	
					echo "<p><a href=\"" . sefRelToAbs( $ac_submitlink ) . "\">" . _ALPHACONTENT_LINK_SUBMIT_IN_SECTION . "</a></p>";
				} else echo "<br />";				
				
				// insert script for rating
				if ( $ac_show_ac_rating ){
					if ( ($ac_checkversion=='') || ($ac_checkversion=='Joomla!1.5.x' && $mosConfig_sef=='0') ) {
						echo "\n<script type=\"text/javascript\" language=\"javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/behavior.js\"></script>";
						echo "\n<script type=\"text/javascript\" language=\"javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/rating.js\"></script>";		
					}
					$mainframe->addCustomHeadTag( "<link rel=\"stylesheet\" type=\"text/css\" href=\"$mosConfig_live_site/components/com_alphacontent/css/rating.css\" />" );
					require( $mosConfig_absolute_path . "/components/com_alphacontent/alphacontent.drawrating.php" );
					$ratingbar = "";
					$component4rating = ( $section=='com_weblinks' ) ? 'com_weblinks' : $option ;
					$ratingbar = rating_bar( $row->id, $ac_num_stars, $component4rating, $ac_width_stars );	
					$row->text = $ratingbar . $row->text;
					$ratingbarIsReady = 1;
				}
				
				// insert Google Maps
				$googlemaps="";
				if ( $showmap ) {	
					$mapIsDefined = 0;								
					if ( preg_match('#{GMAP=(.*)}#Uis', $row->text, $m) ) {
						$row->text = preg_replace( " |{GMAP=(.*)}| ", "", $row->text );
						$mapIsDefined = 1;
					}
					if ( $mapIsDefined ) {
						$googlemaps = createLinkGoogleMap( $ac_googlemaps_width_map, $ac_googlemaps_height_map, $m, _ALPHACONTENT_MAP);
					}
					$row->text = $row->text . $googlemaps;
				}		
				
				// insert Related Items if settings
				if ( $ac_show_relateditems ) {
					$row->text = showRelatedItem( $row->id, $row->text, $ac_nb_relateditems, $ac_show_relateditems_archived, $ac_class_title_relateditems );
				}
				
			} else {
				unset($_SESSION['alphacontent_current_page']);		
				unset($_SESSION['alphacontent_current_article']);			
				unset($_SESSION['alphacontent_current_url']);							
			}
			
		}
		// Just using rating option only, without AlphaContent Component ( view full article or other component with task view )
		if ( $ratingbarIsReady=='0' && $params->get( 'rating' )=='1' && $ac_show_ac_rating || $ratingbarIsReady=='0' && $params->get( 'show_vote' )=='1' && $ac_show_ac_rating ) {
			// insert script for rating
			if ( ($ac_checkversion=='') || ($ac_checkversion=='Joomla!1.5.x' && $mosConfig_sef=='0') ) {
				echo "\n<script type=\"text/javascript\" language=\"javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/behavior.js\"></script>";
				echo "\n<script type=\"text/javascript\" language=\"javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/rating.js\"></script>";		
			}
			$mainframe->addCustomHeadTag( "<link rel=\"stylesheet\" type=\"text/css\" href=\"$mosConfig_live_site/components/com_alphacontent/css/rating.css\" />" );
			require( $mosConfig_absolute_path . "/components/com_alphacontent/alphacontent.drawrating.php" );
			$ratingbar = "";
			$ratingbar = rating_bar( $row->id, $ac_num_stars, $option, $ac_width_stars );
			$row->text = $ratingbar . $row->text;
			$ratingbarIsReady = 1;
		}
		
		// insert Google Maps
		$googlemaps="";
		if ( $showmap && !$mapIsDefined ) {	
			if ( preg_match('#{GMAP=(.*)}#Uis', $row->text, $m) ) {
				$row->text = preg_replace( " |{GMAP=(.*)}| ", "", $row->text );
				$mapIsDefined = 1;
			}
			if ( $mapIsDefined ) {
				$googlemaps = createLinkGoogleMap( $ac_googlemaps_width_map, $ac_googlemaps_height_map, $m, _ALPHACONTENT_MAP);
			}
			$row->text = $row->text . $googlemaps;
		}
		
	}
	
	// Just using rating option only, without AlphaContent Component ( intro, section blog etc... or other component which call mambot content )
	if ( $ratingbarIsReady=='0' && $params->get( 'rating' )=='1' && $ac_show_ac_rating || $ratingbarIsReady=='0' && $params->get( 'show_vote' )=='1' && $ac_show_ac_rating ) {
		// insert script for rating
		if ( ($ac_checkversion=='') || ($ac_checkversion=='Joomla!1.5.x' && $mosConfig_sef=='0') ) {
			echo "\n<script type=\"text/javascript\" language=\"javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/behavior.js\"></script>";
			echo "\n<script type=\"text/javascript\" language=\"javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/rating.js\"></script>";		
		}
		$mainframe->addCustomHeadTag( "<link rel=\"stylesheet\" type=\"text/css\" href=\"$mosConfig_live_site/components/com_alphacontent/css/rating.css\" />" );
		if ( !is_callable( "rating_bar" ) ) {
			require( $mosConfig_absolute_path . "/components/com_alphacontent/alphacontent.drawrating.php" );
		}
		$ratingbar = "";
		$ratingbar = rating_bar( $row->id, $ac_num_stars, $option, $ac_width_stars );
		$row->text = $ratingbar . $row->text;
	}
	
	// insert Google Maps
	$googlemaps="";
	if ( $showmap && !$mapIsDefined ) {	
		if ( preg_match('#{GMAP=(.*)}#Uis', $row->text, $m) ) {
			$row->text = preg_replace( " |{GMAP=(.*)}| ", "", $row->text );
			$mapIsDefined = 1;
		}		
		if ( $mapIsDefined ) {
			$googlemaps = createLinkGoogleMap( $ac_googlemaps_width_map, $ac_googlemaps_height_map, $m, _ALPHACONTENT_MAP);
		}
		$row->text = $row->text . $googlemaps;
	}
	
	unset($_SESSION['alphacontent_init']);
	unset($_SESSION['alphacontent_current_url']);
}

function showRelatedItem( $id, $text, $nb_related=10, $archived=0, $classTitle='contentheading' ) {
	global $mainframe, $database, $mosConfig_absolute_path, $mosConfig_offset, $_VERSION, $my, $Itemid;
	
	$relatedText = "<div class=\"" . $classTitle . "\">" . _ALPHACONTENT_RELATED_ITEMS . "</div>";
	
	// check version of product for compatibily Mambo/Joomla!
	if ( $_VERSION->PRODUCT == 'Joomla!' ){	
		$nullDate = $database->getNullDate();
		if ( $_VERSION->RELEASE >= '1.5' ) {
			$now = date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );
		} else $now = _CURRENT_SERVER_TIME;		
	} else {
		$nullDate = "0000-00-00 00:00:00";
		$now = date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );
	}
	// select the meta keywords from the item
	$query = "SELECT metakey"
	. "\n FROM #__content"
	. "\n WHERE id = " . (int) $id
	;
	$database->setQuery( $query );	
	
	if ( $metakey = trim( $database->loadResult() ) ) {
		// explode the meta keys on a comma
		$keys = explode( ',', $metakey );
		$likes = array();

		// assemble any non-blank word(s)
		foreach ($keys as $key) {
			$key = trim( $key );
			if ($key) {
				$likes[] = $database->getEscaped( $key );
			}
		}
		
		// state		
		$state = "\n AND a.state = '1'";			

		if ( $archived ){ 
			$state = "\n AND (a.state = '1' OR a.state = '-1')"; 
		}		

		if (count( $likes )) {
			// select other items based on the metakey field 'like' the keys found
			$query = "SELECT a.id, a.title, a.sectionid, a.catid, a.created, cc.access AS cat_access, s.access AS sec_access, cc.published AS cat_state, s.published AS sec_state"
			. "\n FROM #__content AS a"
			. "\n LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id"
			. "\n LEFT JOIN #__categories AS cc ON cc.id = a.catid"
			. "\n LEFT JOIN #__sections AS s ON s.id = a.sectionid"
			. "\n WHERE a.id != " . (int) $id
			. $state
			. "\n AND a.access <= " . (int) $my->gid
			. "\n AND ( a.metakey LIKE '%" . implode( "%' OR a.metakey LIKE '%", $likes ) ."%' )"
			. "\n AND ( a.publish_up = " . $database->Quote( $nullDate ) . " OR a.publish_up <= " . $database->Quote( $now ) . " )"
			. "\n AND ( a.publish_down = " . $database->Quote( $nullDate ) . " OR a.publish_down >= " . $database->Quote( $now ) . " )"
			. "\n ORDER BY a.created DESC"
			. "\n LIMIT $nb_related"
			;
			$database->setQuery( $query );
			$temp = $database->loadObjectList();
			
			$related = array();
			if (count($temp)) {
				foreach ($temp as $row ) {
					if (($row->cat_state == 1 || $row->cat_state == '') &&  ($row->sec_state == 1 || $row->sec_state == '') &&  ($row->cat_access <= $my->gid || $row->cat_access == '') &&  ($row->sec_access <= $my->gid || $row->sec_access == '')) {
						$related[] = $row;
					}
				}
			}			
			unset($temp);									
			
			if ( count( $related ) ) {		
				
				$relatedText .= "<br />";
				$relatedText .= "<ul>";
					
					foreach ($related as $item) {					
						if (is_callable( array( $mainframe, "getItemid" ) ) ) {
							$itemid = $mainframe->getItemid( $row->id );
						} elseif (is_callable( "JApplicationHelper::getItemid" ) ) {
							$itemid = JApplicationHelper::getItemid( $row->id );
						} else {
							$itemid = null;
						}
						$_Itemid = $itemid ? "&amp;Itemid=" . (int) $itemid : "";

						$href = sefRelToAbs( "index.php?option=com_content&amp;task=view&amp;id=$item->id$_Itemid" );
						
						$relatedText .= "<li>";
						$relatedText .= "<a href=\"$href\">";
						$relatedText .= stripslashes( $item->title ) . "</a>";
						$relatedText .= "</li>";						
					}
				$relatedText .= "</ul>";

				$text .= $relatedText;

			}		
		}				
	}
	return $text;	
}

function createLinkGoogleMap ( $ac_googlemaps_width_map, $ac_googlemaps_height_map, $m, $label) {

	$a = explode("|", $m[1]);
	if ( count($a)==3 ) {
		$thewidthmap  = $ac_googlemaps_width_map + 4;
		$theheightmap = $ac_googlemaps_height_map + 40;
		$status       = "status=no,toolbar=no,scrollbars=no,titlebar=no,menubar=no,resizable=no,width=".$thewidthmap.",height=".$theheightmap.",directories=no,location=no";
		$googlemaps   = "<a href=\"javascript:void window.open('index2.php?option=com_alphacontent&amp;task=viewmap&amp;la=".$a[0]."&amp;lo=".$a[1]."&amp;txt=".$a[2]."', 'win2', '$status');\">" . $label . "</a>";	
	} else $googlemaps = "";

	return $googlemaps;
}
?>