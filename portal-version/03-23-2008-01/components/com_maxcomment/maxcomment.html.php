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

class HTML_MXC_FRONTEND {

	function showquote( $option, $clang ){
		global $database, $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_sitename, $mainframe, $Itemid, $mosConfig_sef, $_VERSION;
		
		require($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');		
		
		$ifsefTurnOff = ( !$mosConfig_sef ) ? $mosConfig_live_site."/" : "";
		
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpane\">";
		echo "<tr><td>";
		
		$id = trim( mosGetParam( $_REQUEST, 'id', 0 ) );	
		$thequote = sefRelToAbs("index.php?option=com_content&task=view&id=$id&lang=$clang&Itemid=$Itemid");
		$thequote = $ifsefTurnOff . $thequote;		
		$thequote = explode( 'http://', $thequote );
		$thequote = (count($thequote)>2) ? "http://".$thequote[2] : "http://".$thequote[1];
		 
		$copyNow = date('Y');
		
		$query = "SELECT id, title FROM #__content WHERE id = '$id'";
		$database->setQuery( $query );
		$rowTitle = $database->loadObjectList();
		$title = stripslashes($rowTitle[0]->title);
		
		$img = "&raquo;&nbsp;";
		
		$mxc_style4quote = "<style type=\"text/css\">"
		."\n<!--"
		."\n.quote {width:350px; padding: 6px; border: solid 1px #456B8F; font: 10px helvetica, verdana, sans-serif; color: #222222; background-color: #ffffff}"
		."\n.quote a {font: 13px arial, serif; color: #003399; text-decoration: underline}"
		."\n.quote a:hover {color: #FF9900; }"
		."\n-->"
		."\n</style>";
		
		echo _MXC_QUOTETHISARTICLEONYOURSITE;
		echo "<br /><br />";
		echo "<div class='contentheading'>".$title."</div>";
		echo "<br />";
		echo "<strong>"._MXC_CREATELINKTOWARDSTHISARTICLE."</strong>";
		echo "<br /><br />";
		?>
		<textarea name="textarea" cols="56" rows="7"><?php echo $mxc_style4quote; ?><div class="quote"><a href="<?php echo $thequote; ?>" target="_blank"><?php echo $title; ?></a><br /><?php echo $mosConfig_sitename; ?> - <?php echo mosCurrentDate(); ?><br /><div align="right">&copy; <a href="<?php echo $mosConfig_live_site; ?>" target="_blank"><?php echo $mosConfig_sitename; ?></a></div></div>
		</textarea>
		  <?php
		eval(stripslashes(base64_decode("CQllY2hvIFwiPGJyIC8+PGJyIC8+XCI7DQoJCWVjaG8gX01YQ19QUkVWSUVXUVVPVEU7DQoJCWVjaG8gXCI8YnIgLz48YnIgLz5cIjsNCgkJJHRoZWRhdGUgPSBtb3NDdXJyZW50RGF0ZSgpOyANCgkJZWNobyAkbXhjX3N0eWxlNHF1b3RlOw0KCQllY2hvIFwiXFxuPGRpdiBjbGFzcz1cXFwicXVvdGVcXFwiPjxhIGhyZWY9XFxcIiR0aGVxdW90ZVxcXCIgdGFyZ2V0PVxcXCJfYmxhbmtcXFwiPiR0aXRsZTwvYT5cIg0KCQkuXCJcXG48YnIgLz4kbW9zQ29uZmlnX3NpdGVuYW1lIC0gJHRoZWRhdGU8YnIgLz5cIg0KCQkuXCJcXG48ZGl2IGFsaWduPVxcXCJyaWdodFxcXCI+JGNvcHlOb3cgJmNvcHk7IDxhIGhyZWY9XFxcIiRtb3NDb25maWdfbGl2ZV9zaXRlXFxcIiB0YXJnZXQ9XFxcIl9ibGFua1xcXCI+JG1vc0NvbmZpZ19zaXRlbmFtZTwvYT48L2Rpdj48L2Rpdj5cIjsNCgkJZWNobyBcIjxiciAvPlwiOw0KCQllY2hvICRpbWc7DQoJCWVjaG8gXCIgPGEgaHJlZj1cXFwiamF2YXNjcmlwdDpvbmNsaWNrPWhpc3RvcnkuYmFjaygpO1xcXCIgPlwiIC4gX01YQ19HT0JBQ0tJVEVNIC4gXCI8L2E+XCI7CQkNCgkJZWNobyBcIjwvdGQ+PC90cj48L3RhYmxlPlwiOwkJDQoJCV9nZXROb3RpY2VDb3B5cmlnaHQoKTsNCg==")));		
	}

	function saveFavoured( &$rows, $msg, $img, $goItem ) {
		global $database, $mainframe, $my, $mosConfig_absolute_path, $Itemid, $_VERSION;
		
		$checkJversion = ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5') ? 1 : 0;
		
		require($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');		
		
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpane\">";		
		
		echo "<tr><td>";

		echo "<div class='contentheading'>".$msg ."</div>";
		echo "<br />";
		echo _MXC_WHATYOUWANT;
		echo "<br /><br />";
		echo $img;
		echo " <a href=\"javascript:onclick=history.back();\" >" . stripslashes ( _MXC_GOBACKITEM ) . "</a>";
		echo "<br />";
		echo $img;
		echo " <a href=\"index.php\" >" . _MXC_GOHOME . "</a>";
		echo "<br /><br />";
		echo _MXC_YOURFAVOURED;
		echo "<br />";
	
		if ( count($rows) ){
			foreach ( $rows as $row ) {
				if (is_callable( array( $mainframe, "getItemid" ) ) ) {
					$itemid = $mainframe->getItemid( $row->id_content );
				} elseif (is_callable( "JApplicationHelper::getItemid" ) ) {
					$itemid = JApplicationHelper::getItemid( $row->id_content );
				} else {
					$itemid = null;
				}
				$_Itemid = $itemid ? "&amp;Itemid=" . (int) $itemid : "";
				
				echo "<br />";
				echo $img;
				echo " <a href='" . sefRelToAbs( $goItem . $row->id_content . $_Itemid ) . "'>" . stripslashes( $row->title ) . "</a>";
			}
		}
		
		if ( $my->id ) {	
			# Get Itemid for my favourites
			$database->setQuery("SELECT id FROM #__menu"
				.	"\nWHERE link='index.php?option=com_maxcomment&task=myfavoured'"
				.	"\nAND type='url'"
				.	"\nAND published='1'"
				.	"\nLIMIT 1");
			$_Itemid = $database->loadResult();		
			// Blank itemid checker for SEF
			if ($_Itemid == NULL) {
				$_Itemid = '';
			} else {
				$_Itemid = '&amp;Itemid='. $Itemid;
			}	
			echo "<br /><br />";
			
			$link = sefRelToAbs("index.php?option=com_maxcomment&task=myfavoured$_Itemid");
			if ( $checkJversion ) $link2 =  JRoute::_("index.php?option=com_maxcomment&task=myfavoured");
			
			echo _MXC_YOURFAVOUREDUSER . " ( <a href='" . $link . "'>" . stripslashes($my->name) . "</a> )";		
		}			
		eval(stripslashes(base64_decode("CQllY2hvIFwiPC90ZD48L3RyPjwvdGFibGU+XCI7CQkNCgkJX2dldE5vdGljZUNvcHlyaWdodCgpOw0K")));		
	}
	
	
	function moreFavoured( &$rows, $img, $goItem ){
		global $database, $mainframe, $my, $mosConfig_absolute_path, $_VERSION;
		
		$checkJversion = ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5') ? 1 : 0;
		
		require($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');		
		
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpane\">";
		echo "<tr><td>";
	
		echo "<div class='contentheading'>" . _MXC_YOURFAVOURED . "</div>";
		echo "<br />";
		if ( count($rows) ){
			foreach ( $rows as $row ) {
				if (is_callable( array( $mainframe, "getItemid" ) ) ) {
					$itemid = $mainframe->getItemid( $row->id_content );
				} elseif (is_callable( "JApplicationHelper::getItemid" ) ) {
					$itemid = JApplicationHelper::getItemid( $row->id_content );
				} else {
					$itemid = null;
				}
				$_Itemid = $itemid ? "&amp;Itemid=" . (int) $itemid : "";
				
				$link = sefRelToAbs( $goItem.$row->id_content.$_Itemid );
				if ( $checkJversion ) $link2 =  JRoute::_( $goItem.$row->id_content );	
							
				echo $img;
				echo " <a href='". $link ."'>".stripslashes($row->title)."</a><br />";
			}
		}
		
		if ( $my->id ) {	
			# Get Itemid for my favourites
			$database->setQuery("SELECT id FROM #__menu"
				.	"\nWHERE link='index.php?option=com_maxcomment&task=myfavoured'"
				.	"\nAND type='url'"
				.	"\nAND published='1'"
				.	"\nLIMIT 1");
			$_Itemid = $database->loadResult();		
			// Blank itemid checker for SEF
			if ($_Itemid == NULL) {
				$_Itemid = '';
			} else {
				$_Itemid = '&amp;Itemid='. $Itemid;
			}	
			echo "<br /><br />";
			
			$link2 = sefRelToAbs( "index.php?option=com_maxcomment&task=myfavoured$_Itemid" ) ;
			
			if ( $checkJversion ) $link2 =  JRoute::_( "index.php?option=com_maxcomment&task=myfavoured" ) ;
			
			echo _MXC_YOURFAVOUREDUSER . " ( <a href='". $link2 . "'>" . stripslashes($my->name) . "</a> )";		
		} 		
		eval(stripslashes(base64_decode("CQllY2hvIFwiPC90ZD48L3RyPjwvdGFibGU+XCI7CQkNCgkJX2dldE5vdGljZUNvcHlyaWdodCgpOw0K")));			
	}
	
	
	function myFavoured( &$rows, $img, $goItem ){
		global $database, $mainframe, $my, $mosConfig_absolute_path, $_VERSION;
		
		$checkJversion = ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5') ? 1 : 0;
		
		require($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');		
		
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpane\">";
		echo "<tr><td>";
	
		echo "<div class='contentheading'>" . _MXC_YOURFAVOUREDUSER . "</div>";
		echo "<br />";
		
		if ( $my->id ) {		
			if ( count($rows) ) {
				foreach ( $rows as $row ) 
				{
					if (is_callable( array( $mainframe, "getItemid" ) ) ) {
						$itemid = $mainframe->getItemid( $row->id_content );
					} elseif (is_callable( "JApplicationHelper::getItemid" ) ) {
						$itemid = JApplicationHelper::getItemid( $row->id_content );
					} else {
						$itemid = null;
					}
					$_Itemid = $itemid ? "&amp;Itemid=" . (int) $itemid : "";					
				
					echo $img;
					if ( $checkJversion ) {
						echo " <a href='" . JRoute::_( $goItem . $row->id_content ) . "'>" . stripslashes($row->title) . "</a> (<a href='" . JRoute::_( "index.php?option=com_maxcomment&task=removefav&favid=$row->favid" ) . "'>"._MXC_FAVOUREDREMOVE."</a>)<br />";
					} else echo " <a href='" . sefRelToAbs( $goItem . $row->id_content . $_Itemid ) . "'>" . stripslashes($row->title) . "</a> (<a href='" . sefRelToAbs( "index.php?option=com_maxcomment&task=removefav&favid=$row->favid" ) . "'>"._MXC_FAVOUREDREMOVE."</a>)<br />";
				}
			}else{
				echo _MXC_NOFAVOURED;
			}
		} else {	
			// if menu url... and not login
			echo _MXC_FAVOUREDUSERMUSTLOGIN;	
		}				
		eval(stripslashes(base64_decode("CQllY2hvIFwiPC90ZD48L3RyPjwvdGFibGU+XCI7CQkNCgkJX2dldE5vdGljZUNvcHlyaWdodCgpOw0K")));				
	}
	
	function displayForm( $title, $template='/', $option, $cid, $parentid, $useSecurityImage, &$rlist, $Itemid, $titleparent, $alreadyvoting, $clang ) {
		global $mainframe, $mosConfig_live_site, $mosConfig_absolute_path, $my, $mosConfig_sef, $_VERSION;
		
		$checkJversion = ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5') ? 1 : 0;
		
		require( $mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php' );		
		require($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');
		
		if ( $useSecurityImage ) {	
			require ($mosConfig_absolute_path.'/administrator/components/com_securityimages/client.php');
			$packageName = "securityimage_newpass";
			$mxc_use_mathguard = 0;
		}
		
		if ( $mxc_lengthcomment ) {	
			include($mosConfig_absolute_path."/components/com_maxcomment/includes/common/maxlengthcomment.php");
		}
		
		if ( ($my->id>'0' && $mxc_anonentry=='0') || $mxc_anonentry=='1' ){	
		
			$mainframe->setPageTitle( stripslashes( $title ) );
			//$mainframe->addCustomHeadTag( '<link rel="stylesheet" href="' . $mosConfig_live_site . '/templates/'. $template .'css/template_css.css" type="text/css" />' );
			if ( $mxc_openingmode ) {
				$mainframe->addCustomHeadTag( '<link rel="stylesheet" href="templates/'. $template .'/css/template_css.css" type="text/css" />' );
			}
			
			$the_username = ( $mxc_use_name=='1' ) ? $my->name : $my->username ;	
			
			echo "\n<table width=\"100%\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\" class=\"contentpane\">";
			echo "\n<tr>";
			echo "\n<td class=\"contentheading\">" . stripslashes ( _MXC_COMMENT_AN_ARTICLE ) ."</td><br />";
			echo "\n</tr>";
			echo "\n</table>";			
			echo "\n<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpane\">";
			echo "\n<tr>\n<td>";	
			?>
			<script language="JavaScript" type="text/JavaScript">
			function validate(){
				if (document.commentForm.comment.value==''){
						alert("<?php echo _MXC_FORMVALIDATECOMMENT; ?>");
					}else if (document.commentForm.name.value==''){
						alert("<?php echo _MXC_FORMVALIDATENAME; ?>");
					<?php if ( $mxc_displayemail ) { ?>
					}else if (document.commentForm.email.value==''){
						alert("<?php echo _MXC_FORMVALIDATEMAIL; ?>");
					<?php } ?>
					<?php if ( $mxc_displaytitle ) { ?>
					}else if (document.commentForm.title.value==''){
						alert("<?php echo _MXC_FORMVALIDATETITLE; ?>");		
					<?php } ?>		
					} else {
						document.commentForm.submit();
					}
			}
			
			function x () {
				return;
			}
				
			function mxc_smilie(thesmile) {
				document.commentForm.comment.value += " "+thesmile+" ";
				document.commentForm.comment.focus();
			}				
			</script>
			<?php
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
				echo "<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_maxcomment/includes/js/prototype.js\"></script>";
				echo "<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_maxcomment/includes/js/control.textarea.js\"></script>";
				echo "<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_maxcomment/includes/js/control.textarea.bbcode.js\"></script>";
			?>
			<!-- STYLE FOR BBCODE TOOLBAR -->
			<style>
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
					background-image:url("<?php echo $mosConfig_live_site; ?>/components/com_maxcomment/includes/js/bbcode_icons.gif");
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
			</style>
			<!-- END STYLE FOR BBCODE TOOLBAR -->
			<?php } 			
			$destination = ( !$mxc_openingmode && $mosConfig_sef ) ? "index.php?option=com_maxcomment&task=savecomment&Itemid=$Itemid" : "" ;
			?>
				<form action="<?php echo $destination ; ?>" method="post" name="commentForm" id="commentForm">
				<table width="100%" class="contentpane">  
				  <tr>
					<td colspan="2">
					<strong><?php echo $title; ?></strong><br /><br />
					<?php 
					if (  $titleparent ) {
						echo "<br />" . (_MXC_REPLYCOMMENT) .  ": " . $titleparent . "<br />";
					}					
					?>
					</td>
				  </tr>
				  <tr>
					<td width="20%" align="right"><?php echo stripslashes ( _MXC_ENTERNAME ); ?></td>
					<td width="80%">
					<?php 
					//if ( $my->username ) {				
					if ( $my->id>'0' ) {		
					  echo "&#187;&nbsp;" . stripslashes ( $the_username );
					  ?>
					  <input type="hidden" name="name" value="<?php echo stripslashes ( $the_username ); ?>" />				  		  
					  <?php
					  } else {
					  ?>
					  <input class="inputbox" type="text" name="name" size="40" maxlength="30" value="" />
					<?php 						
					}
					?>
					</td>
				  </tr>
				  <?php if ( $mxc_displayemail ) {	?>			  
				  <tr>
					<td width="20%" align="right"><?php echo stripslashes ( _MXC_ENTERMAIL ); ?></td>
					<td width="80%"><input name="email" type="text" class="inputbox" value="<?php echo $my->email; ?>" size="40" maxlength="254" />					
					</td>
				  </tr>
				  <?php 						
				       } else {	
						echo "<input type=\"hidden\" name=\"email\" value=\"\" />";
					}
				  ?>
				  <?php 				  
				  if ( $mxc_ratinguser && $my->id && $alreadyvoting=='0' ) { ?>
				  <tr>
					<td valign="top" align="right"><?php echo stripslashes ( _MXC_RATING ); ?></td>
					<td>
					<?php echo $rlist;
						if ( $mxc_levelrating=='5' ) { ?>
					  <script language="javaScript" type="text/javaScript">
						<!--
						if (document.commentForm.rating.options.value!='0'){
							jsimg='<?php echo $mosConfig_live_site ; ?>/components/com_maxcomment/templates/<?php echo $mxc_template; ?>/images/rating/user_rating_' + getSelectedValue( 'commentForm', 'rating' ) + '.gif';
						} else {
							jsimg='<?php echo $mosConfig_live_site ; ?>/components/com_maxcomment/templates/<?php echo $mxc_template; ?>/images/rating/user_rating_0.gif';
						}
						document.write(' <img src=' + jsimg + ' name="imagelib" border="0" align="middle" alt="" />');
						//-->
					  </script>
						<?php } ?></td>
					  </tr>
				  <?php
				  } else {
					  // $mxc_ratinguser && user unregistered OR is_user && already rating  
					  echo "<input type=\"hidden\" name=\"rating\" value=\"0\" />";
		          }
				  ?>	
				  <?php if ( $mxc_displaytitle ) { ?>  
				  <tr>
					<td valign="top" align="right"><?php echo stripslashes ( _MXC_TITLE ); ?></td>
					<td>
					  <input name="title" type="text" class="inputbox" value="" size="40" maxlength="40" />&nbsp;
					</td>
				  </tr>
				  <?php } else {
					  // not display Title 
					  echo "<input type=\"hidden\" name=\"title\" value=\"\" />";
				  }
				  ?>	
				  <?php  if ( $mxc_smiliesupport ) { ?>
				  <tr>
				    <td valign="top" align="right">&nbsp;</td>
				    <td>
					<?php
					foreach ($smiley as $i=>$sm) {
					  echo "<a href=\"javascript:mxc_smilie('$i')\" title='$i'><img src='$mosConfig_live_site/components/com_maxcomment/images/smilies/$sm' border='0' /></a> ";
					}						
					?>
					</td>
			      </tr>
				  <tr>
				  <?php } ?>
					<td valign="top" align="right"><?php echo stripslashes ( _MXC_COMMENT ) ; ?></td>
					<td>
					  <textarea class="inputbox" cols="50" rows="6" name="comment" id="comment" onKeyDown="countlengthcomment(this.form.comment, 'compteur', <?php echo $mxc_lengthcomment?>);" onKeyUp="countlengthcomment(this.form.comment, 'compteur', <?php echo $mxc_lengthcomment?>);" onFocus="showInputField('compteur', this.form.comment, <?php echo $mxc_lengthcomment?>);"></textarea>
					    <?php  if ( $mxc_bbcodesupport ) { ?>
						<script>
							bbcode_toolbar = new Control.TextArea.ToolBar.BBCode('comment');
							bbcode_toolbar.toolbar.toolbar.id = 'bbcode_toolbar';
						</script>
						<?php } ?>
					</td>
				  </tr>
				  <?php if ( $mxc_lengthcomment ) { ?>
				  <tr>
					<td valign="top" align="right">&nbsp;</td>
					<td>
					<div id="compteur"><?php echo _MXC_NUM_CHARCARTERS . " " . $mxc_lengthcomment ; ?></div>
					</td>
				  </tr>
				  <?php } ?>
				  <tr>
					<td valign="top" align="right">&nbsp;</td>
					<td>
					<?php
					if ( $mxc_displaycheckboxcontact && $mxc_displayemail ) {
					?>
					<input type="checkbox" name="subscribe" id="subscribe" class="inputbox" value="1" />&nbsp;<?php echo stripslashes ( _MXC_NOTIFY_ME_FOLLOW_UP ); ?>
					<?php
					} else {
					?>
					<input type="hidden" name="subscribe" id="subscribe" value="0" />
					<?php }	?>				
					</td>
				  </tr>
				  <?php
					if ( $my->id ) {
						// no security check if registered
						$useSecurityImage  = 0;
						$mxc_use_mathguard = 0;
					}
				  ?>
				  <?php if ( $useSecurityImage ) {	?>
				  <tr>
					<td valign="top" align="right">&nbsp;</td>
					<td>				
					<?php echo insertSecurityImage($packageName); ?><br />
					<?php echo getSecurityImageTextHeader(); ?><br />
					<?php echo getSecurityImageField($packageName); ?><br />
					<?php 
					// echo getSecurityImageTextHelp();
					$mxc_use_mathguard = 0;
					?>
					</td>
				  </tr>
				  <?php } ?>
				  <?php if ( $mxc_use_mathguard ) { ?>
				  <tr>
					<td valign="top" align="right">&nbsp;</td>
					<td>				
					  <?php	
					   include( $mosConfig_absolute_path.'/components/com_maxcomment/includes/ClassMathGuard.php'); 
					   MathGuard::insertQuestion(); 
					   ?>
					</td>
				  </tr>
				  <?php } ?>
				  <tr>
					<td valign="top" align="right">&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td valign="top" align="right">&nbsp;</td>
					<td><input type="button" name="Submit" value="<?php echo (_MXC_BUTTON_SUBMIT); ?>" class="button" onClick="javascript:validate()" />&nbsp;
				<input type="reset" name="Submit2" value="<?php echo _MXC_RESET ; ?>" class="button" /></td>
				  </tr>
				</table>
				<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
				<input type="hidden" name="parentid" value="<?php echo $parentid; ?>" />
				<input type="hidden" name="published" value="<?php echo $mxc_autopublish; ?>" />
				<input type="hidden" name="iduser" value="<?php echo $my->id; ?>" />
				<input type="hidden" name="lang" value="<?php echo $clang; ?>" />
				<input type="hidden" name="option" value="<?php echo $option; ?>" />				
				<input type="hidden" name="task" value="savecomment" />				
				</form>
				<br />
				<?php
				if ( $mxc_openingmode ) {
					echo "<a href=\"javascript:window.close();\">" . stripslashes ( _MXC_CLOSE ) . "</a>";
				} else { 
					
					$img = "&raquo;&nbsp;";
				
					$gobackitem = sefRelToAbs("index.php?option=com_content&task=view&id=$cid&Itemid=$Itemid");
					if ( $checkJversion ) $gobackitem = JRoute::_("index.php?option=com_content&task=view&id=$cid");
					echo "<br />$img <a href='$gobackitem'>". stripslashes ( _MXC_GOBACKITEM ) . "</a>";			
				}	
						
		}else{
			echo stripslashes ( _MXC_COMMENTONLYREGISTERED );			
		}
		eval(stripslashes(base64_decode("CQllY2hvIFwiXFxuPC90ZD5cXG48L3RyPlxcbjwvdGFibGU+XCI7CQkNCgkJX2dldE5vdGljZUNvcHlyaWdodCgpOwkJDQo=")));
	}
	
	
	function viewcomment( $rowUserComments, $pageNav, $limitstart, $limit, $total, $title, $template, $option, $Itemid, $cid, $goItem, $clang ) {
		global $mosConfig_live_site, $mosConfig_absolute_path, $mainframe, $mosConfig_lang, $_VERSION;
		
		$checkJversion = ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5') ? 1 : 0;
		
		// Get the right language template if it exists
		if (file_exists($mosConfig_absolute_path."/components/com_maxcomment/templates/".$template."/languages/".$mosConfig_lang.".php")){
			include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/".$template."/languages/".$mosConfig_lang.".php");
		}else{
			include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/".$template."/languages/english.php");
		}
		
		require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );	
		require($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');		
	
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpane\">";
		echo "<tr><td>";	
		echo "<div class='contentheading'>" . $title . "</div>";
		echo "<br />";
		echo $pageNav->writePagesCounter();
		echo "<br /><br />";
		
		//Load template user comment	
		echo "<link href=\"".$mosConfig_live_site."/components/com_maxcomment/templates/".$template."/css/".$template."_css.css\" rel=\"stylesheet\" type=\"text/css\" />";		
		require( $mosConfig_absolute_path.'/components/com_maxcomment/templates/' . $template . '/usercomment.php' );	
		//
		eval(stripslashes(base64_decode("CQkkbGluayA9IFwnaW5kZXgucGhwP29wdGlvbj1jb21fbWF4Y29tbWVudCZhbXA7dGFzaz12aWV3Y29tbWVudCZhbXA7aWQ9XCcuICRjaWQgLlwnJmFtcDtsYW5nPVwnIC4gJGNsYW5nIC4gXCcmYW1wO0l0ZW1pZD1cJy4gJEl0ZW1pZDsNCgkJZWNobyAkcGFnZU5hdi0+d3JpdGVQYWdlc0xpbmtzKCAkbGluayApOw0KCQllY2hvIFwiPGJyIC8+PGJyIC8+XCI7DQoJCSRsaW5rQWRkQ29tbWVudCA9IHNlZlJlbFRvQWJzKFwiaW5kZXgucGhwP29wdGlvbj1jb21fbWF4Y29tbWVudCZhbXA7dGFzaz1hZGRjb21tZW50JmFtcDtpZD1cIiAuICRjaWQgLiBcIiZhbXA7bGFuZz1cIiAuICRjbGFuZyAuIFwiJmFtcDtJdGVtaWQ9XCIgLiAkSXRlbWlkKTsNCgkJaWYgKCAkY2hlY2tKdmVyc2lvbiApICRsaW5rQWRkQ29tbWVudCA9IEpSb3V0ZTo6XyhcImluZGV4LnBocD9vcHRpb249Y29tX21heGNvbW1lbnQmdGFzaz1hZGRjb21tZW50JmlkPVwiIC4gJGNpZCAuIFwiJmxhbmc9XCIgLiAkY2xhbmcpOwkJDQoJCSRnb0l0ZW0gPSBzZWZSZWxUb0FicygkZ29JdGVtKTsNCgkJaWYgKCAkY2hlY2tKdmVyc2lvbiApICRnb0l0ZW0gPSBKUm91dGU6Ol8oJGdvSXRlbSk7CQkNCgkJZWNobyBcIjxhIGhyZWY9XCdcIiAuICRnb0l0ZW0gLiBcIlwnPlwiIC4gX01YQ19HT0JBQ0tJVEVNIC4gXCI8L2E+IHwgPGEgaHJlZj1cJ1wiIC4gJGxpbmtBZGRDb21tZW50IC4gXCJcJz5cIiAuIF9NWENfQUREWU9VUkNPTU1FTlQgLiBcIjwvYT48YnIgLz48YnIgLz5cIjsNCgkJZWNobyBcIjwvdGQ+PC90cj48L3RhYmxlPlwiOwkJDQoJCV9nZXROb3RpY2VDb3B5cmlnaHQoKTsJDQo=")));
	}

	function viewallreplies( $rowUserComments, $rowReplies, $title, $template, $option, $Itemid, $goItem ) {
		global $mosConfig_live_site, $mosConfig_absolute_path, $mainframe, $mosConfig_lang;
		
		// Get the right language template if it exists
		if (file_exists($mosConfig_absolute_path."/components/com_maxcomment/templates/".$template."/languages/".$mosConfig_lang.".php")){
			include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/".$template."/languages/".$mosConfig_lang.".php");
		}else{
			include_once($mosConfig_absolute_path."/components/com_maxcomment/templates/".$template."/languages/english.php");
		}
		
		require( $mosConfig_absolute_path . '/administrator/components/com_maxcomment/maxcomment_config.php' );	
		require($mosConfig_absolute_path.'/components/com_maxcomment/includes/maxcomment.utils.php');		
	
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"contentpane\">";
		echo "<tr><td>";	
		echo "<div class='contentheading'>" . $title . "</div>";
		echo "<br />";
		echo "<a href='" . sefRelToAbs($goItem) . "'>" . _MXC_GOBACKITEM . "</a><br />";	
		echo "<br />";
		echo "<b>"._MXC_COMMENTINQUESTION."</b>";
		//Load template user comment	
		echo "<link href=\"".$mosConfig_live_site."/components/com_maxcomment/templates/".$template."/css/".$template."_css.css\" rel=\"stylesheet\" type=\"text/css\" />";	
		require( $mosConfig_absolute_path.'/components/com_maxcomment/templates/' . $template . '/usercomment.php' );		
		
		// replies
		echo "<b>" . _getCountAllReplies( $rowUserComments[0]->id ) . " " . _MXC_REPLIES."</b>";	
		
		echo "<table width=\"92%\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		echo "<tr><td>";	
		$rowUserComments = $rowReplies;
		require( $mosConfig_absolute_path.'/components/com_maxcomment/templates/' . $template . '/usercomment.php' );	
		eval(stripslashes(base64_decode("CQkJZWNobyBcIjwvdGQ+PC90cj48L3RhYmxlPlwiOwkJCQ0KCQllY2hvIFwiPC90ZD48L3RyPjwvdGFibGU+XCI7CQkNCgkJX2dldE5vdGljZUNvcHlyaWdodCgpOwkNCg==")));
	}
}
?>