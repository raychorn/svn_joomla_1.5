<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007 by Bernard Gilly        *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $_MAMBOTS, $_VERSION, $option, $mosConfig_absolute_path, $task, $_MXC, $mainframe, $mxc_checkversion;

require_once($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');
require_once( $mosConfig_absolute_path.'/components/com_maxcomment/includes/common/newevaluaterating.php' );
require_once( $mosConfig_absolute_path.'/components/com_maxcomment/includes/ClassMathGuard2.php');    

// Check for compatibility version
$mxc_checkversion = "";
if ( $_VERSION->PRODUCT == 'Joomla!' ){	
	if ( $_VERSION->RELEASE >= '1.5' ) {
		$mxc_checkversion = "Joomla!1.5.x";
	}
}

switch ( $mxc_checkversion ) {
	case "Joomla!1.5.x":
		$mainframe->registerEvent( 'onPrepareContent', 'maxcommentbot15' );
		$mainframe->registerEvent( 'onAfterDisplayContent', 'showContentMXC' );
		break;
	default:
		$_MAMBOTS->registerFunction( 'onPrepareContent', 'maxcommentbot10' );
		$_MAMBOTS->registerFunction( 'onAfterDisplayContent', 'showContentMXC' );
}

function maxcommentbot10( $published , &$row, &$params, $page=0 ) {
	/*
	if ( @$row->content ){
		return;
	}		
	*/
	if ( !$published ) {
		$row->text = str_replace( "{mxc}", "", $row->text );
		$row->text = str_replace( "{mxc::closed}", "", $row->text );
		return;
	}	
	maxcommentbot( $row, $params, $page );	
}

function maxcommentbot15( &$row, &$params, $page=0 ) {
	/*
	if ( @$row->content ){
		return;
	}	
	*/
	maxcommentbot( $row, $params, $page );
}

function maxcommentbot( &$row, &$params, $page=0 ) {
	global $database, $mosConfig_lang, $mosConfig_absolute_path, $mosConfig_locale, $Itemid, $option, $task, $showMXC, $_MXC, $rowUserComments, $mainframe, $_MAMBOTS, $mxc_checkversion;

	switch( $option ){	
	
		case 'com_mamblog':
		case 'com_frontpage':
		case 'com_content':
		
			if ( $mxc_checkversion!='' ){	
				$dir_plugin = 'plugins';
			} else $dir_plugin = 'mambots';
			
			// check if param query has previously been processed
			if ( !isset($_MAMBOTS->_search_mambot_params['maxcomment']) ) {
				// load mambot params info
				$query = "SELECT params"
				. "\n FROM #__$dir_plugin"
				. "\n WHERE element = 'maxcommentbot'"
				. "\n AND folder = 'content'"
				;
				$database->setQuery( $query );
				$database->loadObject($mambot);	
					
				// save query to class variable
				$_MAMBOTS->_content_mambot_params['maxcomment'] = $mambot;
			}
			
			// pull query data from class variable
			$mambot = $_MAMBOTS->_content_mambot_params['maxcomment'];		
			$botParams = new mosParameters( $mambot->params );	
			$notShowOnFrontEnd  = $botParams->def( 'notShowOnFrontEnd', 0 );
			$notShowOnIntro     = $botParams->def( 'notShowOnIntro', 0 );	
			$disabledNativeVote = $botParams->def( 'disabledNativeVote', 0 );	
			$disabledChoiceLang = $botParams->def( 'disabledChoiceLang', 0 );
			$forceKeywordsLang  = $botParams->def( 'forceKeywordsLang', 1 );	
			
			// Get the right language if it exists
			if (file_exists($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php")){
				include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php");
			}else{
				include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/english.php");
			}
		
			require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');
			require_once( $mosConfig_absolute_path."/components/com_maxcomment/maxcomment.class.php");
			
			$seclistarray = @explode ( ",", $mxc_sectionlist );		
			$showMXC = false ;
			$showVR  = false;
			$_MXC->COMMENTCLOSED = false;
			
			// Fix error if $row->sectionid or $row->section not exists
			if ( !isset($row->sectionid ) || !isset($row->section) ) {
					$query = "SELECT a.sectionid, a.catid, a.created_by_alias, a.created_by, a.state, s.name AS section, c.name AS category, e.name AS author"
						. "\n FROM #__content AS a, #__sections AS s, #__categories AS c, #__users AS e"
						. "\n WHERE a.id='$row->id'"
						. "\n AND s.id=a.sectionid"
						. "\n AND c.id=a.catid"
						. "\n AND e.id=a.created_by"
						;
					$database->setQuery( $query );	
					$emptyrow = $database->loadObjectList();			
					if ( $emptyrow ) {
						$row->sectionid = $emptyrow[0]->sectionid;
						$row->section = $emptyrow[0]->section;
						$row->catid = $emptyrow[0]->catid;
						$row->category = $emptyrow[0]->category;
						if ( $emptyrow[0]->created_by_alias!='' ) {
							$row->created_by_alias = $emptyrow[0]->created_by_alias;
							$row->author = $emptyrow[0]->created_by_alias;
						} else {
							$row->created_by_alias = $emptyrow[0]->author;
							$row->author = $emptyrow[0]->author;
						}
						$row->state = $emptyrow[0]->state;
					} else {
						$query = "SELECT a.created_by_alias, a.created_by, e.name AS author"
							. "\n FROM #__content AS a, #__users AS e"
							. "\n WHERE a.id='$row->id'"
							. "\n AND e.id=a.created_by"
							;
						$database->setQuery( $query );	
						$emptyrow1 = $database->loadObjectList();			
						$row->sectionid = "0";
						$row->section = "";
						$row->catid = "0";
						$row->category = "";
						$row->state = "1";
						if ( $emptyrow1 ) {
							if ( $emptyrow1[0]->created_by_alias!='' ) {
								$row->author = $emptyrow1[0]->created_by_alias;
							} else {
								$row->author = $emptyrow1[0]->author;
							}
						} else return false;
					}
			}

			if ( ($mxc_mainmode == "0" || $mxc_mainmode == "2") && ( strpos($row->text, "{mxc}") || strpos($row->text, "{mxc::closed}") ) !== false ) {		  
				$showMXC = true;
			} elseif ( $mxc_mainmode && in_array ( $row->sectionid, $seclistarray ) ) {
				$showMXC = true;
			}
			
			// Prevent load in module
			if ( !isset( $row->title_alias ) ) $showMXC = false;
			
			if ( $mxc_showonarchives=='0' && $row->state < 1) $showMXC = false;
		
			// If not show on front-end only
			if ( $notShowOnFrontEnd && $option=='com_frontpage' ) $showMXC = false;
			
			// If not show on intro
			if ( $notShowOnIntro && $params->get( 'intro_only' ) ) $showMXC = false;
			
			// Replace tag
			$row->text = str_replace( "{mxc}", "", $row->text );	
			$row->text = str_replace( "{moscomment}", "", $row->text );	
			
			if (strpos($row->text, "{mxc::closed}") == true ) {
				$row->text = str_replace( "{mxc::closed}", "", $row->text );	
				$_MXC->COMMENTCLOSED = true;
			}	
			// also if bad tag...
			if (strpos($row->text, "{mxc:closed}") == true ) {
				$row->text = str_replace( "{mxc:closed}", "", $row->text );	
				$_MXC->COMMENTCLOSED = true;
			}
				
			// integration **VisualRecommend**
			if ( $mxc_useVisualRecommend ) {
				require($mosConfig_absolute_path.'/administrator/components/com_visualrecommend/visualrecommend_config.php');
				if ( ($vr_mainmode == "0" || $vr_mainmode == "2") && strpos($row->text, "{visualrecommend}") !== false ) {		  
					$showVR = true;
				} elseif ( $vr_mainmode && in_array ( $row->sectionid, $seclistarray ) ) {
					$showVR = true;
				}		
				$row->text = str_replace( "{visualrecommend}", "", $row->text );	
			}	
			
			$mxclang = "";
			$defaultlangarray = "";
			
			// Prepare content
			if ( $showMXC ){		
				
				if (  substr( $row->text, 0, 2)!='<p' && substr( $row->text, 0, 4)!='<div' ) {
					$row->text = "<br />" . $row->text . "<br />" ;
				}
				
				if ( !@$row->toc ) $row->toc = "";
				$_MXC->CONTENT   = $row->toc.$row->text;
				$_MXC->CONTENTID = $row->id;
				$row->text = "";
				$row->toc  = "";		
				
				// Init language
				if ( file_exists($mosConfig_absolute_path . "/administrator/components/com_joomfish/config.joomfish.php") ) {				
					$GLOBALS['iso_client_mxc'] = $GLOBALS['iso_client_lang'];
					$mxclang = "\n AND lang='" . $GLOBALS['iso_client_mxc'] . "'";					
					if ( $disabledChoiceLang==0 ) MXC_OBJECTS::showLanguageChoice( $row->id, $GLOBALS['iso_client_mxc'] );		
				} else {
					// default language Joomla configuration			
					if( defined("_LANGUAGE") ) {
						$GLOBALS['iso_client_mxc'] = _LANGUAGE;
					} else {
						$defaultlangarray = explode( "_", $mosConfig_locale );
						$GLOBALS['iso_client_mxc'] = $defaultlangarray[0];
					}
				}
				
				$_MXC->CLANG = $GLOBALS['iso_client_mxc'];		
						
				// Load Objects
				if ( $mxc_showcommentusers ) {
					MXC_OBJECTS::showUserCountComment ( $row->id, $mxclang );		
					MXC_OBJECTS::showUserCommentsLink( $row->id, $mxc_showcommentusers, $mxc_template, $mxc_label_showcommentusers, _getItemid($row) );
					MXC_OBJECTS::showUserComments( $row->id, $mxc_sorting, $mxc_numcomments, $mxclang );			
					MXC_OBJECTS::showLinkAddComment ( $row->id, _MXC_ADDYOURCOMMENT, $mxc_numautolimit, $mxc_openingmode, $mxc_width_popup, $mxc_height_popup, $GLOBALS['iso_client_mxc'] );
					MXC_OBJECTS::showReadMoreComments ( $row->id, _MXC_MORECOMMENTS, $mxc_numcomments, $GLOBALS['iso_client_mxc'] );
					MXC_OBJECTS::showFormToAddComment ( $row->id, $GLOBALS['iso_client_mxc'] );
					MXC_OBJECTS::getRssFeedLink();
				}
				if ( $mxc_ratinguser ) {			
					MXC_OBJECTS::showUsersRating( $row->id, $mxc_levelrating, $mxc_template ,_MXC_NO_RATING, _MXC_VOTE, _MXC_VOTES );			
					if ( $disabledNativeVote ) $params->set( 'rating', 0 );
				}
				if ( $mxc_showcommenteditor && $mxc_ratingeditor )	{
					MXC_OBJECTS::showEditorCommentLink( $row->id, $mxc_showcommenteditor, $mxc_template, $mxc_label_showcommenteditor, _getItemid($row) );
					MXC_OBJECTS::showEditorComment( $row->id );
				}	
				if ( $mxc_ratingeditor ) {
					MXC_OBJECTS::showEditorRating( $row->id, $mxc_levelrating, $mxc_template ,_MXC_NO_RATING );			    
				}		
				if ( $mxc_showauthorlink ) {
					MXC_OBJECTS::getAuthorArticle( $row, $mxc_LinkCBProfile );
					if ( $mxc_checkversion=='Joomla!1.5.x' ) {
						$params->set( 'show_author', 0 );
					} else $params->set( 'author', 0 );		    
				}	
				if ( $mxc_showdatecreated )	{
					MXC_OBJECTS::getCreateDate( $row->created, $mxc_showiconnew, $mxc_numdays4showIconNew );
					if ( $mxc_checkversion=='Joomla!1.5.x' ) {
						$params->set( 'show_create_date', 0 );
					} else $params->set( 'createdate', 0 );			
				}
				if ( $mxc_showdatemodified ) {
					MXC_OBJECTS::getLastUpdate( $row );	
					if ( $mxc_checkversion=='Joomla!1.5.x' ) {
						$params->set( 'show_modify_date', 0 );
					} else $params->set( 'modifydate', 0 );	
				}
				if ( $mxc_showsectionlink )	{
					MXC_OBJECTS::getSection( $row );
					if ( $mxc_checkversion=='Joomla!1.5.x' ) {
						$params->set( 'show_section', 0 );
					} else $params->set( 'section', 0 );
				}
				if ( $mxc_showcategorylink ) {
					MXC_OBJECTS::getCategory( $row );
					if ( $mxc_checkversion=='Joomla!1.5.x' ) {
						$params->set( 'show_category', 0 );
					} else $params->set( 'category', 0 );
				}
				if ( $mxc_showkeywordslink ) {
					MXC_OBJECTS::showKeywords( $row, $GLOBALS['iso_client_mxc'], $forceKeywordsLang );
				}		
				if( $mxc_showhits ){			
					$database->setQuery( "SELECT hits FROM #__content WHERE id=$row->id" );
					$rowHits = $database->loadResult();	
					$row->hitsviews = $rowHits;
					MXC_OBJECTS::getHits( $row, $mxc_showiconpopular, $mxc_limitheart1, $mxc_limitheart2, $mxc_limitheart3, $mxc_template );
				}		
				if ( $mxc_showquotelink ) {
					MXC_OBJECTS::showQuoteThis( $row, $mxc_showquotelink, $mxc_template, $mxc_label_quote, $GLOBALS['iso_client_mxc']  );
				}
				if ( $mxc_showfavoured ) {
					MXC_OBJECTS::showFavoured( $row, $mxc_showfavoured, $mxc_template, $mxc_label_favoured );
				}
				if ( $mxc_showprintlink ) {
					MXC_OBJECTS::showPrint( $row, $mxc_showprintlink, $mxc_template, $mxc_label_print, $page, _getItemid($row) );
					if ( $mxc_checkversion=='Joomla!1.5.x' ) {
						$params->set( 'show_print_icon', 0 );
					}			
				}
				if ( $mxc_showsendemaillink ) {
					MXC_OBJECTS::showSendEmail( $row, $mxc_showsendemaillink, $mxc_template, $mxc_label_sendmail, $showVR, _getItemid($row), $task );
					if ( $showVR ) $params->set( 'email', 0 );
					if ( $mxc_checkversion=='Joomla!1.5.x' ) {
						$params->set( 'show_email_icon', 0 );
					}				
				}
				if ( $mxc_showrelatedarticles ) {
					MXC_OBJECTS::showRelatedArticles( $row, $mxc_showrelatedarticles, $mxc_template, $mxc_label_related );
				}
				$_MXC->READMORE = "";
				if ( $mxc_showreadmorelink ) {				
					MXC_OBJECTS::showReadMore( $row, $params, $mxc_showreadmorelink, $mxc_template, $mxc_label_readmore, _getItemid($row) );	
					if ( $mxc_checkversion=='Joomla!1.5.x' && @$row->readmore ) {
						$params->set( 'show_readmore', 0 );
						//$row->readmore_link = "";
					} else $params->set( 'readmore', 0 );					
				}		
				if ( $mxc_showrssfeed ) {
					MXC_OBJECTS::showRssFeed( _MXC_RSSFEED );
				}		
				if ( $mxc_showdeliciouslink ) {
					MXC_OBJECTS::savetodelicious( $row->id, $row->title, $mxc_showdeliciouslink, $mxc_template, $mxc_label_delicious, _getItemid($row) );
				}		
				if ( $mxc_showfavouredcounter ) {
					MXC_OBJECTS::showCountFavoured( $row->id );
				}
				// remove space after title
				echo "\n<style type=\"text/css\">"
				."\n.article_seperator{"
				."\ndisplay:none !important;"
				."\n}"
				."\n</style>\n";				
				return true;
			}
		break;
		
		default:
			return false;
	} // end case component
}

function showContentMXC( &$row, &$params, $page=0 ){
	global $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang, $showMXC, $task, $_MXC, $rowUserComments, $Itemid, $_VERSION, $database, $mxc_checkversion, $option;
	
	// Load mXcomment template
	if ( $showMXC ) {		
		require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');
		
		if ( $mxc_checkversion=='Joomla!1.5.x' ) {
			//if title linkable
			$tempo_url = "";
			$tempo_url_end = "";			
			if ( $params->get('link_titles') && $row->readmore_link != '' ) {
				$tempo_url = "<a href=\"" . $row->readmore_link . "\">";
				$tempo_url_end = "</a>";
			}			
			$tempo ="<table><tr><td class=\"contentheading" . $params->get( 'pageclass_sfx' ) . "\" width=\"100%\">";
			$tempo .= $tempo_url . stripslashes( $row->title ) . $tempo_url_end . "</td></tr></table>";
			$row->title = "";
			echo $tempo;
		}
		?>
		<script language="JavaScript" type="text/JavaScript">	
		<!--//--><![CDATA[//><!--
			function mxclightup(imageobject, opacity){
				 if ((navigator.appName.indexOf("Netscape")!=-1) && (parseInt(navigator.appVersion)>=5)){
					imageobject.style.MozOpacity=opacity/100;
				 } else if ((navigator.appName.indexOf("Microsoft")!= -1) && (parseInt(navigator.appVersion)>=4)){
					imageobject.filters.alpha.opacity=opacity;
				 }
			}		
		//--><!]]>
		</script>
		<?php
		switch( $task ){
			case "show":
				if ( $option!='com_mamblog' ) break;
			case "view":			
				$limitstart = 0;
				require( $mosConfig_absolute_path.'/components/com_maxcomment/templates/'.$mxc_template.'/full.php' );				
				eval(stripslashes(base64_decode("CQkJCWlmICggJF9NWEMtPkNPVU5UQ09NTUVOVCA+IGNvdW50KCAkcm93VXNlckNvbW1lbnRzICkgKSB7DQoJCQkJCWVjaG8gXCI8cCBjbGFzcz1cJ2xpbmttb3JlY29tbWVudHNcJz5cIiAuICAkX01YQy0+TU9SRUNPTU1FTlRTIC4gXCI8L3A+XCI7DQoJCQkJfSBlbHNlaWYgKCAhJF9NWEMtPkNPVU5UQ09NTUVOVCApewkJCQkNCgkJCQkJZWNobyBcIjxwIGNsYXNzPVwnbm9jb21tZW50XCc+XCIgLiAoX01YQ19OT0NPTU1FTlQpIC4gXCI8L3A+XCI7DQoJCQkJfQ0KCQkJCWlmICggJF9NWEMtPkxJTktBRERDT01NRU5UICkgew0KCQkJCQllY2hvIFwiPHAgY2xhc3M9XCdsaW5rYWRkY29tbWVudFwnPlwiIC4gJF9NWEMtPkxJTktBRERDT01NRU5UIC4gXCI8L3A+XCI7DQoJCQkJfQ0KCQkJCWlmICggJF9NWEMtPkNPTU1FTlRDTE9TRUQ9PXRydWUgKSB7DQoJCQkJCWVjaG8gXCI8cCBjbGFzcz1cJ2NvbW1lbnRjbG9zZWRcJz5cIiAuIChfTVhDX0NPTU1FTlRDTE9TRUQpLiBcIjwvcD5cIjsNCgkJCQl9DQoJCQkJX2dldE5vdGljZUNvcHlyaWdodCgpOw0K")));
			break;			
			default:
				require( $mosConfig_absolute_path.'/components/com_maxcomment/templates/'.$mxc_template.'/intro.php' );
		}		
	}	
}
?>