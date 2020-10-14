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

class MXC {

	/** All this vars can be used in template */
	
	/** @var string : show Content Article (intro or fulltext) with all others mambots */
	var $CONTENT = '';
	/** @var string : provide id content article to comment */
	var $CONTENTID = '';
	/** @var string : link to User's comments [image or link]*/
	var $USERCOMMENTS = '';
	/** @var string : Count User's comments for an article */
	var $COUNTCOMMENT = '';
	/** @var string : Link for add a comment */
	var $LINKADDCOMMENT = '';
	/** @var string : Link for readmore */
	var $MORECOMMENTS = '';
	/** @var string : author comment */
	var $AUTHORCOMMENT = '';
	/** @var string : show form to add comment [Direct display, not called by a link]*/
	var $SHOWFORM = '';
	/** @var boolean : close comment for an item*/
	var $COMMENTCLOSED = '';
	
	/** @var string : link to Editor's comment [image or link]*/
	var $EDITORCOMMENT = '';
	/** @var string : Editor's comment Title*/
	var $E_TITLE = '';
	/** @var string : Editor's comment */
	var $E_COMMENT = '';
	/** @var string : Editor's comment Date created*/
	var $E_DATE = '';
	
	/** @var string : show Author article */
	var $AUTHORARTICLE = '';
	/** @var string : show date created */
	var $DATECREATED = '';
	/** @var string : show last update date */
	var $LASTUPDATE = '';
	/** @var string : link to section */
	var $SECTION = '';
	/** @var string : link to category */
	var $CATEGORY = '';
	/** @var string : link to keywords */
	var $KEYWORDS = '';
	/** @var string : link for add this article on del.icio.us [image or link] */
	var $DELICIOUS = '';
	/** @var string : link to quote this article on your website [image or link] */	
	var $QUOTETHIS = '';
	/** @var string : show Hits/views [ + icon popular if enabled] */
	var $HITS = '';
	/** @var string : link to favoured [image or link] */
	var $FAVOURED = '';
	/** @var string : link to print this article [image or link] */
	var $PRINT = '';
	/** @var string : link to send email [image or link] */
	var $SEND = '';
	/** @var string : link to related articles [image or link] */
	var $RELATEDARTICLES = '';
	/** @var string : link to read more [image or link] */
	var $READMORE = '';
	/** @var string : show editor rating [image or notes if level > 5] */
	var $EDITORRATING = '';
	/** @var string : show user rating [image or notes if level > 5] */
	var $USERSRATING = '';
	/** @var string : show num average */
	var $AVERAGE = '';
	/** @var string : show num votes */
	var $VOTES = '';
	/** @var string : show Image for RSS comment */
	var $RSSCOMMENTS = '';
	/** @var string : show link [RSS 2.0] for RSS comment */
	var $RSSCOMMENTSLINK = '';	
	
	/** ADDED IN VERSION 1.0.3 */
	
	/** @var string : show count favoured */
	var $COUNTFAVOURED = '';
	/** @var string : show language Choice */
	var $LANGUAGECHOICE = '';	
	/** @var string : provide current language code (example: en=english, fr=french, ...)*/
	var $CLANG = '';
	
	
	/** ADDED IN VERSION 1.0.7 */
	/** @var boolean : Check version of Joomla */
	var $CHECKJVERSION = 0;
}

$_MXC = new MXC();

global $_VERSION;
$_MXC->CHECKJVERSION = ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5') ? 1 : 0;

if ( $mxc_opacityeffect ) {
	$mxc_opacityeffectpercent2 = ($mxc_opacityeffectpercent/100) ;
	DEFINE("_OPACITY","style=\"filter:alpha(opacity=" . $mxc_opacityeffectpercent . "); -moz-opacity:". $mxc_opacityeffectpercent2 .";\" onMouseOver=\"javascript:mxclightup(this,100);\" onMouseOut=\"javascript:mxclightup(this," . $mxc_opacityeffectpercent . ");\"");
} else DEFINE("_OPACITY","");

class MXC_OBJECTS {

	function showCountFavoured( $cid ) {
		global $_MXC, $my, $database, $Itemid;
		
		$query = "SELECT COUNT(*) FROM #__mxc_favoured WHERE id_content = '$cid'";
		$database->setQuery( $query );
		$countfavoured = $database->loadResult();
		if ( $countfavoured ) {
			$_MXC->COUNTFAVOURED = $countfavoured;
		}else {
			$_MXC->COUNTFAVOURED = _MXC_NONE;
		}
		
		$query = "SELECT id FROM #__mxc_favoured WHERE id_content = '$cid' AND id_user='$my->id'";
		$database->setQuery( $query );
		$rowfavid = $database->loadResult();
		
		if ( $rowfavid && $my->id>0) {
			$link = "<a href='" . sefRelToAbs( "index.php?option=com_maxcomment&task=removefav&favid=$rowfavid&Itemid=$Itemid" ) . "'>";
			if ( $_MXC->CHECKJVERSION ) $link = "<a href=\"" . JRoute::_("index.php?option=com_maxcomment&task=removefav&favid=$rowfavid")."\">";
			$_MXC->COUNTFAVOURED .=  " (" . $link . _MXC_FAVOUREDREMOVE . "</a>)";
		}
	}
	
	function showLanguageChoice( $cid, $currentLang ) {
		global $_MXC, $database, $Itemid;
		
		$_Itemid = ( $Itemid ) ? '&amp;Itemid=' . $Itemid : ''; 				
		
		// Actives languages in Joomfish
		$database->setQuery( 'SELECT * FROM #__languages WHERE active=1 ORDER BY ordering' );
		$rowsLA = $database->loadObjectList();
		if( $rowsLA ) {
			foreach( $rowsLA as $rowLA ) {
				if ( $_MXC->LANGUAGECHOICE !='' ) {
					$_MXC->LANGUAGECHOICE .= ", ";
				}
				$query = "SELECT COUNT(*) FROM #__mxc_comments"
				. "\n WHERE contentid=$cid"
				. "\n AND parentid='0'"
				. "\n AND published='1'"
				. "\n AND status='0'"
				. "\n AND lang='$rowLA->iso'"
				;
				$database->setQuery( $query );	
				$totalCurrentLang = $database->loadResult();
				
				if ( $rowLA->iso != $currentLang ) {					
					if ( $_MXC->CHECKJVERSION ) {					
						$_MXC->LANGUAGECHOICE .= "<a href=\"" . JRoute::_("index.php?option=com_content&task=view&id=$cid&lang=$rowLA->iso")."\">" . $rowLA->name . "</a> (" . $totalCurrentLang . ")";
					} else {
						$_MXC->LANGUAGECHOICE .= "<a href='".sefRelToAbs("index.php?option=com_content&task=view&id=$cid&lang=$rowLA->iso$_Itemid#usercomments")."'>" . $rowLA->name . "</a> (" . $totalCurrentLang . ")";
					}
				} else {
					$_MXC->LANGUAGECHOICE .= $rowLA->name . " (" . $totalCurrentLang . ")";					
				}
			}
			$_MXC->LANGUAGECHOICE = _MXC_COMMENT_LANGUAGE . " " . $_MXC->LANGUAGECHOICE;
		}
	}

	function savetodelicious( $cid, $title, $image, $tpl, $label, $_Itemid ) {
		global $_MXC, $mosConfig_live_site, $mosConfig_sef, $Itemid;
		
		$_Itemid = ( $_Itemid ) ? '&Itemid=' . $_Itemid : ''; 	
		$title = stripslashes( $title );		
		$article = sefRelToAbs("index.php?option=com_content&task=view&id=$cid$_Itemid");
				
		$link = "<a href='http://del.icio.us/post?v=2&url=" . urlencode( $article ) . "&title=" . urlencode( $title ) . "'>";
		
		switch ( $image ) {
			case "2":
				$_MXC->DELICIOUS  = $link;	
				$_MXC->DELICIOUS .= "<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/delicious.gif\"" . _OPACITY . " border=\"0\"  title=\"" . stripslashes( $label ) . "\" alt=\"" . stripslashes($label) . "\" />";
				$_MXC->DELICIOUS .= "</a>";
				break;
			case "1":
			default:
				$_MXC->DELICIOUS = $link . stripslashes( $label ) . "</a>";	
		}		
		
	}

	function showFormToAddComment( $cid, $clang ) {
		global $_MXC, $mosConfig_live_site, $mosConfig_absolute_path, $option, $Itemid, $my, $database, $mosConfig_sef;	
		
		// DIRECT FORM IN TEMPLATE
		
		if ( $_MXC->COMMENTCLOSED==true ) {
		
			$_MXC->SHOWFORM = "";
			
		} else {
		
			require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );
			
			$_MXC->SHOWFORM = "";
			
			if ( $mxc_lengthcomment ) {	
				include($mosConfig_absolute_path."/components/com_maxcomment/includes/common/maxlengthcomment.php");
			}
			
			// check if security image		
			if ( $mxc_use_securityimage && ( file_exists($mosConfig_absolute_path.'/administrator/components/com_securityimages/client.php') ) ) {	
				$useSecurityImage = 1;
				require ($mosConfig_absolute_path.'/administrator/components/com_securityimages/client.php'); 
				$packageName = "securityimage_newpass";
				$mxc_use_mathguard = 0;
			} else $useSecurityImage = 0;
			
			// check if already rating for this article		
			$query = "SELECT COUNT(*) FROM #__mxc_comments WHERE contentid='$cid' AND iduser='$my->id' AND rating > '0'";
			$database->setQuery( $query );
			$alreadyvoting = $database->loadResult();			
			
			$_MXC->SHOWFORM .= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpaneopen\">\n<tr><td>\n";
			
			if ( ($my->id>'0' && $mxc_anonentry=='0') || $mxc_anonentry=='1' ){	
			
				$the_username = ( $mxc_use_name ) ? $my->name : $my->username ;	
		
				
				$_MXC->SHOWFORM .= "		
					<script language=\"JavaScript\" type=\"text/JavaScript\">\n
					function validate(){\n
						if (document.commentForm.comment.value==''){\n
								alert(\"" . _MXC_FORMVALIDATECOMMENT . "\");\n
							}else if (document.commentForm.name.value==''){\n
								alert(\"" . _MXC_FORMVALIDATENAME . "\");\n";
				if ( $mxc_displayemail ) {
					$_MXC->SHOWFORM .= "	
								}else if (document.commentForm.email.value==''){\n
									alert(\"" . _MXC_FORMVALIDATEMAIL . "\");\n";
				}
				if ( $mxc_displaytitle ) {
					$_MXC->SHOWFORM .= "	
								}else if (document.commentForm.title.value==''){\n
									alert(\"" . _MXC_FORMVALIDATETITLE . "\");\n";		
				}
				$_MXC->SHOWFORM .= "	
							} else {\n
								document.commentForm.submit();\n
							}\n
					}\n\n
					
					function x () {\n
						return;\n
					}\n\n
						
					function mxc_smilie(thesmile) {\n
						document.commentForm.comment.value += \" \"+thesmile+\" \";\n
						document.commentForm.comment.focus();\n
					}\n	
					</script>\n\n";	
					
					if ( $mxc_smiliesupport ) {
						// Prepare smiley array
						$smiley[':)']   = "sm_smile.gif";    $smiley[':grin']  = "sm_biggrin.gif";
						$smiley[';)']   = "sm_wink.gif";     $smiley['8)']     = "sm_cool.gif";
						$smiley[':p']   = "sm_razz.gif";     $smiley[':roll']  = "sm_rolleyes.gif";
						$smiley[':eek'] = "sm_bigeek.gif";   $smiley[':upset'] = "sm_upset.gif";
						$smiley[':zzz'] = "sm_sleep.gif";    $smiley[':sigh']  = "sm_sigh.gif";
						$smiley[':?']   = "sm_confused.gif"; $smiley[':cry']   = "sm_cry.gif";
						$smiley[':(']   = "sm_mad.gif";      $smiley[':x']     = "sm_dead.gif";		
					}
		
					if ( $mxc_bbcodesupport ) {
						$_MXC->SHOWFORM .= "<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_maxcomment/includes/js/prototype.js\"></script>\n";
						$_MXC->SHOWFORM .= "<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_maxcomment/includes/js/control.textarea.js\"></script>\n";
						$_MXC->SHOWFORM .= "<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_maxcomment/includes/js/control.textarea.bbcode.js\"></script>\n";
		
						$_MXC->SHOWFORM .= "<style>\n
						#comment {
							width:100%;
							height:100px;
						}
			
						#bbcode_toolbar {
							position:relative;
							list-style:none;
							border:1px solid #d7d7d7;
							background-color:#F6F6F6;
							margin:0;
							padding:0;
							height:18px;
							margin-bottom:2px;
						}
			
						#bbcode_toolbar li {
							float:left;
							list-style:none;
							margin:0;
							padding:0;
						}
			
						#bbcode_toolbar li a {
							width:24px;
							height:16px;
							float:left;
							display:block;
							background-image:url(\"$mosConfig_live_site/components/com_maxcomment/includes/js/bbcode_icons.gif\");
							border:1px solid #fff;
							border-right-color:#d7d7d7;
						}
			
						#bbcode_toolbar li a:hover {
							border-color:#900;
						}
			
						#bbcode_toolbar li span {
							display:none;
						}
			
						#bbcode_toolbar li a#bbcode_help_button {
							position:absolute;
							top:0;
							right:0;
							border-left-color:#d7d7d7;
							border-right-color:#fff;
						}
			
						#bbcode_toolbar li a#bbcode_help_button:hover {
							border-left-color:#900;
							border-right-color:#900;
						}
			
						#bbcode_italics_button { background-position: 0 -119px; }
						#bbcode_bold_button { background-position: 0 -102px; }
						#bbcode_underline_button { background-position: 0 -306px; }
						#bbcode_link_button { background-position: 0 0; }
						#bbcode_image_button { background-position: 0 -170px; }
						#bbcode_unordered_list_button { background-position: 0 -34px; }
						#bbcode_ordered_list_button { background-position: 0 -51px; }
						#bbcode_quote_button { background-position: 0 -68px; }
						#bbcode_code_button { background-position: 0 -136px; }
						#bbcode_help_button { background-position: 0 -153px; }
					</style>\n
					";
				}
								
				$destination = "index.php?option=com_maxcomment&task=savecomment&Itemid=$Itemid";
			
					$_MXC->SHOWFORM .= "<form action=\"" . $destination . "\" method=\"post\" name=\"commentForm\" id=\"commentForm\">\n			
						
						<table width=\"100%\" class=\"contentpane\">\n 
						  <tr>\n
							<td width=\"20%\" align=\"right\">" . stripslashes( _MXC_ENTERNAME ) . "</td>\n
							<td width=\"80%\">\n";
		 
							if ( $my->id ) {				
								$_MXC->SHOWFORM .= "&#187; "; 
								$_MXC->SHOWFORM .= stripslashes( $the_username );
								$_MXC->SHOWFORM .= "<input type=\"hidden\" name=\"name\" value=\"" . stripslashes ( $the_username ) . "\" />\n";  
							} else {
								$_MXC->SHOWFORM .= "<input class=\"inputbox\" type=\"text\" name=\"name\" size=\"40\" maxlength=\"30\" value=\"\" />\n";
							} 
							
							$_MXC->SHOWFORM .= "</td>\n
						  </tr>\n";
						  
						  if ( $mxc_displayemail ) {						  
							  $_MXC->SHOWFORM .= "
							  <tr>\n
								<td width=\"20%\" align=\"right\">" . stripslashes ( _MXC_ENTERMAIL ) . "</td>\n
								<td width=\"80%\"><input name=\"email\" type=\"text\" class=\"inputbox\" value=\"" . $my->email ."\" size=\"40\" maxlength=\"254\" />\n						
								</td>\n	
							  </tr>\n
							  ";	
						  } else {						  
						  	$_MXC->SHOWFORM .= "<input type=\"hidden\" name=\"email\" value=\"\" />";
						  }
						  
						if ( $mxc_ratinguser ) {
							// Build rating list 		
							$rate[] = mosHTML::makeOption( '0', _MXC_NO_RATING );		
							for ( $count=1; $count<=$mxc_levelrating; $count++ ){
								$rate[] = mosHTML::makeOption( $count, $count . '/' . $mxc_levelrating );	
							}
							if ( $mxc_levelrating=='5' ){
								$javascript = " onchange=\"javascript:if (document.commentForm.rating.options[selectedIndex].value!='0') {document.imagelib.src='$mosConfig_live_site/components/com_maxcomment/templates/$mxc_template/images/rating/user_rating_' + document.commentForm.rating.options[selectedIndex].value + '.gif'} else {document.imagelib.src='$mosConfig_live_site/components/com_maxcomment/templates/$mxc_template/images/rating/user_rating_0.gif'}\"";
							} else $javascript = "";
							$rlist = mosHTML::selectList( $rate, 'rating', 'class="inputbox" size="1"' . $javascript, 'value', 'text', '' );
						}
			  
						  if ( $mxc_ratinguser && $my->id && $alreadyvoting=='0' ) { 
						  $_MXC->SHOWFORM .= "<tr>
							<td valign=\"top\" align=\"right\">" .  stripslashes ( _MXC_RATING ) . "</td>
							<td>\n";
							
							$_MXC->SHOWFORM .=  $rlist;
								if ( $mxc_levelrating=='5' ) { 
								
							  $_MXC->SHOWFORM .= "<script language=\"javaScript\" type=\"text/javaScript\">
								<!--
								if (document.commentForm.rating.options.value!='0'){
									jsimg='" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $mxc_template . "/images/rating/user_rating_' + getSelectedValue( 'commentForm', 'rating' ) + '.gif';
								} else {
									jsimg='" . $mosConfig_live_site ."/components/com_maxcomment/templates/" . $mxc_template . "/images/rating/user_rating_0.gif';
								}
								document.write(' <img src=' + jsimg + ' name=\"imagelib\" border=\"0\" align=\"middle\" alt=\"\" />');
								//-->
							  </script>\n";
							  
								 } 							 
								
								$_MXC->SHOWFORM .= "</td>\n</tr>\n";
	
						  } else {
	
						  $_MXC->SHOWFORM .= "<input type=\"hidden\" name=\"rating\" value=\"0\" />\n";
	
						  }					  
			  			  if ( $mxc_displaytitle ) {
							  $_MXC->SHOWFORM .= "<tr>\n
								<td valign=\"top\" align=\"right\">" . stripslashes ( _MXC_TITLE ) . "</td>
								<td>
								  <input name=\"title\" type=\"text\" class=\"inputbox\" value=\"\" size=\"40\" maxlength=\"40\" />&nbsp;
								</td>
							  </tr>\n";
						  } else {						  
						  	$_MXC->SHOWFORM .= "<input type=\"hidden\" name=\"title\" value=\"\" />";
						  }
						  
						  if ( $mxc_smiliesupport ) {					   
							  $_MXC->SHOWFORM .= "<tr>\n<td valign=\"top\" align=\"right\">&nbsp;</td>\n<td>\n";	
								foreach ($smiley as $i=>$sm) {
								  $_MXC->SHOWFORM .= "<a href=\"javascript:mxc_smilie('$i')\" title='$i'><img src='$mosConfig_live_site/components/com_maxcomment/images/smilies/$sm' border='0' /></a> ";
								}	
								$_MXC->SHOWFORM .= "</td>\n</tr>\n<tr>\n";						
						  } 
						  
						  $_MXC->SHOWFORM .= "<td valign=\"top\" align=\"right\">" . stripslashes ( _MXC_COMMENT ) . "</td>\n
							<td>\n
							  <textarea class=\"inputbox\" cols=\"50\" rows=\"6\" name=\"comment\" id=\"comment\" onKeyDown=\"countlengthcomment(this.form.comment, 'compteur', " . $mxc_lengthcomment .");\" onKeyUp=\"countlengthcomment(this.form.comment, 'compteur', " . $mxc_lengthcomment . ");\" onFocus=\"showInputField('compteur', this.form.comment, " . $mxc_lengthcomment . ");\"></textarea>\n";
							   if ( $mxc_bbcodesupport ) { 
							   
								$_MXC->SHOWFORM .= "<script>\n
									bbcode_toolbar = new Control.TextArea.ToolBar.BBCode('comment');\n
									bbcode_toolbar.toolbar.toolbar.id = 'bbcode_toolbar';\n
								</script>\n";
							  } 
							  
						$_MXC->SHOWFORM .= "</td>\n</tr>\n";
						
						 if ( $mxc_lengthcomment ) {					 
							 $_MXC->SHOWFORM .= "<tr>\n<td valign=\"top\" align=\"right\">&nbsp;</td>\n<td valign=\"top\" align=\"left\"><div id=\"compteur\">" . _MXC_NUM_CHARCARTERS . " " . $mxc_lengthcomment."<br /></div></td></tr>\n";
						 } 
						 
						  $_MXC->SHOWFORM .= "<tr>\n
							<td valign=\"top\" align=\"right\">&nbsp;</td>\n
							<td>\n";
	
							if ( $mxc_displaycheckboxcontact && $mxc_displayemail ) {
	
							 $_MXC->SHOWFORM .= "<input type=\"checkbox\" name=\"subscribe\" id=\"subscribe\" class=\"inputbox\" value=\"1\" />&nbsp;" . stripslashes ( _MXC_NOTIFY_ME_FOLLOW_UP ) ;
	
							} else {
	
								$_MXC->SHOWFORM .= "<input type=\"hidden\" name=\"subscribe\" id=\"subscribe\" value=\"0\" />\n";
							}	
									
							$_MXC->SHOWFORM .= "</td>\n</tr>\n";
							
							if ( $my->id ) {
								// no security check if registered
								$useSecurityImage  = 0;
								$mxc_use_mathguard = 0;
							}
							
						  if ( $useSecurityImage ) {					  
							$_MXC->SHOWFORM .= "<tr>\n<td valign=\"top\" align=\"right\">&nbsp;</td>\n<td>\n";								
							$_MXC->SHOWFORM .=  insertSecurityImage($packageName) . "<br />";
							$_MXC->SHOWFORM .= getSecurityImageTextHeader() . "<br />";
							$_MXC->SHOWFORM .= getSecurityImageField($packageName) . "<br />";
							//$_MXC->SHOWFORM .= getSecurityImageTextHelp();			
							$mxc_use_mathguard = 0;
							$_MXC->SHOWFORM .= "</td>\n</tr>\n";						
						  } 
						  if ( $mxc_use_mathguard ) {
						  	$_MXC->SHOWFORM .= "<tr>\n<td valign=\"top\" align=\"right\">&nbsp;</td>\n<td>\n"; 							 
							$_MXC->SHOWFORM .= MathGuard2::insertQuestion2();
							$_MXC->SHOWFORM .= "</td>\n</tr>\n";
						  }						  
						  
						  $_MXC->SHOWFORM .= "<tr>\n
							<td valign=\"top\" align=\"right\">&nbsp;</td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td valign=\"top\" align=\"right\">&nbsp;</td>
							<td><input type=\"button\" name=\"Submit\" value=\"" . _MXC_BUTTON_SUBMIT . "\" class=\"button\" onClick=\"javascript:validate()\" />&nbsp;
						<input type=\"reset\" name=\"Submit2\" value=\"" . _MXC_RESET . "\" class=\"button\" /></td>
						  </tr>
						</table>
						<input type=\"hidden\" name=\"cid\" value=\"" . $cid . "\" />
						<input type=\"hidden\" name=\"parentid\" value=\"0\" />
						<input type=\"hidden\" name=\"published\" value=\"" . $mxc_autopublish . "\" />
						<input type=\"hidden\" name=\"iduser\" value=\"" . $my->id . "\" />
						<input type=\"hidden\" name=\"lang\" value=\"" . $clang . "\" />
						<input type=\"hidden\" name=\"option\" value=\"com_maxcomment\" />				
						<input type=\"hidden\" name=\"task\" value=\"savecomment\" />
						<input type=\"hidden\" name=\"directForm\" value=\"1\" />
						</form>
						<br />\n
						";
			} else {
				$_MXC->SHOWFORM .= stripslashes ( _MXC_COMMENTONLYREGISTERED );			
			}
			$_MXC->SHOWFORM .= "\n</td></tr></table>\n";
			
		}

	}

	function showRssFeed( $label ) {
		global $_MXC, $mosConfig_live_site, $mosConfig_absolute_path, $Itemid;
		
		require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );
		
		if ( file_exists( $mosConfig_absolute_path . "/components/com_maxcomment/templates/$mxc_template/images/rss.gif" ) ) {	
			$imgrss = $mosConfig_live_site . "/components/com_maxcomment/templates/$mxc_template/images/rss.gif";
		} else $imgrss = $mosConfig_live_site . "/components/com_maxcomment/images/rss.gif";		
		
		$_MXC->RSSCOMMENTS = "<a href='index.php?option=com_maxcomment&task=feed&Itemid=$Itemid'><img src='$imgrss' border='0' style='vertical-align:middle;' alt='" . $label . "' /></a>";
		
	}
	
	function getRssFeedLink() {
		global $_MXC, $mosConfig_live_site, $mosConfig_absolute_path, $Itemid;
		
		require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );
	
		$_MXC->RSSCOMMENTSLINK = "<a href='index.php?option=com_maxcomment&task=feed&Itemid=$Itemid'>RSS 2.0</a>";
		
	}

	function showUserCommentsLink ( $cid, $image, $tpl, $label, $_Itemid ) {
		global $_MXC, $mosConfig_live_site, $mosConfig_sef, $Itemid;

		// use by anchor if no SEO
		$anchor = (!$mosConfig_sef)? "#usercomments": "";		
		
		$_Itemid = ( $_Itemid ) ? '&amp;Itemid=' . $_Itemid : ''; 		
		$link = "<a href='".sefRelToAbs("index.php?option=com_content&task=view&id=$cid$_Itemid$anchor")."'>";	
		if ( $_MXC->CHECKJVERSION ) $link = "<a href=\"" . JRoute::_("index.php?option=com_content&task=view&id=$cid") . "\">";
			
		switch ( $image ) {
			case "2":
				$_MXC->USERCOMMENTS  = $link;	
				$_MXC->USERCOMMENTS .= "<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/usercomments.gif\" " . _OPACITY . " border=\"0\" title=\"" . stripslashes($label) . "\" alt=\"" . stripslashes($label) . "\" />";
				$_MXC->USERCOMMENTS .= "</a>";
				break;
			case "1":
			default:
				if ( $_MXC->COUNTCOMMENT ) {
					$_MXC->USERCOMMENTS = $link . stripslashes($label) . "</a> (" . $_MXC->COUNTCOMMENT . ")";
				} else $_MXC->USERCOMMENTS = $link . stripslashes( _MXC_WRITEFIRSTCOMMENT ) . "</a>";
		}		
	}
	
	function showLinkAddComment ( $cid, $label, $maxcomment, $popup=1, $width_popup, $height_popup, $clang ) {
		global $_MXC, $mosConfig_live_site, $Itemid;	
		
		if ( $_MXC->COMMENTCLOSED==true ) {
		
			$_MXC->LINKADDCOMMENT = "";
			
		} else {
			
			$width_popup  = ( $width_popup!=''  ) ? $width_popup  : "420"  ;
			$height_popup = ( $height_popup!='' ) ? $height_popup : "550"  ;
			
			if( !$maxcomment || $maxcomment > $_MXC->COUNTCOMMENT ) {
			
				switch ( $popup ) {			
					case 0 :
						$link = sefRelToAbs("index.php?option=com_maxcomment&task=addcomment&id=" . $cid . "&lang=" . $clang . "&Itemid=" . $Itemid);
						if ( $_MXC->CHECKJVERSION ) $link = JRoute::_( "index.php?option=com_maxcomment&task=addcomment&id=" . $cid . "&lang=" . $clang );
						$_MXC->LINKADDCOMMENT = "<a href='" . $link . "'>" . $label . "</a>";	
						break;
					case 1 :
						$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width='.$width_popup.',height='.$height_popup.',directories=no,location=no';					
						$link = $mosConfig_live_site . "/index2.php?option=com_maxcomment&amp;task=addcomment&amp;id=" . $cid . "&amp;pop=1&amp;lang=" . $clang. "&amp;Itemid=" . $Itemid;
						$_MXC->LINKADDCOMMENT = "<a href=\"".$link."\" target=\"_blank\" onclick=\"window.open('" . $link . "','win2','" . $status . "'); return false;\">" . $label . "</a>";
						break;					
				}
				
			}
		}

	}
	
	function showReadMoreComments ( $cid, $label, $maxnumcomments, $clang ) {
		global $_MXC, $Itemid;		
	
		$link = "<a href='".sefRelToAbs("index.php?option=com_maxcomment&amp;task=viewcomment&amp;id=". $cid ."&amp;lang=" . $clang . "&amp;Itemid=". $Itemid . "&amp;limitstart=" . $maxnumcomments . "&amp;limit=" . $maxnumcomments) . "'>";	;
		if ( $_MXC->CHECKJVERSION ) $link = "<a href=\"" . JRoute::_("index.php?option=com_maxcomment&amp;task=viewcomment&id=". $cid ."&lang=" . $clang . "&limitstart=" . $maxnumcomments . "&limit=" . $maxnumcomments) . "\">";
		
		$_MXC->MORECOMMENTS = $link . $label . "</a>";

	}
	
	function showUserComments( $cid, $sorting, $commentperpage, $mxclang ){
		global $database, $rowUserComments;

		$query = "SELECT *, CONCAT('maxcomment', id) AS anchor FROM #__mxc_comments"
		. "\n WHERE contentid=$cid"
		. "\n AND published='1'"
		. "\n AND status='0'"
		. "\n AND parentid='0'"
		. $mxclang
		. "\n ORDER BY date $sorting"
		. "\n LIMIT $commentperpage"
		;
		$database->setQuery( $query );	
		$rowUserComments = $database->loadObjectList();
	}
	
	function showUserCountComment( $cid, $mxclang ){	
		global $_MXC, $database;

		$query = "SELECT COUNT(*) FROM #__mxc_comments"
		. "\n WHERE contentid=$cid"
		. "\n AND parentid='0'"
		. "\n AND published='1'"
		. "\n AND status='0'"
		. $mxclang
		;
		$database->setQuery( $query );	
		$_MXC->COUNTCOMMENT = $database->loadResult();
	}
	
	function showEditorCommentLink( $cid, $image, $tpl, $label, $_Itemid) {
		global $_MXC, $mosConfig_live_site, $mosConfig_sef, $Itemid;
		
		// use by anchor if no SEO
		$anchor = (!$mosConfig_sef)? "#editorcomment": "";		
		
		$_Itemid = ( $_Itemid ) ? '&amp;Itemid=' . $_Itemid : ''; 		
		$link = "<a href='".sefRelToAbs("index.php?option=com_content&task=view&id=$cid$_Itemid$anchor")."'>";
		if ( $_MXC->CHECKJVERSION ) $link = "<a href=\"" . JRoute::_("index.php?option=com_content&task=view&id=$cid") . "\">";
			
		switch ( $image ) {
			case "2":
				$_MXC->EDITORCOMMENT  = $link;	
				$_MXC->EDITORCOMMENT .= "<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/editorcomment.gif\" " . _OPACITY . " border=\"0\" title=\"" . stripslashes($label) . "\" alt=\"" . stripslashes($label) . "\" />";
				$_MXC->EDITORCOMMENT .= "</a>";
				break;
			case "1":
			default:
				$_MXC->EDITORCOMMENT = $link . stripslashes($label) . "</a>";	
		}		
	}
	
	function showEditorComment( $cid ) {
		global $_MXC, $database, $mosConfig_live_site, $mosConfig_absolute_path;
				
		require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );
		
		$query = "SELECT * FROM #__mxc_admcomments"
		. "\n WHERE contentid=$cid"
		. "\n AND published='1'"
		;
		$database->setQuery( $query );	
		$rowEC = $database->loadObjectList();		
		if ( $rowEC ) {				
			// Prepare smiley array
			$smiley[':)']     = "sm_smile.gif";    $smiley[':grin']  = "sm_biggrin.gif";
			$smiley[';)']     = "sm_wink.gif";     $smiley['8)']     = "sm_cool.gif";
			$smiley[':p']     = "sm_razz.gif";     $smiley[':roll']  = "sm_rolleyes.gif";
			$smiley[':eek']   = "sm_bigeek.gif";   $smiley[':upset'] = "sm_upset.gif";
			$smiley[':zzz']   = "sm_sleep.gif";    $smiley[':sigh']  = "sm_sigh.gif";
			$smiley[':?']     = "sm_confused.gif"; $smiley[':cry']   = "sm_cry.gif";
			$smiley[':(']     = "sm_mad.gif";      $smiley[':x']     = "sm_dead.gif";
			
			$rowE = $rowEC[0];
			$_MXC->E_TITLE   = stripslashes( $rowE->title );
			$_MXC->E_COMMENT = stripslashes( $rowE->comment );
			$_MXC->E_COMMENT = mxcParse( $_MXC->E_COMMENT, $smiley, $mxc_bbcodesupport, $mxc_picturesupport, $mxc_smiliesupport, $mosConfig_live_site );
			$_MXC->E_DATE    = $rowE->date;					
		}		
	}

	function showEditorRating( $rid, $level, $tpl, $no_rating ) {
		global $_MXC, $database, $mosConfig_live_site;		
		
		$query = "SELECT rating, currentlevelrating"
		. "\n FROM #__mxc_admcomments"
		. "\n WHERE contentid=$rid"
		. "\n AND published='1'"
		;
		$database->setQuery( $query );	
		//$rowER = $database->loadResult();
		$rows = $database->loadObjectList();	
		
		if ( !$rows ) {		
			$rowER = "0";
			$rowLevel = "0";
		} else {
			$rowER = $rows[0]->rating;
			$rowLevel = $rows[0]->currentlevelrating;		
			$rowER = intval( confirm_evaluate( $rowER, $rowLevel, $level ) );
		}
		switch ( $level ) {
			case "20":				
			case "10":
				if ( $rowER > 0 ) {
					$_MXC->EDITORRATING = $rowER . "/" . $level;
				} else {
					$_MXC->EDITORRATING = $no_rating;
				}
				break;
			case "5":
			default:				
				$_MXC->EDITORRATING = "<img src='" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/rating/editor_rating_" . $rowER . ".gif' align='middle' border='0' alt='' />";
		}				
	}

	function showUsersRating( $rid, $level, $tpl, $no_rating, $label_vote, $label_votes ) {
		global $_MXC, $database, $mosConfig_live_site;		
		
		$_MXC->VOTES   = 0;		
		$_MXC->AVERAGE = 0;
		$totalRating   = 0;
		$dec           = 0;
		
		$query = "SELECT COUNT(rating) AS countuser"
		. "\n FROM #__mxc_comments"
		. "\n WHERE contentid=$rid"
		. "\n AND rating > '0'"
		. "\n AND iduser > '0'"
		. "\n AND published='1'"
		. "\n AND status='0'"
		;
		$database->setQuery( $query );	
		$rowUR = $database->loadResult();		
		if ( $rowUR ) $_MXC->VOTES = $rowUR;
		
		$query = "SELECT rating, currentlevelrating"
		. "\n FROM #__mxc_comments"
		. "\n WHERE contentid=$rid"
		. "\n AND rating > '0'"
		. "\n AND iduser > '0'"
		. "\n AND published='1'"
		. "\n AND status='0'"
		;
		$database->setQuery( $query );	
		$rowsRating = $database->loadObjectList();		
			
		if ( count($rowsRating) ) {
			foreach ( $rowsRating as $rowRating ) {
			   // recalculate
				$totalRating = $totalRating + confirm_evaluate( $rowRating->rating, $rowRating->currentlevelrating, $level );			
			}			
			$_MXC->AVERAGE = number_format( ( $totalRating / $_MXC->VOTES), 1 );
	
			$dec = MXC_OBJECTS::fract_part( $_MXC->AVERAGE );	
			
			if ( $dec==0 ) {
				$_MXC->AVERAGE = intval( $_MXC->AVERAGE );
			}			
		}
		
		if ( $_MXC->VOTES < 2 ) {		
			$label4numbervote = "&nbsp;&nbsp;&nbsp;(" . $_MXC->VOTES . " " .  $label_vote . ")";		
		} else $label4numbervote = "&nbsp;&nbsp;&nbsp;(" . $_MXC->VOTES . " " .  $label_votes . ")";			
		
 		
		switch ( $level ) {
			case "20":				
			case "10":			
					$_MXC->USERSRATING = $_MXC->AVERAGE . "/" . $level . $label4numbervote;					
					if ( $_MXC->VOTES == 0 ) $_MXC->USERSRATING = $no_rating;
				break;
			case "5":
			default:				
				if ( $dec >= 0.5 ) {
					$average = intval( $_MXC->AVERAGE ) . "a" ;
				} else {					
					$average = intval( $_MXC->AVERAGE );
				}
				if ( $average == '0' ) $_MXC->AVERAGE = "";
				$_MXC->USERSRATING = "<img src='" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/rating/user_rating_" . $average . ".gif' align='middle' border='0' alt='' />" . $label4numbervote;
		}			
		
		
	}

	function getAuthorArticle( &$row, $cb ) {
		global $_MXC, $my;
				
		$authorarticle = ( $row->created_by_alias ) ? $row->created_by_alias : $row->author ; 
		
		$checkCBcomponent = MXC_OBJECTS::checkCBcomponent();
		
			//if( $cb && $checkCBcomponent && $my->id ){
			if( $cb && $checkCBcomponent ){
				$link = sefRelToAbs( 'index.php?option=com_comprofiler&amp;task=userProfile&amp;user=' . $row->created_by . MXC_OBJECTS::CBAuthorItemid() );
				if ( $_MXC->CHECKJVERSION ) $link = "<a href=\"" . JRoute::_("index.php?option=com_comprofiler&task=userProfile&user=" . $row->created_by . MXC_OBJECTS::CBAuthorItemid() ) . "\">";
				$_MXC->AUTHORARTICLE = "<a href='" . $link . "'>" . $authorarticle . "</a>";
			} else {
				$_MXC->AUTHORARTICLE = $authorarticle ;
			}
	}

	function getCreateDate( $datecreated, $showiconnew, $numdays4showIconNew ) {
		global $_MXC, $mosConfig_live_site, $mosConfig_absolute_path;
		
		require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );
		
		$iconnew = "";
		
		if ( intval( $datecreated ) != 0 ) {
			$_MXC->DATECREATED = mosFormatDate( $datecreated, $mxc_fdate );	
			$cdate = $datecreated;
			$cjour = substr($cdate,8,2); 
			$cmois = substr($cdate,5,2); 
			$cannee = substr($cdate,0,4); 		
			$timestamp = mktime( 0, 0, 0, $cmois, $cjour, $cannee );
			$cmaintenant = time();							
			$ecart_secondes = $cmaintenant - $timestamp;
			$ecart_jours = floor($ecart_secondes / (60*60*24)); 
					
			if ( $showiconnew && intval( $numdays4showIconNew ) > 0 ) {
				if ( $ecart_jours <= $numdays4showIconNew ){
					$iconnew =  "&nbsp;&nbsp;<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/$mxc_template/images/new.gif\" align=\"middle\" alt=\"\" />";
				}
				$_MXC->DATECREATED .= $iconnew;				
			}
		}
	}
	
	function getLastUpdate( &$row ) {
		global $_MXC, $mosConfig_absolute_path;
		
		require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );
		
		if ( intval( $row->modified ) != 0) {
			$_MXC->LASTUPDATE = mosFormatDate( $row->modified, $mxc_fdate );
		} else $_MXC->LASTUPDATE = mosFormatDate( $row->created, $mxc_fdate );	
	}

	function getSection( &$row ) {
		global $_MXC;
		$link_s = "index.php?option=com_content&task=section&id=".$row->sectionid."&Itemid="._getItemid($row);	
		$_MXC->SECTION = "<a href='" . sefRelToAbs( $link_s ) . "'>" . $row->section . "</a>";
		if ( $_MXC->CHECKJVERSION ) $_MXC->SECTION = "<a href=\"" . JRoute::_("index.php?option=com_content&task=section&id=".$row->sectionid) . "\">" . $row->section . "</a>";	
	}
	
	function getCategory( &$row ) {
		global $_MXC;
		$link_c = "index.php?option=com_content&task=category&sectionid=".$row->sectionid."&id=".$row->catid."&Itemid="._getItemid($row);
		$_MXC->CATEGORY = "<a href='" . sefRelToAbs( $link_c ) . "'>" . $row->category . "</a>";
		if ( $_MXC->CHECKJVERSION ) $_MXC->CATEGORY = "<a href=\"" . JRoute::_("index.php?option=com_content&task=category&sectionid=".$row->sectionid."&id=".$row->catid) . "\">" . $row->category . "</a>";	
	}
	
	function getHits( &$row, $popu, $mxc_limitheart1, $mxc_limitheart2, $mxc_limitheart3, $tpl ) {
		global $_MXC, $mosConfig_live_site;
		$_MXC->HITS = $row->hitsviews;
		if ( $popu && $row->hitsviews ){
			switch ( $row->hitsviews ) {
				case ( $row->hitsviews >= $mxc_limitheart3 ):
					$_MXC->HITS .= "&nbsp;&nbsp;&nbsp;&nbsp;<img src='".$mosConfig_live_site."/components/com_maxcomment/templates/".$tpl."/images/icon_popular_3.gif' align='middle' alt='' />";
					break;
				case ( $row->hitsviews >= $mxc_limitheart2 ):
					$_MXC->HITS .= "&nbsp;&nbsp;&nbsp;&nbsp;<img src='".$mosConfig_live_site."/components/com_maxcomment/templates/".$tpl."/images/icon_popular_2.gif' align='middle' alt='' />";
					break;
				case ( $row->hitsviews >= $mxc_limitheart1 ):
					$_MXC->HITS .= "&nbsp;&nbsp;&nbsp;&nbsp;<img src='".$mosConfig_live_site."/components/com_maxcomment/templates/".$tpl."/images/icon_popular_1.gif' align='middle' alt='' />";
					break;
				case ( $row->hitsviews < $mxc_limitheart1 ):					
				default:				
					$_MXC->HITS = $row->hitsviews;
			}	
		}
	}
	
	function showQuoteThis( &$row, $image, $tpl, $label, $clang='' ) {
		global $_MXC, $mosConfig_live_site, $Itemid;
		
		$link = "<a href='".sefRelToAbs("index.php?option=com_maxcomment&task=quote&id=$row->id&lang=$clang&Itemid=$Itemid")."'>";		
		if ( $_MXC->CHECKJVERSION ) $link = "<a href=\"" . JRoute::_("index.php?option=com_maxcomment&task=quote&id=$row->id&lang=$clang") . "\">";
		switch ( $image ) {
			case "2":
				$_MXC->QUOTETHIS  = $link;	
				$_MXC->QUOTETHIS .= "<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/quotethis.gif\" " . _OPACITY . " border=\"0\" title=\"" . stripslashes($label) . "\" alt=\"" . stripslashes($label) . "\" />";
				$_MXC->QUOTETHIS .= "</a>";
				break;
			case "1":
			default:
				$_MXC->QUOTETHIS = $link . stripslashes($label) . "</a>";	
		}	
	}

	function showFavoured( &$row, $image, $tpl, $label ) {
		global $_MXC, $database, $mosConfig_live_site, $Itemid;
		
		$link = "<a href='".sefRelToAbs("index.php?option=com_maxcomment&task=favoured&id=$row->id&Itemid=$Itemid")."'>";		
		if ( $_MXC->CHECKJVERSION ) $link = "<a href=\"" . JRoute::_("index.php?option=com_maxcomment&task=favoured&id=$row->id") . "\">";

		switch ( $image ) {
			case "2":
				$_MXC->FAVOURED  = $link;	
				$_MXC->FAVOURED .= "<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/favoured.gif\" " . _OPACITY . " border=\"0\" title=\"" . stripslashes($label) . "\" alt=\"" . stripslashes($label) . "\" />";
				$_MXC->FAVOURED .= "</a>";
				break;
			case "1":
			default:
				$query = "SELECT COUNT(*) AS favourite FROM #__mxc_favoured WHERE id_content = '".$row->id."'";
				$database->setQuery( $query );
				$favorite = $database->loadResult();			
				$_MXC->FAVOURED = $link . stripslashes($label) . "</a> (" . $favorite . ")";		
		}	
	}
	
	function showPrint( &$row, $image, $tpl, $label, $page, $_Itemid ) {
		global $_MXC, $mosConfig_live_site;
		
		$_Itemid = ( $_Itemid ) ? '&amp;Itemid=' . $_Itemid : ''; 
		
		$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
		$link4image = "index2.php?option=com_content&task=view&id=$row->id&pop=1&page=$page$_Itemid";		
		//if ( $_MXC->CHECKJVERSION ) $link4image = JRoute::_("index.php?option=com_content&task=view&id=$row->id&pop=1&page=$page");
		if ( $_MXC->CHECKJVERSION ) {
			$link4image  = 'index.php?view=article';
			$link4image .= '&id='.$row->id.'&tmpl=component&print=1&page='.$page;
		    $link4image = JRoute::_($link4image);
		}		
		
		$link = "<a href=\"" . $link4image . "\" target=\"_blank\" onclick=\"window.open('" . $link4image . "','win2','" . $status . "'); return false;\" title=\"" . stripslashes($label) . "\">";
		
		switch ( $image ) {
			case "2":
				$imagesrc= "<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/print.gif\"" . _OPACITY . " border=\"0\" alt=\"" . stripslashes($label) . "\" />";
				$_MXC->PRINT  = "<a href=\"" . $link4image . "\" target=\"_blank\" onclick=\"window.open('" . $link4image . "','win2','" . $status . "'); return false;\" title=\"" . stripslashes($label) . "\">" . $imagesrc . "</a>";
				break;
			case "1":
			default:
				$_MXC->PRINT = $link . stripslashes($label) . "</a>";	
		}
	}
	
	function showSendEmail( &$row, $image, $tpl, $label, $vr, $_Itemid, $task ) {
		global $_MXC, $mosConfig_live_site, $mosConfig_absolute_path, $option, $mxc_checkversion ;
		
		$_Itemid = ( $_Itemid ) ? '&amp;Itemid=' . $_Itemid : ''; 		
		if ( $task != 'view' ) {
			$_Itemid = '';
		}
		switch ( $option ){
			case 'com_alphacontent':
				$com = "alphacontent";
				break;
			case 'com_content':
			default :
				$com = "content";
		}	
		if ( $vr ) {
			// integration for VisualRecommend
			if (file_exists($mosConfig_absolute_path.'/administrator/components/com_visualrecommend/visualrecommend_config.php')){
				require($mosConfig_absolute_path.'/administrator/components/com_visualrecommend/visualrecommend_config.php');	
			} else  $vr = false;				
		}		
		if ( $vr ) {			
			$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width='.$vr_width_popup.',height='.$vr_height_popup.',directories=no,location=no';
			$link4image = "index2.php?option=com_visualrecommend&task=showform&com=" . $com . "&id=" . $row->id . $_Itemid;
			$link = "<a href=\"" . $link4image . "\" target=\"_blank\" onclick=\"window.open('" . $link4image . "','win2','" . $status . "'); return false;\" title=\"" . stripslashes($label) . "\">";
		} else {
			$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=400,height=250,directories=no,location=no';
			$link4image = "index2.php?option=com_content&task=emailform&id=$row->id$_Itemid";	
			$link = "<a href=\"" . $link4image . "\" target=\"_blank\" onclick=\"window.open('" . $link4image . "','win2','" . $status . "'); return false;\" title=\"" . stripslashes($label) . "\">";
		}
		switch ( $image ) {
			case "2":
				$imagesrc = "<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/email.gif\"" . _OPACITY . " border=\"0\" alt=\"" . stripslashes($label) . "\" />";
				$_MXC->SEND = "<a href=\"" . $link4image . "\" target=\"_blank\" onclick=\"window.open('" . $link4image . "','win2','" . $status . "'); return false;\" title=\"" . stripslashes($label) . "\">" . $imagesrc . "</a>";
				break;
			case "1":
			default:
				$_MXC->SEND = $link . stripslashes($label) . "</a>";	
		}
		
		// Joomla! 1.5
		if ( $mxc_checkversion=='Joomla!1.5.x' ) {		
			if ( $vr ) {			
				$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width='.$vr_width_popup.',height='.$vr_height_popup.',directories=no,location=no';
				$link4image = "index2.php?option=com_visualrecommend&task=showform&com=" . $com . "&id=" . $row->id . $_Itemid;
				$link = "<a href=\"" . $link4image . "\" target=\"_blank\" onclick=\"window.open('" . $link4image . "','win2','" . $status . "'); return false;\" title=\"" . stripslashes($label) . "\">";
			} else {			
				$linkRoute	= JURI::base().JRoute::_("index.php?view=article&id=".$row->id, false);
				$url	= 'index.php?option=com_mailto&tmpl=component&link='.base64_encode( $linkRoute );
				$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=400,height=250,directories=no,location=no';
				$link4image = $mosConfig_live_site . "/index.php?option=com_mailto&tmpl=component&link=$url$_Itemid";	
				$link = "<a href=\"" . $link4image . "\" target=\"_blank\" onclick=\"window.open('" . $link4image . "','win2','" . $status . "'); return false;\" title=\"" . stripslashes($label) . "\">";
			}
			switch ( $image ) {			
				case "2":
					$imagesrc = "<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/email.gif\"" . _OPACITY . " border=\"0\" alt=\"" . stripslashes($label) . "\" />";
					$_MXC->SEND = "<a href=\"" . $link4image . "\" target=\"_blank\" onclick=\"window.open('" . $link4image . "','win2','" . $status . "'); return false;\" title=\"" . stripslashes($label) . "\">" . $imagesrc . "</a>";
					break;
				case "1":
				default:
					$_MXC->SEND = $link . stripslashes($label) . "</a>";	
			}
		}
		
	}
	
	function showRelatedArticles( &$row, $image, $tpl, $label ) {
		global $_MXC, $mosConfig_live_site, $Itemid;
		
		$link = "<a href='".sefRelToAbs("index.php?option=com_maxcomment&task=related&id=$row->id&Itemid=$Itemid")."'>";	
		if ( $_MXC->CHECKJVERSION ) $link = "<a href=\"" . JRoute::_("index.php?option=com_maxcomment&task=related&id=$row->id") . "\">";

		switch ( $image ) {
			case "2":
				$_MXC->RELATEDARTICLES  = $link;	
				$_MXC->RELATEDARTICLES .= "<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/relatedarticles.gif\"" . _OPACITY . " border=\"0\" title=\"" . stripslashes($label) . "\" alt=\"" . stripslashes($label) . "\" />";
				$_MXC->RELATEDARTICLES .= "</a>";
				break;
			case "1":
			default:
				$_MXC->RELATEDARTICLES = $link . stripslashes($label) . "</a>";	
		}	
	}

	function showReadMore( &$row, &$params, $image, $tpl, $label, $_Itemid ) {
		global $_MXC, $mosConfig_live_site, $my, $Itemid, $mosConfig_sef;
		
		if ( $mosConfig_sef ) {
			$_Itemid = ( $_Itemid ) ? '&Itemid=' . $_Itemid : ''; 		
		} else $_Itemid = ( $_Itemid ) ? '&Itemid=' . $_Itemid : $Itemid;
		
		$link = "<a href=\"" . sefRelToAbs("index.php?option=com_content&task=view&id=" . $row->id . "$_Itemid")."\">";	
		if ( $_MXC->CHECKJVERSION ) $link = "<a href=\"" . JRoute::_("index.php?option=com_content&task=view&id=" . $row->id) . "\">";
		
		//if ( $params->get( 'intro_only' ) ) {
			if ( (isset($row->readmore) && @$row->readmore) || $params->get( 'intro_only' ) || $params->get('show_readmore') ) {
				if ( $row->access <= $my->gid ) {
					$label = $label;
				} else {
					$label = _READ_MORE_REGISTER;
					$link = "<a href=\"" . sefRelToAbs( "index.php?option=com_registration&task=register" ) . "\">";
					if ( $_MXC->CHECKJVERSION ) $link = "<a href=\"" . JRoute::_("index.php?option=com_registration&task=register") . "\">";
					
				}
				switch ( $image ) {
					case "2":
						$_MXC->READMORE  = $link;	
						$_MXC->READMORE .= "<img src=\"" . $mosConfig_live_site . "/components/com_maxcomment/templates/" . $tpl . "/images/readmore.gif\"" . _OPACITY . " border=\"0\" title=\"" . stripslashes($label) . "\" alt=\"" . stripslashes($label) . "\" />";
						$_MXC->READMORE .= "</a>";
						break;
					case "1":
					default:
						$_MXC->READMORE = $link . stripslashes($label) . "</a>";
				}
			}
		//}
	}
	
	function showKeywords( &$row, $currentLang, $forceKeywordsLang ) {
		global $_MXC, $database, $mosConfig_absolute_path, $Itemid;
		
		// Itemid for com_search -----------------------
		$query = "SELECT id"
		. "\n FROM #__menu"
		. "\n WHERE `link`='index.php?option=com_search'"
		. "\n AND `type`='components'"
		. "\n AND published='1'"
		;
		$database->setQuery( $query );	
		$row_Itemid = $database->loadResult();		
		if ( $row_Itemid!=NULL ) {		
			$_Itemid = "&amp;Itemid=$row_Itemid";		
		} else $_Itemid="";
		//----------------------------------------------
		
		$_MXC->KEYWORDS = '';		
		
		if ( file_exists($mosConfig_absolute_path . "/administrator/components/com_joomfish/config.joomfish.php") ) {					
			$database->setQuery( "SELECT id FROM #__languages WHERE active='1' AND iso='$currentLang'" );
			$rowLA = $database->loadResult();
			if( $rowLA ) {		
				$query = "SELECT `value`"
				. "\n FROM #__jf_content"
				. "\n WHERE `reference_id`='$row->id'"
				. "\n AND `reference_table`='content'"
				. "\n AND `reference_field`='metakey'"
				. "\n AND `language_id`='$rowLA'"		
				. "\n AND `published`='1'"
				;		
				$database->setQuery( $query );	
				$rowsKeys = $database->loadResult();
				if ( !$rowsKeys && $forceKeywordsLang ) {
					// try to find original keywords if not exists
					$query = "SELECT metakey"
					. "\n FROM #__content"
					. "\n WHERE id='$row->id'"
					;				
					$database->setQuery( $query );	
					$rowsKeys = $database->loadResult();				
				}
			} else {
				// prevent error
				$query = "SELECT metakey"
				. "\n FROM #__content"
				. "\n WHERE id='$row->id'"
				;				
				$database->setQuery( $query );	
				$rowsKeys = $database->loadResult();	
			}
		} else {
			// Joom!fish not exist
			$query = "SELECT metakey"
			. "\n FROM #__content"
			. "\n WHERE id='$row->id'"
			;	
			$database->setQuery( $query );	
			$rowsKeys = $database->loadResult();	
		}		

		$keywords = array();
		$keywords = explode( "," , $rowsKeys );

		if ( $rowsKeys ) {
			for ($i=0, $n=count($keywords); $i < $n; $i++) {
				$metakey = trim($keywords[$i]);
				if ( $i > 0 ) $_MXC->KEYWORDS .= ", ";
				$_MXC->KEYWORDS .= "<a href='".sefRelToAbs("index.php?option=com_search&searchword=$metakey&submit=Search&searchphrase=any&ordering=newest&lang=$currentLang$_Itemid")."'>" . $metakey . "</a>";
				if ( $_MXC->CHECKJVERSION ) $_MXC->KEYWORDS = "<a href=\"" . JRoute::_("index.php?option=com_search&searchword=$metakey&submit=Search&searchphrase=any&ordering=newest&lang=$currentLang") . "\">" . $metakey . "</a>";
			}	
		}
	}

	
	// UTILS	
	function fract_part( $num ) {
		return abs( $num ) - intval( abs( $num ) );
	}
	
	function CBAuthorItemid() {
		global $_CBAuthorbot__Cache_ProfileItemid, $database;
		
		if ( !$_CBAuthorbot__Cache_ProfileItemid ) {
			if ( !isset( $_REQUEST['Itemid'] ) ) {
				$database->setQuery( "SELECT id FROM #__menu WHERE link = 'index.php?option=com_comprofiler' AND published=1" );
				$Itemid = (int) $database->loadResult();
			} else {
				$Itemid = (int) $_REQUEST['Itemid'];
			}
			if ( ! $Itemid ) {
				// Nope, just use the homepage then
				$query = "SELECT id"
				. "\n FROM #__menu"
				. "\n WHERE menutype = 'mainmenu'"
				. "\n AND published = 1"
				. "\n ORDER BY parent, ordering"
				. "\n LIMIT 1"
				;
				$database->setQuery( $query );
				$Itemid = (int) $database->loadResult();
			}
			$_CBAuthorbot__Cache_ProfileItemid = $Itemid;
		}
		if ($_CBAuthorbot__Cache_ProfileItemid) {
			return "&amp;Itemid=" . $_CBAuthorbot__Cache_ProfileItemid;
		} else {
			return null;
		}
	}
	
	function checkCBcomponent() {
		global $mosConfig_absolute_path;
		
		// Check if CB component exist
		$pathFileCB = $mosConfig_absolute_path . "/components/com_comprofiler/comprofiler.php";		
		if ( file_exists( $pathFileCB ) ) {
			$checkCBcomponent = 1;	
		} else $checkCBcomponent = 0;		
		return $checkCBcomponent;
	}	
}
?>