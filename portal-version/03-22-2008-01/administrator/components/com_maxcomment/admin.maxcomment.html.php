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
	 
class HTML_MXC {

	////////////////////////////  CONTROL PANEL  /////////////////////////////
	
	function quickiconButtonMXC( $link, $image, $text, $option ) {
		global $_VERSION;
		
		if ( $_VERSION->PRODUCT == 'Mambo' ){ 
		?>			
			<style type="text/css">
			<!--
			#cpanel {  text-align: center;  vertical-align: middle; }				
			#cpanel div.icon   { margin: 3px; }
			#cpanel div.icon a { 
				display: block; float: left;
				height: 97px !important;
				height: 100px; 
				width: 108px !important;
				width: 110px; 
				vertical-align: middle; 
				text-decoration : none;
				border: 1px solid #DDD;
				padding: 2px 5px 1px 5px;
			}				
			#cpanel div.icon a:link    {  color : #808080;  }
			#cpanel div.icon a:hover   { 
				color : #333; 
				background-color: #f1e8e6;  
				border: 1px solid #c24733;
				padding: 3px 4px 0px 6px; 
			}
			#cpanel div.icon a:active  {  color : #808080;  }
			#cpanel div.icon a:visited {  color : #808080;  }				
			#cpanel div.icon img { margin-top: 13px; }
			#cpanel div.icon span { display: block; padding-top: 3px;}
			-->
			</style>		
	<?php } ?>				
			<div style="float:left;">
				<div class="icon">
					<a href="<?php echo $link; ?>">
						<?php echo mosAdminMenus::imageCheckAdmin( $image, '/administrator/components/'.$option.'/images/icons/', NULL, NULL, $text ); ?>
						<span><?php echo $text; ?></span>
					</a>
				</div>
			</div>
			<?php
	}		
	

	function showcontrolpanel( $option, &$lcrows, &$mfrows ) {
	global $mosConfig_live_site, $mosConfig_absolute_path, $database;
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="adminheading">
      <tr>
        <th class="cpanel">&nbsp;<?php echo "maXcomment :: " . _MXC_CONTROLPANEL ; ?></th>
      </tr>
    </table>
	<table class="adminform">
      <tr>
        <td width="40%" valign="top">
			<div id="cpanel">
				<?php
				$link = 'index2.php?option='.$option.'&amp;task=config';
				HTML_MXC::quickiconButtonMXC( $link, 'config.png', _MXC_CPL_CONFIG, $option );
			
				$link = 'index2.php?option='.$option.'&amp;task=admcomments';
				HTML_MXC::quickiconButtonMXC( $link, 'adm_comment.png', _MXC_CPL_ADM_COMMENTS, $option );
			
				$link = 'index2.php?option='.$option.'&amp;task=usercomments';
				HTML_MXC::quickiconButtonMXC( $link, 'user_comment.png', _MXC_CPL_USER_COMMENTS, $option );
			
				$link = 'index2.php?option='.$option.'&amp;task=favoured';
				HTML_MXC::quickiconButtonMXC( $link, 'favoured.png', _MXC_CPL_FAVOURED, $option );
			
				$link = 'index2.php?option='.$option.'&amp;task=editcss';
				HTML_MXC::quickiconButtonMXC( $link, 'editcss.png', _MXC_CPL_EDIT_CSS_FILE, $option );
			
				$link = 'index2.php?option='.$option.'&amp;task=editlanguage';
				HTML_MXC::quickiconButtonMXC( $link, 'editlanguage.png', _MXC_CPL_EDIT_LANGUAGE_FILE, $option );
				
				$link = 'index2.php?option='.$option.'&amp;task=badwords';
				HTML_MXC::quickiconButtonMXC( $link, 'badwords.png', _MXC_CPL_BAD_WORDS, $option );
				
				$link = 'index2.php?option='.$option.'&amp;task=blockip';
				HTML_MXC::quickiconButtonMXC( $link, 'blockip.png', _MXC_CPL_BLOCK_IP, $option );
			
				$link = 'index2.php?option='.$option.'&amp;task=supportwebsite';
				HTML_MXC::quickiconButtonMXC( $link, 'supportwebsite.png', _MXC_CPL_SUPPORT_WEBSITE, $option );			
				
				$link = 'index2.php?option='.$option.'&amp;task=about';
				HTML_MXC::quickiconButtonMXC( $link, 'about.png', _MXC_CPL_ABOUT, $option );			
				?>
			</div>	
			<div style="clear:both;"> </div>	
		</td>
        <td width="60%" valign="top">		
		<?php 
		$commentlenght = 60;
		
		$mxc_paneltabs = new mosTabs( 0 );
		$mxc_paneltabs->startPane( "panel_maXcomment" );
		$mxc_paneltabs->startTab( _MXC_LASTCOMMENTS ,"lastcomment-page");
		?>
		<table class="adminlist">
		<tr>
			<th class="title">
				<?php echo _MXC_LASTCOMMENTS; ?>
			</th>
			<th class="title">
				<?php echo _MXC_AUTHOR; ?>
			</th>
			<th class="title">
				<?php echo _MXC_DATE; ?>
			</th>
		</tr>
		<?php
		foreach ($lcrows as $row) {			
			$link = 'index2.php?option=com_maxcomment&amp;task=usercomments';
			?>
			<tr>
				<td>
				<?php 
				if( strlen($row->comment) > $commentlenght) {
					$row->comment  = substr( $row->comment, 0, $commentlenght-3 );
					$row->comment .= "...";
				}		
				?>
					<a href="<?php echo $link; ?>">
						<?php echo stripslashes( $row->comment );?></a>
				</td>
				<td>
					<?php echo stripslashes( $row->name );?>
				</td>
				<td>
					<?php echo $row->date;?>
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<th colspan="3">
			</th>
		</tr>
		</table>
		<?php
		$mxc_paneltabs->endTab();
		
		$mxc_paneltabs->startTab( _MXC_MOSTFAVOURED ,"mostfavoured-page");
		?>
		<table class="adminlist">
		<tr>
			<th class="title">
				<?php echo _MXC_TITLE; ?>
			</th>
			<th class="title">
				<?php echo _MXC_FAVOURED; ?>
			</th>
		</tr>
		<?php
		foreach ($mfrows as $row) {			
			$link = 'index2.php?option=com_typedcontent&amp;task=edit&amp;hidemainmenu=1&amp;id='. $row->id;
			?>
			<tr>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo htmlspecialchars($row->title, ENT_QUOTES);?></a>
				</td>
				<td>
					<?php echo $row->favourite;?>
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<th colspan="3">
			</th>
		</tr>
		</table>
		<?php
		$mxc_paneltabs->endTab();	
		$mxc_paneltabs->endPane();
		?>		
		</td>
      </tr>
    </table>
	  <?php
	}		

	function showConfig( $option ) {
		global $mosConfig_live_site, $mosConfig_absolute_path, $database, $mainframe;	
		
		require( $mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php' );	
		mosCommonHTML::loadOverlib();
	?>
		<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function MM_reloadPage(init) {  //reloads the window if Nav4 resized
		  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
			document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
		  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
		}
		MM_reloadPage(true);
		//-->
		</script>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
		  var form = document.adminForm;
		  if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		  }
		  if (form.mxc_autopublish.value == ""){
			alert( "Please choose publish mode." );
		  } else {
			submitform( pressbutton );
		  }
		}
		</script>
		<style>
		h1 { 
			color: #666666;
			font-size: 1.5em;
			border-left: 25px solid #666666;
			border-right: 1px solid #666666;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			padding: 0 0 2px 5px;
		}
		</style>	
	  <form action="index2.php" method="POST" name="adminForm">
			<table class="adminheading">
			<tr>
				<th width="100%">
				<?php echo _MXC_CPL_CONFIG; ?>
				</th>
				<td align="right">&nbsp;
				
				</td>
				<td>&nbsp;
				
				</td>
			</tr>
			</table>
	  <table cellpadding="4" cellspacing="0" border="0" width="100%" >
	  <tr>
	  <td width="100%">
	  <?php
	  
	  
	  if ( !isset($mxc_showfavouredcounter) || !isset($mxc_use_gravatar) || !isset($mxc_replaceCBavatar) || !isset($mxc_maxgravatarwidth) ) {
	  	echo "<h3>" . _MXC_WARNING_CONFIG . "</h3>";
	  }
	  
	  $mxc_cfgtabs = new mosTabs( 0 );
	  $mxc_cfgtabs->startPane( "max_comment" );
	  $mxc_cfgtabs->startTab( _MXC_GENERAL ,"General-page");
	  ?>
	  <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminform">
		   <tr align="left" valign="middle">
			 <th width="24%">&nbsp;</th>
			 <th width="20%"><?php echo _MXC_CURRENTSETTINGS; ?></th>
			 <th width="56%"><?php echo _MXC_EXPLANATION; ?></th>
		  </tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_GENERAL; ?></h1></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_MAINOPERATINGMODE; ?></td>
		  <td align="left" valign="top">
		  <?php
			$acmainmode[] = mosHTML::makeOption( '0', _MXC_MANUAL );
			$acmainmode[] = mosHTML::makeOption( '2', _MXC_SEMIAUTOMATIC );
			$acmainmode[] = mosHTML::makeOption( '1', _MXC_AUTOMATIC );
			$mc_mxc_mainmode = mosHTML::selectList( $acmainmode, 'mxc_mainmode', 'class="inputbox" size="1"', 'value', 'text', $mxc_mainmode );
			echo $mc_mxc_mainmode;
		  ?>	  
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_MANUAL; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_SECTIONSAVAILABLE; ?></td>
		  <td align="left" valign="top"><select size="5" name="acselections[]" class="inputbox" multiple="multiple">
		  <?php
			$seclistarray = explode (",", $mxc_sectionlist);
			$database -> setQuery("SELECT id, title FROM #__sections WHERE published='1' ORDER BY title ASC");
			$dbsectionlist = $database -> loadObjectList();
			foreach ($dbsectionlist as $row){
			  echo "<option value='" . $row->id . "'";
			  if (in_array ($row->id, $seclistarray)) echo " selected";
			  echo ">" . stripslashes( $row->title ) . "</option>";
			}
		  ?>
			</select>
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_AUTOMATIC; ?></td>
		</tr>
		<tr align="center" valign="middle" class="adminForm">
          <td align="left" valign="top"><?php echo _MXC_COMMENTFORM ; ?></td>
          <td align="left" valign="top">
            <?php
        $openingmode[] = mosHTML::makeOption( '0', _MXC_OPENINSAMEWINDOW );
        $openingmode[] = mosHTML::makeOption( '1', _MXC_OPENINPOPUPWINDOW );
        $list_openingmode = mosHTML::selectList( $openingmode, 'mxc_openingmode', 'class="inputbox" size="2"', 'value', 'text', $mxc_openingmode );
        echo $list_openingmode;
      ?>
          </td>
          <td align="left" valign="top"><?php echo _MXC_EXPL_COMMENTFORM ; ?></td>
		  </tr>
		<tr align="left" valign="middle">
		  <td valign="top" class="row0"><?php echo _MXC_WIDTH_POPUP ; ?></td>
		  <td valign="top" class="row0"><input name="mxc_width_popup" type="text" id="mxc_width_popup" size="6" value="<?php echo $mxc_width_popup ; ?>"> 
		  px 
</td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_WIDTH_POPUP ; ?></td>
		  </tr>
		<tr align="left" valign="middle">
		  <td valign="top" class="row0"><?php echo _MXC_HEIGHT_POPUP ; ?></td>
		  <td valign="top" class="row0"><input name="mxc_height_popup" type="text" id="mxc_height_popup" size="6" value="<?php echo $mxc_height_popup ; ?>"> 
		  px 
</td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_HEIGHT_POPUP ; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_AUTOPUBLICHCOMMENTS; ?></td>
		  <td align="left" valign="top">
		  <?php
			echo mosHTML::yesnoRadioList( 'mxc_autopublish', 'class="inputbox"', $mxc_autopublish );
		  ?>
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_AUTOPUBLICHCOMMENTS ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_ANONYMOUSCOMMENTS; ?></td>
		  <td align="left" valign="top">
		  <?php
			echo mosHTML::yesnoRadioList( 'mxc_anonentry', 'class="inputbox"', $mxc_anonentry );
		  ?>
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_ANONYMOUSCOMMENTS ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_REPORTCOMMENT; ?></td>
		  <td align="left" valign="top">
            <?php
			echo mosHTML::yesnoRadioList( 'mxc_report', 'class="inputbox"', $mxc_report );
		  ?>
</td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_REPORTCOMMENT; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_REPLYCOMMENT; ?></td>
		  <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_reply', 'class="inputbox"', $mxc_reply );
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_REPLYCOMMENT; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_SHOWNAMEORUSERNAME;?></td>
		  <td align="left" valign="top">
			<?php
				//Build  box
				$confshowusername[] = mosHTML::makeOption( '1', _MXC_NAME );
				$confshowusername[] = mosHTML::makeOption( '0', _MXC_USERNAME );		
				$listshowusername = mosHTML::selectList( $confshowusername, 'mxc_use_name', 'size="2"', 'value', 'text', $mxc_use_name );
				echo $listshowusername;		
			?>
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_SHOWNAMEORUSERNAME; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_USEMAXCOMMENTONARCHIVES; ?></td>
		  <td align="left" valign="top">
			<?php
			echo mosHTML::yesnoRadioList( 'mxc_showonarchives', 'class="inputbox"', $mxc_showonarchives );
		  ?>
		  </td>
		  <td align="left" valign="top">&nbsp;</td>
		</tr>
	  </table>
	  <?php
	  $mxc_cfgtabs->endTab();
	  $mxc_cfgtabs->startTab( _MXC_TEMPLATE ,"Template-page");
	  ?>
	  <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminform">
		   <tr align="left" valign="middle">
			 <th width="24%">&nbsp;</th>
			 <th width="20%"><?php echo _MXC_CURRENTSETTINGS; ?></th>
			 <th width="56%"><?php echo _MXC_EXPLANATION; ?></th>
		  </tr>  
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_TEMPLATE; ?>&nbsp;&nbsp;<span class="small">
		  <a href="components/com_maxcomment/vars_tpl.html" target="_blank"><?php echo _MXC_SEE_ALL_VARS_TPL ;?></a></span></h1>
		  </td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_COMMENTS_SORTING;?></td>
		  <td align="left" valign="top">
			<?php
			$acsorting[] = mosHTML::makeOption( 'DESC', _MXC_NEW_ENTRIES_FIRST );
			$acsorting[] = mosHTML::makeOption( 'ASC', _MXC_NEW_ENTRIES_LAST );
			$mc_mxc_sorting = mosHTML::selectList( $acsorting, 'mxc_sorting', 'class="inputbox" size="1"', 'value', 'text', $mxc_sorting );
			echo $mc_mxc_sorting;
		  ?>
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_COMMENTS_SORTING; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_AUTOLIMIT_NUM_COMMENTS_PER_ARTICLE; ?></td>
		  <td align="left" valign="top"><?php
				//Build  box
				$confnbtotalcomment[] = mosHTML::makeOption( '10', '10' );	
				$confnbtotalcomment[] = mosHTML::makeOption( '20', '20' );	
				$confnbtotalcomment[] = mosHTML::makeOption( '30', '30' );	
				$confnbtotalcomment[] = mosHTML::makeOption( '40', '40' );	
				$confnbtotalcomment[] = mosHTML::makeOption( '50', '50' );	
				$confnbtotalcomment[] = mosHTML::makeOption( '100', '100' );
				$confnbtotalcomment[] = mosHTML::makeOption( '150', '150' );
				$confnbtotalcomment[] = mosHTML::makeOption( '200', '200' );
				$confnbtotalcomment[] = mosHTML::makeOption( '300', '300' );
				$confnbtotalcomment[] = mosHTML::makeOption( '400', '400' );
				$confnbtotalcomment[] = mosHTML::makeOption( '500', '500' );
				$confnbtotalcomment[] = mosHTML::makeOption( '1000', '1000' );
				$confnbtotalcomment[] = mosHTML::makeOption( '0', _MXC_UNLIMITED );
				$listnbtotalcomment = mosHTML::selectList( $confnbtotalcomment, 'mxc_numautolimit', 'size="1"', 'value', 'text', $mxc_numautolimit );
				echo $listnbtotalcomment;		
			?></td>
		  <td align="left" valign="top"><?php echo _MXC_DISABLED_ADD_FORM; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_COMMENTPERPAGE; ?></td>
		  <td align="left" valign="top">
			<?php
				//Build  box
				$confnbcomments[] = mosHTML::makeOption( '5', '5' );
				$confnbcomments[] = mosHTML::makeOption( '6', '6' );
				$confnbcomments[] = mosHTML::makeOption( '8', '8' );
				$confnbcomments[] = mosHTML::makeOption( '10', '10' );		
				$confnbcomments[] = mosHTML::makeOption( '15', '15' );	
				$confnbcomments[] = mosHTML::makeOption( '20', '20' );	
				$confnbcomments[] = mosHTML::makeOption( '25', '25' );	
				$confnbcomments[] = mosHTML::makeOption( '30', '30' );	
				$confnbcomments[] = mosHTML::makeOption( '40', '40' );	
				$confnbcomments[] = mosHTML::makeOption( '50', '50' );
				$confnbcomments[] = mosHTML::makeOption( '100', '100' );
				$confnbcomments[] = mosHTML::makeOption( '500', '500' );
				$confnbcomments[] = mosHTML::makeOption( '1000', '1000' );
				$listnbcomments = mosHTML::selectList( $confnbcomments, 'mxc_numcomments', 'size="1"', 'value', 'text', $mxc_numcomments );
				echo $listnbcomments;		
			?>
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_COMMENTPERPAGE; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_TEMPLATE; ?></td>
		  <td align="left" valign="top"><?php	
				//Build  box
				$directorytpl = opendir( $mosConfig_absolute_path."/components/com_maxcomment/templates" );
				while( FALSE !== ($entryname = readdir($directorytpl))){
					if( $entryname!='.' && $entryname!='..' && $entryname!='' && is_dir($mosConfig_absolute_path."/components/com_maxcomment/templates/".$entryname)==true ){
						$conftemplate[] = mosHTML::makeOption( $entryname, str_replace("_", " ", $entryname) );	
					}
				}
				closedir($directorytpl);  			
				$listtemplate = mosHTML::selectList( $conftemplate, 'mxc_template', 'size="1"', 'value', 'text', $mxc_template );
				echo $listtemplate;				  
			?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_CHOOSE_TEMPLATE; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_SHOWRSSFEED; ?> <img src="<?php echo $mosConfig_live_site ; ?>/components/com_maxcomment/images/rss.gif" width="29" height="15" align="absmiddle" alt="" /></td>
		  <td align="left" valign="top"><?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showrssfeed', 'class="inputbox"', $mxc_showrssfeed );
			?></td>
		  <td align="left" valign="top">
			<?php
				//Build  box
				$confnbrss[] = mosHTML::makeOption( '5', '5 links' );
				$confnbrss[] = mosHTML::makeOption( '10', '10 links' );		
				$confnbrss[] = mosHTML::makeOption( '15', '15 links' );
				$confnbrss[] = mosHTML::makeOption( '20', '20 links' );
				$listnbrss = mosHTML::selectList( $confnbrss, 'mxc_numrssfeed', 'size="1"', 'value', 'text', $mxc_numrssfeed );
				echo $listnbrss;		
			?>
		  </td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_DATEFORMAT; ?></td>
		  <td align="left" valign="top">
			<input name="mxc_fdate" type="text" id="mxc_fdate" value="<?php echo $mxc_fdate; ?>">
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_DATEFORMAT; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_LOADINGELEMENTS; ?></h1></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_AUTHORARTICLE; ?></td>
		  <td align="left" valign="top" class="adminForm">
		  <?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showauthorlink', 'class="inputbox"', $mxc_showauthorlink );
		  ?>
			</td>
		  <td align="left" valign="top">&nbsp;</td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_SHOWDATECREATED; ?></td>
		  <td align="left" valign="top" class="adminForm">
            <?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showdatecreated', 'class="inputbox"', $mxc_showdatecreated );
		  ?>
          </td>
		  <td align="left" valign="top">&nbsp;</td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_SHOWDATEMODIFIED; ?></td>
		  <td align="left" valign="top" class="adminForm">
            <?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showdatemodified', 'class="inputbox"', $mxc_showdatemodified );
		  ?>
          </td>
		  <td align="left" valign="top">&nbsp;</td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_SECTION; ?></td>
		  <td align="left" valign="top" class="adminForm">
		   <?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showsectionlink', 'class="inputbox"', $mxc_showsectionlink );
			?>
		  </td>
		  <td align="left" valign="top">&nbsp;</td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_CATEGORY; ?></td>
		  <td align="left" valign="top" class="adminForm">
		   <?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showcategorylink', 'class="inputbox"', $mxc_showcategorylink );
			?>
		  </td>
		  <td align="left" valign="top">&nbsp;</td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_KEYWORDS ;?></td>
		  <td align="left" valign="top" class="adminForm"><?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showkeywordslink', 'class="inputbox"', $mxc_showkeywordslink );
			?></td>
		  <td align="left" valign="top">&nbsp;</td>
		</tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top" class="adminForm"><?php echo _MXC_HITS_VIEWS; ?></td>
          <td align="left" valign="top" class="adminForm"><?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showhits', 'class="inputbox"', $mxc_showhits );
			?></td>
          <td align="left" valign="top">&nbsp;</td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_SHOW_STATUT; ?></td>
		  <td align="left" valign="top" class="adminForm"><?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showstatus', 'class="inputbox"', $mxc_showstatus );
			?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_SHOW_STATUT ; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_SHOW_IP; ?></td>
		  <td align="left" valign="top" class="adminForm">
		  <?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showIp', 'class="inputbox"', $mxc_showIp );
		  ?>		  
		  </td>
		  <td align="left" valign="top">&nbsp;</td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_SHOW_FAVOUREDCOUNTER; ?></td>
		  <td align="left" valign="top" class="adminForm"><?php		
			  echo mosHTML::yesnoRadioList( 'mxc_showfavouredcounter', 'class="inputbox"', $mxc_showfavouredcounter );
			?></td>
		  <td align="left" valign="top">&nbsp;</td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top" class="adminForm"><?php echo _MXC_USERSCOMMENTS; ?></td>
          <td align="left" valign="top" class="adminForm">
            <?php
			$acOptionImage = "";
			$acOptionImage[] = mosHTML::makeOption( '0', _MXC_NO );
			$acOptionImage[] = mosHTML::makeOption( '1', _MXC_LINK );
			$acOptionImage[] = mosHTML::makeOption( '2', _MXC_IMAGE );
			$mc_mxc_OptionImage = mosHTML::selectList( $acOptionImage, 'mxc_showcommentusers', 'class="inputbox" size="1"', 'value', 'text', $mxc_showcommentusers );
			echo $mc_mxc_OptionImage;
		  ?></td>
          <td align="left" valign="top"><?php echo _MXC_LABEL; ?>&nbsp;&nbsp;
              <input name="mxc_label_showcommentusers" type="text" id="mxc_label_showcommentusers" value="<?php echo stripslashes($mxc_label_showcommentusers); ?>" size="30"></td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top" class="adminForm"><?php echo _MXC_EDITORSCOMMENTS; ?></td>
          <td align="left" valign="top" class="adminForm">
            <?php
			$acOptionImage = "";
			$acOptionImage[] = mosHTML::makeOption( '0', _MXC_NO );
			$acOptionImage[] = mosHTML::makeOption( '1', _MXC_LINK );
			$acOptionImage[] = mosHTML::makeOption( '2', _MXC_IMAGE );
			$mc_mxc_OptionImage = mosHTML::selectList( $acOptionImage, 'mxc_showcommenteditor', 'class="inputbox" size="1"', 'value', 'text', $mxc_showcommenteditor );
			echo $mc_mxc_OptionImage;
		  ?></td>
          <td align="left" valign="top"><?php echo _MXC_LABEL; ?>&nbsp;&nbsp;
              <input name="mxc_label_showcommenteditor" type="text" id="mxc_label_showcommenteditor" value="<?php echo stripslashes($mxc_label_showcommenteditor); ?>" size="30"></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_QUOTETHIS; ?></td>
		  <td align="left" valign="top" class="adminForm"><?php
		  	$acOptionImage = "";
			$acOptionImage[] = mosHTML::makeOption( '0', _MXC_NO );
			$acOptionImage[] = mosHTML::makeOption( '1', _MXC_LINK );
			$acOptionImage[] = mosHTML::makeOption( '2', _MXC_IMAGE );
			$mc_mxc_OptionImage = mosHTML::selectList( $acOptionImage, 'mxc_showquotelink', 'class="inputbox" size="1"', 'value', 'text', $mxc_showquotelink );
			echo $mc_mxc_OptionImage;
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_LABEL; ?>&nbsp;&nbsp;
		    <input name="mxc_label_quote" type="text" id="mxc_label_quote" value="<?php echo stripslashes($mxc_label_quote); ?>" size="30"></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_FAVOURED; ?></td>
		  <td align="left" valign="top" class="adminForm"><?php
		  	$acOptionImage = "";
			$acOptionImage[] = mosHTML::makeOption( '0', _MXC_NO );
			$acOptionImage[] = mosHTML::makeOption( '1', _MXC_LINK );
			$acOptionImage[] = mosHTML::makeOption( '2', _MXC_IMAGE );
			$mc_mxc_OptionImage = mosHTML::selectList( $acOptionImage, 'mxc_showfavoured', 'class="inputbox" size="1"', 'value', 'text', $mxc_showfavoured );
			echo $mc_mxc_OptionImage;
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_LABEL; ?>&nbsp;&nbsp;
            <input name="mxc_label_favoured" type="text" id="mxc_label_favoured" value="<?php echo stripslashes($mxc_label_favoured); ?>" size="30"></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_PRINT; ?></td>
		  <td align="left" valign="top" class="adminForm"><?php
		    $acOptionImage = "";
			$acOptionImage[] = mosHTML::makeOption( '0', _MXC_NO );
			$acOptionImage[] = mosHTML::makeOption( '1', _MXC_LINK );
			$acOptionImage[] = mosHTML::makeOption( '2', _MXC_IMAGE );
			$mc_mxc_OptionImage = mosHTML::selectList( $acOptionImage, 'mxc_showprintlink', 'class="inputbox" size="1"', 'value', 'text', $mxc_showprintlink );
			echo $mc_mxc_OptionImage;
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_LABEL; ?>&nbsp;&nbsp;
            <input name="mxc_label_print" type="text" id="mxc_label_print" value="<?php echo stripslashes($mxc_label_print); ?>" size="30"></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_SENDBYEMAIL; ?></td>
		  <td align="left" valign="top" class="adminForm"><?php
		    $acOptionImage = "";
			$acOptionImage[] = mosHTML::makeOption( '0', _MXC_NO );
			$acOptionImage[] = mosHTML::makeOption( '1', _MXC_LINK );
			$acOptionImage[] = mosHTML::makeOption( '2', _MXC_IMAGE );
			$mc_mxc_OptionImage = mosHTML::selectList( $acOptionImage, 'mxc_showsendemaillink', 'class="inputbox" size="1"', 'value', 'text', $mxc_showsendemaillink );
			echo $mc_mxc_OptionImage;
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_LABEL; ?>&nbsp;&nbsp;
            <input name="mxc_label_sendmail" type="text" id="mxc_label_sendmail" value="<?php echo stripslashes($mxc_label_sendmail); ?>" size="30"></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_DELICIOUS; ?></td>
		  <td align="left" valign="top" class="adminForm"><?php
		    $acOptionImage = "";
			$acOptionImage[] = mosHTML::makeOption( '0', _MXC_NO );
			$acOptionImage[] = mosHTML::makeOption( '1', _MXC_LINK );
			$acOptionImage[] = mosHTML::makeOption( '2', _MXC_IMAGE );
			$mc_mxc_OptionImage = mosHTML::selectList( $acOptionImage, 'mxc_showdeliciouslink', 'class="inputbox" size="1"', 'value', 'text', $mxc_showdeliciouslink );
			echo $mc_mxc_OptionImage;
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_LABEL; ?>&nbsp;&nbsp;
              <input name="mxc_label_delicious" type="text" id="mxc_label_delicious" value="<?php echo stripslashes($mxc_label_delicious); ?>" size="30"></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_RELATEDARTICLES; ?></td>
		  <td align="left" valign="top" class="adminForm"><?php
		    $acOptionImage = "";
			$acOptionImage[] = mosHTML::makeOption( '0', _MXC_NO );
			$acOptionImage[] = mosHTML::makeOption( '1', _MXC_LINK );
			$acOptionImage[] = mosHTML::makeOption( '2', _MXC_IMAGE );
			$mc_mxc_OptionImage = mosHTML::selectList( $acOptionImage, 'mxc_showrelatedarticles', 'class="inputbox" size="1"', 'value', 'text', $mxc_showrelatedarticles );
			echo $mc_mxc_OptionImage;
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_LABEL; ?>&nbsp;&nbsp;
            <input name="mxc_label_related" type="text" id="mxc_label_related" value="<?php echo stripslashes($mxc_label_related); ?>" size="30"> 
            &nbsp;<?php echo _MXC_DISPLAY_X_RELATEDITEM; ?> <input name="mxc_limitrelated" type="text" id="mxc_limitrelated" value="<?php echo $mxc_limitrelated; ?>" size="4"></td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top" class="adminForm"><?php echo _MXC_READMORE; ?></td>
          <td align="left" valign="top" class="adminForm">
		  <?php
		    $acOptionImage = "";
			$acOptionImage[] = mosHTML::makeOption( '0', _MXC_NO );
			$acOptionImage[] = mosHTML::makeOption( '1', _MXC_LINK );
			$acOptionImage[] = mosHTML::makeOption( '2', _MXC_IMAGE );
			$mc_mxc_OptionImage = mosHTML::selectList( $acOptionImage, 'mxc_showreadmorelink', 'class="inputbox" size="1"', 'value', 'text', $mxc_showreadmorelink );
			echo $mc_mxc_OptionImage;
		  ?>
		  </td>
          <td align="left" valign="top"><?php echo _MXC_LABEL; ?>&nbsp;&nbsp;
              <input name="mxc_label_readmore" type="text" id="mxc_label_readmore" value="<?php echo stripslashes($mxc_label_readmore); ?>" size="30"></td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top" class="adminForm"><?php echo _MXC_OPACITYEFFECTONIMAGE; ?></td>
          <td align="left" valign="top" class="adminForm"><?php
				echo mosHTML::yesnoRadioList( 'mxc_opacityeffect', 'class="inputbox"', $mxc_opacityeffect ); ?></td>
          <td align="left" valign="top"><?php echo _MXC_EXPL_OPACITYEFFECTONIMAGE; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top" class="adminForm"><?php echo _MXC_OPACITYEFFECTPERCENT; ?></td>
		  <td align="left" valign="top" class="adminForm">		  
		  <?php
		    $acOptionImage = "";
			$acOptionImage[] = mosHTML::makeOption( '10', '10' );
			$acOptionImage[] = mosHTML::makeOption( '20', '20' );
			$acOptionImage[] = mosHTML::makeOption( '30', '30' );
			$acOptionImage[] = mosHTML::makeOption( '40', '40' );
			$acOptionImage[] = mosHTML::makeOption( '50', '50' );
			$acOptionImage[] = mosHTML::makeOption( '60', '60' );
			$acOptionImage[] = mosHTML::makeOption( '70', '70' );
			$acOptionImage[] = mosHTML::makeOption( '80', '80' );
			$acOptionImage[] = mosHTML::makeOption( '90', '90' );
			$mc_mxc_OptionImage = mosHTML::selectList( $acOptionImage, 'mxc_opacityeffectpercent', 'class="inputbox" size="1"', 'value', 'text', $mxc_opacityeffectpercent );
			echo $mc_mxc_OptionImage;
		  ?>

		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_OPACITYEFFECTPERCENT; ?></td>
		</tr>
	  </table>
	  <?php
	  $mxc_cfgtabs->endTab();
	  $mxc_cfgtabs->startTab( _MXC_FEATURES ,"Features-page");
	  ?>  <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminform">
			<tr align="left" valign="middle">
			 <th width="24%">&nbsp;</th>
			 <th width="20%"><?php echo _MXC_CURRENTSETTINGS; ?></th>
			 <th width="56%"><?php echo _MXC_EXPLANATION; ?></th>
		  </tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_NEW; ?></h1></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_SHOWICONNEW; ?></td>
		  <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_showiconnew', 'class="inputbox"', $mxc_showiconnew );
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_SHOWICONNEW; ?>&nbsp;<img src="<?php echo $mosConfig_live_site ; ?>/administrator/components/com_maxcomment/images/new.gif" alt="" /></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_DAYS_NEW; ?></td>
		  <td align="left" valign="top"><input name="mxc_numdays4showIconNew" type="text" value="<?php echo $mxc_numdays4showIconNew ; ?>" size="8" maxlength="5"></td>
		  <td align="left" valign="top">&nbsp;</td>
		  </tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_POPULAR; ?></h1></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_SHOWICONPOPULAR; ?></td>
		  <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_showiconpopular', 'class="inputbox"', $mxc_showiconpopular );
		  ?></td>
		  <td align="left" valign="top">&nbsp;</td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_LIMITFORSHOWICONPOPULAR; ?> (1) </td>
		  <td align="left" valign="top"><input name="mxc_limitheart1" type="text" value="<?php echo $mxc_limitheart1 ; ?>" size="8" maxlength="5"> 
		  <?php echo _MXC_HITS_VIEWS; ?></td>
		  <td align="left" valign="top"><img src="<?php echo $mosConfig_live_site ; ?>/administrator/components/com_maxcomment/images/icon_popular_1.gif" alt="" /></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_LIMITFORSHOWICONPOPULAR; ?> (2)</td>
		  <td align="left" valign="top"><input name="mxc_limitheart2" type="text" value="<?php echo $mxc_limitheart2 ; ?>" size="8" maxlength="5"> 
		  <?php echo _MXC_HITS_VIEWS; ?></td>
		  <td align="left" valign="top"><img src="<?php echo $mosConfig_live_site ; ?>/administrator/components/com_maxcomment/images/icon_popular_2.gif" alt="" /></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_LIMITFORSHOWICONPOPULAR; ?> (3)</td>
		  <td align="left" valign="top"><input name="mxc_limitheart3" type="text" value="<?php echo $mxc_limitheart3 ; ?>" size="8" maxlength="5"> 
		  <?php echo _MXC_HITS_VIEWS; ?></td>
		  <td align="left" valign="top"><img src="<?php echo $mosConfig_live_site ; ?>/administrator/components/com_maxcomment/images/icon_popular_3.gif" alt="" /></td>
		</tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_RATING_2; ?></h1></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="middle"><?php echo _MXC_EDITORSRATING; ?></td>
		  <td align="left" valign="middle">
			<?php
			echo mosHTML::yesnoRadioList( 'mxc_ratingeditor', 'class="inputbox"', $mxc_ratingeditor );
		  ?>
		  </td>
		  <td align="left" valign="middle"><img src="<?php echo $mosConfig_live_site ; ?>/administrator/components/com_maxcomment/images/stars_editor_4.gif" alt="" />&nbsp;&nbsp;&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family:verdana;font-size:18px;width:60px;height:68px;vertical-align:middle;text-align:center;line-height:68px;background: url(<?php echo $mosConfig_live_site; ?>/administrator/components/com_maxcomment/images/bgground_rating.gif) no-repeat;">8/10</span>&nbsp;&nbsp;&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family:verdana;font-size:18px;width:60px;height:68px;vertical-align:middle;text-align:center;line-height:68px;background: url(<?php echo $mosConfig_live_site; ?>/administrator/components/com_maxcomment/images/bgground_rating.gif) no-repeat;">16/20</span></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="middle"><?php echo _MXC_USERSRATING; ?></td>
		  <td align="left" valign="middle">
			<?php
			echo mosHTML::yesnoRadioList( 'mxc_ratinguser', 'class="inputbox"', $mxc_ratinguser );
		  ?>
		  </td>
		  <td align="left" valign="middle"><img src="<?php echo $mosConfig_live_site ; ?>/administrator/components/com_maxcomment/images/stars_user_4.gif" alt="" />&nbsp;&nbsp;&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;&nbsp;<span style="font-family:verdana;font-size:18px;width:60px;height:68px;vertical-align:middle;text-align:center;line-height:68px;background: url(<?php echo $mosConfig_live_site; ?>/administrator/components/com_maxcomment/images/bgground_rating.gif) no-repeat;">8/10</span>&nbsp;&nbsp;&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family:verdana;font-size:18px;width:60px;height:68px;vertical-align:middle;text-align:center;line-height:68px;background: url(<?php echo $mosConfig_live_site; ?>/administrator/components/com_maxcomment/images/bgground_rating.gif) no-repeat;">16/20</span></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="middle"><?php echo _MXC_LEVEL_RATING ;?></td>
		  <td align="left" valign="middle">
			<?php
				//Build  box
				$rat[] = mosHTML::makeOption( '5', '5' );
				$rat[] = mosHTML::makeOption( '10', '10' );		
				$rat[] = mosHTML::makeOption( '20', '20' );
				$listlevelrating = mosHTML::selectList( $rat, 'mxc_levelrating', 'size="1"', 'value', 'text', $mxc_levelrating );
				echo $listlevelrating;		
			?>
		  </td>
		  <td align="left" valign="top">&nbsp;</td>
		</tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_FAVOURED; ?></h1></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_USERS; ?></td>
		  <td align="left" valign="top">
			<?php
			$favoured_user[] = mosHTML::makeOption( '1', _MXC_REGISTERED_ONLY );
			$favoured_user[] = mosHTML::makeOption( '0', _MXC_ALL_USERS );
			$list_favoured_user = mosHTML::selectList( $favoured_user, 'mxc_favoured_user', 'class="inputbox" size="1"', 'value', 'text', $mxc_favoured_user );
			echo $list_favoured_user;
		  ?>
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_WHO_ADD_FAVOURITE; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_NUMBEROFFAVOURITES; ?></td>
		  <td align="left" valign="top"><?php
				//Build  box
				$confnbfavoured[] = mosHTML::makeOption( '3', '3' );
				$confnbfavoured[] = mosHTML::makeOption( '5', '5' );
				$confnbfavoured[] = mosHTML::makeOption( '6', '6' );
				$confnbfavoured[] = mosHTML::makeOption( '10', '10' );		
				$confnbfavoured[] = mosHTML::makeOption( '15', '15' );	
				$confnbfavoured[] = mosHTML::makeOption( '20', '20' );	
				$confnbfavoured[] = mosHTML::makeOption( '25', '25' );	
				$confnbfavoured[] = mosHTML::makeOption( '30', '30' );	
				$confnbfavoured[] = mosHTML::makeOption( '50', '50' );
				$listnbfavoured = mosHTML::selectList( $confnbfavoured, 'mxc_numfavoured', 'size="1"', 'value', 'text', $mxc_numfavoured );
				echo $listnbfavoured;		
			?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_AFTER_VOTING_FAVOURITE; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_MENUS_FOR_FAVOURED; ?></h1></td>
		</tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"> <strong><?php echo _MXC_HOWCREATEMENU_1; ?></strong><br />
			  <br /><code>
		- go to Menu &gt; mainmenu &gt; then select New <br />
		- Choose type " Link - URL " then write the URL to be : <font color="green">index.php?option=com_maxcomment&amp;task=morefav</font></code></td>
		</tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><strong><br />
		<?php echo _MXC_HOWCREATEMENU_2; ?></strong><br />
		<br />
		- go to Menu &gt; usermenu &gt; then select New <br /><code>
		- Choose type " Link - URL " then write the URL to be : <font color="green">index.php?option=com_maxcomment&amp;task=myfavoured</font></code></td>
		</tr>
	  </table>
		<?php
	  $mxc_cfgtabs->endTab();
	  $mxc_cfgtabs->startTab( _MXC_POSTING ,"Posting-page");
		?>
	  <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminform">
		   <tr align="left" valign="middle">
			 <th width="24%">&nbsp;</th>
			 <th width="20%"><?php echo _MXC_CURRENTSETTINGS; ?></th>
			 <th width="56%"><?php echo _MXC_EXPLANATION; ?></th>
		  </tr>  
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_POSTING; ?></h1></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_MAXCOMMENTLENGTH; ?> </td>
		  <td align="left" valign="top">
			<input name="mxc_lengthcomment" type="text" value="<?php echo $mxc_lengthcomment ; ?>" size="8" maxlength="5">
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_BLANKFORUNLIMITED; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_WRAPWORDLONGERTHAN; ?></td>
		  <td align="left" valign="top"><input name="mxc_lengthwrap" type="text" value="<?php echo $mxc_lengthwrap ; ?>" size="8" maxlength="5"></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_WRAPWORDLONGER; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_BBCODESUPPORT; ?></td>
		  <td align="left" valign="top">
		  <?php
			echo mosHTML::yesnoRadioList( 'mxc_bbcodesupport', 'class="inputbox"', $mxc_bbcodesupport );
		  ?>
		  </td>
		  <td align="left" valign="top" width="56%"><?php echo _MXC_EXPL_BBCODESUPPORT; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_PICTURESUPPORT; ?></td>
		  <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_picturesupport', 'class="inputbox"', $mxc_picturesupport );
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_PICTURESUPPORT; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_MAX_WIDTH_PICTURESUPPORT ; ?></td>
		  <td align="left" valign="top"><input name="mxc_bbcodewidthpicture" type="text" value="<?php echo $mxc_bbcodewidthpicture ; ?>" size="8" maxlength="5"></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_WIDTH_PICTURESUPPORT ; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_SMILIESSUPPORT; ?></td>
		  <td align="left" valign="top">
			<?php
			echo mosHTML::yesnoRadioList( 'mxc_smiliesupport', 'class="inputbox"', $mxc_smiliesupport );
		  ?>
		  </td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_SMILIESSUPPORT; ?></td>
		</tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top"><?php echo _MXC_DISPLAY_TITLE_FIELD; ?></td>
          <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_displaytitle', 'class="inputbox"', $mxc_displaytitle );
		  ?></td>
          <td align="left" valign="top"><?php echo _MXC_EXPL_DISPLAY_TITLE_FIELD; ?></td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top"><?php echo _MXC_DISPLAY_EMAIL_FIELD; ?></td>
          <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_displayemail', 'class="inputbox"', $mxc_displayemail );
		  ?></td>
          <td align="left" valign="top"><?php echo _MXC_EXPL_DISPLAY_EMAIL_FIELD; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_SHOWCHECKBOXFORCONTACT; ?></td>
		  <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_displaycheckboxcontact', 'class="inputbox"', $mxc_displaycheckboxcontact );
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_SHOWCHECKBOXFORCONTACT; ?></td>
		</tr>
	  </table>
	  <?php
		$mxc_cfgtabs->endTab();
		$mxc_cfgtabs->startTab( _MXC_SECURITY ,"Security-page");
	  ?>
	  <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminform">
		   <tr align="left" valign="middle">
			 <th width="24%">&nbsp;</th>
			 <th width="20%"><?php echo _MXC_CURRENTSETTINGS; ?></th>
			 <th width="56%"><?php echo _MXC_EXPLANATION; ?></th>
		  </tr>  
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_SECURITY; ?></h1></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_NOTIFYADMIN; ?></td>
		  <td align="left" valign="top">
		  <?php
			echo mosHTML::yesnoRadioList( 'mxc_notify', 'class="inputbox"', $mxc_notify );
		  ?>
		  </td>
		  <td align="left" valign="top" width="56%"><?php echo _MXC_EXPL_NOTIFYADMIN; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_ADMINEMAIL; ?></td>
		  <td align="left" valign="top"><input name="mxc_notify_email" type="text" value="<?php echo "$mxc_notify_email"; ?>" size="35"></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_ADMINEMAIL; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_FLOODPROTECTION; ?></td>
		  <td align="left" valign="top"><input name="mxc_timeout" type="text" value="<?php echo $mxc_timeout ; ?>" size="8" maxlength="5"></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_FLOODPROTECTION; ?></td>
		</tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top"><?php echo _MXC_BADWORDSFILTER; ?></td>
          <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_badwords', 'class="inputbox"', $mxc_badwords );
		  ?></td>
          <td align="left" valign="top"><?php echo _MXC_EXPL_BADWORDSFILTER; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_SPAMPREVENTION; ?></h1></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_MATHGUARD; ?></td>
		  <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_use_mathguard', 'class="inputbox"', $mxc_use_mathguard );
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_MATHGUARD_URL; ?></td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top"><?php echo _MXC_ASKIMET; ?></td>
          <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_use_askimet', 'class="inputbox"', $mxc_use_askimet );
		  ?></td>
          <td align="left" valign="top"><?php echo _MXC_EXPL_USEASKIMET; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_WORDPRESSKEYAPI; ?></td>
		  <td align="left" valign="top"><input name="mxc_wordpressapikey" type="text" value="<?php echo $mxc_wordpressapikey; ?>" size="35"></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_WORDPRESSKEYAPI ; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_BLOGURL; ?></td>
		  <td align="left" valign="top"><input name="mxc_akismetblogurl" type="text" value="<?php echo $mxc_akismetblogurl; ?>" size="35"></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_BLOGURL; ?></td>
		</tr>
	  </table>
	  <?php
	  $mxc_cfgtabs->endTab();
		 $mxc_cfgtabs->startTab( _MXC_INTEGRATION ,"Integration-page");
	  ?>
	  <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminform">
		   <tr align="left" valign="middle">
			 <th width="24%">&nbsp;</th>
			 <th width="20%"><?php echo _MXC_CURRENTSETTINGS; ?></th>
			 <th width="56%"><?php echo _MXC_EXPLANATION; ?></th>
		  </tr>  
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_SECURITYIMAGE; ?></h1></td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top"><?php echo _MXC_USESECURITYIMAGE; ?></td>
          <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_use_securityimage', 'class="inputbox"', $mxc_use_securityimage );
		  ?></td>
          <td align="left" valign="top"><?php echo _MXC_EXPL_USESECURITYIMAGE; ?></td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top"><a href="http://www.waltercedric.com" target="_blank">http://www.waltercedric.com</a></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_COMUNITYBUILDER; ?></h1></td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top"><?php echo _MXC_CBAUTORLINK; ?> </td>
          <td align="left" valign="top"><?php		
			  echo mosHTML::yesnoRadioList( 'mxc_LinkCBProfile', 'class="inputbox"', $mxc_LinkCBProfile );
			?></td>
          <td align="left" valign="top"><?php echo _MXC_EXPL_CBAUTORLINK; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_CBAUTORCOMMENTLINK; ?> </td>
		  <td align="left" valign="top"><?php		
			  echo mosHTML::yesnoRadioList( 'mxc_LinkCommentAuthorCBProfile', 'class="inputbox"', $mxc_LinkCommentAuthorCBProfile );
			?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_CBAUTORCOMMENTLINK; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_SHOWAVATARCBPROFILE; ?></td>
		  <td align="left" valign="top"><?php		
			  echo mosHTML::yesnoRadioList( 'mxc_ShowAvatarCBProfile', 'class="inputbox"', $mxc_ShowAvatarCBProfile );
			?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_SHOWAVATARCBPROFILE; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_MAXAVATARWIDTH; ?></td>
		  <td align="left" valign="top"><input name="mxc_maxavatarwidth" type="text" value="<?php echo $mxc_maxavatarwidth ; ?>" size="8" maxlength="5"></td>
		  <td align="left" valign="top"><?php echo _MXC_PIXELS; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_VISUALRECOMMEND; ?></h1></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_USEVISUALRECOMMENDFORMAILFRIEND; ?></td>
		  <td align="left" valign="top"><?php		
			  echo mosHTML::yesnoRadioList( 'mxc_useVisualRecommend', 'class="inputbox"', $mxc_useVisualRecommend );
			?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_USEVISUALRECOMMENDFORMAILFRIEND; ?></td>
		</tr>
		<tr align="center" valign="middle">
		  <td colspan="3" align="left" valign="top"><h1><?php echo _MXC_GRAVATAR; ?></h1></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_SHOW_GRAVATAR_USER; ?></td>
		  <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_use_gravatar', 'class="inputbox"', $mxc_use_gravatar );
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_SHOW_GRAVATAR_USER; ?></td>
		  </tr>
		<tr align="center" valign="middle">
		  <td align="left" valign="top"><?php echo _MXC_REPLACE_CB_AVATAR; ?></td>
		  <td align="left" valign="top"><?php
			echo mosHTML::yesnoRadioList( 'mxc_replaceCBavatar', 'class="inputbox"', $mxc_replaceCBavatar );
		  ?></td>
		  <td align="left" valign="top"><?php echo _MXC_EXPL_REPLACE_CB_AVATAR_BY_GRAVATAR_USER; ?></td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top"><?php echo _MXC_MAXAVATARWIDTH; ?></td>
          <td align="left" valign="top"><input name="mxc_maxgravatarwidth" type="text" value="<?php echo $mxc_maxgravatarwidth ; ?>" size="8" maxlength="5"></td>
          <td align="left" valign="top"><?php echo _MXC_PIXELS; ?></td>
		  </tr>
		<tr align="center" valign="middle">
          <td align="left" valign="top"><?php echo _MXC_CHOOSE_DEFAULT_GRAVATAR; ?></td>
          <td align="left" valign="top">
		  <?php
			$dirlistimg = "/components/com_maxcomment/images/gravatar/";
			$javascript = "onchange=\"javascript:if (document.forms[0].mxc_default_gravatar.options[selectedIndex].value!='') {document.imagelib.src='../components/com_maxcomment/images/gravatar/' + document.forms[0].mxc_default_gravatar.options[selectedIndex].value} else {document.imagelib.src='../components/com_maxcomment/images/gravatar/generic_gravatar_grey.gif'}\"";
			$listgrab = mosAdminMenus::Images( 'mxc_default_gravatar', $mxc_default_gravatar, $javascript, $dirlistimg );
			echo $listgrab;
		  ?>
		  </td>
          <td align="left" valign="top">
			<script language="javascript" type="text/javascript">
			if (document.forms[0].mxc_default_gravatar.options.value!=''){
				jsimg='../components/com_maxcomment/images/gravatar/' + getSelectedValue( 'adminForm', 'mxc_default_gravatar' );
			} else {
				jsimg='../components/com_maxcomment/images/gravatar/generic_gravatar_grey.gif';
			}
			document.write('<img src=' + jsimg + ' name="imagelib" border="0" align="middle" alt="" />');
			</script>
		  </td>
		  </tr>
	  </table>
	  <?php
	  $mxc_cfgtabs->endTab();
	  $mxc_cfgtabs->endPane();
	  ?>
	  <input type="hidden" name="option" value="<?php echo $option; ?>">
	  <input type="hidden" name="act" value="<?php echo $act; ?>">
	  <input type="hidden" name="task" value="">
	  <input type="hidden" name="boxchecked" value="0">
	 </td>
	</tr>
	</table>
	</form>
<?php
}

	
  function showComments( $option, &$rows, &$search, &$pageNav, &$akismetList, &$mxclangList ) {
	global $mainframe, $mosConfig_live_site, $mxc_levelrating, $mxc_use_askimet;		
	
		$commentlenght = "60";
		
		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading" width="100%">
		<tr>
			<th width="90%">
			<?php
			 echo _MXC_COMMENTS; 
			 
			 if ( $mxc_use_askimet ) {
			 ?>			
			<div class="small"><img src="<?php echo $mosConfig_live_site ; ?>/administrator/components/com_maxcomment/images/akismet.png" align="absmiddle" alt="Akismet" />&nbsp;&nbsp;<a href="index2.php?option=com_maxcomment&task=removeallspam"><?php echo _MXC_DELETEALLSPAM ; ?></a></div>
			<?php } ?>
			</th>
			<?php if ( $mxclangList ) { ?>
				<td align="right">
				<?php echo _MXC_LANGUAGE; ?>:
				</td>			
				<td align="right"><?php echo $mxclangList; ?> </td>
			<?php } ?>
			<td align="right">
			<?php echo _MXC_FILTER; ?>:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
			</td>
			<?php if ( $mxc_use_askimet ) { ?>
			<td>
			<?php echo $akismetList; ?>
			</td>
			<?php } ?>
		</tr>
		</table>
		
		<table class="adminlist" cellspacing="1">
		<thead>
		<tr>
			<th width="5">
			#
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title" width="12%"><div align="left">
			<?php echo _MXC_AUTHOR ; ?></div>
			</th>
			<th class="title" align="left"><div align="left">
			<?php echo _MXC_COMMENT ; ?></div>
			</th>
		    <th width="7%" class="title"><div align="center"><?php echo _MXC_RATING ; ?></div></th>
			<?php if ( $mxc_use_askimet ) { ?>
				<th width="6%" class="title"><div align="left"><?php echo _MXC_SPAM ; ?></div></th>
			<?php } ?>
		    <th width="10%" class="title"><div align="left"><?php echo _MXC_DATE ; ?></div></th>
		    <th width="10%" class="title"><div align="left"><?php echo _MXC_IP ; ?></div></th>
		    <th width="10%" class="title"><div align="center"><?php echo _MXC_CONTENT_ITEM ; ?></div></th>
		    <th width="6%" class="title"><div align="center"><?php echo _MXC_PUBLISHED ; ?></div></th>
		</tr>
		</thead>
		<tfoot>
		  <tr>
			<td colspan="10">
				<?php echo $pageNav->getListFooter(); ?>
			</td>
		  </tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count($rows); $i < $n; $i++) {
			$row = $rows[$i];						
				
			$task 	  = $row->published ? 'unpublish' : 'publish';
			$img 	  = $row->published ? 'publish_g.png' : 'publish_x.png';
			$alt 	  = $row->published ? 'Published' : 'Unpublished';
			$taskSpam = $row->status ? 'unSpam' : 'markSpam';
			$altSpam  = $row->status ? 'Possible spam, checked by Akismet.com' : 'Not spam, checked by Akismet.com';
			$imgSpam  = $row->status ? 'tick.png' : 'publish_x.png';
			
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id );?>				
				</td>
				<td><div align="left">
					<a href="#editcomment" onClick="return listItemTask('cb<?php echo $i;?>','editcomment')" title="<?php echo _MXC_EDIT; ?>">
					<?php echo $row->name; ?>
					</a></div>	
				</td>
				<td><div align="left">
				<?php
				echo "<strong>" . stripslashes($row->title) . "</strong><br />"; 	
					if( strlen($row->comment) > $commentlenght) {
						$row->comment  = substr($row->comment, 0, $commentlenght-3);
						$row->comment .= "...";
					}
				 echo stripslashes($row->comment); 				
				?>
				</div></td>
			    <td><div align="center">
				<?php
				if ( $row->rating ){				
				    //echo "<strong><font color='green'>" . $row->rating . "</font></strong> / " . $mxc_levelrating; 
					echo "<strong><font color='green'>" . number_format(confirm_evaluate( $row->rating, $row->currentlevelrating, $mxc_levelrating ), 1) . "</font></strong> / " . $mxc_levelrating;
				} else echo "-";
				 ?>
				</div></td>				
				<?php if ( $mxc_use_askimet ) { ?>
					<td><div align="center">
					<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $taskSpam;?>')">
					<img src="images/<?php echo $imgSpam;?>" width="12" height="12" border="0" alt="<?php echo $altSpam; ?>" />
					</a>
					</div>
					</td>
				<?php } ?>				
			    <td><div align="left"><?php echo $row->date; ?></div></td>
			    <td><div align="left"><?php echo $row->ip; ?></div></td>
			    <td><div align="center">
				<a href="" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_content&task=view&id=<?php echo $row->contentid; ?>&pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');" title="<?php echo _MXC_PREVIEW_ARTICLE; ?>" >
				<?php echo $row->contentid; ?>
				</a>
				</div></td>
			    <td><div align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</div></td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="usercomments" />
		<input type="hidden" name="typecomment" value="comments">
		<input type="hidden" name="usertable" value="user">
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">
		</form>
		<?php
	}
	
  function editComment( $option, &$row, &$clist, &$olist, &$rlist, &$puplist, &$aksimetlist ) {  
  global $mosConfig_live_site, $mosConfig_absolute_path, $mxc_lengthcomment;
  
  require( $mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php' );		
  
  	mosMakeHtmlSafe( $row, ENT_QUOTES, 'comment' );  
  	if ( $mxc_lengthcomment && !$row->id ) {	
		include_once($mosConfig_absolute_path."/components/com_maxcomment/includes/common/maxlengthcomment.php");
	}
    ?>	
    <script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
      var form = document.adminForm;
      if (pressbutton == 'cancelcomment') {
        submitform( pressbutton );
        return;
      }

      // do field validation
      if (form.comment.value == ""){
        alert( "You must at least write the comment text." );
      } else if (form.contentid.value == "0"){
        alert( "You must select a corresponding content item." );
      } else if (form.name.value == ""){
        alert( "You must enter the author's name." );
      } else {
        submitform( pressbutton );
      }
    }
	
	function x () {
		return;
	}
	
	function mxc_smilie(thesmile) {
		document.adminForm.comment.value += " "+thesmile+" ";
		document.adminForm.comment.focus();
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
	<?php } ?>
	<form action="index2.php" method="post" name="adminForm" id="adminForm">
	<table class="adminheading">
	<tr>
	  <th><?php echo _MXC_COMMENT; ?> : <small><?php echo $row->id ? _MXC_EDIT : _MXC_ADD;?></small></th>
	</tr>
	</table>  
    <table width="100%" class="adminform">  
	  <tr>
		<th colspan="2">
		<?php echo _MXC_DETAILS; ?>
		</th>
	  </tr>
      <tr>
        <td width="20%" align="right"><?php echo _MXC_AUTHOR; ?>:</td>
        <td width="80%">
          <input class="inputbox" type="text" name="name" size="40" maxlength="30" value="<?php echo $row->name;?>" />
        </td>
      </tr>
      <tr>
        <td valign="top" align="right"><?php echo _MXC_CONTENT_ITEM; ?>:</td>
        <td>
          <?php echo $clist; ?>
        </td>
      </tr>
      <tr>
        <td valign="top" align="right"><?php echo _MXC_TITLE; ?>:</td>
        <td>
          <input name="title" type="text" class="inputbox" value="<?php echo $row->title; ?>" size="40" maxlength="40" />
 &nbsp;<?php echo _MXC_RATING; ?>&nbsp; <?php echo $rlist; ?></td>
      </tr>
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
        <td valign="top" align="right"><?php echo _MXC_COMMENT; ?>:</td>
        <td>
		<div style="width:60%">
          <textarea class="inputbox" cols="50" rows="8" id="comment" name="comment" onKeyDown="countlengthcomment(this.form.comment, 'compteur', <?php echo $mxc_lengthcomment?>);" onKeyUp="countlengthcomment(this.form.comment, 'compteur', <?php echo $mxc_lengthcomment?>);" onFocus="showInputField('compteur', this.form.comment, <?php echo $mxc_lengthcomment?>);"><?php echo $row->comment;?></textarea>
		  <script>
			bbcode_toolbar = new Control.TextArea.ToolBar.BBCode('comment');
			bbcode_toolbar.toolbar.toolbar.id = 'bbcode_toolbar';
		  </script>
		 </div>
        </td>
      </tr>
	  <?php if ( $mxc_lengthcomment && !$row->id ) { ?>
      <tr>
        <td valign="top" align="right">&nbsp;</td>
        <td>
		<div id="compteur"><?php echo _MXC_NUM_CHARCARTERS . " " . $mxc_lengthcomment ; ?></div>
		</td>
      </tr>
	  <?php } ?>
	  <?php if ( file_exists($mosConfig_absolute_path . "/administrator/components/com_joomfish/config.joomfish.php") ) {?>
      <tr>
        <td valign="top" align="right"><?php echo _MXC_LANGUAGE; ?>:</td>
        <td><input class="inputbox" type="text" name="lang" size="5" maxlength="10" value="<?php echo $row->lang; ?>" /></td>
      </tr>
	  <?php 
	  } else {
	  		echo "<input type=\"hidden\" name=\"lang\" value=\"$row->lang\" />";
	  }
	  ?>
	  <?php if ( $mxc_use_askimet ) { ?>
      <tr>
        <td valign="top" align="right"><img src="<?php echo $mosConfig_live_site; ?>/administrator/components/com_maxcomment/images/akismet.png" alt="" /></td>
        <td><?php 
		echo $aksimetlist;
		echo "&nbsp;&nbsp;" . _MXC_FEEDBACKTOAKISMET;
		echo "&nbsp;&nbsp;<a href=\"index2.php?option=com_maxcomment&task=notspam\">feedback</a>";		
		?>
		</td>
      </tr>
	  <?php } ?>
      <tr>
        <td valign="top" align="right"><?php echo _MXC_ORDERING; ?>:</td>
        <td>
          <?php echo $olist; ?>
        </td>
      </tr>
      <tr>
        <td valign="top" align="right"><?php echo _MXC_PUBLISHED; ?>:</td>
        <td>
          <?php echo $puplist; ?>
        </td>
      </tr>
    </table>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="date" value="<?php echo $row->date; ?>" />
	<input type="hidden" name="ip" value="<?php echo $row->ip; ?>" />
	<input type="hidden" name="currentlevelrating" value="<?php echo $mxc_levelrating ;?>" />
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="task" value="" />
    </form>
  <?php
  }
  
   function showAdmComments( $option, &$rows, &$search, &$pageNav ) {
	global $mainframe, $mosConfig_live_site, $mxc_levelrating;		
	
		$commentlenght = "60";
		
		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th width="100%">
			<?php echo _MXC_EDITORSCOMMENTS; ?>
			</th>
			<td align="right">
			<?php echo _MXC_FILTER; ?>:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
			</td>
		</tr>
		</table>
		
		<table class="adminlist" cellspacing="1">
		<thead>
		<tr>
			<th width="5">
			#
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title" width="12%"><div align="left">
			<?php echo _MXC_AUTHOR ; ?></div>
			</th>
			<th class="title" align="left"><div align="left">
			<?php echo _MXC_COMMENT ; ?></div>
			</th>
		    <th width="8%" class="title"><div align="center"><?php echo _MXC_RATING ; ?></div></th>
		    <th width="10%" class="title"><div align="left"><?php echo _MXC_DATE ; ?></div></th>
		    <th width="8%" class="title"><div align="center"><?php echo _MXC_CONTENT_ITEM ; ?></div></th>
		    <th width="6%" class="title"><div align="center"><?php echo _MXC_PUBLISHED ; ?></div></th>
		</tr>
		</thead>
		<tfoot>
		  <tr>
			<td colspan="9">
				<?php echo $pageNav->getListFooter(); ?>
			</td>
		  </tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count($rows); $i < $n; $i++) {
			$row = $rows[$i];	

			$task 	= $row->published ? 'unpublish' : 'publish';
			$img 	= $row->published ? 'publish_g.png' : 'publish_x.png';
			$alt 	= $row->published ? 'Published' : 'Unpublished';
			
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id );?>				
				</td>
				<td><div align="left">
					<a href="#editadmcomment" onClick="return listItemTask('cb<?php echo $i;?>','editadmcomment')" title="<?php echo _MXC_EDIT; ?>">
					<?php echo $row->name; ?>
					</a></div>	
				</td>
				<td><div align="left">
				<?php
				if( strlen($row->comment) > $commentlenght) {
        			$row->comment  = substr($row->comment, 0, $commentlenght-3);
        			$row->comment .= "...";
      			}
				 echo $row->comment; 				
				?>
				</div></td>
			    <td><div align="center">
				<?php
				if ( $row->rating ){
					//echo "<strong><font color='green'>" . $row->rating . "</font></strong> / " . $mxc_levelrating;
					echo "<strong><font color='green'>" . intval(confirm_evaluate ( $row->rating, $row->currentlevelrating, $mxc_levelrating )) . "</font></strong> / " . $mxc_levelrating;
				} else echo "-";
				 ?>
				</div></td>
			    <td><div align="left"><?php echo $row->date; ?></div></td>
			    <td><div align="center">
				<a href="" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_content&task=view&id=<?php echo $row->contentid; ?>&pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');" title="<?php echo _MXC_PREVIEW_ARTICLE; ?>" >
				<?php echo $row->contentid; ?>
				</a>
				</div></td>
			    <td><div align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</div></td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="admcomments" />
		<input type="hidden" name="typecomment" value="comments">
		<input type="hidden" name="usertable" value="adm">
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">
		</form>
		<?php
	}

  function editAdmComment( $option, &$row, &$clist, &$rlist, &$puplist ) {
    global $mosConfig_live_site, $mosConfig_absolute_path, $mxc_lengthcomment, $my;
  
    require( $mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php' );
  
  	mosMakeHtmlSafe( $row, ENT_QUOTES, 'comment' );  
 	$name = $row->name;
	if ( $name=='' ) { $name = $my->username; }
  	if ( $mxc_lengthcomment && !$row->id ) {	
		include_once($mosConfig_absolute_path."/components/com_maxcomment/includes/common/maxlengthcomment.php");
	}
    ?>	
    <script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
      var form = document.adminForm;
      if (pressbutton == 'canceladmcomment') {
        submitform( pressbutton );
        return;
      }

      // do field validation
      if (form.comment.value == ""){
        alert( "You must at least write the comment text." );
      } else if (form.contentid.value == "0"){
        alert( "You must select a corresponding content item." );
      } else if (form.name.value == ""){
        alert( "You must enter the author's name." );
      } else {
        submitform( pressbutton );
      }
    }
	
	
	function x () {
		return;
	}
	
	function mxc_smilie(thesmile) {
		document.adminForm.comment.value += " "+thesmile+" ";
		document.adminForm.comment.focus();
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
	<?php } ?>
	<form action="index2.php" method="post" name="adminForm" id="adminForm">
	<table class="adminheading">
	<tr>
	  <th><?php echo _MXC_EDITORSCOMMENTS; ?> : <small><?php echo $row->id ? _MXC_EDIT : _MXC_ADD;?></small></th>
	</tr>
	</table>  
    <table width="100%" class="adminform">  
	  <tr>
		<th colspan="2">
		<?php echo _MXC_DETAILS; ?>
		</th>
	  </tr>
      <tr>
        <td width="20%" align="right"><?php echo _MXC_AUTHOR; ?>:</td>
        <td width="80%">
          <input class="inputbox" type="text" name="name" size="40" maxlength="30" value="<?php echo $name;?>" />
        </td>
      </tr>
      <tr>
        <td valign="top" align="right"><?php echo _MXC_CONTENT_ITEM; ?>:</td>
        <td>
          <?php echo $clist; ?>
        </td>
      </tr>
      <tr>
        <td valign="top" align="right"><?php echo _MXC_TITLE; ?>:</td>
        <td>
          <input class="inputbox" type="text" name="title" value="<?php echo $row->title; ?>" size="40" maxlength="40" />
&nbsp;          <?php echo _MXC_RATING; ?>&nbsp;&nbsp;<?php echo $rlist; ?>
        </td>
      </tr>
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
        <td valign="top" align="right"><?php echo _MXC_COMMENT; ?>:</td>
        <td>
		 <div style="width:60%">
          <textarea class="inputbox" cols="50" rows="8" name="comment" id="comment" onKeyDown="countlengthcomment(this.form.comment, 'compteur', <?php echo $mxc_lengthcomment?>);" onKeyUp="countlengthcomment(this.form.comment, 'compteur', <?php echo $mxc_lengthcomment?>);" onFocus="showInputField('compteur', this.form.comment, <?php echo $mxc_lengthcomment?>);"><?php echo $row->comment;?></textarea>
		  <script>
			bbcode_toolbar = new Control.TextArea.ToolBar.BBCode('comment');
			bbcode_toolbar.toolbar.toolbar.id = 'bbcode_toolbar';
		  </script>
		 </div>		  
        </td>
      </tr>
	  <?php if ( $mxc_lengthcomment && !$row->id ) { ?>
      <tr>
        <td valign="top" align="right">&nbsp;</td>
        <td>
		<div id="compteur"><?php echo _MXC_NUM_CHARCARTERS . " " . $mxc_lengthcomment ; ?></div>
		</td>
      </tr>
	  <?php } ?>
      <tr>
        <td valign="top" align="right"><?php echo _MXC_PUBLISHED; ?>:</td>
        <td>
          <?php echo $puplist; ?>
        </td>
      </tr>
    </table>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="date" value="<?php echo $row->date; ?>" />
	<input type="hidden" name="currentlevelrating" value="<?php echo $mxc_levelrating ;?>" />
    <input type="hidden" name="option" value="<?php echo $option;?>" />	
    <input type="hidden" name="task" value="" />
    </form>
  <?php
  }
  
    function showBadwords( $option, &$rows, &$search, &$pageNav ) {
	global $mainframe, $mosConfig_live_site;		
	
		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th width="100%">
			<?php echo _MXC_BADWORDS; ?>
			</th>
			<td align="right">
			<?php echo _MXC_FILTER; ?>:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
			</td>
		</tr>
		</table>
		
		<table class="adminlist" cellspacing="1">
		<thead>
		<tr>
			<th width="10">
			#
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title" width="30%"><div align="left">
			<?php echo _MXC_BADWORD ; ?></div>
			</th>
		    <th width="6%" class="title"><div align="center"><?php echo _MXC_PUBLISHED ; ?></div></th>
			<th width="60%" class="title"><div align="center">&nbsp;</div></th>
		</tr>
		</thead>
		<tfoot>
		  <tr>
			<td colspan="9">
				<?php echo $pageNav->getListFooter(); ?>
			</td>
		  </tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count($rows); $i < $n; $i++) {
			$row = $rows[$i];	

			$task 	= $row->published ? 'unpublish' : 'publish';
			$img 	= $row->published ? 'publish_g.png' : 'publish_x.png';
			$alt 	= $row->published ? 'Published' : 'Unpublished';
			
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id );?>				
				</td>
				<td><div align="left">
					<a href="#editbadword" onClick="return listItemTask('cb<?php echo $i;?>','editbadword')" title="<?php echo _MXC_EDIT; ?>">
					<?php echo $row->badword; ?>
					</a></div>	
				</td>
			    <td><div align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</div></td>
				<td><div align="center">&nbsp;</div></td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="badwords" />
		<input type="hidden" name="typecomment" value="badwords">
		<input type="hidden" name="usertable" value="">
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">
		</form>
		<?php
	}

  function editBadword( $option, &$row, &$puplist ) {  
    ?>
    <script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
      var form = document.adminForm;
      if (pressbutton == 'cancelbadword') {
        submitform( pressbutton );
        return;
      }

      // do field validation
      if (form.badword.value == ""){
         alert( "You must enter the bad word." );
      } else {
        submitform( pressbutton );
      }
    }
    </script>
	<form action="index2.php" method="post" name="adminForm" id="adminForm">
	<table class="adminheading">
	<tr>
	  <th><?php echo _MXC_BADWORDS; ?> : <small><?php echo $row->id ? _MXC_EDIT : _MXC_ADD;?></small></th>
	</tr>
	</table>  
    <table width="100%" class="adminform">  
	  <tr>
		<th colspan="2">
		<?php echo _MXC_DETAILS; ?>
		</th>
	  </tr>
      <tr>
        <td width="20%" align="right"><?php echo _MXC_BADWORD; ?>:</td>
        <td width="80%">
          <input class="inputbox" type="text" name="badword" size="30" maxlength="20" value="<?php echo $row->badword ;?>" />
        </td>
      </tr>
      <tr>
        <td valign="top" align="right"><?php echo _MXC_PUBLISHED; ?>:</td>
        <td>
          <?php echo $puplist; ?>
        </td>
      </tr>
    </table>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="task" value="" />
    </form>
  <?php
  }
  
     function showBlockIp( $option, &$rows, &$search, &$pageNav ) {
	global $mainframe, $mosConfig_live_site;		
	
		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th width="100%">
			<?php echo _MXC_BLOCKIPADDRESSES; ?>
			</th>
			<td align="right">
			<?php echo _MXC_FILTER; ?>:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
			</td>
		</tr>
		</table>
		
		<table class="adminlist" cellspacing="1">
		<thead>
		<tr>
			<th width="10">
			#
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title" width="30%"><div align="left">
			<?php echo _MXC_IP ; ?></div>
			</th>
		    <th width="6%" class="title"><div align="center"><?php echo _MXC_PUBLISHED ; ?></div></th>
			<th width="60%" class="title"><div align="center">&nbsp;</div></th>
		</tr>
		</thead>
		<tfoot>
		  <tr>
			<td colspan="9">
				<?php echo $pageNav->getListFooter(); ?>
			</td>
		  </tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count($rows); $i < $n; $i++) {
			$row = $rows[$i];	

			$task 	= $row->published ? 'unpublish' : 'publish';
			$img 	= $row->published ? 'publish_g.png' : 'publish_x.png';
			$alt 	= $row->published ? 'Published' : 'Unpublished';
			
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id );?>				
				</td>
				<td><div align="left">
					<a href="#editblockip" onClick="return listItemTask('cb<?php echo $i;?>','editblockip')" title="<?php echo _MXC_EDIT; ?>">
					<?php echo $row->ipblock; ?>
					</a></div>	
				</td>
			    <td><div align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</div></td>
				<td><div align="center">&nbsp;</div></td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="blockip" />
		<input type="hidden" name="typecomment" value="blockip">
		<input type="hidden" name="usertable" value="">
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">
		</form>
		<?php
	}

  function editBlockIp( $option, &$row, &$puplist ) {  
    ?>
    <script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
      var form = document.adminForm;
      if (pressbutton == 'cancelblockip') {
        submitform( pressbutton );
        return;
      }

      // do field validation
      if (form.ipblock.value == ""){
         alert( "You must enter a valid IP." );
      } else {
        submitform( pressbutton );
      }
    }
    </script>
	<form action="index2.php" method="post" name="adminForm" id="adminForm">
	<table class="adminheading">
	<tr>
	  <th><?php echo _MXC_BLOCKIPADDRESSES; ?> : <small><?php echo $row->id ? _MXC_EDIT : _MXC_ADD;?></small></th>
	</tr>
	</table>  
    <table width="100%" class="adminform">  
	  <tr>
		<th colspan="2">
		<?php echo _MXC_DETAILS; ?>
		</th>
	  </tr>
      <tr>
        <td width="20%" align="right"><?php echo _MXC_IP; ?>:</td>
        <td width="80%">
          <input class="inputbox" type="text" name="ipblock" size="30" maxlength="15" value="<?php echo $row->ipblock ;?>" />
        </td>
      </tr>
      <tr>
        <td valign="top" align="right"><?php echo _MXC_PUBLISHED; ?>:</td>
        <td>
          <?php echo $puplist; ?>
        </td>
      </tr>
    </table>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="task" value="" />
    </form>
  <?php
  }
  
	function showFavoured( $option, &$rows, &$pageNav ) {
	global $mainframe, $mosConfig_live_site;
	
		?>
		<form action="index2.php" method="post" name="adminForm" id="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo _MXC_FAVOURED; ?>
			</th>
			<td>&nbsp;			
			</td>
			<td align="right"><input type="submit" name="resetfavouredcounter" value="<?php echo _MXC_RESET_FAVOURED_COUNT; ?>"></td>
		</tr>
		</table>		
		<table class="adminlist" cellspacing="1">
		<thead>
		<tr>
			<th width="10">
			#
			</th>
			<th class="title"><div align="left">
			<?php echo _MXC_TITLE ; ?></div>
			</th>
			<th class="title" align="left"  width="12%"><div align="center">
			<?php echo _MXC_FAVORITES ; ?></div>
			</th>
		    <th width="10%" class="title"><div align="center"><?php echo _MXC_CONTENT_ITEM ; ?></div></th>
		</tr>
		</thead>
		<tfoot>
		  <tr>
			<td colspan="9">
				<?php echo $pageNav->getListFooter(); ?>
			</td>
		  </tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count($rows); $i < $n; $i++) {
			$row = $rows[$i];		
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td><div align="left"><?php echo $row->title; ?></div></td>
				<td><div align="center"><?php echo $row->favourite; ?></div></td>
			    <td><div align="center"><?php echo $row->id_content;?></div></td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="resetfavouredcount" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">
		</form>
		<?php		
	}
	
			
	function about( $option, $version ) {
	global $mosConfig_live_site;
	?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
          <tr>
            <th width="100%"> <?php echo _MXC_CPL_ABOUT ; ?> </th>
          </tr>
        </table>
		<table class="adminlist" cellspacing="1">
          <thead>
            <tr>
              <th width="100%">&nbsp; </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td><div align="center"></div></td>
            </tr>
          </tfoot>
          <tbody>
            <tr class="row0">
              <td><p><img src="<?php echo $mosConfig_live_site."/administrator/components/com_maxcomment" ?>/images/maXcomment.png" /><br />
                <br />                
      <strong>MXcomment </strong>is a comment system  with rating, templates and more features for Joomla! and Mambo articles.<br />
      This Free Software is provided without warranty or guarantee.<br />
                  <br />
                  <strong>License</strong> : <br />
					<!--Creative Commons License-->
					<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/">
					<img alt="Creative Commons License" style="border-width:0" src="http://creativecommons.org/images/public/somerights20.png" />
					</a><br />This work is licensed under a 
					<!--
					<span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/" rel="dc:type">creation</span> 
					-->
					<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/">Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License</a>.
                  <br />
                  <strong>Author</strong> : Bernard Gilly<br />
                  <strong>Website</strong> : <a href="http://www.visualclinic.fr" target="_blank">www.visualclinic.fr</a><br />
                  <strong>Support forum</strong> : <a href="http://www.visualclinic.fr/forum/" target="_blank">http://www.visualclinic.fr/forum/</a><br />
                  <strong>Version</strong> <?php echo $version ; ?><br />
				  <!--
                  <br />
                  <strong>Vote &amp; Review</strong> : <br />
                  If you find my free stuff useful, why not vote and review this component on official extensions Joomla.org :<br /> 
                  <a href="http://extensions.joomla.org/component/option,com_mtree/task,viewowner/user_id,2316/Itemid,35/" target="_blank">http://extensions.joomla.org/component/option,com_mtree/task,viewowner/user_id,2316/Itemid,35/</a><br />
				  -->
				  <br />
                <strong>Donate to MXcomment </strong>:<br />
                You can send me a <a href="http://www.visualclinic.fr/support.html" target="_blank">donation</a> and thus support the <strong>MXcomment</strong> further development.                <br />
                </p>
              </td>
            </tr>
          </tbody>
        </table>	
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="about" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">
		</form>
	<?php
	}	
	
	function showFileLanguage( $file, $option ) {
		$file = stripslashes($file);
		$permission = is_writable($file);
		if (!$permission ) {		
			echo "<font color='red'>" . _MXC_FILE_NOT_WRITEABLE . "</font>";
			return;
		}
		$f=fopen($file,"r");
		$content = fread($f, filesize($file));
		$content = str_replace( "<?php", "", $content);
		$content = str_replace( "?>", "",$content);
		$content = htmlspecialchars($content);
		fclose ($f);		
		?>
		<form action="index2.php?" method="post" name="adminForm" class="adminform">
		<table width="100%" class="adminheading">
		  <tr>
			<th width="100%">
			  <?php echo _MXC_EDIT_LANGUAGE ; ?>
			</th>
		  </tr>
		</table>
		<table width="100%" class="adminform">
		   <tr>
			 <th colspan="4">Path: <?php echo $file; ?></td> </tr>
		   <tr>
			 <td><textarea cols="100" rows="30" name="filecontent"><?php echo $content; ?></textarea>
			 </td>
		   </tr>
		   <tr>
			 <td class="error"><?php echo _MXC_FILE_MUST_BE_WRITEABLE; ?></td>
		   </tr>
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="file" value="<?php echo $file; ?>" />
		<input type="hidden" name="task" value="">
		<input type="hidden" name="boxchecked" value="0">
		</form>
		<?php
	  }	
	  
	function showFileCSS( $file, $option ) {
		$file = stripslashes($file);		
		$permission = is_writable($file);
		if (!$permission ) {		
			echo "<font color='red'>" . _MXC_FILE_NOT_WRITEABLE . "</font>";
			return;
		}		
		$f=fopen($file,"r");
		$content = fread($f, filesize($file));
		$content = htmlspecialchars($content);
		fclose ($f);
		
		?>
		<form action="index2.php?" method="post" name="adminForm" class="adminform">
		<table width="100%" class="adminheading">
		  <tr>
			<th width="100%">
			  <?php echo _MXC_EDIT_CSS ; ?>
			</th>
		  </tr>
		</table>
		<table width="100%" class="adminform">
		   <tr>
			 <th colspan="4">Path: <?php echo $file; ?></td> </tr>
		   <tr>
			 <td><textarea cols="100" rows="30" name="filecontent"><?php echo $content; ?></textarea>
			 </td>
		   </tr>
		   <tr>
			 <td class="error"><?php echo _MXC_FILE_MUST_BE_WRITEABLE; ?></td>
		   </tr>
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="file" value="<?php echo $file; ?>" />
		<input type="hidden" name="task" value="">
		<input type="hidden" name="boxchecked" value="0">
		</form>
		<?php
	  }	
	  
 }
?>
