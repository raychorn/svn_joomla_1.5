<?php
/*********************************************
* alphacontent - Mambo/Joomla! Component     *
* Copyright (C) 2005-2008 by Bernard Gilly   *
* Homepage   : www.visualclinic.fr           *
* Version    : 3.0                           *
* License    : DonationWare                  *
* 			 : All Rights Reserved           *
*********************************************/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// load the html drawing class
require_once( $mainframe->getPath( 'front_html' ) );
require( $mosConfig_absolute_path.'/administrator/components/com_alphacontent/version.php' );

// Get the right language if it exists
if (file_exists($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/".$mosConfig_lang.".php")){
     include_once($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/".$mosConfig_lang.".php");
}else{
     include_once($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/english.php");
}
require( $mosConfig_absolute_path.'/administrator/components/com_alphacontent/alphacontent_config.php' );
require( $mosConfig_absolute_path.'/components/com_alphacontent/alphacontent.class.php' );
require( $mosConfig_absolute_path.'/components/com_alphacontent/includes/alphacontent.functions.php' );

$alpha = mosGetParam( $_REQUEST, 'alpha', 'all' );
$section = mosGetParam( $_REQUEST, 'section', 'all' );
$cat = mosGetParam( $_REQUEST, 'cat', 'all' );

switch ( $task ) {
	case "viewmap":
		viewmap ( $option );
		break;	
	default:		
		viewSearchAlpha( $option, $alpha, $section, $cat );
}

function viewSearchAlpha( $option, $alpha, $section, $cat ) {
	global $mainframe, $mosConfig_absolute_path, $mosConfig_lang;
	global $Itemid, $database, $my, $mosConfig_offset;
	global $mosConfig_list_limit, $_VERSION;
	global $alphaREGEXP, $alphaREGEXPintro;
	
	require( $mosConfig_absolute_path.'/administrator/components/com_alphacontent/alphacontent_config.php' );
	
	@session_start('alphacontent');
	$_SESSION['alphacontent_init'] = "true";
	unset($_SESSION['alphacontent_current_page']);
	unset($_SESSION['alphacontent_current_article']);
	unset($_SESSION['alphacontent_current_url']);
	
	// check version of product for compatibily Mambo/Joomla!
	if ( $_VERSION->PRODUCT == 'Joomla!' ){	
		$nullDate = $database->getNullDate();
		if ( $_VERSION->RELEASE >= '1.5' ) {
			$now = date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );
			$checkVersionJ = 1;
		} else {
			$now = _CURRENT_SERVER_TIME;
			$checkVersionJ = 0;
		}
	} else {
		$nullDate = "0000-00-00 00:00:00";
		$now = date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );
		$checkVersionJ = 0;
	}

	// Parameters
	$menu = new mosMenu( $database );
	$menu->load( $Itemid );
	$params = new mosParameters( $menu->params );
	$params->def( 'pageclass_sfx', '' );
	$params->def( 'page_title', 1 );
	$params->def( 'header', $menu->name );
	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ));
	$params->def( 'content_type', $content_type );
	$params->def( 'include_archived', $include_archived );
	$params->def( 'sec_id', $select_section_ID );
	$params->def( 'cat_id', $select_category_ID );
	$params->def( 'show_weblinks', $ac_insertweblink );
		
	$content_typecontent = $params->get( 'content_type' );
	$include_archived = $params->get( 'include_archived' );

	// get section and category selected
	$secid = $params->get( 'sec_id' );
	$catid = $params->get( 'cat_id' );
	
	// add static items if need
	if ($secid!='' && $content_typecontent=='2' ){
		$secid = "0," . $secid; 
	}
	if ($catid!='' && $content_typecontent=='2' ){
		$catid = "0," . $catid; 
	}
		
	$title_static          = stripslashes(_ALPHACONTENT_NO_CATEGORISED);
	$title_frontpage       = stripslashes(_ALPHACONTENT_DIRECTORY);
	$sortitemrundefault    = (( $defaultsortoptionrun !='' ) ? $defaultsortoptionrun : '5' );	
	$ac_default_list_limit = intval($ac_default_list_limit);
	$ac_displayItemMode    = (( $ac_displayItemMode !='' ) ? $ac_displayItemMode : '0' );	
	$limit                 = intval(mosGetParam( $_REQUEST, 'limit', $ac_default_list_limit ) );
	$limitstart            = intval(mosGetParam( $_REQUEST, 'limitstart', 0 ) );
	$sortitems             = trim( mosGetParam( $_REQUEST, 'sort', $sortitemrundefault ) );
	
	switch( $sortitems ){
		case '1':
			$sort = 'a.title ASC';
			if ( $ac_title_used == 'title_alias' ) {
				$sort = 'a.title_alias ASC';
			}
			break;
		case '2':
			$sort = 'a.title DESC';
			if ( $ac_title_used == 'title_alias' ) {
				$sort = 'a.title_alias DESC';
			}
			break;
		case '3':
			$sort = 'a.introtext ASC';
			break;
		case '4':
			$sort = 'a.introtext DESC';
			break;	
		case '5':
			$sort = 'a.created DESC';
			break;
		case '6':
			$sort = 'a.created ASC';	
			break;
		case '7':
			$sort = 'a.modified DESC';		
			break;
		case '8':
			$sort = 'a.modified ASC';
			break;
		case '9':
			$sort = 'a.hits DESC';
			break;
		case '10':
			$sort = 'a.hits ASC';	
			break;
		case '11':
			$sort = 'rating DESC';
			break;
		case '12':
			$sort = 'rating ASC';	
			break;
		case '13':
			$sort = 'CONCAT( a.created_by_alias, s.name) ASC';	
			break;
		case '14':
			$sort = 'CONCAT( a.created_by_alias, s.name) DESC';	
			break;
		case '15':
			$sort = 'a.catid ASC, a.ordering ASC';
			break;
		default:
			$sort = 'a.created DESC';
			break;
	}
	
	// Sections & Categories
	if( $section=='all' && $cat=='all' ){
		$where = "WHERE a.sectionid >= '0'";
		if ( $content_typecontent == '1' ) {$where = "WHERE a.sectionid = '0'";}
	}elseif( $section!='all' && $section!='com_weblinks' && $cat=='all' ){
		$where = "WHERE a.sectionid = '".$section."'";
	}elseif( $section!='all' && $section!='com_weblinks' && $cat!='all' ){
		$where = "WHERE a.sectionid = '".$section."' AND a.catid = '".$cat."'";
	}elseif( $section=='com_weblinks' && $cat=='all' ) {
		$where = "WHERE a.published='1'";
	}elseif( $section=='com_weblinks' && $cat!='all' ) {
		$where = "WHERE a.published='1' AND a.catid='".$cat."'";
	}
	
	$order = $sort;	
	
	// Filter index A - Z	
	$alphaREGEXP = "";
	$alphaREGEXPintro = "";	
	if( $alpha!='all' && $section!='com_weblinks' ){	
		
		acCreateRegxExp( $alpha );

		switch ( $content_zone ) {		
			case "0": //title
				if ( $ac_title_used == 'title' ) {
					if ( $stylealpha=='3b' || $stylealpha=='7' || $checkVersionJ ) {
						$where .= " AND a.title LIKE '".$alpha."%'";
					} else {
						$where .= " AND a.title " . $alphaREGEXP;
					}
					$order = $sort.", a.title ASC";
				} elseif ( $ac_title_used == 'title_alias' ) {					
					if ( $stylealpha=='3b' || $stylealpha=='7' || $checkVersionJ ) {
						$where .= " AND a.title_alias LIKE '".$alpha."%'";
					} else {
						 $where .= " AND a.title_alias " . $alphaREGEXP;	
					}
					$order = $sort.", a.title_alias ASC";
				}
				break;
			case "1": //introtext			
				if ( $stylealpha=='3b' || $stylealpha=='7' || $checkVersionJ ) {
					$where .= " AND a.introtext LIKE '".$alpha."%'";
				} else {
					 $where .= " AND a.introtext " . $alphaREGEXPintro;
				}
				$order = $sort . ", a.introtext ASC";
				break;
		}		
				
	} elseif ( $alpha!='all' && $section=='com_weblinks' ){		
		if ( $stylealpha=='3b' || $stylealpha=='7' || $checkVersionJ ) {
			$where .= " AND a.title LIKE '".$alpha."%'";
		} else $where .= " AND a.title REGEXP '^([".$alpha."]| [".$alpha."])'";
	}
	// End filter index A - Z		
	
	// Filter / Search
	$searchfilter = trim( mosGetParam( $_REQUEST, 'searchfilter', '' ) );
	$searchfilter = $database->getEscaped( trim( $searchfilter ) );	
	$searchfieldfilter = mosGetParam( $_POST, 'searchlistfield', '' );
	if ( $searchfilter!='' ) $limit = 1000;
	if ( $searchfilter!='' && $section!='com_weblinks' ){
		if ( $searchfieldfilter!='' ) {
			$where .= " AND (" . $searchfieldfilter . " LIKE '%" . $searchfilter . "%') ";	
		} else {
			$where .= " AND (a.".$ac_title_used." LIKE '%".$searchfilter."%' OR a.introtext LIKE '%".$searchfilter."%' OR a.fulltext LIKE '%".$searchfilter."%') ";		
		}		
	} elseif ( $searchfilter!='' && $section!='com_weblinks' ){
		$where .= " AND (a.".$ac_title_used." LIKE '%".$searchfilter."%') ";
	} elseif ( $searchfilter!='' && $section=='com_weblinks' ){
		$where .= " AND (a.title LIKE '%".$searchfilter."%') ";
	}	
	
	// state		
	$state = " AND a.state = '1' ";	
	if ( $include_archived=='1' ){ 
		$state = " AND (a.state = '1' OR a.state = '-1') "; 
	}	
		
	if ( $section!='com_weblinks' ) {
		// content type
		if ( $content_typecontent=='0' ){
			if ( $secid == '' && $catid =='' ){
				$wheresection = " AND a.sectionid > '0'";			 
			}elseif( $secid != '' && $catid =='' ){
				$wheresection = " AND a.sectionid IN (".$secid.")";		
			}elseif( $secid == '' && $catid !='' ){
				$wheresection = " AND a.sectionid > '0' AND a.catid IN (".$catid.")";		
			}elseif( $secid != '' && $catid !='' ){
				$wheresection = " AND a.sectionid IN (".$secid.") AND a.catid IN (".$catid.")";		
			}
		}elseif ( $content_typecontent=='2' ){
			if ( $secid == '' && $catid =='' ){
				$wheresection = " AND a.sectionid >= '0'";			 
			}elseif( $secid != '' && $catid =='' ){
				$wheresection = " AND a.sectionid IN (".$secid.")";		
			}elseif( $secid == '' && $catid !='' ){
				$wheresection = " AND a.sectionid >= '0' AND a.catid IN (".$catid.")";
			}elseif( $secid != '' && $catid !='' ){
				$wheresection = " AND a.sectionid IN (".$secid.") AND a.catid IN (".$catid.")";
			}
		}	
		
		// select between Content Items, Static Content or both
		switch ( $content_typecontent ) {	
			case "0":  
				$query = "SELECT a.title AS title, a.title_alias AS title_alias, "
				. "\n a.created AS created,"
				//. "\n CONCAT(a.introtext, a.fulltext) AS text,"
				. "\n a.introtext AS text,"
				. "\n CONCAT_WS( '/', u.title, b.title ) AS section,"
				. "\n CONCAT( 'index.php?option=com_alphacontent&task=view&id=', a.id ) AS href,"
				. "\n '2' AS browsernav"
				. "\n FROM #__content AS a"
				. "\n INNER JOIN #__categories AS b ON b.id=a.catid AND b.access <= '$my->gid'"
				. "\n LEFT JOIN #__sections AS u ON u.id = a.sectionid"
				. "\n $where"
				. "\n $wheresection"
				. "\n $state"
				. "\n AND a.access <= '$my->gid'"
				. "\n AND u.published = '1'"
				. "\n AND b.published = '1'"
				. "\n AND ( publish_up = '$nullDate' OR publish_up <= '$now' )"
				. "\n AND ( publish_down = '$nullDate' OR publish_down >= '$now' )";
				$database->setQuery( $query );
				$list = $database->loadObjectList();								
				break;	
	
			case "1": 
				$query = "SELECT a.title AS title, a.title_alias AS title_alias,"
				. "\n a.created AS created,"
				//. "\n CONCAT(a.introtext, a.fulltext) AS text,"
				. "\n a.introtext AS text,"
				. "\n '"._ALPHACONTENT_NOCATEGORY."' AS section,"
				. "\n CONCAT( 'index.php?option=com_alphacontent&task=view&id=', a.id ) AS href,"
				. "\n '2' AS browsernav"
				. "\n FROM #__content AS a"
				. "\n $where"
				. "\n AND a.sectionid = '0'"
				. "\n $state"
				. "\n AND a.access <= '$my->gid'"
				. "\n AND ( publish_up = '$nullDate' OR publish_up <= '$now' )"
				. "\n AND ( publish_down = '$nullDate' OR publish_down >= '$now' )";
				$database->setQuery( $query );
				$list = $database->loadObjectList();
				break;
		
			case "2": 
				$query = "SELECT a.title AS title, a.title_alias AS title_alias,"
				. "\n a.created AS created,"
				//. "\n CONCAT(a.introtext, a.fulltext) AS text,"
				. "\n a.introtext AS text,"
				. "\n CONCAT( 'index.php?option=com_alphacontent&task=view&id=', a.id ) AS href,"
				. "\n '2' AS browsernav,"
				. "\n a.state AS state"
				. "\n FROM #__content AS a"
				. "\n $where"
				. "\n $wheresection"
				. "\n $state"
				. "\n AND a.access <= '$my->gid'"
				. "\n AND ( publish_up = '$nullDate' OR publish_up <= '$now' )"
				. "\n AND ( publish_down = '$nullDate' OR publish_down >= '$now' )"
				;
				$database->setQuery( $query );
				$list = $database->loadObjectList();	
				break;	
		}
	} else {
		// com_weblinks = new section
		$query = "SELECT a.title AS title,"
		. "\n a.date AS created,"
		. "\n a.description AS text,"
		. "\n a.url AS href"
		. "\n FROM #__weblinks AS a"
		. "\n $where"
		. "\n AND a.approved = '1'"
		;
		$database->setQuery( $query );
		$list = $database->loadObjectList();	
	}
	
	// Build Search List fields	
	$searchfields[] = mosHTML::makeOption( 'a.title', _ALPHACONTENT_SEARCH_TITLE_ONLY );
	$searchfields[] = mosHTML::makeOption( 'a.introtext', _ALPHACONTENT_SEARCH_CONTENT_ONLY );
	$searchfields[] = mosHTML::makeOption( '', _ALPHACONTENT_SEARCH_TITLE_AND_CONTENT );
	$searchlistfields = mosHTML::selectList( $searchfields, 'searchlistfield', 'class="inputbox" size="1"', 'value', 'text', $searchfieldfilter );
	
	// html output
	$total = count( $list );
	if ( $total >= 0 && $section!='com_weblinks' ) {
	
		$linkHref = "option=com_content&amp;task=view&amp;id=";
	
		require_once( $mosConfig_absolute_path . '/includes/pageNavigation.php' );
		$pageNav = new mosPageNav( $total, $limitstart, $limit );		
		$href = "";
		switch( $ac_displayItemMode ){		
			case '1':  // Popup
				$href = "\n CONCAT( 'index2.php?$linkHref', a.id, '&amp;pop=1' ) AS href,";
			break;	
			case '2':  // Lightbox
				$href = "\n CONCAT( 'index2.php?$linkHref', a.id ) AS href,";
			break;	
			case '0':  // Normal
			default:   
				$href = "\n CONCAT( 'index.php?$linkHref', a.id ) AS href,";
			break;	
		}				

		$sqlRating  = ( $ac_show_ac_rating ) ? "\n ROUND(ar.total_value/ar.total_votes) AS rating, ar.total_votes AS rating_count," : "\n ROUND(v.rating_sum/v.rating_count) AS rating, v.rating_count,";
		$sqlRating2 = ( $ac_show_ac_rating ) ? "\n LEFT JOIN #__alphacontent_rating AS ar ON a.id = ar.id AND ar.component='com_content'" : "\n LEFT JOIN #__content_rating AS v ON a.id = v.content_id";
		// select between Content Items, Static Content or both
		switch ( $content_typecontent ) {
					
			case "0":  
				$query = "SELECT a.id AS id, a.title AS title, a.title_alias AS title_alias,"
				. "\n a.created AS created, a.created_by_alias,"
				//. "\n CONCAT(a.introtext, a.fulltext) AS text,"
				. "\n a.introtext AS text,"
				. "\n a.fulltext AS fulltextmore,"
				. "\n CONCAT_WS( '/', u.title, b.title ) AS section,"
				. $href 
				. "\n '2' AS browsernav,"
				. "\n a.images AS images,"
				. "\n a.state AS state,"
				. "\n a.hits AS hits,"
				. "\n a.attribs AS attribs,"
				. "\n a.created_by AS created_by,"
				. $sqlRating
				. "\n s.name AS author"
				. "\n FROM #__content AS a"
				. "\n INNER JOIN #__categories AS b ON b.id=a.catid AND b.access <= '$my->gid'"
				. "\n LEFT JOIN #__sections AS u ON u.id = a.sectionid"
				. $sqlRating2
				. "\n LEFT JOIN #__users AS s ON s.id = a.created_by"
				. "\n $where"
				. "\n $wheresection"
				. "\n $state"
				. "\n AND a.access <= '$my->gid'"
				. "\n AND u.published = '1'"
				. "\n AND b.published = '1'"
				. "\n AND ( publish_up = '$nullDate' OR publish_up <= '$now' )"
				. "\n AND ( publish_down = '$nullDate' OR publish_down >= '$now' )"
				. "\n ORDER BY $order"
				. "\n LIMIT $pageNav->limitstart, $pageNav->limit";
			
				$database->setQuery( $query );
				$rows = $database->loadObjectList();
				break;	
				
			case "2": 
				$query = "SELECT a.id AS id, a.title AS title, a.title_alias AS title_alias,"
				. "\n a.created AS created, a.created_by_alias,"
				//. "\n CONCAT(a.introtext, a.fulltext) AS text,"
				. "\n a.introtext AS text,"
				. "\n a.fulltext AS fulltextmore,"
				. $href 
				. "\n '2' AS browsernav,"
				. "\n a.images AS images,"
				. "\n a.state AS state,"
				. "\n a.sectionid AS section,"
				. "\n a.catid AS category,"
				. "\n a.hits AS hits,"
				. "\n a.attribs AS attribs,"
				. "\n a.created_by AS created_by,"
				. $sqlRating
				. "\n s.name AS author"
				. "\n FROM #__content AS a"
				. $sqlRating2
				. "\n LEFT JOIN #__users AS s ON s.id = a.created_by"
				. "\n $where"
				. "\n $wheresection"
				. "\n $state"
				. "\n AND a.access <= '$my->gid'"
				. "\n AND ( publish_up = '$nullDate' OR publish_up <= '$now' )"
				. "\n AND ( publish_down = '$nullDate' OR publish_down >= '$now' )"
				. "\n ORDER BY $order"
				. "\n LIMIT $pageNav->limitstart, $pageNav->limit";
	
				$database->setQuery( $query );
				$rows = $database->loadObjectList();	
				break;	

			case "1": 
				$query = "SELECT a.id AS id, a.title AS title, a.title_alias AS title_alias,"
				. "\n a.created AS created, a.created_by_alias,"
				//. "\n CONCAT(a.introtext, a.fulltext) AS text,"
				. "\n a.introtext AS text,"
				. "\n a.fulltext AS fulltextmore,"
				. "\n '"._ALPHACONTENT_NOCATEGORY."' AS section,"
				. $href 
				. "\n '2' AS browsernav,"
				. "\n a.images AS images,"
				. "\n a.state AS state,"
				. "\n a.hits AS hits,"
				. "\n a.attribs AS attribs,"
				. "\n a.created_by AS created_by,"
				. $sqlRating
				. "\n s.name AS author"
				. "\n FROM #__content AS a"
				. $sqlRating2
				. "\n LEFT JOIN #__users AS s ON s.id = a.created_by"
				. "\n $where"
				. "\n AND a.sectionid = '0'"
				. "\n $state"
				. "\n AND a.access <= '$my->gid'"
				. "\n AND ( publish_up = '$nullDate' OR publish_up <= '$now' )"
				. "\n AND ( publish_down = '$nullDate' OR publish_down >= '$now' )"
				. "\n ORDER BY $order"
				. "\n LIMIT $pageNav->limitstart, $pageNav->limit";
			
				$database->setQuery( $query );
				$rows = $database->loadObjectList();	
				break;		
		}		
		$searchfilter = "";		
		HTML_ALPHA_FRONTEND::display( $rows, $pageNav, $limitstart, $limit, $total, $alpha, $content_typecontent, $section, $cat, $sortitems, $params, $searchlistfields, $searchfilter );		
		
	} elseif ( $total >= 0 && $section=='com_weblinks' ) {
		$params->set( 'content_type', '2' );
		// html output
		$linkHref = "";
	
		require_once( $mosConfig_absolute_path . '/includes/pageNavigation.php' );
		$pageNav = new mosPageNav( $total, $limitstart, $limit );		
		$href = "";
		
		$sqlRating  = ( $ac_show_ac_rating ) ? "\n ROUND(ar.total_value/ar.total_votes) AS rating, ar.total_votes AS rating_count," : "\n '0' AS rating, '0' AS rating_count,";
		$sqlRating2 = ( $ac_show_ac_rating ) ? "\n LEFT JOIN #__alphacontent_rating AS ar ON a.id = ar.id AND ar.component='com_weblinks'" : "";
		
		$order = ( $order=='a.created DESC' ) ? "a.title ASC" : $order ;
		
		// com_weblinks = new section 
		$query = "SELECT a.id AS id, a.title AS title,"
		. "\n a.date AS created,"
		. "\n a.description AS text,"
		. "\n a.url AS href,"
		. "\n '2' AS browsernav,"
		. "\n '' AS images,"
		. "\n '1' AS state,"
		. "\n 'com_weblinks' AS section,"
		. "\n a.catid AS category,"
		. "\n a.hits AS hits,"
		. "\n '' AS attribs,"
		. $sqlRating
		. "\n '' AS author, '' AS created_by_alias, '' AS fulltextmore"
		. "\n FROM #__weblinks AS a"
		. $sqlRating2
		. "\n $where"
		. "\n AND a.approved = '1'"
		. "\n ORDER BY $order"
		. "\n LIMIT $pageNav->limitstart, $pageNav->limit";
		;
		$database->setQuery( $query );
		$rows = $database->loadObjectList();	
		$searchfilter = "";
		
		HTML_ALPHA_FRONTEND::display( $rows, $pageNav, $limitstart, $limit, $total, $alpha, $content_typecontent, $section, $cat, $sortitems, $params, $searchlistfields, $searchfilter );		
	}
}

function viewmap( $option ) {
	global $mosConfig_absolute_path;

	require( $mosConfig_absolute_path.'/administrator/components/com_alphacontent/alphacontent_config.php' );
	
	$latitude   = trim( mosGetParam( $_GET, 'la', '' ) );
	$longitude  = trim( mosGetParam( $_GET, 'lo', '' ) );
	$marker_lat = $latitude;
	$marker_lon = $longitude;
	$messag     = trim( mosGetParam( $_GET, 'txt', '' ) );
	
?>
<script src="http://maps.google.com/maps?file=api&amp;v=2.x<?php if( $ac_googlemaps_api_key != "" ) {  echo  '&amp;key=' . $ac_googlemaps_api_key;} ?>" type="text/javascript"></script>
<script type="text/javascript"> 

var map;
var marker = null;

function initialize() {
  if (GBrowserIsCompatible()) {
     map = new GMap2(document.getElementById("map_canvas"));
     map.setCenter(new GLatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>), <?php echo $ac_googlemaps_zoom_level; ?>);     
     map.setMapType(G_NORMAL_MAP);	
     marker = new GMarker(new GLatLng(<?php echo $marker_lat; ?>, <?php echo $marker_lon; ?>));
     GEvent.addListener(marker,  "mouseover",  addMessag);
     map.addOverlay( marker );

	 var mapTypeControl = new GMapTypeControl();

     var topRight = new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(5,5));
	
	 if( (<?php echo $ac_googlemaps_type_menu; ?>)!=0) {
	    map.addControl(mapTypeControl, topRight);
	 }
	 if( (<?php echo $ac_googlemaps_controls_menu; ?>)!=0 ) {	
		 map.addControl(new GSmallMapControl());
	 }
  }
}
  
function addMessag() {
  marker.openInfoWindowHtml("<?php echo $messag; ?>");
}

</script> 
<iframe src="components/com_alphacontent/alphacontent.google_map.php?google_map_key=<?php echo $ac_googlemaps_api_key; ?>&
	latitude=<?php echo $latitude; ?>&
	longitude=<?php echo $longitude; ?>&
	zoom=<?php echo $ac_googlemaps_zoom_level; ?>&
	marker_lat=<?php echo $marker_lat; ?>&
	marker_lon=<?php echo $marker_lon; ?>&
	menu_map=<?php echo $ac_googlemaps_type_menu; ?>&
	control_map=<?php echo $ac_googlemaps_controls_menu; ?>&
	messag=<?php echo $messag; ?>&
	map_width=<?php echo $ac_googlemaps_width_map; ?>&
	map_height=<?php echo $ac_googlemaps_height_map; ?>"
	
	scrolling="no" style="width: <?php echo $ac_googlemaps_width_map; ?>px; height: <?php echo $ac_googlemaps_height_map; ?>px;" border="0px" marginwidth="0px" marginheight="0px">
</iframe>
<?php
eval(stripslashes(base64_decode("CWVjaG8gXCI8ZGl2IGFsaWduPVxcY2VudGVyXFw+XCI7DQoJX2dldEFDQ29weXJpZ2h0Tm90aWNlKCk7DQoJZWNobyBcIjwvZGl2PlwiOw0K")));
}
// correct view for Litbox Mode
$dModeLitBox = (( $ac_displayItemMode == '2' ) ? "<br /><br />" : "" );
?>