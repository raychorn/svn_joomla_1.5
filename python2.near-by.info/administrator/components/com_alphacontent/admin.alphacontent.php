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

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
		| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_alphacontent' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

// Get the right language if it exists
if (file_exists($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/".$mosConfig_lang.".php")){
   include_once($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/".$mosConfig_lang.".php");
}else{
   include_once($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/english.php");
}

require_once( $mainframe->getPath( 'admin_html' ) );
require( $mosConfig_absolute_path.'/administrator/components/com_alphacontent/version.php' );

switch ($task) {

	case "config":		
		showConfig( $option ) ;
		break;

	case "savesettings":
		savesettings( $option );
		break;
		
	case "cancelsettings":
		mosRedirect( "index2.php?option=$option&task=config" );
		break;
					
	default:
		showConfig( $option );
		break;
}

function showConfig( $option ) {
	HTML_ALPHA::showConfig( $option );
}


function savesettings ( $option ) {
	global $database;
	
	$configfile = "components/com_alphacontent/alphacontent_config.php";
	@chmod ($configfile, 0766);
	$permission = is_writable($configfile);
	if (!$permission ) {		
		mosRedirect("index2.php?option=$option&task=config", _ALPHACONTENT_NOTWRITING );
		return;
	}
	// checked boxes
	$ac_show_pathway = intval( mosGetParam( $_POST, 'ac_show_pathway', 0 ));
	$ac_link2CB = intval( mosGetParam( $_POST, 'ac_link2CB', 0 ));
	
	$config = "<?php\n";
	$config .= "/**********************************************\n";
	$config .= "* AlphaContent - Mambo/Joomla! component      *\n";
	$config .= "* Copyright (C) 2005-2007 by Bernard Gilly    *\n";
	$config .= "* Homepage   : www.visualclinic.fr            *\n";
	$config .= "* Version    : " . _ALPHACONTENT_NUM_VERSION . "                          *\n";
	$config .= "* License    : DonationWare                   *\n";
	$config .= "*            : All Rights Reserved            *\n";
	$config .= "**********************************************/\n";
	$config .= "\n";
	$config .= "defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );\n";
	$config .= "\n";
	$config .= "\$ac_show_pathway = \"".$ac_show_pathway."\";\n";
	$config .= "\$ac_link2CB = \"".$ac_link2CB."\";\n";
	
	// verify vars authorized => prevent problem with session
	$varauth[] = 'ac_weighttitleindex';
	$varauth[] = 'ac_sizetitleindex';
	$varauth[] = 'ac_display_result_on_run';
	$varauth[] = 'ac_show_position_module';
	$varauth[] = 'ac_posmodule';
	$varauth[] = 'ac_displayItemMode';
	$varauth[] = 'showletters';
	$varauth[] = 'stylealpha';
	$varauth[] = 'numspace';
	$varauth[] = 'separatif';
	$varauth[] = 'content_zone';
	$varauth[] = 'showcategories';
	$varauth[] = 'nbcolums';
	$varauth[] = 'nbcat';
	$varauth[] = 'dontdisplayemptysection';
	$varauth[] = 'shownumcatitem';
	$varauth[] = 'ac_charbetwcat';
	$varauth[] = 'ac_charbetwcat2';
	$varauth[] = 'sortcat';
	$varauth[] = 'sizesection';
	$varauth[] = 'weightsection';
	$varauth[] = 'sizecategory';
	$varauth[] = 'weightcategory';
	$varauth[] = 'content_type';
	$varauth[] = 'include_archived';
	$varauth[] = 'select_section_ID';
	$varauth[] = 'select_category_ID';
	$varauth[] = 'ac_insertweblink';
	$varauth[] = 'ac_showlinkthumbnail';
	$varauth[] = 'ac_numcolumnslisting';
	$varauth[] = 'ac_showsectiondescription';
	$varauth[] = 'ac_styleblockresult';
	$varauth[] = 'ac_intro';
	$varauth[] = 'numcharintro';
	$varauth[] = 'ac_linktitle';
	$varauth[] = 'ac_showsubmitlink';
	$varauth[] = 'shownumitemresult';
	$varauth[] = 'showrating';
	$varauth[] = 'showiconnew';
	$varauth[] = 'numdaynew';
	$varauth[] = 'showiconhot';
	$varauth[] = 'numhitshot';
	$varauth[] = 'showdatecreate';
	$varauth[] = 'ac_formatdate';
	$varauth[] = 'showauthor';
	$varauth[] = 'showsectioncategory';
	$varauth[] = 'shownumcomment';
	$varauth[] = 'ac_commentsystem';
	$varauth[] = 'showhits';
	$varauth[] = 'showmap';	
	$varauth[] = 'showprint';
	$varauth[] = 'showpdf';
	$varauth[] = 'showemail';
	$varauth[] = 'showreadmore';
	$varauth[] = 'showresultpagetotal';
	$varauth[] = 'showchoicenumlist';
	$varauth[] = 'ac_default_list_limit';
	$varauth[] = 'showsearchfilter';
	$varauth[] = 'defaultsortoptionrun';
	$varauth[] = 'showsortselector';
	$varauth[] = 'ac_showimgsection';
	$varauth[] = 'ac_maximgsection';
	$varauth[] = 'ac_maxbordersection';
	$varauth[] = 'ac_colorbordersection';
	$varauth[] = 'ac_vspacesection';
	$varauth[] = 'ac_hspacesection';
	$varauth[] = 'img_weblinks_section';
	$varauth[] = 'showfirstimg';
	$varauth[] = 'ac_maximg';
	$varauth[] = 'ac_maxborder';
	$varauth[] = 'ac_colorborder';
	$varauth[] = 'ac_vspace';
	$varauth[] = 'ac_hspace';
	$varauth[] = 'ac_alignimage';
	$varauth[] = 'ac_show_relateditems';
	$varauth[] = 'ac_show_relateditems_archived';
	$varauth[] = 'ac_class_title_relateditems';
	$varauth[] = 'ac_nb_relateditems';
	$varauth[] = 'ac_show_tags';
	$varauth[] = 'ac_numTags';
	$varauth[] = 'ac_gid_submit';
	$varauth[] = 'ac_showsearchbuttonfilter';	
	$varauth[] = 'ac_labelsearchbutton';	
	$varauth[] = 'ac_show_ac_rating';	
	$varauth[] = 'ac_nomosimage';
	$varauth[] = 'ac_title_used';
	$varauth[] = 'ac_num_stars';
	$varauth[] = 'ac_width_stars';
	$varauth[] = 'ac_googlemaps_api_key';
	$varauth[] = 'ac_googlemaps_zoom_level';
	$varauth[] = 'ac_googlemaps_width_map';
	$varauth[] = 'ac_googlemaps_height_map';
	$varauth[] = 'ac_googlemaps_type_menu';
	$varauth[] = 'ac_googlemaps_controls_menu';
	
    foreach ( $_POST as $k=>$v ) {
		if ( in_array ( $k, $varauth ) ) {			
			$config .= "$".$k." = \"".$v."\";\n";
		}
    }	
   
	$config .= "?>\n";
	if ($fp = fopen("$configfile", "w")) {
		fputs($fp, $config, strlen($config));
		fclose ($fp);
	}
	mosRedirect("index2.php?option=$option&task=config", _ALPHACONTENT_SAVESETTINGS );
}

// COPYRIGHT NOTICE
$copyStart = 2005; 
$copyNow = date('Y');  
if ($copyStart == $copyNow) { 
	$copySite = $copyStart;
} else {
	$copySite = $copyStart." - ".$copyNow ;
} 
?>
<!-- IMPORTANT! DO NOT REMOVE THE COPYRIGHT NOTICE -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><br /><a href="http://www.visualclinic.fr">AlphaContent <?php echo _ALPHACONTENT_NUM_VERSION ; ?></a> - Copyright &copy; <?php echo $copySite ; ?> <a href="http://www.visualclinic.fr">visualclinic.fr</a> - All Rights Reserved<br /></div></td>
  </tr>
</table>