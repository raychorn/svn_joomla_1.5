<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007-2008 by Bernard Gilly   *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// load the html drawing class
require_once( $mainframe->getPath( 'front_html' ) );
require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );
require( $mosConfig_absolute_path."/components/com_maxcomment/maxcomment.class.php");
require( $mosConfig_absolute_path.'/components/com_maxcomment/includes/common/newevaluaterating.php' );

// Get the right language if it exists
if (file_exists($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php")){
	include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php");
}else{
	include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/english.php");
}

$limitmore = intval( mosGetParam( $_GET, 'limit', 30 ));
$fid       = intval( mosGetParam( $_GET, 'favid', 0 ));
$id        = intval( mosGetParam( $_GET, 'id', 0 ));
$cid       = intval( mosGetParam( $_GET, 'cid', 0 )); // contentid
$tag       = trim(mosGetParam( $_GET, 'tag', '' ));
$lang	   = trim(mosGetParam( $_GET, 'lang', '' ));
$pa_wck_mo = $database->getEscaped(mosGetParam( $_GET, 'mosConfig_absolute_path', '' ));
//$pa_wck_mo =  $pa_wck_mo );

function is_email( $email ){
	$rBool=false;
	if(preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email)) {
	   $rBool=true;
	}
	return $rBool;
}

switch ($task) {

	case 'quote':		
		HTML_MXC_FRONTEND::showQuote( $option, $lang ) ;
		break;
		
	case 'feed':
		loadFeed( $option ) ;
		break;
		
	case 'favoured':
		saveFavoured( $option ) ;
		break;	
		
	case 'removefav':
		removeFavoured( $option, $fid ) ;
		break;	
		
	case 'myfavoured':
		myFavoured ( $option, $limitmore ) ;
		break;		
		
	case 'report':
		report( $option, $id, $cid ) ;
		break;			
		
	case 'reply':
		addcomment( $option, $id, 1, $lang ) ;
		break;			
		
	case 'viewallreplies':
		viewallreplies( $option, $id ) ;
		break;
		
	case 'addcomment':
		addcomment( $option, $id, 0, $lang ) ;
		break;		
		
	case 'savecomment':
		savecomment( $option ) ;
		break;		
		
	case 'viewcomment':
		viewcomment( $option, $id ) ;
		break;		
		
	case 'related':		
		showRelatedItems( $option, $id ) ;
		break;
		
	case 'unsubscribe':
		unsubscribe( $option, $id ) ;
		break;
		
	case 'morefav':		
	default:		
		moreFavoured ( $option, $limitmore ); // Call by module "mxc_mostfavoured" or by menu link url : ex. index.php?option=com_maxcomment&task=morefav
}

function loadFeed( $option ){
	global $database, $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_sitename, $mosConfig_cachepath, $mosConfig_MetaDesc, $mosConfig_sef, $mainframe;
	
	// Load feed creator class
	require_once( $mosConfig_absolute_path .'/includes/feedcreator.class.php' );
	// Load variables	
	require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');
	
	$iso = split( '=', _ISO );
	
	$rssfile = $mosConfig_cachepath .'/comments.xml';	
	
    $rss = new UniversalFeedCreator(); 
    $rss->title = $mosConfig_sitename . " - " . stripslashes ( _MXC_RSS_LASTCOMMENTS ); 
    $rss->description = $mosConfig_MetaDesc; 
    $rss->link = htmlspecialchars( $mosConfig_live_site );
    $rss->syndicationURL = htmlspecialchars( $mosConfig_live_site );
    $rss->cssStyleSheet = NULL;
	$rss->encoding = $iso[1];
	
	$query = "SELECT ak.*, UNIX_TIMESTAMP( ak.date ) AS created_ts, c.id AS id_content, c.title AS titlearticle, c.sectionid AS sectionid"
		. "\n FROM #__mxc_comments AS ak"
		. "\n LEFT JOIN #__content AS c ON c.id = ak.contentid"
		. "\n WHERE ak.published='1'"
		. "\n ORDER BY ak.id DESC"
		. "\n LIMIT " . $mxc_numrssfeed
		;	
	$database->setQuery( $query );	
	$rows = $database->loadObjectList();
	
	if ( $rows ) {
		foreach ( $rows as $row ) {
		
			if (is_callable( array( $mainframe, "getItemid" ) ) ) {
				$itemid = $mainframe->getItemid( $row->id_content );
			} elseif (is_callable( "JApplicationHelper::getItemid" ) ) {
				$itemid = JApplicationHelper::getItemid( $row->id_content );
			} else {
				$itemid = null;
			}
			$Itemid	= $itemid ? "&amp;Itemid=" . (int) $itemid : "";
			
			// use by anchor if no SEO
			$anchor = (!$mosConfig_sef)? "#maxcomment$row->id": "";			
			
			$item = new FeedItem(); 
			$item->title = htmlspecialchars( $row->titlearticle );
			$item->title = html_entity_decode( $item->title );		
			$item->title = _MXC_RSS_COMMENTON . " " . $item->title . " (" . _MXC_RSS_WRITTENBY . " " . stripslashes( $row->name ) . ")";		
			$item->link = sefRelToAbs("index.php?option=com_content&task=view&id=$row->contentid$Itemid$anchor");		 		
			$item->description = ( $row->title!='' ) ? $row->title : $row->comment ;	
			$item->description = mosHTML::cleanText( $item->description );
			$item->description = html_entity_decode( $item->description );
			// limits description text to 10 words
			$item_description_array = split( ' ', $item->description );
			$count = count( $item_description_array );
			if ( $count > 10 ){
				$item->description = '';
				for ( $a = 0; $a < $info[ 'text_length' ]; $a++ ) {
					$item->description .= $item_description_array[$a]. ' ';
				}
				$item->description = trim( $item->description );
				$item->description .= '...';
			}
			$item->description = stripslashes(  $row->name ) . " > " . $item->description . " <a href='". sefRelToAbs("index.php?option=com_content&task=view&id=$row->contentid$Itemid$anchor")."'>" . _MXC_RSS_VIEWCOMMENT . "</a>";  
			$item->date = date( 'r', $row->created_ts );
			$item->source = htmlspecialchars( $mosConfig_live_site );
	   
			$rss->addItem($item);
		}
	}	
	// save feed file
	$rss->saveFeed('RSS2.0', $rssfile, 1);
}

function saveFavoured( $option ){
	global $database, $mosConfig_sitename, $mosConfig_absolute_path, $mainframe, $my, $limitmore, $Itemid, $_VERSION;
	
    require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');
	
	$is_user   = (strtolower($my->usertype) <> '');
		
	$id          = intval( mosGetParam( $_REQUEST, 'id', 0 ) );	
	$goItem      = "index.php?option=com_content&task=view&id="; 
	$ip          = getenv('REMOTE_ADDR');	
	
	// Check already favoured
	$query = "SELECT * FROM #__mxc_favoured WHERE id_content = '$id' AND ip='$ip'";
	$database->setQuery( $query );
	$alreadyfav = $database->loadResult();	
	
	if ( $alreadyfav ) {	
		$msg = stripslashes ( _MXC_YOUHAVEFAVOUREDTHISARTICLE );	
	} 
	
	if ( $mxc_favoured_user=='1' && $is_user=='' ) {
		$msg = stripslashes ( _MXC_FAVOUREDONLYREGISTERED ) ;		
	}
	
	if ( !$alreadyfav && ( $mxc_favoured_user && $is_user ) || !$alreadyfav && !$mxc_favoured_user ){
		$id_user   = $my->id;
		$date      = date( "Y-m-d H:i:s" );
		$query     = "INSERT INTO #__mxc_favoured SET id_content='$id', id_user='$id_user', ip='$ip', date='$date'";
		$database->setQuery( $query );
		$database->query();		
		$msg = stripslashes ( _MXC_THANKFAVOURED );
	}	
	
	$img = "&raquo;&nbsp;";
	
	$query = "SELECT COUNT(af.id) AS favourite, af.id_content, c.title AS title, c.sectionid AS sectionid FROM #__mxc_favoured AS af, #__content AS c WHERE c.id = af.id_content AND (c.state = '1' OR c.state = '-1') GROUP BY af.id_content ORDER BY favourite DESC LIMIT $mxc_numfavoured";
	$database->setQuery( $query );
	$rows = $database->loadObjectList();	
	
	mosCache::cleanCache();
	
	HTML_MXC_FRONTEND::saveFavoured( $rows, $msg, $img, $goItem );	
}

// Call by module  "ac_mostfavoured" or by menu url : ex. index.php?option=akocomment&task=morefav
function moreFavoured( $option, $limitmore='10' ){
	global $database, $mosConfig_sitename, $mosConfig_absolute_path, $mainframe, $my, $Itemid, $_VERSION;
	
    require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');
	
	$goItem = "index.php?option=com_content&task=view&id="; 
		
	$img = "&raquo;&nbsp;";
	
	$query = "SELECT COUNT(af.id) AS favourite, af.id_content, c.title AS title, c.sectionid AS sectionid FROM #__mxc_favoured AS af, #__content AS c WHERE c.id = af.id_content AND (c.state = '1' OR c.state = '-1') GROUP BY af.id_content ORDER BY favourite DESC LIMIT $limitmore";
	$database->setQuery( $query );
	$rows = $database->loadObjectList();	
	
	HTML_MXC_FRONTEND::moreFavoured( $rows, $img, $goItem );	
}

function myFavoured( $option, $limitmore='10' ){
	global $database, $mosConfig_live_site, $mosConfig_sitename, $mosConfig_absolute_path, $mainframe, $my, $Itemid, $_VERSION;
	
    require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');
	$Itemid4myfavoured = $Itemid;
	
	// Call by menu url : index.php?option=com_maxcomment&task=myfavoured	
	$img = "&raquo;&nbsp;";
	$goItem = "index.php?option=com_content&task=view&id="; 
	$rows = "";
	
	if ( $my->id ) {	
		
		$query = "SELECT af.id AS favid, af.id_content, c.title AS title, c.sectionid AS sectionid FROM #__mxc_favoured AS af, #__content AS c WHERE c.id = af.id_content AND af.id_user = '$my->id' AND (c.state = '1' OR c.state = '-1') ORDER BY date DESC";
		$database->setQuery( $query );
		$rows = $database->loadObjectList();
		
	}
	
	HTML_MXC_FRONTEND::myFavoured( $rows, $img, $goItem );
	
}

function removeFavoured( $option, $fid ){
	global $database, $Itemid;

	$query = "DELETE FROM #__mxc_favoured"
	. "\n WHERE id = '$fid'"
	;
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}
	
	mosCache::cleanCache();

	mosRedirect( "index.php?option=$option&task=myfavoured&Itemid=$Itemid" );	
	
}

function report( $option, $id, $cid ){
	global $database, $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_sef, $mainframe, $Itemid, $rowUserComments, $mosConfig_lang;
	
	require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');
	require($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');

	$img = "&raquo;&nbsp;";
	$goItem = "index.php?option=com_content&task=view&id=";
	
	echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpane\">";
	echo "<tr><td>";	 
	
	if ( $_POST ){		
		
		$reportemail = mosGetParam( $_POST, 'reportemail', '' );
		$reportname = mosGetParam( $_POST, 'reportname', '' );
		$reportname = stripslashes( $reportname );
		$reason = mosGetParam( $_POST, 'reason', '' );			
		$reason = stripslashes( $reason );
		$id = mosGetParam( $_POST, 'id', 0 );
		$cid = mosGetParam( $_POST, 'cid', 0 );
		
		$query = "SELECT title FROM #__mxc_comments WHERE id='$id'";
		$database->setQuery( $query );
		$title = stripslashes($database->loadResult());	
		
		// use by anchor if no SEO
		$anchor = (!$mosConfig_sef)? "#maxcomment$id": "";			

		if ( is_email( $reportemail ) ){		
				
			// multi notify for Admins
			if ( strpos($mxc_notify_email, ";") == true ) $mxc_notify_email = explode( ";", $mxc_notify_email );			
			
			// send email to administrator		
			$articlelink = sefRelToAbs("index.php?option=com_content&task=view&id=".$cid."&Itemid=".$Itemid.$anchor); 
			$ifsefTurnOff = ( !$mosConfig_sef ) ? $mosConfig_live_site."/" : "";
			
			$articlelink = $ifsefTurnOff . $articlelink;
			$articlelink = explode( 'http://', $articlelink );
			$articlelink = (count($articlelink)>2) ? "http://".$articlelink[2] : "http://".$articlelink[1];			
			
			$subject = stripslashes( _MXC_REPORTADMINEMAIL );
			$mailtext = "<b>" . (_MXC_TITLE) . " " . (_MXC_COMMENT) . ": </b>" . htmlspecialchars(  $title, ENT_QUOTES ) . "<br/><br/>";
			if ($reportname != '')     $mailtext .= "<b>" . _MXC_ENTERNAME . ": </b>" . htmlspecialchars(  $reportname, ENT_QUOTES ) . "<br/>";
			if ($reportemail != '') 	$mailtext .= "<b>" . _MXC_ENTERMAIL . ": </b><a href=\"mailto:" . $reportemail . "\">" . $reportemail . "</a><br/>";
			$mailtext .= "<b>" . _MXC_REASON_REPORT . ": </b>" . htmlspecialchars( $reason, ENT_QUOTES ) . "<br/><br/>";
			$mailtext .= "<b>" . _MXC_ARTICLE . ": </b><a href=\"" . $articlelink . "\">" . $articlelink . "</a><br/><br/>";
		
			$success = mosMail( $reportemail, $reportname, $mxc_notify_email, $subject, $mailtext, 1 );		
			
			echo "<div class='contentheading'>" . stripslashes ( _MXC_REPORTACOMMENT ) . "</div><br />";	
				
			if ( $success ){
				echo stripslashes ( _MXC_THANKS4UREPORT );		
			} else {
				echo stripslashes ( _MXC_ERRORONSENDREPORT );	
			}
			echo "<br /><br />";
			$gobackitem = sefRelToAbs("index.php?option=com_content&task=view&id=$cid&Itemid=$Itemid$anchor"); 
			echo "<a href='$gobackitem'>" . stripslashes ( _MXC_GOBACKITEM ) . "</a>";
		}
	}else{
	?>
	<script language="JavaScript" type="text/JavaScript">
	function validate(){
		if (document.maxcommentformreport.reason.value==''){
				alert("<?php echo _MXC_FORMREPORTVALIDATE; ?>");
			}else if (document.maxcommentformreport.reportname.value==''){
				alert("<?php echo _MXC_FORMVALIDATENAME; ?>");
			}else if (document.maxcommentformreport.reportemail.value==''){
				alert("<?php echo _MXC_FORMVALIDATEMAIL; ?>");
			} else {
				document.maxcommentformreport.submit();
			}
	}
	</script>	
	<div class="contentheading"><?php echo _MXC_REPORTACOMMENT; ?></div><br />
	<?php echo _MXC_REPORTINTRO; ?><br />
	<?php echo _MXC_REPORTINTRO2; ?><br /><br />
	  <form name="maxcommentformreport" method="post" action="">
	    <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="30%"><div align="right"><?php echo _MXC_ENTERNAME; ?></div></td>
            <td width="12">&nbsp;</td>
            <td width="68%"><input type="text" name="reportname" class="inputbox"></td>
          </tr>
          <tr>
            <td><div align="right"><?php echo _MXC_ENTERMAIL; ?></div></td>
            <td>&nbsp;</td>
            <td><input type="text" name="reportemail" class="inputbox"></td>
          </tr>
          <tr>
            <td valign="top"><div align="right"><?php echo _MXC_REASON_REPORT; ?></div></td>
            <td>&nbsp;</td>
            <td><textarea name="reason" cols="40" rows="5" class="inputbox"></textarea></td>
          </tr>
          <tr>
            <td><div align="right"></div></td>
            <td>&nbsp;</td>
            <td><input type="hidden" name="task" value="report">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="cid" value="<?php echo $cid; ?>">
			</td>			
          </tr>
          <tr>
            <td><div align="right"></div></td>
            <td>&nbsp;</td>
            <td><input type="button" name="Submit" value="<?php echo _MXC_BUTTON_SUBMIT; ?>" class="button" onClick="validate()"></td>
          </tr>
        </table>
     </form>
		<?php
		$query = "SELECT * FROM #__mxc_comments WHERE id=" . $id;
		$database->setQuery( $query );
		$rowUserComments = $database->loadObjectList();		
	
		echo "<br /><b>"._MXC_COMMENTINQUESTION."</b>";
		
		// Load template user comment	
		// Get the right language template if it exists
		if (file_exists($mosConfig_absolute_path."/components/com_maxcomment/templates/".$mxc_template."/languages/".$mosConfig_lang.".php")){
			include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/".$mxc_template."/languages/".$mosConfig_lang.".php");
		}else{
			include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/".$mxc_template."/languages/english.php");
		}
		
		echo "<link href=\"".$mosConfig_live_site."/components/com_maxcomment/templates/".$mxc_template."/css/".$mxc_template."_css.css\" rel=\"stylesheet\" type=\"text/css\" />";	
		require( $mosConfig_absolute_path.'/components/com_maxcomment/templates/'.$mxc_template.'/usercomment.php' );
		eval(stripslashes(base64_decode("CQllY2hvICRpbWc7DQoJCWVjaG8gXCIgPGEgaHJlZj1cXFwiamF2YXNjcmlwdDpvbmNsaWNrPWhpc3RvcnkuYmFjaygpO1xcXCIgPlwiIC4gX01YQ19HT0JBQ0tJVEVNIC4gXCI8L2E+XCI7CQkJCQ0K")));
	}		
	eval(stripslashes(base64_decode("CWVjaG8gXCI8L3RkPjwvdHI+PC90YWJsZT5cIjsJDQoJX2dldE5vdGljZUNvcHlyaWdodCgpOw0K")));	
}

function addcomment( $option, $id, $reply, $clang ){
	global $database, $mosConfig_live_site, $mosConfig_absolute_path, $Itemid, $my, $Itemid;
	
	require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );
	$useSecurityImage = 0;
	$parentid = 0;
	$titleparentid ="";
	$javascript = "";
	
	if ( $reply ) {
		$parentid = $id;
		$query = "SELECT contentid FROM #__mxc_comments WHERE id='$id'";
		$database->setQuery( $query );
		$cid = $database->loadResult();		
		$query = "SELECT title FROM #__mxc_comments WHERE id='$id'";
		$database->setQuery( $query );
		$titleparentid = stripslashes($database->loadResult());
	} else {
		$cid = $id;		
	}
	
	$query = "SELECT id, title FROM #__content WHERE id='$cid'";
	$database->setQuery( $query );
	$rowT = $database->loadObjectList();		
	$title = stripslashes($rowT[0]->title);	
	
	$query = "SELECT template"
	. "\n FROM #__templates_menu"
	. "\n WHERE client_id = 0"
	. "\n AND menuid = 0"
	;
	$database->setQuery( $query );
	$template = $database->loadResult();
	
	$template .= "/";
	
	// check if security image
	if ( $mxc_use_securityimage && ( file_exists($mosConfig_absolute_path.'/administrator/components/com_securityimages/client.php') ) ) {	
		$useSecurityImage = 1;
	}	
	
	if ( $mxc_ratinguser ) {
		// Build rating list 		
		$rate[] = mosHTML::makeOption( '0', _MXC_NO_RATING );		
		for ( $count=1; $count<=$mxc_levelrating; $count++ ){
			$rate[] = mosHTML::makeOption( $count, $count . '/' . $mxc_levelrating );	
		}
		if ( $mxc_levelrating=='5' ){
			$javascript = " onchange=\"javascript:if (document.commentForm.rating.options[selectedIndex].value!='0') {document.imagelib.src='$mosConfig_live_site/components/com_maxcomment/templates/$mxc_template/images/rating/user_rating_' + document.commentForm.rating.options[selectedIndex].value + '.gif'} else {document.imagelib.src='$mosConfig_live_site/components/com_maxcomment/templates/$mxc_template/images/rating/user_rating_0.gif'}\"";
		}
		$rlist = mosHTML::selectList( $rate, 'rating', 'class="inputbox" size="1"' . $javascript, 'value', 'text', '' );
	}
	
	// check if already rating for this article
	
	$query = "SELECT COUNT(*) FROM #__mxc_comments WHERE contentid='$cid' AND iduser='$my->id' AND rating > '0'";
	$database->setQuery( $query );
	$alreadyvoting = $database->loadResult();	
		
	HTML_MXC_FRONTEND::displayForm( $title, $template, $option, $cid, $parentid, $useSecurityImage, $rlist, $Itemid, $titleparentid, $alreadyvoting, $clang );
}

function savecomment( $option ) {
	global $database, $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_sitename, $mosConfig_sef, $mosConfig_mailfrom, $my, $Itemid, $_VERSION, $mosConfig_offset;
	
	$checkJversion = ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5') ? 1 : 0;
	
	// Block IP addresses
	$query = "SELECT ipblock FROM #__mxc_blockip WHERE published='1' and ipblock='".getenv('REMOTE_ADDR')."'";
	$database->setQuery( $query );
	$rowIP = $database->loadResult();
	if ( $rowIP ) {
		echo "<script>history.back();</script>";
		exit();
	}
	
	require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );
	
	$img = "&raquo;&nbsp;";	
	
	if ( $my->id ) {
		// no security check if registered
		$mxc_use_securityimage = 0;
		$mxc_use_mathguard     = 0;
	}

	if ( $mxc_use_securityimage ) {
		$securityimage_newpass_refid = mosGetParam( $_POST, 'securityimage_newpass_refid', '' ) ;
		$securityimage_newpass_try = mosGetParam( $_POST, 'securityimage_newpass_try', '' ) ;
		$securityimage_newpass_reload = mosGetParam( $_POST, 'securityimage_newpass_reload', '' ) ;
		require( $mosConfig_absolute_path . '/administrator/components/com_securityimages/server.php' );	
		$checkSecurity = checkSecurityImage( $securityimage_newpass_refid, $securityimage_newpass_try, $securityimage_newpass_reload );	
		$mxc_use_mathguard = 0;
	} elseif ( $mxc_use_mathguard ) {
		// first we need to require our MathGuard class 
		include( $mosConfig_absolute_path.'/components/com_maxcomment/includes/ClassMathGuard.php'); 
		// this condition checks the user input. Don't change the condition, just the body within the curly braces 
		if (MathGuard :: checkResult($_POST['mathguard_answer'], $_POST['mathguard_code'])) {
			$checkSecurity = 1;
		} else {
			$checkSecurity = 0;
		}
	} else $checkSecurity = 1;
	
	$is_user   = (strtolower($my->usertype) <> '');	
	$statusSpam = "0";

	$name       = strval( mosGetParam( $_POST, 'name', '' ) );
	$email      = strval( strtolower( mosGetParam( $_POST, 'email', '' ) ) );	
	$title      = strval( mosGetParam( $_POST, 'title', '' ) );
	$comment    = strval(  mosGetParam( $_POST, 'comment', '' ) );
	$web        = strval( mosGetParam( $_POST, 'web', '' ) );	
	$contentid  = intval( mosGetParam( $_POST, 'cid', 0 ) );
	$parentid   = intval( mosGetParam( $_POST, 'parentid', 0 ) );	
	$iduser     = intval( mosGetParam( $_POST, 'iduser', 0 ) );
	$rating     = intval( mosGetParam( $_POST, 'rating', 0 ) );
	$subscribe  = intval( mosGetParam( $_POST, 'subscribe', 0 ) );
	$published  = intval( mosGetParam( $_POST, 'published', 0 ) );
	$clang      = strval( mosGetParam( $_POST, 'lang', '' ) );	
	$directForm = intval( mosGetParam( $_POST, 'directForm', 0 ));
	
	$iduser = ( $iduser!=$my->id )? $my->id : $iduser;
	
	// Prevent double post
	$ip           = getenv('REMOTE_ADDR');
	$comment_db   =  $database->getEscaped( $comment );
	$query        = ("SELECT COUNT(*) FROM #__mxc_comments WHERE ip='".$ip."' AND contentid='".$contentid."' AND comment='" . $comment_db . "'");
	$database->setQuery( $query );
	$alreadySent = $database->loadResult();
	if ( $alreadySent ) {
		echo "<script>history.back();</script>";
		exit();
	}
	
	// Prevent empty post
	if ( trim($comment_db)=='' ) {
		echo "<script>history.back();</script>";
		exit();	
	}
	
	// language
	$clang      = $database->getEscaped( $clang );		
	if ( $clang=='' ) $clang = null;	
	
	$query = "SELECT id, title FROM #__content WHERE id=" . $contentid;
	$database->setQuery( $query );
	$rowT = $database->loadObjectList();	
	$title_article = stripslashes( $rowT[0]->title );
	
	echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpaneopen\">";
	echo "<tr><td>";			
	echo "<div class='contentheading'>" . $title_article . "</div>";
	echo "<br />";
	
	if ( $checkSecurity ) {
		
		// Check if Registered Users only
		if ( $mxc_anonentry=='0' && $is_user=='' ) {
			echo "<script>alert('"._MXC_COMMENTONLYREGISTERED."'); document.location.href='".sefRelToAbs("index.php?option=content&task=view&id=$contentid&Itemid=$Itemid")."';</script>";
			exit();
		}
	
		//$date  = date( "Y-m-d H:i:s" );
		$date  = date( 'Y-m-d H:i:s', time() + $mosConfig_offset*60*60 );
		$ip    = getenv('REMOTE_ADDR');
			
		// Check if timeout
		$timeout = ( $mxc_timeout=='' ) ? 0 : intval( $mxc_timeout );
		if ( $timeout > 0 ){
			$ts = strtotime( $date );			
			$query = ("SELECT ip, date FROM #__mxc_comments WHERE ip='$ip' ORDER BY date DESC LIMIT 1");
			$database->setQuery( $query );
			$rows = $database->loadObjectList();
			if ( $rows ) {
				$row = $rows[0];
				$lasttime = strtotime($row->date) + $timeout;		
				if ( $lasttime > $ts ){
					$rest = $lasttime - $ts;
					echo "<script> alert('" . _MXC_WAITING . " " . $rest . " " . _MXC_SECONDS . "'); history.back();</script>";
					exit();
				}
			}		
		}		
		
		$ifsefTurnOff = ( !$mosConfig_sef ) ? $mosConfig_live_site . "/" : "";
		$name = stripslashes( $name );
		$title = stripslashes( $title );
		$comment = stripslashes( $comment );
		
		if ( file_exists($mosConfig_absolute_path . "/administrator/components/com_joomfish/config.joomfish.php") ) {	
			$languageUrl = "&lang=" . $clang;
		} else $languageUrl = "";
		
		$articlelink = sefRelToAbs( "index.php?option=com_content&task=view&id=" . $contentid . $languageUrl . "&Itemid=" . $Itemid );	
		$articlelink = $ifsefTurnOff . $articlelink;
		$articlelink = explode( 'http://', $articlelink );
		$articlelink = (count($articlelink)>2) ? "http://".$articlelink[2] : "http://".$articlelink[1];			
		
		if ( $mxc_use_askimet ) { // prevent spam by web service Akismet.com
		
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
				if( $akismet->isSpam() ){
				   $statusSpam = "1"; // check potential spam
				   $published = "0";  // unpublish comment
				   echo _MXC_SPAMALERT . "<br />";
				} else {
					$statusSpam = "0";					
				}				
			} else {
				require_once ( $mosConfig_absolute_path . "/administrator/components/com_maxcomment/classes_akismet/php5/Akismet.class.php" );
				$akismet = new Akismet( $MyBlogURL, $WordPressAPIKey );
				$akismet->setCommentAuthor( $name );
				$akismet->setCommentAuthorEmail( $email );
				$akismet->setCommentAuthorURL( '' );
				$akismet->setCommentContent( $comment );
				$akismet->setPermalink( '' );
				if( $akismet->isCommentSpam() ){
				   $statusSpam = "1"; // check potential spam
				   $published = "0";  // unpublish comment
				   echo _MXC_SPAMALERT . "<br />";
				} else {
					$statusSpam = "0";					
				}		
			}						
		}
		
		// Send notify to admin mail
		if ( $mxc_notify=='1' && $statusSpam=='0') {
		
			// multi notify for Admins
			if ( strpos($mxc_notify_email, ";") == true ) $mxc_notify_email = explode( ";", $mxc_notify_email );
						
			$subject = sprintf( _MXC_ADMINMAILSUBJECT, $mosConfig_live_site );
			$subject = stripslashes( $subject );
			$mailtext = stripslashes( _MXC_ADMINMAIL );		
			$mailtext .= "<br /><b>" . _MXC_AUTHOR . "</b>: " . htmlspecialchars( $name, ENT_QUOTES ) . "<br />";
			$mailtext .= "<b>" . _MXC_TITLE . "</b>: " . htmlspecialchars( $title, ENT_QUOTES ) . "<br />";
			$mailtext .= "<b>" ._MXC_COMMENT . "</b>: " . htmlspecialchars( $comment, ENT_QUOTES ) . "<br /><br /><a href=\"" . $articlelink . "\">" . $articlelink . "</a><br /><br />";
			$mailtext .= "<b>" ._MXC_ENTERMAIL . "</b>: " . $email . "<br /><br />";
			$mailtext .= stripslashes(_MXC_ADMINMAILFOOTER);
			$success = mosMail( $mosConfig_mailfrom, $mosConfig_sitename, $mxc_notify_email, $subject, $mailtext, 1 );		
		}		
		
		$email_db 	  =  $database->getEscaped( $email );		
	
		// Subscribes alert on new comment
		if ( $mxc_displaycheckboxcontact=='1' && $published=='1' && $statusSpam=='0') {
			// Check if item article have comments with alert mail
			$query = "SELECT DISTINCTROW id AS subscribeID, `name`, `email` "
					."\nFROM #__mxc_comments "
					."\nWHERE `contentid` = '$contentid ' "
					."\nAND `subscribe`='1' "
					."\nAND `email` != '$email_db' "
					."\nAND `published`='1' "
					."\nAND `status`='0' "
					."\nORDER BY `date` DESC"
					;
			$database->setQuery( $query );
			$rows = $database->loadObjectList();
			if ( $rows ){	
				foreach ( $rows as $row ) {
					$articlelink = sefRelToAbs( "index.php?option=com_content&task=view&id=" . $contentid . $languageUrl . "&Itemid=" . $Itemid );
					$articlelink = $ifsefTurnOff . $articlelink;
					$articlelink = explode( 'http://', $articlelink );
					$articlelink = (count($articlelink)>2) ? "http://".$articlelink[2] : "http://".$articlelink[1];			
					
					$unsubscribelink = sefRelToAbs( "index.php?option=com_maxcomment&task=unsubscribe&id=".$row->subscribeID . "&Itemid=" . $Itemid );
					$unsubscribelink = $ifsefTurnOff . $unsubscribelink;
					$unsubscribelink = explode( 'http://', $unsubscribelink );
					$unsubscribelink = (count($unsubscribelink)>2)?	"http://".$unsubscribelink[2] : "http://".$unsubscribelink[1];
					
					$subject = sprintf( _MXC_ADMINMAILSUBJECT, $mosConfig_live_site );
					$subject = stripslashes( $subject );
					$manesubscribe = stripslashes( $row->name );					
					$mailtext = sprintf(   _MXC_USERSUBSCRIBEMAIL , $manesubscribe );							
					$mailtext .= "<br /><b>" . _MXC_AUTHOR . "</b>: " . htmlspecialchars( $name, ENT_QUOTES ) . "<br />";
					$mailtext .= "<b>" . _MXC_TITLE . "</b>: " . htmlspecialchars( $title, ENT_QUOTES ) . "<br />";
					$mailtext .= "<b>" . _MXC_COMMENT . "</b>: " . htmlspecialchars( $comment, ENT_QUOTES ) . "<br /><br /><a href=\"" . $articlelink . "\">" . $articlelink . "</a><br /><br />";
					$mailtext .= stripslashes( _MXC_UNSUBSCRIBE_TO_COMMENT ) . "<br /><a href=\"" . $unsubscribelink . "\">" . $unsubscribelink . "</a><br /><br />";
					$mailtext .= stripslashes( _MXC_ADMINMAILFOOTER );
					$success = mosMail( $mosConfig_mailfrom, $mosConfig_sitename, $row->email, $subject, $mailtext, 1 );		
				}
			}
		}
		
		$date_db      =  date( 'Y-m-d H:i:s', time() + $mosConfig_offset*60*60 );
		$ip_db        =  getenv('REMOTE_ADDR');		
		$name_db      =  $database->getEscaped( $name );		
		$title_db     =  $database->getEscaped( $title );
		$comment_db   =  $database->getEscaped( $comment );
		$web_db       =  $database->getEscaped( $web );
		
		$query = "INSERT INTO #__mxc_comments SET contentid='".$contentid."', parentid='".$parentid."', `status`='".$statusSpam."', ip='".$ip_db."', `name`='".$name_db."', web='".$web_db."', email='".$email_db."', title='".$title_db."', comment='".$comment_db."', `date`='".$date_db."', published='".$published."', iduser='".$iduser."', subscribe='".$subscribe."', rating='".$rating."', currentlevelrating='".$mxc_levelrating."', lang='". $clang."'"; 
		$database->setQuery( $query );
		$database->query();
		if ($database->GetErrorNum()) echo $database->GetErrorMsg();		
		
		echo stripslashes(_MXC_COMMENT_SAVED);		
		
	} else {
	
		echo stripslashes(_MXC_SECURITYCODE_WRONG);
	
	}	
	
	echo "<br /><br />";
	
	if ( $mxc_openingmode && !$directForm ) {
		echo "$img <a href=\"javascript:window.close();\">" . stripslashes ( _MXC_CLOSE ) . "</a>";	
	} else {
		$gobackitem = sefRelToAbs("index.php?option=com_content&task=view&id=$contentid&Itemid=$Itemid");
		if ( $checkJversion ) $gobackitem = JRoute::_("index.php?option=com_content&task=view&id=$contentid");
		echo "$img <a href='$gobackitem'>". stripslashes ( _MXC_GOBACKITEM ) . "</a>";
	}	
	
	echo "</td></tr></table>";
	
	mosCache::cleanCache();
}

function viewcomment( $option, $cid ) {
	global $database, $mosConfig_live_site, $mosConfig_absolute_path, $my, $Itemid, $mainframe;
	
	require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );	
	
	$goItem = "index.php?option=com_content&task=view&id=$cid&Itemid=$Itemid"; 

	$query = "SELECT id, title FROM #__content WHERE id=" . $cid;
	$database->setQuery( $query );
	$rowT = $database->loadObjectList();	
	$title = stripslashes( $rowT[0]->title );
	
	$limit      = trim( mosGetParam( $_GET, 'limit', $mxc_numcomments ) );
	$limitstart = trim( mosGetParam( $_GET, 'limitstart', 0 ) );	
	$clang      = trim( mosGetParam( $_GET, 'lang', '' ) );	
	
	$query = "SELECT * FROM #__mxc_comments WHERE parentid='0' AND contentid='$cid' AND published='1' AND `status`='0' AND `lang`='$clang'";
	$database->setQuery( $query );
	$total = count($database->loadObjectList());	

	require_once( $mosConfig_absolute_path . '/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );	
	
	$query = "SELECT * FROM #__mxc_comments"
			."\n WHERE parentid='0' AND contentid='$cid' AND published='1' AND `status`='0' AND `lang`='$clang'"
			."\n ORDER BY `date` $mxc_sorting"
			."\n LIMIT $pageNav->limitstart, $pageNav->limit"
			;
	$database->setQuery( $query );
	$rowUserComments = $database->loadObjectList();
	
	HTML_MXC_FRONTEND::viewcomment( $rowUserComments, $pageNav, $limitstart, $limit, $total, $title, $mxc_template, $option, $Itemid, $cid, $goItem, $clang );
	
}

function viewallreplies( $option, $id ) {
	global $database, $mosConfig_live_site, $mosConfig_absolute_path, $my, $Itemid;
	
	require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );	

	$query = "SELECT * FROM #__mxc_comments WHERE id='$id'";
	$database->setQuery( $query );
	$rowUserComments = $database->loadObjectList();		
	$cid = $rowUserComments[0]->contentid;	
	
	$query = "SELECT id, title FROM #__content WHERE id=" . $cid;
	$database->setQuery( $query );
	$rowT = $database->loadObjectList();	
	$title = stripslashes( $rowT[0]->title );
	
	$goItem = "index.php?option=com_content&task=view&id=$cid&Itemid=$Itemid";
	
	$query = "SELECT * FROM #__mxc_comments WHERE parentid='$id' AND published='1' AND `status`='0'";
	$database->setQuery( $query );
	$rowReplies = $database->loadObjectList();	
	
	HTML_MXC_FRONTEND::viewallreplies( $rowUserComments, $rowReplies, $title, $mxc_template, $option, $Itemid, $goItem );

}

function showRelatedItems( $option, $id ) {
	global $mainframe, $database, $mosConfig_absolute_path, $mosConfig_offset, $_VERSION, $my, $Itemid;
	
	$checkJversion = ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5') ? 1 : 0;
	
	require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );	
	require($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');
	
	$mxc_limitrelated = ( $mxc_limitrelated!='' ) ? $mxc_limitrelated : 10 ;
	$goBackItem = "index.php?option=com_content&task=view&id=$id&Itemid=$Itemid"; 
	$img = "&raquo;&nbsp;";

	echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpane\">";
	echo "<tr><td>";
	echo "<div class='contentheading'>" . _MXC_RELATEDARTICLES . "</div>";
	echo "<br />";
	
	$query = "SELECT title FROM #__content WHERE id=" . $id;
	$database->setQuery( $query );
	$title = stripslashes( $database->loadResult() );
	
	echo "<strong>" . _MXC_RELATED_ARTICLE_TO_THIS_ARTICLE . "</strong>";
	echo "&nbsp;&laquo;&nbsp;" . $title . "&nbsp;&raquo;";
	echo "<br />";	

	// check version of product for compatibily Mambo/Joomla!
	if ( $_VERSION->PRODUCT == 'Joomla!' ){	
		$nullDate = $database->getNullDate();
		if ( $_VERSION->RELEASE >= '1.5' ) {
			$now = date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );
		} else $now = _CURRENT_SERVER_TIME;		
	}elseif( $_VERSION->PRODUCT == 'Mambo' ){
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
		
		/*
		if ( $archived ){ 
			$state = "\n AND (a.state = '1' OR a.state = '-1')"; 
		}			
		*/		

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
			. "\n LIMIT $mxc_limitrelated"
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
		
				?>
				<br />
				<ul>
					<?php
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
						if ( $checkJversion ) $href = JRoute::_("index.php?option=com_content&amp;task=view&amp;id=$item->id");
						?>
						<li>
							<a href="<?php echo $href; ?>">
								<?php echo stripslashes( $item->title ); ?></a>
						</li>
						<?php
					}
					?>
				</ul>
				<?php

			} else {			
				echo "<br />";
				echo (_MXC_NO_RELATEDITEM);
			}					
			
		}				
	} else {	
		echo "<br />";
		echo (_MXC_NO_RELATEDITEM);			
	}	
	eval(stripslashes(base64_decode("CWVjaG8gXCI8YnIgLz48YnIgLz5cIiAuICRpbWc7DQoJZWNobyBcIjxhIGhyZWY9XFxcImphdmFzY3JpcHQ6b25jbGljaz1oaXN0b3J5LmJhY2soKTtcXFwiID5cIiAuIChfTVhDX0dPQkFDS0lURU0pIC4gXCI8L2E+PGJyIC8+XCI7DQoJZWNobyBcIjxiciAvPlwiOw0KCWVjaG8gXCI8L3RkPjwvdHI+PC90YWJsZT5cIjsJDQoJX2dldE5vdGljZUNvcHlyaWdodCgpOw0K")));	
}

function unsubscribe ( $option, $id  ) {
	global $database, $mosConfig_absolute_path;
	
	require($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');

	$database->setQuery("UPDATE #__mxc_comments SET subscribe='0' WHERE id='$id'");
	$database->query();
	eval(stripslashes(base64_decode("CWVjaG8gXCI8dGFibGUgd2lkdGg9XFxcIjEwMCVcXFwiIGJvcmRlcj1cXFwiMFxcXCIgY2VsbHBhZGRpbmc9XFxcIjBcXFwiIGNlbGxzcGFjaW5nPVxcXCIwXFxcIiBjbGFzcz1cXFwiY29udGVudHBhbmVcXFwiPlwiOw0KCWVjaG8gXCI8dHI+PHRkPlwiOw0KCWVjaG8gXCI8ZGl2IGNsYXNzPVwnY29udGVudGhlYWRpbmdcJz5cIiAuIF9NWENfVElUTEVfQ09ORklSTV9VTlNVQlNDUklCRSAuIFwiPC9kaXY+XCI7DQoJZWNobyBcIjxiciAvPlwiOw0KCWVjaG8gX01YQ19DT05GSVJNX1VOU1VCU0NSSUJFOw0KCWVjaG8gXCI8YnIgLz5cIjsJDQoJZWNobyBcIjwvdGQ+PC90cj48L3RhYmxlPlwiOw0KCV9nZXROb3RpY2VDb3B5cmlnaHQoKTsJDQo=")));
}
?>