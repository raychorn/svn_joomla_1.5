<?php
/*********************************************
* alphacontent - Mambo/Joomla! Component     *
* Copyright (C) 2005-2008 by Bernard Gilly   *
* Homepage   : www.visualclinic.fr           *
* Version    : 3.0                           *
* License    : DonationWare                  *
* 			 : All Rights Reserved           *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_ALPHA {

	function showConfig( $option ) {
	global $database, $mosConfig_live_site, $mosConfig_absolute_path;
	
	require( $mosConfig_absolute_path.'/administrator/components/com_alphacontent/alphacontent_config.php' );
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


<table width="100%"  border="0">
<tr>
<td valign="top" bgcolor="#FFFFFF"><img src="<?php echo $mosConfig_live_site."/administrator/components/com_alphacontent" ?>/images/alphacontent.jpg"></td>
</tr>
  <tr>  
    <td valign="top">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
<form action="index2.php" method="POST" name="adminForm" >
<?php
  $aclisttabs = new mosTabs( 0 );
  $aclisttabs->startPane( "config" );
  $aclisttabs->startTab(_ALPHACONTENT_ABOUT,"About-page");
  ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="adminheading">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr >
      <th ><?php echo _ALPHACONTENT_ABOUT; ?></th>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">
	  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><strong>AlphaContent</strong>&nbsp;<?php echo _ALPHACONTENT_DESCRIPTIONALPHACONTENT; ?><br />
            <br />
            <strong><?php echo _ALPHACONTENT_LICENSE; ?></strong> : <?php echo _ALPHACONTENT_LICENSE_DETAIL; ?><br />
 <br />
 <strong><?php echo _ALPHACONTENT_AUTHOR; ?></strong> : Bernard Gilly<br />
 <br />
 <strong><?php echo _ALPHACONTENT_VERSION; ?></strong> : <?php echo _ALPHACONTENT_NUM_VERSION; ?><br />
 <br />
 <strong><?php echo _ALPHACONTENT_OFFICIAL_SITE; ?></strong> : <a href="http://www.visualclinic.fr" target="_blank">www.visualclinic.fr</a><br />
 <br>
 <strong><?php echo _ALPHACONTENT_AUTHOR_NOTES; ?></strong> : 
 <a href="components/com_alphacontent/readme.html" target="_blank"><?php echo _ALPHACONTENT_README?></a><br />
          </td>
        </tr>
      </table>
	  </td>
    </tr>
  </table>
  <?php
    $aclisttabs->endTab();
    $aclisttabs->startTab(_ALPHACONTENT_SETTING,"Settings-page");
  ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="adminList">
    <tr class="row1">
      <td colspan="2" valign="top"><b><?php echo _ALPHACONTENT_GENERAL ; ?></b></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_TITLE ; ?></td>
      <td valign="top">
        <?php
	$fontweightIndex[] = mosHTML::makeOption( 'bold', _ALPHACONTENT_BOLD );
	$fontweightIndex[] = mosHTML::makeOption( 'normal', _ALPHACONTENT_NORMAL );
	echo mosHTML::radioList( $fontweightIndex, 'ac_weighttitleindex', 'class="inputbox"', $ac_weighttitleindex );
	echo "&nbsp;-&nbsp;";
	echo _ALPHACONTENT_SIZE . "&nbsp;&nbsp;";
	//Build  box
	$confIndexsize[] = mosHTML::makeOption( '', _ALPHACONTENT_DEFAULT );
	$confIndexsize[] = mosHTML::makeOption( '8', '8' );
	$confIndexsize[] = mosHTML::makeOption( '9', '9' );		
	$confIndexsize[] = mosHTML::makeOption( '10', '10' );	
	$confIndexsize[] = mosHTML::makeOption( '11', '11' );	
	$confIndexsize[] = mosHTML::makeOption( '12', '12' );	
	$confIndexsize[] = mosHTML::makeOption( '14', '14' );	
	$confIndexsize[] = mosHTML::makeOption( '16', '16' );	
	$confIndexsize[] = mosHTML::makeOption( '18', '18' );
	$confIndexsize[] = mosHTML::makeOption( '20', '20' );		
	$confIndexsize[] = mosHTML::makeOption( '22', '22' );	
	$confIndexsize[] = mosHTML::makeOption( '24', '24' );	
	$confIndexsize[] = mosHTML::makeOption( '26', '26' );
	$confIndexsize[] = mosHTML::makeOption( '28', '28' );
	$listIndexsize = mosHTML::selectList( $confIndexsize, 'ac_sizetitleindex', 'size="1"', 'value', 'text', $ac_sizetitleindex );
	echo $listIndexsize;		
?>
      </td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_NO_DISPLAY_RESULT_ON_RUN ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'ac_display_result_on_run', 'class="inputbox"', $ac_display_result_on_run ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top">&nbsp;</td>
      <td valign="top"><?php echo " " . _ALPHACONTENT_YOUCANCHOOSEAMODULE ; ?></td>
    </tr>
    <tr class="row0">
      <td valign="top">&nbsp;</td>
      <td valign="top">
	  <?php
	    $confModules[] = mosHTML::makeOption( '0', _ALPHACONTENT_SELECT_A_MODULE );
		$query = "SELECT title"
		. "\nFROM #__modules"
		. "\nWHERE published = 1"
		;
		$database->setQuery( $query );
		$rowsModules = $database->loadObjectList();
		if ( count($rowsModules) ) {
			foreach ( $rowsModules AS $rowMod ) {			
	  			$confModules[] = mosHTML::makeOption( $rowMod->title, $rowMod->title );
			}
		}
		$listModules = mosHTML::selectList( $confModules, 'ac_show_position_module', 'size="1"', 'value', 'text', $ac_show_position_module );
		echo $listModules;

		$confPosModule[] = mosHTML::makeOption( '0', _ALPHACONTENT_BEFORE_DIRECTORY ); 
		$confPosModule[] = mosHTML::makeOption( '1', _ALPHACONTENT_AFTER_DIRECTORY ); 

		$listPosModule = mosHTML::selectList( $confPosModule, 'ac_posmodule', 'size="1"', 'value', 'text', $ac_posmodule );
		echo "&nbsp;&nbsp;" . $listPosModule;		  
	  ?>
	  </td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_DISPLAY_ITEM_MODE ; ?></td>
      <td valign="top">
	  	  <?php
			$displayMode[] = mosHTML::makeOption( '0', _ALPHACONTENT_DISPLAY_NORMAL  );
			$displayMode[] = mosHTML::makeOption( '1', _ALPHACONTENT_DISPLAY_POPUP );
			$displayMode[] = mosHTML::makeOption( '2', _ALPHACONTENT_DISPLAY_LITBOX );
			$displayModeItem = mosHTML::radioList( $displayMode, 'ac_displayItemMode', 'class="inputbox"', $ac_displayItemMode );
			echo $displayModeItem;
		   ?>
	  </td>
    </tr>
    <tr class="row1">
      <td colspan="2" valign="top"><b><?php echo _ALPHACONTENT_TITLE_SHOW ; ?></b></td>
      </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOWLETTERS ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showletters', 'class="inputbox"', $showletters ); ?></td>
    </tr>
    <tr class="row0">
      <td width="19%" valign="top"><?php echo _ALPHACONTENT_TYPEALPHA ; ?></td>
      <td width="81%" valign="top"><?php
			//Build  box
			$confstylealpha[] = mosHTML::makeOption( '0', _ALPHACONTENT_LISTALPHA_0 );	 // Occidental upper
			$confstylealpha[] = mosHTML::makeOption( '1', _ALPHACONTENT_LISTALPHA_1 );	 // Occidental lower
			$confstylealpha[] = mosHTML::makeOption( '2', _ALPHACONTENT_LISTALPHA_2 );	 // Occidental images, upper
			$confstylealpha[] = mosHTML::makeOption( '3', _ALPHACONTENT_LISTALPHA_3 );	 // Russian upper
			$confstylealpha[] = mosHTML::makeOption( '3a', _ALPHACONTENT_LISTALPHA_3a ); // Occidental + Russian upper
			$confstylealpha[] = mosHTML::makeOption( '3b', _ALPHACONTENT_LISTALPHA_3b ); // Russian upper (UTF-8)
			$confstylealpha[] = mosHTML::makeOption( '4', _ALPHACONTENT_LISTALPHA_4 );   // Russian lower
			$confstylealpha[] = mosHTML::makeOption( '5', _ALPHACONTENT_LISTALPHA_5 );   // Swedish, danish, Norvegian
			$confstylealpha[] = mosHTML::makeOption( '6', _ALPHACONTENT_LISTALPHA_6 );	 // Hebrew
			$confstylealpha[] = mosHTML::makeOption( '7', _ALPHACONTENT_LISTALPHA_7 );   // Greek
			$confstylealpha[] = mosHTML::makeOption( '8', _ALPHACONTENT_LISTALPHA_8 );   // Arabic
			$confstylealpha[] = mosHTML::makeOption( '8a', _ALPHACONTENT_LISTALPHA_8a ); // Occidental + Arabic
			$confstylealpha[] = mosHTML::makeOption( '9', _ALPHACONTENT_LISTALPHA_9 );   // Turkish
			$confstylealpha[] = mosHTML::makeOption( '10', _ALPHACONTENT_LISTALPHA_10 ); // Estonian
			$confstylealpha[] = mosHTML::makeOption( '11', _ALPHACONTENT_LISTALPHA_11 ); // Slovenian/Croatian/Serbian
			$confstylealpha[] = mosHTML::makeOption( '12', _ALPHACONTENT_LISTALPHA_12 ); // Hungarian

			$liststylealpha = mosHTML::selectList( $confstylealpha, 'stylealpha', 'size="1"', 'value', 'text', $stylealpha );
		  	echo $liststylealpha;		
?> 
	</td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_NUM_SPACE ; ?></td>
      <td valign="top"><?php
			//Build  box
			$display_num = mosHTML::integerSelectList( 0, 10, 1, 'numspace', '', $numspace );
			echo $display_num;
	  ?>
      </td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_CHAR_SEPARATIVE ; ?></td>
      <td><input name="separatif" type="text" value="<?php echo $separatif ; ?>" size="2" maxlength="2"></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_SELECTZONEALPHA ; ?></td>
      <td><?php
			//Build  box
			$confcontent[] = mosHTML::makeOption( '0', _ALPHACONTENT_LISTZONEALPHA_0 );
			$confcontent[] = mosHTML::makeOption( '1', _ALPHACONTENT_LISTZONEALPHA_1 );		
			$listcontent = mosHTML::selectList( $confcontent, 'content_zone', 'size="1"', 'value', 'text', $content_zone );
		  	echo $listcontent;		  
			echo _ALPHACONTENT_SELECTZONEALPHA_DESC ; ?></td>
    </tr>
	</table>
	<?php   
    $aclisttabs->endTab();
	$aclisttabs->startTab(_ALPHACONTENT_DIRECTORY,"Directory-page");
  ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="adminList">
    <tr class="row1">
      <td colspan="2" valign="top"><b><?php echo _ALPHACONTENT_TITLECATEGORY ; ?></b></td>
    </tr>
    <tr class="row0">
      <td width="19%" valign="top"><?php echo _ALPHACONTENT_DISPLAYCATEGORY ; ?></td>
      <td width="81%" valign="top"><?php echo mosHTML::yesnoRadioList( 'showcategories', 'class="inputbox"', $showcategories );	?>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ac_show_pathway" id="ac_show_pathway" value="1"<?php echo $ac_show_pathway ? ' checked="checked"' : ''; ?> /> 
<?php echo _ALPHACONTENT_SHOW_PATHWAY ; ?>
</td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_NBCOLUMS ; ?></td>
      <td valign="top"><?php
			//Build  box
			$confnbcolums[] = mosHTML::makeOption( '1', '1' );
			$confnbcolums[] = mosHTML::makeOption( '2', '2' );
			$confnbcolums[] = mosHTML::makeOption( '3', '3' );		
			$confnbcolums[] = mosHTML::makeOption( '4', '4' );	
			$confnbcolums[] = mosHTML::makeOption( '5', '5' );	
			$confnbcolums[] = mosHTML::makeOption( '6', '6' );	
			$listnbcolums = mosHTML::selectList( $confnbcolums, 'nbcolums', 'size="1"', 'value', 'text', $nbcolums );
		  	echo $listnbcolums;		
?>
      </td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_LIMITCAT ; ?></td>
      <td valign="top">
	  <?php
			//Build  box
			$confnbcat[] = mosHTML::makeOption( 'all', _ALPHACONTENT_ALL );
			$confnbcat[] = mosHTML::makeOption( '2', '2' );
			$confnbcat[] = mosHTML::makeOption( '3', '3' );		
			$confnbcat[] = mosHTML::makeOption( '4', '4' );	
			$confnbcat[] = mosHTML::makeOption( '5', '5' );	
			$confnbcat[] = mosHTML::makeOption( '6', '6' );	
			$confnbcat[] = mosHTML::makeOption( '7', '7' );	
			$confnbcat[] = mosHTML::makeOption( '8', '8' );	
			$confnbcat[] = mosHTML::makeOption( '9', '9' );
			$confnbcat[] = mosHTML::makeOption( '10', '10' );		
			$confnbcat[] = mosHTML::makeOption( '15', '15' );	
			$confnbcat[] = mosHTML::makeOption( '20', '20' );	
			$listnbcat = mosHTML::selectList( $confnbcat, 'nbcat', 'size="1"', 'value', 'text', $nbcat );
		  	echo $listnbcat;		
		?>
	  </td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_DONTDISPLAYEMPTYSECTION ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'dontdisplayemptysection', 'class="inputbox"', $dontdisplayemptysection ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOWNUMITEMS ; ?></td>
      <td valign="top"><?php
			  echo mosHTML::yesnoRadioList( 'shownumcatitem', 'class="inputbox"', $shownumcatitem );
			  echo "&nbsp;&nbsp;-&nbsp;&nbsp;"._ALPHACONTENT_SHOWNUMITEMS_DESC;
			?>
	  </td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_CHAR_BETWEEN_CAT ; ?></td>
      <td valign="top"><?php
			//Build  box
			$confcharbetwcat[] = mosHTML::makeOption( ', ', ',' );
			$confcharbetwcat[] = mosHTML::makeOption( ' | ', '|' );
			$confcharbetwcat[] = mosHTML::makeOption( ' / ', '/' );		
			$confcharbetwcat[] = mosHTML::makeOption( ' - ', '-' );		
			$confcharbetwcat[] = mosHTML::makeOption( ' + ', '+' );
			$confcharbetwcat[] = mosHTML::makeOption( ' : ', ':' );			
			$confcharbetwcat[] = mosHTML::makeOption( ' :: ', '::' );	
			$confcharbetwcat[] = mosHTML::makeOption( ' ::: ', ':::' );	
			$confcharbetwcat[] = mosHTML::makeOption( '<br />', '&lt;br /&gt;' );	
			$confcharbetwcat[] = mosHTML::makeOption( '<li>', '&lt;li&gt;' );				
			$listcharbetwcat = mosHTML::selectList( $confcharbetwcat, 'ac_charbetwcat', 'size="1"', 'value', 'text', $ac_charbetwcat );
		  	echo _ALPHACONTENT_INDEX_PAGE.$listcharbetwcat;
			$listcharbetwcat2 = mosHTML::selectList( $confcharbetwcat, 'ac_charbetwcat2', 'size="1"', 'value', 'text', $ac_charbetwcat2 );
			echo "&nbsp;&nbsp;"._ALPHACONTENT_CATEGORY_PAGE.$listcharbetwcat2;		
?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_TITLEORDERING ; ?></td>
      <td valign="top"><?php
			//Build  box
			$confsortcat[] = mosHTML::makeOption( 'title ASC', _ALPHACONTENT_TITLESORTASC );
			$confsortcat[] = mosHTML::makeOption( 'title DESC', _ALPHACONTENT_TITLESORTDESC );
			$confsortcat[] = mosHTML::makeOption( 'ordering ASC', _ALPHACONTENT_ORDERINGSORT );		
			$listsortcat = mosHTML::selectList( $confsortcat, 'sortcat', 'size="1"', 'value', 'text', $sortcat );
		  	echo $listsortcat;		
?></td>
    </tr>
    <tr class="row1">
      <td colspan="2" valign="top"><strong><?php echo _ALPHACONTENT_STYLEFONT ; ?></strong></td>
      </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SIZESECTION ; ?>
	  </td>
      <td valign="top"><?php
			//Build  box
			$confsizesection[] = mosHTML::makeOption( '', _ALPHACONTENT_DEFAULT );
			$confsizesection[] = mosHTML::makeOption( '8', '8' );
			$confsizesection[] = mosHTML::makeOption( '9', '9' );		
			$confsizesection[] = mosHTML::makeOption( '10', '10' );	
			$confsizesection[] = mosHTML::makeOption( '11', '11' );	
			$confsizesection[] = mosHTML::makeOption( '12', '12' );	
			$confsizesection[] = mosHTML::makeOption( '14', '14' );	
			$confsizesection[] = mosHTML::makeOption( '16', '16' );	
			$confsizesection[] = mosHTML::makeOption( '18', '18' );
			$confsizesection[] = mosHTML::makeOption( '20', '20' );		
			$confsizesection[] = mosHTML::makeOption( '22', '22' );	
			$confsizesection[] = mosHTML::makeOption( '24', '24' );	
			$confsizesection[] = mosHTML::makeOption( '26', '26' );
			$confsizesection[] = mosHTML::makeOption( '28', '28' );
			$listsizesection = mosHTML::selectList( $confsizesection, 'sizesection', 'size="1"', 'value', 'text', $sizesection );
		  	echo $listsizesection;		
			echo "&nbsp;";
			$fontweight[] = mosHTML::makeOption( 'bold', _ALPHACONTENT_BOLD );
			$fontweight[] = mosHTML::makeOption( 'normal', _ALPHACONTENT_NORMAL );
			echo mosHTML::radioList( $fontweight, 'weightsection', 'class="inputbox"', $weightsection );
		?>
</td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SIZECATEGORY ; ?></td>
      <td valign="top"><?php
			//Build  box
			$confsizecategory[] = mosHTML::makeOption( '', _ALPHACONTENT_DEFAULT );
			$confsizecategory[] = mosHTML::makeOption( '8', '8' );
			$confsizecategory[] = mosHTML::makeOption( '9', '9' );		
			$confsizecategory[] = mosHTML::makeOption( '10', '10' );	
			$confsizecategory[] = mosHTML::makeOption( '11', '11' );	
			$confsizecategory[] = mosHTML::makeOption( '12', '12' );	
			$confsizecategory[] = mosHTML::makeOption( '14', '14' );	
			$confsizecategory[] = mosHTML::makeOption( '16', '16' );	
			$confsizecategory[] = mosHTML::makeOption( '18', '18' );
			$confsizecategory[] = mosHTML::makeOption( '20', '20' );		
			$confsizecategory[] = mosHTML::makeOption( '22', '22' );	
			$confsizecategory[] = mosHTML::makeOption( '24', '24' );	
			$confsizecategory[] = mosHTML::makeOption( '26', '26' );
			$confsizecategory[] = mosHTML::makeOption( '28', '28' );
			$listsizecategory = mosHTML::selectList( $confsizecategory, 'sizecategory', 'size="1"', 'value', 'text', $sizecategory );
		  	echo $listsizecategory;		
			echo "&nbsp;";
			$fontweightc[] = mosHTML::makeOption( 'bold', _ALPHACONTENT_BOLD );
			$fontweightc[] = mosHTML::makeOption( 'normal', _ALPHACONTENT_NORMAL );
			echo mosHTML::radioList( $fontweightc, 'weightcategory', 'class="inputbox"', $weightcategory );
		?></td>
    </tr>
	</table>  
  <?php   
    $aclisttabs->endTab();
	$aclisttabs->startTab(_ALPHACONTENT_TITLECONTENT,"Content-page");
  ?>
   <table width="100%" border="0" cellspacing="0" cellpadding="4" class="adminList">
    <tr class="row1">
      <td colspan="2"><strong><?php echo _ALPHACONTENT_TITLECONTENT ; ?></strong></td>
    </tr>
    <tr class="row0">
      <td width="15%"><?php echo _ALPHACONTENT_CONTENT ; ?></td>
      <td width="85%"><?php
			//Build  box
			$confcontenttype[] = mosHTML::makeOption( '0', _ALPHACONTENT_LISTTYPECONTENT_0 );
			$confcontenttype[] = mosHTML::makeOption( '1', _ALPHACONTENT_LISTTYPECONTENT_1 );		
			$confcontenttype[] = mosHTML::makeOption( '2', _ALPHACONTENT_LISTTYPECONTENT_2 );		
			$listcontenttype = mosHTML::selectList( $confcontenttype, 'content_type', 'size="1"', 'value', 'text', $content_type );
		  	echo $listcontenttype;		  
?>
      <?php echo _ALPHACONTENT_CONTENT_DESC ; ?></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_INCLUDEARCHIVED ; ?></td>
      <td><?php echo mosHTML::yesnoRadioList( 'include_archived', 'class="inputbox"', $include_archived ); ?></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_SECTIONS ; ?></td>
      <td><input name="select_section_ID" type="text" value="<?php echo $select_section_ID ; ?>" size="30">
        <?php echo _ALPHACONTENT_SECTIONS_DESC ; ?></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_CATEGORIES ; ?></td>
      <td><input name="select_category_ID" type="text" value="<?php echo $select_category_ID ; ?>" size="30">
        <?php echo _ALPHACONTENT_CATEGORIES_DESC ; ?></td>
    </tr>
    <tr class="row0">
      <td>&nbsp;</td>
      <td style="color:#CC0000;"><?php echo _ALPHACONTENT_BLANK4ALLCATEGORIES ; ?></td>
    </tr>
    <tr class="row0">
      <td colspan="2"><strong><?php echo _ALPHACONTENT_WEBLINK_COMPONENT ; ?></strong></td>
      </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_INSERT_WEBLINK_COMPONENT; ?></td>
      <td><?php echo mosHTML::yesnoRadioList( 'ac_insertweblink', 'class="inputbox"', $ac_insertweblink ); ?></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_SHOW_LINKTHUMBNAIL ; ?></td>
      <td><?php echo mosHTML::yesnoRadioList( 'ac_showlinkthumbnail', 'class="inputbox"', $ac_showlinkthumbnail ); ?></td>
    </tr>
  </table>
	<?php   
    $aclisttabs->endTab();
	$aclisttabs->startTab(_ALPHACONTENT_LIST,"Liste-page");
  ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="adminList">
    <tr class="row1">
      <td colspan="2" valign="top"><strong><?php echo _ALPHACONTENT_TITLERESULT ; ?></strong></td>
      </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_NBCOLUMS ; ?></td>
      <td valign="top"><?php	  
			$confNumColumnsListing[] = mosHTML::makeOption( '0', '1' );
			$confNumColumnsListing[] = mosHTML::makeOption( '1', '2' );
			$optionNumColumnsListing = mosHTML::radioList( $confNumColumnsListing, 'ac_numcolumnslisting', 'class="inputbox"', $ac_numcolumnslisting );
			echo $optionNumColumnsListing;	  			  
			?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_SECTION_DESCRIPTION ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'ac_showsectiondescription', 'class="inputbox"', $ac_showsectiondescription ); ?></td>
    </tr>
    <tr class="row0">
      <td width="15%" valign="top"><?php echo _ALPHACONTENT_BLOCK_RESULT ; ?></td>
      <td width="85%" valign="top">
        <?php 
			//Build  box
			$confresultstyle[] = mosHTML::makeOption( '2', _ALPHACONTENT_NORMAL );
			$confresultstyle[] = mosHTML::makeOption( '0', _ALPHACONTENT_BLOCK_RESULT_FIELDSET );
			$confresultstyle[] = mosHTML::makeOption( '1', _ALPHACONTENT_BLOCK_RESULT_HR );		
			$listresultstyle = mosHTML::selectList( $confresultstyle, 'ac_styleblockresult', 'size="1"', 'value', 'text', $ac_styleblockresult );
			echo $listresultstyle;
		?>
</td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_CONTENT_INTRO ; ?></td>
      <td valign="top"><?php
			//Build  box
			$confcontentintrostyle[] = mosHTML::makeOption( '0', _ALPHACONTENT_CONTENT_INTRO_LIGHT );
			$confcontentintrostyle[] = mosHTML::makeOption( '1', _ALPHACONTENT_CONTENT_INTRO_LINK );		
			$confcontentintrostyle[] = mosHTML::makeOption( '2', _ALPHACONTENT_CONTENT_INTRO_ORIGINAL );		
			$confcontentintrostyle[] = mosHTML::makeOption( '3', _ALPHACONTENT_NONE );	
			$listcontentintrostyle = mosHTML::selectList( $confcontentintrostyle, 'ac_intro', 'size="1"', 'value', 'text', $ac_intro );
		  	echo $listcontentintrostyle;		  
?>
&nbsp;&nbsp;<?php echo _ALPHACONTENT_LIMITCHRINTRO ; ?>&nbsp;&nbsp;
<input name="numcharintro" type="text" value="<?php echo $numcharintro ; ?>" size="4" maxlength="6">
<?php echo _ALPHACONTENT_LIMITCHRINTRO_DESC ; ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_TITLE_USED ; ?></td>
      <td valign="top">
        <?php 
			//Build  box
			$conftitleused[] = mosHTML::makeOption( 'title', _ALPHACONTENT_USE_TITLE_FIELD );
			$conftitleused[] = mosHTML::makeOption( 'title_alias', _ALPHACONTENT_USE_TITLE_ALIAS_FIELD );
			$listconftitleused = mosHTML::selectList( $conftitleused, 'ac_title_used', 'size="1"', 'value', 'text', $ac_title_used );
			echo $listconftitleused;
		?>	  
	  </td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_TITLELINK ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'ac_linktitle', 'class="inputbox"', $ac_linktitle ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_LINK_SUBMIT ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'ac_showsubmitlink', 'class="inputbox"', $ac_showsubmitlink ); ?>&nbsp;&nbsp;
<?php
			//Build  box			
			$confcontentGID[] = mosHTML::makeOption( '1', 'Member' );		
			$confcontentGID[] = mosHTML::makeOption( '2', 'Special' );		
			$listcontentGID = mosHTML::selectList( $confcontentGID, 'ac_gid_submit', 'size="1"', 'value', 'text', $ac_gid_submit );
		  	echo $listcontentGID;		  
?>	  </td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_NUMITEMRESULT ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'shownumitemresult', 'class="inputbox"', $shownumitemresult ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_RATING ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showrating', 'class="inputbox"', $showrating );	?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_ICON_NEW ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showiconnew', 'class="inputbox"', $showiconnew );
			  echo "&nbsp;&nbsp;-&nbsp;&nbsp;"._ALPHACONTENT_DAYS_NEW; ?>
          <input name="numdaynew" type="text" value="<?php echo $numdaynew ; ?>" size="4" maxlength="6">
      </td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_ICON_HOT ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showiconhot', 'class="inputbox"', $showiconhot );
			  echo "&nbsp;&nbsp;-&nbsp;&nbsp;"._ALPHACONTENT_NB_HOT; ?>
          <input name="numhitshot" type="text" value="<?php echo $numhitshot ; ?>" size="4" maxlength="6"></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOWDATECREATE ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showdatecreate', 'class="inputbox"', $showdatecreate ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_DATE_FORMAT ; ?></td>
      <td valign="top"><input name="ac_formatdate" type="text" value="<?php echo $ac_formatdate ; ?>" size="20" maxlength="20">
&nbsp;<?php echo _ALPHACONTENT_EXAMPLE_FORMAT_DATE; ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_AUTHOR ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showauthor', 'class="inputbox"', $showauthor );	?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="ac_link2CB" id="ac_link2CB" value="1"<?php echo $ac_link2CB ? ' checked="checked"' : ''; ?> />
<?php echo _ALPHACONTENT_LINK_TO_CB ; ?>
</td>
    </tr>    
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_SECTION_CATEGORY ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showsectioncategory', 'class="inputbox"', $showsectioncategory ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_COMMENTS ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'shownumcomment', 'class="inputbox"', $shownumcomment );
			  echo "&nbsp;&nbsp;";
			  $boxcomment = array();
			  $boxcomment[] = mosHTML::makeOption( '', _ALPHACONTENT_SELECT_YOUR_COMMENT_SYSTEM );
			  $boxcomment[] = mosHTML::makeOption( 'mxc_comments', 'mXcomment' );
			  $boxcomment[] = mosHTML::makeOption( 'akocomment', 'AkoComment' );
			  $boxcomment[] = mosHTML::makeOption( 'akocomment', 'AkoComment Tweaked' );
			  $boxcomment[] = mosHTML::makeOption( 'akocomment', 'AkoComment Tweaked Special Edition' );
			  $boxcomment[] = mosHTML::makeOption( 'opencomment', 'OpenComment' );
			  $boxcomment[] = mosHTML::makeOption( 'jomcomment', 'Jomcomment' );
			  $boxcomment[] = mosHTML::makeOption( 'comment', '!JoomlaComment' );
			  $boxcomment[] = mosHTML::makeOption( 'combo', 'ComboLITE / ComboMAX' );
			  $boxcomment[] = mosHTML::makeOption( 'mambocomment', 'Integrated Mambo Component System' );
			  $listcomment = mosHTML::selectList( $boxcomment, 'ac_commentsystem', 'size="1"', 'value', 'text', $ac_commentsystem );
			  echo $listcomment;
			?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOWHITS ; ?></td>
      <td valign="top"><?php  echo mosHTML::yesnoRadioList( 'showhits', 'class="inputbox"', $showhits ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_MAP_LINK ; ?></td>
      <td valign="top"><?php  echo mosHTML::yesnoRadioList( 'showmap', 'class="inputbox"', $showmap ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_PRINT ; ?></td>
      <td valign="top"><?php  echo mosHTML::yesnoRadioList( 'showprint', 'class="inputbox"', $showprint ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_PDF ; ?></td>
      <td valign="top"><?php  echo mosHTML::yesnoRadioList( 'showpdf', 'class="inputbox"', $showpdf ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_EMAIL ; ?></td>
      <td valign="top"><?php  echo mosHTML::yesnoRadioList( 'showemail', 'class="inputbox"', $showemail ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_READ_MORE_LINK ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showreadmore', 'class="inputbox"', $showreadmore );	?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_TOTAL_NUM_OF_RESULT ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showresultpagetotal', 'class="inputbox"', $showresultpagetotal ); ?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_CHOICENUMLIST ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showchoicenumlist', 'class="inputbox"', $showchoicenumlist ); ?>
<font color="red"><em>&nbsp;-&nbsp;<?php echo _ALPHACONTENT_NOT_AVAILABLE_IN_JOOMLA_1_5 ; ?></em></font>
      </td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_RESULTS_PER_PAGE; ?></td>
      <td valign="top">
	  <?php
		//Build  box
		$box = array();
		$box[] = mosHTML::makeOption( '5','5' );
		$box[] = mosHTML::makeOption( '6','6' );
		$box[] = mosHTML::makeOption( '8','8' );
		$box[] = mosHTML::makeOption( '10', '10' );
		$box[] = mosHTML::makeOption( '12', '12' );		
		$box[] = mosHTML::makeOption( '15', '15' );
		$box[] = mosHTML::makeOption( '16', '16' );
		$box[] = mosHTML::makeOption( '18', '18' );
		$box[] = mosHTML::makeOption( '20', '20' );
		$box[] = mosHTML::makeOption( '25', '25' );
		$box[] = mosHTML::makeOption( '30', '30' );
		$box[] = mosHTML::makeOption( '50', '50' );
		$box[] = mosHTML::makeOption( '100', '100' );
		$list = mosHTML::selectList( $box, 'ac_default_list_limit', 'size="1"', 'value', 'text', $ac_default_list_limit );
		echo $list;	
	  ?>
	  </td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_DISPLAY_FILTER_SEARCH ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showsearchfilter', 'class="inputbox"', $showsearchfilter );	?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_SEARCH_BUTTON ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'ac_showsearchbuttonfilter', 'class="inputbox"', $ac_showsearchbuttonfilter );	?>&nbsp;&nbsp;- <?php echo _ALPHACONTENT_LABEL_FOR_SEARCH_BUTTON ; ?>&nbsp;&nbsp;
          <input name="ac_labelsearchbutton" type="text" value="<?php echo $ac_labelsearchbutton ; ?>" size="8"></td>
    </tr>
    <tr class="row1">
      <td colspan="2" valign="top"><strong><?php echo _ALPHACONTENT_SORT_OPTION ; ?></strong></td>
      </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SORT_OPTION_DEFAULT_RUN ; ?></td>
      <td valign="top"><?php
			//Build  box			
			$confsortoption[] = mosHTML::makeOption( '1', _ALPHACONTENT_SORT_ITEM_ALPHA_TITLE_ASC );
			$confsortoption[] = mosHTML::makeOption( '2', _ALPHACONTENT_SORT_ITEM_ALPHA_TITLE_DESC );
			$confsortoption[] = mosHTML::makeOption( '3', _ALPHACONTENT_SORT_ITEM_ALPHA_INTRO_ASC );
			$confsortoption[] = mosHTML::makeOption( '4', _ALPHACONTENT_SORT_ITEM_ALPHA_INTRO_DESC );
			$confsortoption[] = mosHTML::makeOption( '5', _ALPHACONTENT_SORT_ITEM_CREATED_DESC );
			$confsortoption[] = mosHTML::makeOption( '6', _ALPHACONTENT_SORT_ITEM_CREATED_ASC );		
			$confsortoption[] = mosHTML::makeOption( '7', _ALPHACONTENT_SORT_ITEM_MODIFIED_DESC );		
			$confsortoption[] = mosHTML::makeOption( '8', _ALPHACONTENT_SORT_ITEM_MODIFIED_ASC );
			$confsortoption[] = mosHTML::makeOption( '9', _ALPHACONTENT_SORT_ITEM_HITS_DESC );
			$confsortoption[] = mosHTML::makeOption( '10', _ALPHACONTENT_SORT_ITEM_HITS_ASC );
			$confsortoption[] = mosHTML::makeOption( '11', _ALPHACONTENT_SORT_ITEM_RATING_DESC );
			$confsortoption[] = mosHTML::makeOption( '12', _ALPHACONTENT_SORT_ITEM_RATING_ASC );
			$confsortoption[] = mosHTML::makeOption( '13', _ALPHACONTENT_SORT_ITEM_AUTHOR_ASC );
			$confsortoption[] = mosHTML::makeOption( '14', _ALPHACONTENT_SORT_ITEM_AUTHOR_DESC );
			$confsortoption[] = mosHTML::makeOption( '15', _ALPHACONTENT_SORT_ITEM_DEFAULT_ORDERING );			
			$listsortoption = mosHTML::selectList( $confsortoption, 'defaultsortoptionrun', 'size="1"', 'value', 'text', $defaultsortoptionrun );
		  	echo $listsortoption;		  
?></td>
    </tr>
    <tr class="row0">
      <td valign="top"><?php echo _ALPHACONTENT_SHOW_SORT_SELECTOR ; ?></td>
      <td valign="top"><?php echo mosHTML::yesnoRadioList( 'showsortselector', 'class="inputbox"', $showsortselector ); ?></td>
    </tr>
  </table>
  <?php
    $aclisttabs->endTab();
	$aclisttabs->startTab(_ALPHACONTENT_TITLEIMAGE,"Image-page");
  ?>
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo $mosConfig_live_site."/administrator/components/com_alphacontent" ?>/js/ColorPicker2.js"></SCRIPT>
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo $mosConfig_live_site."/administrator/components/com_alphacontent" ?>/js/AnchorPosition.js"></SCRIPT>
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo $mosConfig_live_site."/administrator/components/com_alphacontent" ?>/js/PopupWindow.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
var cp = new ColorPicker('window'); // Popup Color Picker window
</SCRIPT><table width="100%" border="0" cellspacing="0" cellpadding="4" class="adminList">
    <tr class="row1">
      <td colspan="3"><strong><?php echo _ALPHACONTENT_IMAGE_SECTION ; ?></strong></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_SHOW_IMAGE_SECTION ; ?></td>
      <td colspan="2">
	<?php echo mosHTML::yesnoRadioList( 'ac_showimgsection', 'class="inputbox"', $ac_showimgsection ); ?>	  
	</td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_MAXIMG ; ?></td>
      <td colspan="2"><input name="ac_maximgsection" type="text" value="<?php echo $ac_maximgsection ; ?>" size="8"></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_BORDER ; ?></td>
      <td colspan="2"><input name="ac_maxbordersection" type="text" value="<?php echo $ac_maxbordersection ; ?>" size="8"></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_COLORBORDER ; ?></td>
      <td><input name="ac_colorbordersection" type="text" value="<?php echo $ac_colorbordersection ; ?>" size="8"></td>
      <td><img src="<?php echo $mosConfig_live_site."/administrator/components/com_alphacontent" ?>/images/color.gif" width="21" height="20" border="0" align="absmiddle" onClick="cp.select(document.adminForm.ac_colorbordersection,'pick1');return false;" style="cursor:pointer;" name="pick1" id="pick1"> </td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_VSPACE ; ?></td>
      <td colspan="2"><input name="ac_vspacesection" type="text" value="<?php echo $ac_vspacesection ; ?>" size="8"></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_HSPACE ; ?></td>
      <td colspan="2"><input name="ac_hspacesection" type="text" value="<?php echo $ac_hspacesection ; ?>" size="8"></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_IMG4WEBLINKSSECTION ; ?></td>
      <td colspan="2">
	  <?php
	  $dirlistimg = "/images/stories/";
		$lists['img_weblinks_section'] = mosAdminMenus::Images( 'img_weblinks_section', $img_weblinks_section, '', $dirlistimg );	  
	    echo $lists['img_weblinks_section']; 	  
	  ?>
	  </td>
    </tr>
    <tr class="row1">
      <td colspan="3"><strong><?php echo _ALPHACONTENT_IMAGE_IN_LISTING ; ?></strong></td>
    </tr>
    <tr class="row0">
      <td width="174"><?php echo _ALPHACONTENT_SHOWFIRSTIMG ; ?>&nbsp;<font color="#CC0000">*</font></td>
      <td colspan="2"><?php
			$confshowimg[] = mosHTML::makeOption( '0', _ALPHACONTENT_NO  );
			$confshowimg[] = mosHTML::makeOption( '1', _ALPHACONTENT_FIRST );
			$confshowimg[] = mosHTML::makeOption( '2', _ALPHACONTENT_LAST );
			$confshowimage = mosHTML::radioList( $confshowimg, 'showfirstimg', 'class="inputbox"', $showfirstimg );
			echo $confshowimage . "&nbsp;&nbsp;-&nbsp;&nbsp;";			  
			
			//Build  box
			$box = array();
			$box[] = mosHTML::makeOption( '0', _ALPHACONTENT_USE_MOSIMAGE_FUNCTION );	
			$box[] = mosHTML::makeOption( '1', _ALPHACONTENT_DETECT_TAG_IMG );
			$list = mosHTML::selectList( $box, 'ac_nomosimage', 'size="1"', 'value', 'text', $ac_nomosimage );
			echo $list;	
	  ?>
      </td>
      </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_MAXIMG ; ?></td>
      <td width="96"><input name="ac_maximg" type="text" value="<?php echo $ac_maximg ; ?>" size="8"></td>
      <td width="928">&nbsp;</td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_BORDER ; ?></td>
      <td><input name="ac_maxborder" type="text" value="<?php echo $ac_maxborder ; ?>" size="8"></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_COLORBORDER ; ?></td>
      <td><input name="ac_colorborder" type="text" value="<?php echo $ac_colorborder ; ?>" size="8"></td>
      <td><img src="<?php echo $mosConfig_live_site."/administrator/components/com_alphacontent" ?>/images/color.gif" width="21" height="20" border="0" align="absmiddle" onClick="cp.select(document.adminForm.ac_colorborder,'pick');return false;" style="cursor:pointer;" name="pick" id="pick"> </td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_VSPACE ; ?></td>
      <td><input name="ac_vspace" type="text" value="<?php echo $ac_vspace ; ?>" size="8"></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_HSPACE ; ?></td>
      <td><input name="ac_hspace" type="text" value="<?php echo $ac_hspace ; ?>" size="8"></td>
      <td>&nbsp; </td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_POSITION_IMAGE ; ?></td>
      <td colspan="2">
	  <?php 
			$confalignimage[] = mosHTML::makeOption( '0', _ALPHACONTENT_ALIGN_IMAGE_LEFT  );
			$confalignimage[] = mosHTML::makeOption( '1', _ALPHACONTENT_ALIGN_IMAGE_RIGHT );
			$confalignimage[] = mosHTML::makeOption( '2', _ALPHACONTENT_ALIGN_IMAGE_ALTERNATE );
			$optionalignimage = mosHTML::radioList( $confalignimage, 'ac_alignimage', 'class="inputbox"', $ac_alignimage );
			echo $optionalignimage;	  
	  ?>
	  </td>
      </tr>
    <tr class="row0">
      <td colspan="3"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="color:#CC0000;"><?php echo _ALPHACONTENT_DISABLE_IMAGE_ON_INTRO_ORIGINAL; ?> </td>
        </tr>
      </table></td>
    </tr>
  </table>
<?php
	$aclisttabs->endTab();
	$aclisttabs->startTab(_ALPHACONTENT_TAB_OPTIONS,"OPTIONS-page");
  ?>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="adminList">
    <tr class="row1">
      <td colspan="3"><strong><?php echo _ALPHACONTENT_TITLE_OPTIONS ; ?></strong></td>
    </tr>
    <tr class="row0">
      <td width="176">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="row1">
      <td colspan="3"><strong><?php echo _ALPHACONTENT_RELATED_ITEMS ; ?></strong></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_SHOW_RELATED_ITEMS ; ?></td>
      <td width="147"><?php echo mosHTML::yesnoRadioList( 'ac_show_relateditems', 'class="inputbox"', $ac_show_relateditems ); ?></td>
      <td width="875"><?php echo _ALPHACONTENT_RELATED_ITEMS_DETAIL ; ?></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_INCLUDE_ARCHIVED ; ?></td>
      <td><?php echo mosHTML::yesnoRadioList( 'ac_show_relateditems_archived', 'class="inputbox"', $ac_show_relateditems_archived ); ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_CLASS_CSS_4_TITLE ; ?></td>
      <td><?php
			//Build  box			
			$confclasstitleoption[] = mosHTML::makeOption( '', _ALPHACONTENT_DEFAULT );
			$confclasstitleoption[] = mosHTML::makeOption( 'contentheading', 'contentheading' );
			$confclasstitleoption[] = mosHTML::makeOption( 'componentheading', 'componentheading' );
			$confclasstitleoption[] = mosHTML::makeOption( 'contentdescription', 'contentdescription' );
			$confclasstitleoption[] = mosHTML::makeOption( 'small', 'small' );
			$listclasstitleoption = mosHTML::selectList( $confclasstitleoption, 'ac_class_title_relateditems', 'size="1"', 'value', 'text', $ac_class_title_relateditems );
		  	echo $listclasstitleoption;		  
?></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_NUM_RELATED_ITEM ; ?></td>
      <td><?php
			//Build  box			
			$confnbrelatedoption[] = mosHTML::makeOption( '3', '3' );
			$confnbrelatedoption[] = mosHTML::makeOption( '5', '5' );
			$confnbrelatedoption[] = mosHTML::makeOption( '6', '6' );
			$confnbrelatedoption[] = mosHTML::makeOption( '10', '10' );
			$confnbrelatedoption[] = mosHTML::makeOption( '15', '15' );
			$confnbrelatedoption[] = mosHTML::makeOption( '20', '20' );
			$confnbrelatedoption[] = mosHTML::makeOption( '25', '25' );
			$confnbrelatedoption[] = mosHTML::makeOption( '30', '30' );
			$listnbrelatedoption = mosHTML::selectList( $confnbrelatedoption, 'ac_nb_relateditems', 'size="1"', 'value', 'text', $ac_nb_relateditems );
		  	echo $listnbrelatedoption;		  
?></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="row1">
      <td colspan="3"><strong><?php echo _ALPHACONTENT_TAGS ; ?></strong></td>
      </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_SHOW_TAGS_BELOW_CATEGORIES ; ?></td>
      <td><?php echo mosHTML::yesnoRadioList( 'ac_show_tags', 'class="inputbox"', $ac_show_tags ); ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_MAX_TAGS ; ?></td>
      <td><?php
			//Build  box			
			$confnbTagoption[] = mosHTML::makeOption( '3', '3' );
			$confnbTagoption[] = mosHTML::makeOption( '5', '5' );
			$confnbTagoption[] = mosHTML::makeOption( '6', '6' );
			$confnbTagoption[] = mosHTML::makeOption( '10', '10' );
			$confnbTagoption[] = mosHTML::makeOption( '15', '15' );
			$confnbTagoption[] = mosHTML::makeOption( '20', '20' );
			$confnbTagoption[] = mosHTML::makeOption( '25', '25' );
			$confnbTagoption[] = mosHTML::makeOption( '30', '30' );
			$listnbTagoption = mosHTML::selectList( $confnbTagoption, 'ac_numTags', 'size="1"', 'value', 'text', $ac_numTags );
		  	echo $listnbTagoption;		  
?></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="row1">
      <td colspan="3"><strong><?php echo _ALPHACONTENT_SYSTEM_RATING ; ?></strong></td>
      </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_SHOW_SYSTEM_RATING ; ?></td>
      <td colspan="2"><?php echo mosHTML::yesnoRadioList( 'ac_show_ac_rating', 'class="inputbox"', $ac_show_ac_rating ) . "&nbsp;&nbsp;-&nbsp;&nbsp;" . _ALPHACONTENT_USE_ALPHACONTENT_AJAX_RATING_SYSTEM; ?> </td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_NUM_RATING_STARS ; ?></td>
      <td colspan="2"><?php
			//Build  box			
			$confstars[] = mosHTML::makeOption( '5', '5' );
			$confstars[] = mosHTML::makeOption( '6', '6' );
			$confstars[] = mosHTML::makeOption( '7', '7' );
			$confstars[] = mosHTML::makeOption( '8', '8' );
			$confstars[] = mosHTML::makeOption( '9', '9' );
			$confstars[] = mosHTML::makeOption( '10', '10' );
			$listconfstars = mosHTML::selectList( $confstars, 'ac_num_stars', 'size="1"', 'value', 'text', $ac_num_stars );
		  	echo $listconfstars;		  
?>
      </td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_WIDTH ; ?></td>
      <td colspan="2"><input name="ac_width_stars" type="text" value="<?php echo $ac_width_stars ; ?>" size="5"></td>
    </tr>
    <tr class="row0">
      <td>&nbsp;</td>
      <td colspan="2"><?php echo _ALPHACONTENT_CHANGE_IMAGE_STARS ; ?></td>
    </tr>
    <tr class="row0">
      <td>&nbsp;</td>
      <td colspan="2">&nbsp; </td>
    </tr>
  </table>
<?php
	$aclisttabs->endTab();
	$aclisttabs->startTab(_ALPHACONTENT_TAB_GOOGLE_MAPS,"GOOGLEMAP-page");
  ?>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="adminList">
    <tr class="row1">
      <td colspan="3"><strong><?php echo _ALPHACONTENT_LOCATION_GOOGLE_MAPS ; ?></strong></td>
    </tr>
    <tr class="row0">
      <td width="176"><?php echo _ALPHACONTENT_API_KEY ; ?></td>
      <td colspan="2"><input name="ac_googlemaps_api_key" type="text" value="<?php echo $ac_googlemaps_api_key ; ?>" size="70"></td>
      </tr>
    <tr class="row0">
      <td>&nbsp;</td>
      <td colspan="2"><?php echo _ALPHACONTENT_API_KEY_DESCRIPTION ; ?></td>
      </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_ZOOM_LEVEL ; ?></td>
      <td width="147"><input name="ac_googlemaps_zoom_level" type="text" value="<?php echo $ac_googlemaps_zoom_level ; ?>" size="5"></td>
      <td width="875">&nbsp;</td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_WIDTH_OF_MAP ; ?></td>
      <td><input name="ac_googlemaps_width_map" type="text" value="<?php echo $ac_googlemaps_width_map ; ?>" size="5"></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_HEIGHT_OF_MAP ; ?></td>
      <td><input name="ac_googlemaps_height_map" type="text" value="<?php echo $ac_googlemaps_height_map ; ?>" size="5"></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_MAP_TYPE_MENU ; ?></td>
      <td><?php echo mosHTML::yesnoRadioList( 'ac_googlemaps_type_menu', 'class="inputbox"', $ac_googlemaps_type_menu ); ?></td>
      <td><?php echo _ALPHACONTENT_MAP_TYPE_MENU_DESCRIPTION ; ?></td>
    </tr>
    <tr class="row0">
      <td><?php echo _ALPHACONTENT_MAP_CONTROLS_MENU ; ?></td>
      <td><?php echo mosHTML::yesnoRadioList( 'ac_googlemaps_controls_menu', 'class="inputbox"', $ac_googlemaps_controls_menu ); ?></td>
      <td><?php echo _ALPHACONTENT_MAP_CONTROLS_MENU_DESCRIPTION ; ?></td>
    </tr>
    <tr class="row0">
      <td>&nbsp;</td>
      <td colspan="2"><?php echo _ALPHACONTENT_USING_TAG_FOR_MAMBOT_MAP ; ?></td>
      </tr>
  </table>
<?php
	$aclisttabs->endTab();
  	$aclisttabs->endPane();
?>
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />
</form>
	</td>
  </tr>
</table>	
    <?php	
	}
 } // end class()
?>
