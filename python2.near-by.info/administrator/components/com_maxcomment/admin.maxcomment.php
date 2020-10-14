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

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
		| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_maxcomment' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );	
}

require_once( $mainframe->getPath( 'admin_html' ) );

// Get the right language if it exists
if (file_exists($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php")){
	include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php");
}else{
	include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/english.php");
}

require( $mosConfig_absolute_path."/administrator/components/com_maxcomment/class.maxcomment.php");
require( $mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php' );
require( $mosConfig_absolute_path.'/administrator/components/com_maxcomment/version.php' );
require( $mosConfig_absolute_path.'/components/com_maxcomment/includes/common/newevaluaterating.php' );

$cid = mosGetParam( $_REQUEST, 'cid', array(0) );
$typecomment = mosGetParam( $_POST, 'typecomment' );
$usertable = mosGetParam( $_POST, 'usertable' );
$idcontent = mosGetParam( $_REQUEST, 'idcontent', '' );

$file = mosGetParam( $_POST, 'file' );

switch ( $task ) {

	// CONFIGURATION
	case "config":		
		showConfig( $option ) ;
		break;

	case "savesettings":
		$mxc_sectionlist   = implode(',', $mxcselections);
		savesettings( $option );
		break;
		
	case "cancelsettings":
		mosRedirect( "index2.php?option=$option&task=config" );
		break;
		
	// IMPORT EXISTING DATA OF AKOCOMMENT TWEAKED SPECIAL EDITION
	case "import":
		import( $option );
		break;	
		
	// COMMON PUBLISH		
	case 'publish':
		publishComments( $cid, 1, $option, $typecomment, $usertable );
		break;

	case 'unpublish':
		publishComments( $cid, 0, $option, $typecomment, $usertable );
		break;				
		
	// USER'S COMMENTS	
	case "usercomments":
		showComments( $option );
		break;		
		
	case "editcomment":
		editComment( $option, $cid[0] );
		break;

	case "savecomment":
		saveComment( $option, $cid[0] );
		break;			
		
	case "delcomment":
		delComment( $option, $cid );
		break;	

	case "cancelcomment":
		mosRedirect( "index2.php?option=$option&task=usercomments" );
		break;			
	
	case 'unSpam':
		markSpam( $cid, 0, $option );
		break;

	case 'markSpam':
		markSpam( $cid, 1, $option );
		break;				
		
	case 'removeallspam':
		removeallspam( $option );
		break;				
		
	case 'notpam':
		notpam( $option, $cid );
		break;
				
	// EDITOR'S COMMENTS			
	case "admcomments":
		showAdmComments( $option );
		break;		
		
	case "editadmcomment":
		editAdmComment( $option, $cid[0] );
		break;
		
	case "saveadmcomment":
		saveAdmComment( $option, $cid[0] );
		break;	
		
	case "deladmcomment":
		delAdmcomment( $option, $cid );
		break;		
	
	case "canceladmcomment":
		mosRedirect( "index2.php?option=$option&task=admcomments" );
		break;			
		
	// FAVOURED
	case "favoured":
		showFavoured( $option );
		break;
		
	case "resetfavouredcount":
		resetfavouredcount( $option );
		break;
	
	// BADWORDS
	case "badwords":
		showBadwords( $option );
		break;		
		
	case "editbadword":
		editBadword( $option, $cid[0] );
		break;
		
	case "savebadword":
		saveBadword( $option, $cid[0] );
		break;	
		
	case "delbadword":
		delBadword( $option, $cid );
		break;		
	
	case "cancelbadword":
		mosRedirect( "index2.php?option=$option&task=badwords" );
		break;			
	
	// EDIT CSS
	case "editcss":
		editCSS( $option );
		break;			
	
	case "savecss":
		saveCSS( $option, $file );
		break;			
	
	// LANGUAGE			
	case "editlanguage":
		editlanguage( $option );
		break;			
	
	case "savelanguage":
		savelanguage( $option, $file );
		break;
	
	// SUPPORT WEBSITE	
    case "supportwebsite":
		mosRedirect("http://www.visualclinic.fr/forum/" );
		break;

	// ABOUT	
	case "about":
		HTML_MXC::about( $option, _MAXCOMMENT_NUM_VERSION );
		break;	
		
	// BLOCK IP ADDRESSES
	case "blockip":
		showBlockIp( $option );
		break;		
		
	case "editblockip":
		editBlockIp( $option, $cid[0] );
		break;
		
	case "saveblockip":
		saveBlockIp( $option, $cid[0] );
		break;	
		
	case "delblockip":
		delBlockIp( $option, $cid );
		break;		
	
	case "cancelblockip":
		mosRedirect( "index2.php?option=$option&task=blockip" );
		break;			

	// DEFAULT			
	case "controlpanel":	
	default:
		showControlPanel( $option );
}


function import( $option ) {
	global $database, $mosConfig_absolute_path;
	
	require( $mosConfig_absolute_path . '/components/com_maxcomment/includes/common/languages.php' );

	$succes = 0;
	
	$defaultlang = findFirstLanguageConfig ();
	
	// check and upgrade AkoComment table
	$AKOupgrades[0]['test'] = "SELECT `rating` FROM #__akocomment";
	$AKOupgrades[0]['updates'][0] = "ALTER TABLE #__akocomment ADD `rating` TINYINT( 2 ) DEFAULT '0' NOT NULL AFTER `subscribe`";
	$AKOupgrades[0]['updates'][1] = "ALTER TABLE #__akocomment ADD `currentlevelrating` TINYINT( 2 ) DEFAULT '0' NOT NULL AFTER `rating`";
	$AKOupgrades[0]['updates'][2] = "ALTER TABLE #__akocomment ADD `lang` VARCHAR( 10 ) DEFAULT '$defaultlang' NOT NULL AFTER `currentlevelrating`";
	$AKOupgrades[0]['updates'][3] = "ALTER TABLE #__akocomment ADD `component` VARCHAR( 50 ) DEFAULT 'com_content' NOT NULL AFTER `lang`";
	
	foreach ($AKOupgrades as $AKOupgrade) {
		$database->setQuery($AKOupgrade['test']);
		if (!$database->query()) {		
			foreach($AKOupgrade['updates'] as $AKOScript){
				$database->setQuery($AKOScript);
				if(!$database->query()) {
					mosRedirect("index2.php?option=$option&task=controlpanel", _MXC_MSG_IMPORT_ERROR );
				}else{
					$succes = 1;
				}	
			}		
			if ( $succes ) {
				// import data
				$query = "INSERT INTO #__mxc_comments SELECT * FROM #__akocomment";
				$database->setQuery( $query );
				$database->query();				
				if ($database->getErrorNum()) {
					mosRedirect("index2.php?option=$option&task=controlpanel", _MXC_MSG_IMPORT_ERROR );
				}				
				$query2 = "INSERT INTO #__mxc_favoured SELECT * FROM #__akocomment_favoured";
				$database->setQuery( $query2 );
				$database->query();				
				if ($database->getErrorNum()) {
					mosRedirect("index2.php?option=$option&task=controlpanel", _MXC_MSG_IMPORT_ERROR );
				}		
				mosRedirect("index2.php?option=$option&task=controlpanel", _MXC_MSG_IMPORT_SUCCESS );		
			}	
			
		}else{
			mosRedirect("index2.php?option=$option&task=controlpanel", _MXC_MSG_IMPORT_ERROR );
		}
	}
}

function showControlPanel( $option ) {
	global $database;
	
	$database->setQuery( "SELECT * FROM #__mxc_comments"
	. "\nORDER BY date DESC"
	. "\nLIMIT 10"
	);
	$lcrows = $database->loadObjectList();
	
	$query = "SELECT COUNT(af.id) AS favourite, af.id_content, c.id, c.title AS title, c.sectionid AS sectionid"
		."\nFROM #__mxc_favoured AS af, #__content AS c"
		."\nWHERE c.id = af.id_content GROUP BY af.id_content"
		."\nORDER BY favourite DESC"
		."\nLIMIT 10"
		;
	$database->setQuery( $query );
	$mfrows = $database->loadObjectList();	
	
	HTML_MXC::showcontrolpanel( $option, $lcrows, $mfrows );
}

function showConfig( $option ) {
	HTML_MXC::showConfig( $option );
}

function savesettings ( $option ) {
	global $mosConfig_absolute_path, $mainframe;
	
	$configfile = "components/$option/maxcomment_config.php";
	@chmod ($configfile, 0766);
	$permission = is_writable($configfile);
	if (!$permission ) {		
		mosRedirect("index2.php?option=$option&task=config", _MXC_FILE_NOT_WRITEABLE );
		return;
	}	

	$mxc_sectionlist = implode(",", mosGetParam( $_POST, 'acselections', 0 ));	

	$config = "<?php\n";	
	$config .= "/*********************************************\n";
	$config .= "* mXcomment - Joomla! Component              *\n";
	$config .= "* Copyright (C) 2007 by Bernard Gilly        *\n";
	$config .= "* --------- All Rights Reserved ------------ *\n";  
	$config .= "* Homepage   : www.visualclinic.fr           *\n";
	$config .= "* Version    : " . _MAXCOMMENT_NUM_VERSION . "                         *\n";
	$config .= "* License    : Creative Commons              *\n";
	$config .= "*********************************************/\n";
	$config .= "\n";
	$config .= "defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );\n";
	$config .= "\n";
	$config .= "\$mxc_sectionlist = \"" . $mxc_sectionlist ."\";\n"; 
	
	foreach ( $_POST as $k=>$v ) {
	 if ( $k!='option' && $k!='act' && $k!='task' && $k!='boxchecked' && $k!='acselections' && $k!='mxc_addonarchives' && $k!='mxc_autolimit4add' && ereg("^mxc_{1,1}([_a-zA-Z0-9])*", $k) ){
	 	if ( $k == 'mxc_default_gravatar' && $v == '' ) $v = "generic_gravatar_grey.gif";
		$config .= "$".$k." = \"".$v."\";\n";
	 }
	}	  
	$config .= "?>";
	
	if ($fp = fopen("$configfile", "w")) {
		fputs($fp, $config, strlen($config));
		fclose ($fp);
	}
	
	mosRedirect("index2.php?option=$option&task=config", _MXC_SETTINGS_SAVED);
}

/**
* Publishes or Unpublishes one or more records
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The current url option
*/
function publishComments( $cid=null, $publish=1, $option, $table, $usertable='' ) {
	global $database, $my;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}
	
	mosArrayToInts( $cid );
	$cids = 'id=' . implode( ' OR id=', $cid );
	
	$table2 = ( $usertable=='adm' ) ? $usertable.$table : $table ;

	$query = "UPDATE #__mxc_" . $table2
	. "\n SET published = " . (int) $publish
	. "\n WHERE ( $cids )"
	;
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	mosRedirect( "index2.php?option=$option&task=$usertable$table" );
}

function markSpam( $cid=null, $publish=1, $option ) {
	global $database;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'mark spam' : 'Not a spam';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}
	
	mosArrayToInts( $cid );
	$cids = 'id=' . implode( ' OR id=', $cid );
	
	$query = "UPDATE #__mxc_comments"
	. "\n SET status = " . (int) $publish
	. "\n WHERE ( $cids )"
	;
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	mosRedirect( "index2.php?option=$option&task=usercomments" );
}

function removeallspam( $option ) {
	global $database;
	
	$query = "SELECT COUNT(*) FROM #__mxc_comments"
	. "\n WHERE `status`='1'"
	;
	$database->setQuery( $query );	
	$total = $database->loadResult();	
	
	$query = "DELETE FROM #__mxc_comments"
	. "\n WHERE `status`='1'"
	;
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}
	
	$msg = $total . " " . _MXC_ITEM_DELETED;
	
	mosRedirect( "index2.php?option=$option&task=usercomments", $msg );  

}

function notspam( $option, $id ) {
	global $database, $mosConfig_absolute_path;
	
	$query = "SELECT name, email, comment FROM #__mxc_comments WHERE id=$id";
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
	}
	$rows=$database->loadObjectList();	
	$name=stripslashes($rows[0]->name);
	$email=stripslashes($rows[0]->email);
	$comment=stripslashes($rows[0]->comment);
	
	$WordPressAPIKey = $mxc_wordpressapikey ;	
	$MyBlogURL = ( $mxc_akismetblogurl!='' )? $mxc_akismetblogurl : $mosConfig_live_site ;

	if( version_compare(phpversion(), '5.0', '<') ) {			
		require_once ( $mosConfig_absolute_path . "/administrator/components/com_maxcomment/classes_akismet/php4/Akismet.class.php" );
		$akismet = new Akismet( $MyBlogURL, $WordPressAPIKey );
		$akismet->setAuthor( $name );
		$akismet->setAuthorEmail( $email );
		$akismet->setAuthorURL( '' );
		$akismet->setContent( $comment );
		$akismet->setPermalink( '' );		
	} else {
		require_once ( $mosConfig_absolute_path . "/administrator/components/com_maxcomment/classes_akismet/php5/Akismet.class.php" );
		$akismet = new Akismet( $MyBlogURL, $WordPressAPIKey );
		$akismet->setCommentAuthor( $name );
		$akismet->setCommentAuthorEmail( $email );
		$akismet->setCommentAuthorURL( '' );
		$akismet->setCommentContent( $comment );
		$akismet->setPermalink( '' );
	}			
	submitHam();		
	
	$msg = _MXC_MSGFEEDBACKTOAKISMET;
	
	mosRedirect( "index2.php?option=$option&task=editcomment&cid=$id", $msg );
	
}


/**
* List the records
* @param string The current GET/POST option
*/
function showComments ( $option ) {
  global $database, $mainframe, $mosConfig_absolute_path;

  $limit        = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
  $limitstart   = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
  $search       = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
  $search       = $database->getEscaped( trim( strtolower( $search ) ) );
  $filter_spam 	= $mainframe->getUserStateFromRequest( "filter_spam{$option}", 'filter_spam', '0' );
  $filter_lang  = $mainframe->getUserStateFromRequest( "filter_lang{$option}", 'filter_lang', '' );

  $where = array();
  $filter_status="";
  
  if ( $filter_lang !='' ) {  
  	$where[] = "`lang`='$filter_lang'";
  }
  
  if ($search) {
    $where[] = "LOWER(comment) LIKE '%$search%'";
  }  

  switch( $filter_spam  ){
	  case '0':
		$filter_status = "`status`>='0'";
	  break;			
	  case '1':
		$filter_status = "`status`='1'";
	  break;				
	  case '2':
		$filter_status = "`status`='0'";
	  break;		
  }  
  $where[] = $filter_status;	  

  $database->setQuery( "SELECT count(*) FROM #__mxc_comments AS a" . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "") );
  $total = $database->loadResult();  

  include_once( "includes/pageNavigation.php" );
  $pageNav = new mosPageNav( $total, $limitstart, $limit  );

  $database->setQuery( "SELECT * FROM #__mxc_comments"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	//. $filter_status
    . "\nORDER BY id DESC"
    . "\nLIMIT $pageNav->limitstart,$pageNav->limit"
  );
  $rows = $database->loadObjectList();
  
  $mxclangList = "";
  if ( file_exists($mosConfig_absolute_path . "/administrator/components/com_joomfish/config.joomfish.php") ) {	
	  // Build language filter 
	  $mxclang[] = mosHTML::makeOption( '', _MXC_ALL );
	  // Actives languages in Joomfish
	  $database->setQuery( 'SELECT * FROM #__languages WHERE active=1 ORDER BY ordering' );
	  $rowsL = $database->loadObjectList();
	  if( $rowsL ) {
		foreach( $rowsL as $rowL ) {
			$mxclang[] = mosHTML::makeOption( $rowL->iso, $rowL->name );
		}
	  }
	  
	  $mxclangList = mosHTML::selectList( $mxclang, 'filter_lang', 'class="inputbox" size="1" onChange="document.adminForm.submit();"', 'value', 'text', $filter_lang );
   }
  
  // Build Akismet filter search  
  $akis[] = mosHTML::makeOption( '0', _MXC_ALL );
  $akis[] = mosHTML::makeOption( '1', _MXC_POTENTIALSPAM );
  $akis[] = mosHTML::makeOption( '2', _MXC_NOTSPAM );
  $akismetList = mosHTML::selectList( $akis, 'filter_spam', 'class="inputbox" size="1" onChange="document.adminForm.submit();"', 'value', 'text', $filter_spam );

  HTML_MXC::showComments( $option, $rows, $search, $pageNav, $akismetList, $mxclangList );
}

// Edit comment user
function editComment( $option, $uid ) {
  global $database, $my, $mxc_levelrating;

  $row = new mosMXComment( $database );
  $row->load( $uid );

  // Get list of Content
  $contentitem[] = mosHTML::makeOption( '0', 'Select Content Item' );
  $database->setQuery( "SELECT id AS value, title AS text FROM #__content ORDER BY created DESC" );
  $contentitem = array_merge( $contentitem, $database->loadObjectList() );
  if (count( $contentitem ) < 1) {
    mosRedirect( "index2.php?option=com_sections&scope=content", 'You must add content first.' );
  }
  $clist = mosHTML::selectList( $contentitem, 'contentid', 'class="inputbox" size="1"', 'value', 'text', intval( $row->contentid ) );

  if ( !$uid ) {
    $row->published = 0;
  }

  $aksimet[] = mosHTML::makeOption( '0', _MXC_NOTSPAM );		
  $aksimet[] = mosHTML::makeOption( '1', _MXC_POTENTIALSPAM );		
  $aksimetlist = mosHTML::selectList( $aksimet, 'status', 'size="1" class="inputbox"', 'value', 'text', intval( $row->status ));

  // Prepare Ordering box
  $order = mosGetOrderingList( "SELECT ordering AS value, title AS text FROM #__mxc_comments"
    . "\nWHERE contentid='$row->contentid' ORDER BY ordering" );
  $olist = mosHTML::selectList( $order, 'ordering', 'class="inputbox" size="1"', 'value', 'text', intval( $row->ordering ) );
  
  // Build rating list
  $rate[] = mosHTML::makeOption( '0', _MXC_NO_RATING );		
  for ( $count=1; $count<=$mxc_levelrating; $count++ ){
  	$rate[] = mosHTML::makeOption( $count, $count . '/' . $mxc_levelrating );	
  }
  $rlist = mosHTML::selectList( $rate, 'rating', 'size="1" class="inputbox"', 'value', 'text', intval(confirm_evaluate( $row->rating, $row->currentlevelrating, $mxc_levelrating ) ) );

  // Build published box
  $publist = mosHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published );

  HTML_MXC::editComment( $option, $row, $clist, $olist, $rlist, $publist, $aksimetlist );
}

// Save comment user
function saveComment( $option ) {
  global $database;
  
  $row = new mosMXComment( $database );
  
  if (!$row->bind( $_POST )) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
  
  if ( !$row->date ){
  	$row->date = date( "Y-m-d H:i:s" );
  }
  if ( !$row->ip ){
  	$row->ip = getenv('REMOTE_ADDR');
  }
  
  if (!$row->store()) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
  $row->updateOrder( "contentid='$row->contentid'" );
  
  mosRedirect( "index2.php?option=$option&task=usercomments", _MXC_ITEM_SAVED );
}

// Remove comment user
function delComment( $option, $cid ) {
  global $database;
 
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$total = count( $cid );
	if (count( $cid )) {
		mosArrayToInts( $cid );
		$cids = 'id=' . implode( ' OR id=', $cid );
		$query = "DELETE FROM #__mxc_comments"
		. "\n WHERE ( $cids )"
		;
		$database->setQuery( $query );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}
	
	$msg = $total . " " . _MXC_ITEM_DELETED;
	
	mosRedirect( "index2.php?option=$option&task=usercomments", $msg );  
}

// show comments editor
function showAdmComments ( $option ) {
  global $database, $mainframe;

  $limit      = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
  $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
  $search     = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
  $search     = $database->getEscaped( trim( strtolower( $search ) ) );

  $where = array();
  if ($search) {
    $where[] = "LOWER(comment) LIKE '%$search%'";
  }

  $database->setQuery( "SELECT count(*) FROM #__mxc_admcomments AS a" . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "") );
  $total = $database->loadResult();  

  include_once( "includes/pageNavigation.php" );
  $pageNav = new mosPageNav( $total, $limitstart, $limit  );

  $database->setQuery( "SELECT * FROM #__mxc_admcomments"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . "\nORDER BY id DESC"
    . "\nLIMIT $pageNav->limitstart,$pageNav->limit"
  );
  $rows = $database->loadObjectList();

  HTML_MXC::showAdmComments( $option, $rows, $search, $pageNav );
}


// Edit Comment Editor
function editAdmComment( $option, $uid ) {
  global $database, $my, $mxc_levelrating;

  $row = new mosMX_admComment( $database );
  $row->load( $uid );
  
  // Get list of editor's comment 
  $database->setQuery( "SELECT contentid FROM #__mxc_admcomments WHERE published='1'" );
  $rowsID = $database->loadObjectList();

  // Get list of Content
  $contentitem[] = mosHTML::makeOption( '0', 'Select Content Item' );
  $database->setQuery( "SELECT id AS value, title AS text FROM #__content ORDER BY created DESC" );
  $contentitem = array_merge( $contentitem, $database->loadObjectList() );
  if (count( $contentitem ) < 1) {
    mosRedirect( "index2.php?option=com_sections&scope=content", 'You must add content first.' );
  }
  $clist = mosHTML::selectList( $contentitem, 'contentid', 'class="inputbox" size="1"', 'value', 'text', intval( $row->contentid ) );

  if ( !$uid ) {
    $row->published = 0;
  }
 
  // Build rating list  
  $rate[] = mosHTML::makeOption( '0', _MXC_NO_RATING );		
  for ( $count=1; $count<=$mxc_levelrating; $count++ ){
  	$rate[] = mosHTML::makeOption( $count, $count . '/' . $mxc_levelrating );	
  }
  $rlist = mosHTML::selectList( $rate, 'rating', 'size="1" class="inputbox"', 'value', 'text', intval(confirm_evaluate( $row->rating, $row->currentlevelrating, $mxc_levelrating ) ) );
  

  // Build published box
  $publist = mosHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published );

  HTML_MXC::editAdmComment( $option, $row, $clist, $rlist, $publist );
}

// Save comment editor
function saveAdmComment( $option ) {
  global $database;
  
  $row = new mosMX_admComment( $database );
  
  if (!$row->bind( $_POST )) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
  
  if ( !$row->date ){
  	$row->date = date( "Y-m-d H:i:s" );
  }
  
  if (!$row->store()) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
 
  mosRedirect( "index2.php?option=$option&task=admcomments", _MXC_ITEM_SAVED );
}

// Remove comment editor
function delAdmComment( $option, $cid ) {
  global $database;
 
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$total = count( $cid );
	if (count( $cid )) {
		mosArrayToInts( $cid );
		$cids = 'id=' . implode( ' OR id=', $cid );
		$query = "DELETE FROM #__mxc_admcomments"
		. "\n WHERE ( $cids )"
		;
		$database->setQuery( $query );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}
	
	$msg = $total . " " . _MXC_ITEM_DELETED;
	
	mosRedirect( "index2.php?option=$option&task=admcomments", $msg );  
}

// show Bad Words
function showBadwords ( $option ) {
  global $database, $mainframe;

  $limit      = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
  $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
  $search     = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
  $search     = $database->getEscaped( trim( strtolower( $search ) ) );

  $where = array();
  if ($search) {
    $where[] = "LOWER(badword) LIKE '%$search%'";
  }

  $database->setQuery( "SELECT count(*) FROM #__mxc_badwords AS a" . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "") );
  $total = $database->loadResult();  

  include_once( "includes/pageNavigation.php" );
  $pageNav = new mosPageNav( $total, $limitstart, $limit  );

  $database->setQuery( "SELECT * FROM #__mxc_badwords"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . "\nORDER BY badword ASC"
    . "\nLIMIT $pageNav->limitstart,$pageNav->limit"
  );
  $rows = $database->loadObjectList();

  HTML_MXC::showBadwords( $option, $rows, $search, $pageNav );
}


// Edit Bad Word
function editBadword( $option, $uid ) {
  global $database, $my;

  $row = new mosMXCBadwords( $database );
  $row->load( $uid );

  if ( !$uid ) {
    $row->published = 0;
  }
   
  // Build published box
  $publist = mosHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published );

  HTML_MXC::editBadword( $option, $row, $publist );
}

// Save Bad Word
function saveBadword( $option ) {
  global $database;
  
  $row = new mosMXCBadwords( $database );
  
  if (!$row->bind( $_POST )) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }  
 
  if (!$row->store()) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
 
  mosRedirect( "index2.php?option=$option&task=badwords", _MXC_ITEM_SAVED );
}

// Remove Bad word
function delBadword( $option, $cid ) {
  global $database;
 
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$total = count( $cid );
	if (count( $cid )) {
		mosArrayToInts( $cid );
		$cids = 'id=' . implode( ' OR id=', $cid );
		$query = "DELETE FROM #__mxc_badwords"
		. "\n WHERE ( $cids )"
		;
		$database->setQuery( $query );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}
	
	$msg = $total . " " . _MXC_ITEM_DELETED;
	
	mosRedirect( "index2.php?option=$option&task=badwords", $msg );  
}

// show Block IP
function showBlockIp ( $option ) {
  global $database, $mainframe;

  $limit      = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
  $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
  $search     = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
  $search     = $database->getEscaped( trim( strtolower( $search ) ) );

  $where = array();
  if ($search) {
    $where[] = "LOWER(ipblock) LIKE '%$search%'";
  }

  $database->setQuery( "SELECT count(*) FROM #__mxc_blockip AS a" . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "") );
  $total = $database->loadResult();  

  include_once( "includes/pageNavigation.php" );
  $pageNav = new mosPageNav( $total, $limitstart, $limit  );

  $database->setQuery( "SELECT * FROM #__mxc_blockip"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . "\nORDER BY ipblock ASC"
    . "\nLIMIT $pageNav->limitstart,$pageNav->limit"
  );
  $rows = $database->loadObjectList();

  HTML_MXC::showBlockIp( $option, $rows, $search, $pageNav );
}


// Edit Block IP
function editBlockIp( $option, $uid ) {
  global $database, $my;

  $row = new mosMXCBlockip( $database );
  $row->load( $uid );

  if ( !$uid ) {
    $row->published = 0;
  }
   
  // Build published box
  $publist = mosHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published );

  HTML_MXC::editBlockIp( $option, $row, $publist );
}

// Save Block IP
function saveBlockIp( $option ) {
  global $database;
  
  $row = new mosMXCBlockip( $database );
  
  if (!$row->bind( $_POST )) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }  
 
  if (!$row->store()) {
    echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
    exit();
  }
 
  mosRedirect( "index2.php?option=$option&task=blockip", _MXC_ITEM_SAVED );
}

// Remove Block IP
function delBlockIp( $option, $cid ) {
  global $database;
 
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$total = count( $cid );
	if (count( $cid )) {
		mosArrayToInts( $cid );
		$cids = 'id=' . implode( ' OR id=', $cid );
		$query = "DELETE FROM #__mxc_blockip"
		. "\n WHERE ( $cids )"
		;
		$database->setQuery( $query );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}
	
	$msg = $total . " " . _MXC_ITEM_DELETED;
	
	mosRedirect( "index2.php?option=$option&task=blockip", $msg );  
}


// Show Favoured
function showFavoured ( $option ) {
	global $database, $mainframe;
		
	$limit      = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

	$query = "SELECT COUNT(af.id) AS favourite, af.id_content, c.id, c.title AS title"
			."\nFROM #__mxc_favoured AS af, #__content AS c"
			."\nWHERE c.id = af.id_content"
			."\nGROUP BY af.id_content"			
			;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$total = count($rows);
	
	include_once( "includes/pageNavigation.php" );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$database->setQuery( "SELECT COUNT(af.id) AS favourite, af.id_content AS id_content, c.id, c.title AS title"
			 ."\nFROM #__mxc_favoured AS af, #__content AS c"
			 ."\nWHERE c.id = af.id_content"
			 ."\nGROUP BY af.id_content"
			 ."\nORDER BY favourite DESC"
			 ."\nLIMIT $pageNav->limitstart, $pageNav->limit"
			 );
	$rows = $database->loadObjectList();
	
	HTML_MXC::showFavoured( $option, $rows, $pageNav );
}

function resetfavouredcount ( $option ){
	global $database;
	
	$query = "DELETE FROM #__mxc_favoured";
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}
		
	mosRedirect( "index2.php?option=$option&task=favoured", _MXC_COUNTER_RESETED );  

}

// EDIT LANGUAGE
function editlanguage( $option ) {
  global $mosConfig_absolute_path, $mosConfig_lang;

  if ( file_exists( $mosConfig_absolute_path.'/administrator/components/com_maxcomment/languages/'.$mosConfig_lang.'.php') ) {
    $file = $mosConfig_absolute_path.'/administrator/components/com_maxcomment/languages/'.$mosConfig_lang.'.php';
  } else {
    $file = $mosConfig_absolute_path.'/administrator/components/com_maxcomment/languages/english.php';
  }
  @chmod ( $file, 0766 );
  $permission = is_writable( $file );
  if ( !$permission ) {
    echo "<center><h1><font color=red>" . _MXC_WARNING . "</font></h1><br />";
    echo "<strong>" . _MXC_FILE_MUST_BE_WRITEABLE . "</strong></center><br />";
  }

  HTML_MXC::showFileLanguage( $file, $option );
}

function savelanguage( $option, $file ) {
  $filecontent = mosGetParam( $_POST, 'filecontent' );
  $filecontent = "<?php\n" . $filecontent . "\n?>";
 
  @chmod ( $file, 0766 );
  $permission = is_writable( $file );
  if ( !$permission ) {
    mosRedirect("index2.php?option=$option&task=editlanguage", _MXC_FILE_NOT_WRITEABLE );
  }
  
  if ( $fp = fopen( "$file", "w") ) {
    fputs($fp, stripslashes($filecontent), strlen($filecontent));
    fclose($fp);
    mosRedirect( "index2.php?option=$option&task=controlpanel", _MXC_LANGUAGE_SAVED );
  } else mosRedirect( "index2.php?option=$option&task=controlpanel", "FATAL ERROR !" );
  
}

// EDIT CSS
function editCSS( $option ) {
  global $mosConfig_absolute_path, $mosConfig_lang, $mxc_template;  

  if ( file_exists( $mosConfig_absolute_path.'/components/com_maxcomment/templates/'.$mxc_template.'/css/'.$mxc_template.'_css.css') ) {
    $file = $mosConfig_absolute_path.'/components/com_maxcomment/templates/'.$mxc_template.'/css/'.$mxc_template.'_css.css';
  } else {
    $file = $mosConfig_absolute_path.'/components/com_maxcomment/templates/default/css/default_css.css';
  }
  @chmod ( $file, 0766 );
  $permission = is_writable( $file );
  if ( !$permission ) {
    echo "<center><h1><font color=red>" . _MXC_WARNING . "</font></h1><br />";
    echo "<strong>" . _MXC_FILE_MUST_BE_WRITEABLE . "</strong></center><br />";
  }

  HTML_MXC::showFileCSS( $file, $option );
}

function saveCSS( $option, $file ) {
  $filecontent = mosGetParam( $_POST, 'filecontent' );
 
  @chmod ( $file, 0766 );
  $permission = is_writable( $file );
  if ( !$permission ) {
    mosRedirect("index2.php?option=$option&task=editcss", _MXC_FILE_NOT_WRITEABLE );
  }
  
  if ( $fp = fopen( "$file", "w") ) {
    fputs($fp, stripslashes($filecontent), strlen($filecontent));
    fclose($fp);
    mosRedirect( "index2.php?option=$option&task=controlpanel", _MXC_CSS_SAVED );
  } else mosRedirect( "index2.php?option=$option&task=controlpanel", "FATAL ERROR !" );
  
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
<!-- IMPORTANT! DON'T REMOVE THE COPYRIGHT NOTICE -->
<!-- If you want to remove the legal mention of this copyright notice on your front-end, please contact the author -->
<!-- e-mail : contact@visualclinic.fr -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong>mXcomment</strong> - Copyright &copy; <?php echo $copySite ; ?> by Bernard Gilly - <a href="http://www.visualclinic.fr">visualclinic.fr</a> - Some rights reserved<br /></div>
	</td>
  </tr>
</table>