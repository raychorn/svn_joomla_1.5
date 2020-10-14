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

class ALPHACONTENT {

	function displaysearchletter( $alpha, $section, $cat, $_Itemid='' ){
		global $mosConfig_live_site, $mosConfig_absolute_path, $option, $Itemid, $_VERSION, $mosConfig_sef;		
		
		// If the source is an article ( transmitted by the bot )
		if ( $_Itemid ) $Itemid = $_Itemid;
		
		require( $mosConfig_absolute_path . '/administrator/components/com_alphacontent/alphacontent_config.php' );
		
		$separative = $separatif;
		if( $separative!='' || $separative!=' ' || $separative!='  ') $separative = str_repeat( '&nbsp;', $numspace ).$separative;
		echo "<table class=\"contentpane\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"><tr><td>\n";
		echo "<div align=\"center\">\n";		
		require_once($mosConfig_absolute_path."/components/com_alphacontent/alphabet/alpha" . $stylealpha . ".php");		
		echo "</div>\n";	
		echo "</td></tr></table>\n<br />\n";
	}

	function displayallcategories( $secid, $catid, $params, $alpha ){
		global $mosConfig_live_site, $mosConfig_absolute_path, $option, $Itemid, $my, $database, $mosConfig_offset, $_VERSION, $mainframe;
		
		require( $mosConfig_absolute_path.'/administrator/components/com_alphacontent/alphacontent_config.php' );

		// check version of product for compatibily Mambo/Joomla!
		if ( $_VERSION->PRODUCT == 'Joomla!' ){	
			$nullDate = $database->getNullDate();
			if ( $_VERSION->RELEASE >= '1.5' ) {
				$now = date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );
			} else {
				$now = _CURRENT_SERVER_TIME;		
			}
		} else {
			$nullDate = "0000-00-00 00:00:00";
			$now = date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );
		}
		
		$imgPath =  'templates/' . $mainframe->getTemplate() . '/images/arrow.png';
		if (file_exists( "$mosConfig_absolute_path/$imgPath" )){
			$img = '<img src="' . $mosConfig_live_site . '/' . $imgPath . '" border="0" alt="" />';
		} else {
			$imgPath = '/images/M_images/arrow.png';
			if (file_exists( $mosConfig_absolute_path . $imgPath )){
				$img = '<img src="' . $mosConfig_live_site . '/images/M_images/arrow.png" border="0" alt="" />';
			} else {
				$img = "&gt;";
			}
		}
		
		switch( $nbcolums ){				
			case "1":
				$percent = '100%';
				break;
			case "2":
				$percent = '50%';
				break;
			case "3":
				$percent = '33%';			
				break;
			case "4":
				$percent = '25%';			
				break;
			case "5":
				$percent = '20%';
				break;
			case "6":
				$percent = '16%';
				break;
			default:
				$nbcolums = "2";
				$percent = '50%';
				break;	
		}

		$indexalphacontent = "index.php?option=com_alphacontent&amp;Itemid=$Itemid";
		$directoryname     = $params->get( 'header' );
		
		if ( $params->get( 'page_title' )  ) {
			echo "\n<table class=\"contentpane\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";	
			echo "<tr><td>\n";	
			echo "<a href=\"" . sefRelToAbs($indexalphacontent) . "\" style=\"font-weight:" . $ac_weighttitleindex . ";font-size:" . $ac_sizetitleindex."px\">" . $directoryname . "</a>"; 
			if ( $alpha!='all' ) echo " " . $img . " " . strtoupper($alpha);
			echo "<br /><br />\n";
			echo "</td></tr>\n";
			echo "</table>\n";
		}
		
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\" align=\"center\">\n";	
	
		if(trim($secid)!=''){ 
			$wheresecid = "\nAND id IN (".trim($secid).")";
		}else{
			$wheresecid = "";
		}
		// All sections and categories
		$query = "SELECT id, title, image"
		. "\nFROM #__sections"
		. "\nWHERE published = '1' "			
		. "\nAND access <= '$my->gid'"
		. $wheresecid
		. "\nORDER BY $sortcat";
		$database->setQuery( $query );
		$listsections = $database->loadObjectList();
		
		// State published - archived
		$stateItem = "\nAND state = '1'";
		if ($params->get( 'include_archived' )=='1'){ $stateItem .= " OR state = '-1'"; }
		
		// Select categories...
		if(trim($catid)!=''){ 
			$wherecatid = "\nAND id IN (".trim($catid).")";
		}else{
			$wherecatid = "";
		}
		
		if( $params->get( 'content_type' ) == 0 ) {
			$g=0;
			$h=count($listsections);
		}elseif ($params->get( 'content_type' ) >= 1 ) {		
			// add not-categorised (static) if setting
			$h=count($listsections)+1;			
			$g=1;			
			echo "<tr>\n";	
			echo "<td valign=\"top\" width=\"$percent\"><div align=\"left\">";
			$linksection = "index.php?option=com_alphacontent&amp;section=0&amp;Itemid=$Itemid";
			echo "<a href='".sefRelToAbs($linksection) . "' style='font-weight:" . $weightsection . ";font-size:" . $sizesection . "px'>";
			echo stripslashes(_ALPHACONTENT_NO_CATEGORISED);
			echo "</a>";
			// if show num items		
			if ( $shownumcatitem ){	
				$query = "SELECT COUNT(id)"
				. "\nFROM #__content"
				. "\nWHERE sectionid = '0'"
				. "\nAND catid = '0'"
				. $stateItem
				. "\nAND access <= '$my->gid'"
				. "\n AND ( publish_up = '$nullDate' OR publish_up <= '$now' )"
				. "\n AND ( publish_down = '$nullDate' OR publish_down >= '$now' )";
				$database->setQuery( $query );
				$listitems = $database->loadResult();
				echo " (0/" . $listitems . ")";
			}
			echo "\n<br />\n";
			echo "</div></td>";
		}	
		
		// if add com_weblink
		if ( $params->get( 'show_weblinks' ) ) $h++;	
				
		$totallignes = intval($h/$nbcolums);
		if ( $h%$nbcolums>0 ){$totallignes = $totallignes + 1 ;}
		$nbcases = intval( $totallignes*$nbcolums );		
		$colspan = intval( $nbcases-$h );		
		$n=count($listsections);
		if ( $params->get( 'show_weblinks' ) ) $n++;	
		$endlineok = 0;
		
		for ( $i=0, $n; $i < $n; $i++ ){	
			
			if ( $params->get( 'show_weblinks' ) && $i<$n-1 || !$params->get( 'show_weblinks' ) ) {
				$row = $listsections[$i];			
				
				// check num item
				if(trim($catid)!=''){ 
					$wcatid = "\nAND catid IN (" . trim($catid) . ")";
				}else{
					$wcatid = "";
				}
				$query = "SELECT COUNT(id)"
				. "\nFROM #__content"
				. "\nWHERE sectionid = '$row->id'"
				. $wcatid
				. $stateItem
				. "\nAND access <= '$my->gid'"
				. "\n AND ( publish_up = '$nullDate' OR publish_up <= '$now' )"
				. "\n AND ( publish_down = '$nullDate' OR publish_down >= '$now' )";
				$database->setQuery( $query );
				$totalcount = $database->loadResult();

			} elseif ( $params->get( 'show_weblinks' ) && $i==$n-1 ) {
				$row->title = stripslashes(_ALPHACONTENT_WEBLINKS);				
				$row->id    = "com_weblinks";
				$row->image = $img_weblinks_section;
				$query = "SELECT COUNT(id)"
				. "\nFROM #__weblinks"
				. "\nWHERE published='1'"
				. "\nAND approved='1'";
				$database->setQuery( $query );
				$totalcount = $database->loadResult();			
			}
			
			if ( $dontdisplayemptysection == '0' || ($dontdisplayemptysection == '1' && $totalcount >= 1) ){
			
				if ($g%$nbcolums == 0) { 
					echo "<tr>\n";
				}
				echo "<td valign=\"top\" width=\"$percent\"><div align=\"left\">";
				
				$linksection = "index.php?option=com_alphacontent&amp;section=".$row->id."&amp;Itemid=$Itemid";		
				if ( $params->get( 'show_weblinks' ) && $i==$n-1 ) $linksection = "index.php?option=com_alphacontent&amp;section=com_weblinks&amp;Itemid=$Itemid";		
				$thesectionimage = "";
			    // Insert image section
				if ( $ac_showimgsection ) {
					$widthimgsection = ( $ac_maximgsection ) ? $ac_maximgsection : 60 ;
					$widthimgbordersection = ( $ac_maxbordersection ) ? $ac_maxbordersection : 0 ;
					$colorbordersection = ( $ac_colorbordersection ) ? $ac_colorbordersection : '#000' ;
					$max_ac_hspacesection = (($ac_hspacesection !='') ? $ac_hspacesection : 0 );
					$max_ac_vspacesection = (($ac_vspacesection !='') ? $ac_vspacesection : 0 );						
					if ( $row->image!='' ) {
						$thesectionimage = "<img src=\"" . $mosConfig_live_site . "/images/stories/" . $row->image . "\" style=\"border:".$widthimgbordersection."px solid " . $colorbordersection . ";\" width=\"" . $widthimgsection . "px\" hspace=\"" . $max_ac_hspacesection . "px\" vspace=\"" . $max_ac_vspacesection . "px\" align=\"left\" alt=\"" . $row->title . "\" />";
					}
				}
				$thesection = "<a href='".sefRelToAbs($linksection) . "' style='font-weight:" . $weightsection . ";font-size:" . $sizesection . "px'>";
				$thesection .= $thesectionimage;
				$thesection .= stripslashes($row->title);	
				$thesection .= "</a> ";				
				
				$query = "SELECT id, title"
				. "\nFROM #__categories"
				. "\nWHERE published = '1'"
				. "\nAND section = '$row->id'"
				. "\nAND access <= '$my->gid'"
				. $wherecatid
				. "\nORDER BY $sortcat";
				
				if ( $params->get( 'show_weblinks' ) && $i==$n-1 ) {
					$query = "SELECT id, title"
					. "\nFROM #__categories"
					. "\nWHERE published = '1'"
					. "\nAND section = 'com_weblinks'"
					. "\nAND access <= '$my->gid'"
					. "\nORDER BY $sortcat";				
				}
					
				$database->setQuery( $query );
				$listcategs = $database->loadObjectList();
				// Show num items		
				$counter = "";
				if ( $shownumcatitem ){	
					$counter = " (" . count($listcategs) . "/" . $totalcount . ")";
				}
						
				echo $thesection.$counter;
				echo "\n<br />\n";
				// show limited or unlimited categories
				if( $nbcat == 'all' ){
					$nn=count($listcategs);
				}else{
					if( $nbcat < count($listcategs) ){
						$nn = $nbcat;
					}elseif( $nbcat >= count($listcategs) ){
						$nn=count($listcategs);
					}
				}
				if ( $ac_charbetwcat == '<li>' ){ echo '<ul>'; }
				for ($ii=0, $nn; $ii < $nn; $ii++) {
					$yrow = $listcategs[$ii];
					$linksouscat = "index.php?option=com_alphacontent&amp;section=" . $row->id . "&amp;cat=" . $yrow->id . "&amp;Itemid=$Itemid";					
					if ( $ac_charbetwcat == '<li>' ) echo "<li>";
					echo "<a href='" . sefRelToAbs($linksouscat) . "' style='font-weight:" . $weightcategory . ";font-size:" . $sizecategory . "px'>";
					echo stripslashes($yrow->title);										
					echo "</a>";		
					if ( $ii <= ($nn-2) && $ac_charbetwcat != '<li>' ) {
						echo $ac_charbetwcat; 
					}elseif ( $ac_charbetwcat == '<li>' ){
						echo "</li>"; 
					}			
				}				
				if ( $nbcat != 'all' && ($nbcat < count($listcategs)) ) {
					echo $ac_charbetwcat." <a href='" . sefRelToAbs($linksection) . "' style='font-weight:" . $weightcategory . ";font-size:" . $sizecategory . "px'>...</a>";
					if ( $ac_charbetwcat == '<li>' ) echo "</li>";
				}
				if ( $ac_charbetwcat == '<li>' ) echo "</ul>";
				echo "\n<br />\n";
				// if you want a space larger between each category, remove comment in front of the line below ->
				// echo "<br />\n";
				echo "</div></td>";
				// colspan
				if( $i==$n-1 ){
					if ( $colspan>0 ) echo "<td valign=\"top\" colspan=\"$colspan\">&nbsp;</td></tr>";
					$endlineok = 1;		
				}				
				if ( ($g%$nbcolums==$nbcolums-1 && !$endlineok ) ){
					echo "</tr>\n";
				}	
				$g++;		
				
			} // end  if item in section & category
		}
		echo  "</table>";
	} 
	
		
	function displaycategorie( $section, $cat, $category_ID, $alpha, $_Itemid='', &$params, $prov=0 ){
		global $mainframe, $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_offset, $option, $Itemid, $my, $database, $_VERSION;
		
		require( $mosConfig_absolute_path.'/administrator/components/com_alphacontent/alphacontent_config.php' );
	
		$imgPath =  'templates/' . $mainframe->getTemplate() . '/images/arrow.png';
		if (file_exists( "$mosConfig_absolute_path/$imgPath" )){
			$img = '<img src="' . $mosConfig_live_site . '/' . $imgPath . '" border="0" alt="" />';
		} else {
			$imgPath = '/images/M_images/arrow.png';
			if (file_exists( $mosConfig_absolute_path . $imgPath )){
				$img = '<img src="' . $mosConfig_live_site . '/images/M_images/arrow.png" border="0" alt="" />';
			} else {
				$img = '&gt;';
			}
		}		
		
		$order = $sortcat;
		
		// If the source is an article ( transmitted by the bot )
		if ( $_Itemid ) $Itemid = $_Itemid;
				
		// Name of the directory
		$directoryNameInstance = $params->get( 'header' );
		
		if ( $ac_show_pathway ){
			echo "<table class=\"contentpane\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
			$indexalphacontent = "index.php?option=com_alphacontent&amp;Itemid=$Itemid";
			echo "<tr><td>\n<a href=\"" . sefRelToAbs($indexalphacontent) . "\">" . stripslashes($directoryNameInstance) . "</a>  $img  ";
		}		
		switch ( $section ) {		
		case '0':		
			$indexalphacontent = "index.php?option=com_alphacontent&amp;section=0&amp;Itemid=$Itemid";
			if ( $ac_show_pathway ){
				echo "<a href=\"".sefRelToAbs($indexalphacontent)."\">" . stripslashes(_ALPHACONTENT_NO_CATEGORISED) . "</a>";
			}
			if ( !$prov ) {	
				$mainframe->SetPageTitle( stripslashes(html_entity_decode ($directoryNameInstance)) . " - " . stripslashes( html_entity_decode ( _ALPHACONTENT_NO_CATEGORISED ) ) );
			}
			if ( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) {			
				$pathway =& $mainframe->getPathWay();
				$pathway->addItem( stripslashes(_ALPHACONTENT_NO_CATEGORISED), sefRelToAbs( "index.php?option=com_alphacontent&amp;section=0&amp;Itemid=$Itemid" ) );
			} else {
				$mainframe->appendPathWay( "<a class=\"pathway\" href=\"" . sefRelToAbs( "index.php?option=com_alphacontent&amp;section=0&amp;Itemid=$Itemid" ) . "\">" . stripslashes(_ALPHACONTENT_NO_CATEGORISED) . "</a>&nbsp;" );
			}			
		break;
		default:			
			if ( $section=='com_weblinks' ) {
				$row->id           = "com_weblinks"   ;
				$row->title        = stripslashes(_ALPHACONTENT_WEBLINKS);
				$row->description  = "";
			} else {
				$query = "SELECT id, title, description FROM #__sections WHERE id = '$section'";
				$database->setQuery( $query );
				$rows = $database->loadObjectList();
				$row = $rows[0];						
			}
			$indexalphacontent = "index.php?option=com_alphacontent&amp;section=" . $row->id . "&amp;Itemid=$Itemid";		
			$indexSection	   = "index.php?option=com_alphacontent&amp;section=" . $row->id;			
			if ( $ac_show_pathway ){
				echo "<a href=\"" . sefRelToAbs($indexalphacontent) . "\">" . $row->title . "</a>";
				
					if ( $alpha != 'all' && $alpha!='' && $cat=='all' ){
						echo "  $img  " . _ALPHACONTENT_LETTER . ": " . strtoupper($alpha);				
					}
			}
			
			// preserve original title of article
			if ( !$prov ) {
				$mainframe->SetPageTitle( stripslashes( html_entity_decode ( $directoryNameInstance . " - " . $row->title ) ) );
			}
			
			if ( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) {						
				$pathway =& $mainframe->getPathWay();
				$pathway->addItem( stripslashes($row->title), sefRelToAbs($indexalphacontent) );				
			} else {
				$mainframe->appendPathWay( "<a class=\"pathway\" href=\"". sefRelToAbs($indexalphacontent) . "\">" . stripslashes($row->title) . "</a> " );
			}	
			
			// Section description 
			if ( $ac_showsectiondescription && $row->description!='' && $cat=='all') {
				echo "<br /><p>" . stripslashes( $row->description ) . "</p>";
			} elseif ( $ac_showsectiondescription && $row->description=='' && $cat=='all' ) {
				echo "<br />";
			}
			
			if( $cat=='all' ){
				// list categories
				if ( $section!='com_weblinks' ) {
					if(trim($category_ID)!=''){
						$wherecatid = " AND id IN (" . trim($category_ID) . ")";
					}else{
						$wherecatid = "";
					}
				} else $wherecatid = "";								
				$query = "SELECT id, title FROM #__categories WHERE section = '$section' $wherecatid AND published = '1' AND access <= '$my->gid' ORDER BY $order";
				$database->setQuery( $query );
				$rows = $database->loadObjectList();
				if (count($rows)){
					if ( $ac_show_pathway ){
						//echo "<br />\n" . _ALPHACONTENT_CATEGORY . " : <br />\n";				
						echo "<br />\n" . _ALPHACONTENT_CATEGORY . " " . stripslashes($row->title) . "<br />\n";	 
						if ( $ac_charbetwcat2 == '<li>' ) echo "<ul>\n";
					}
					$catIdTag = "";
					for ($i=0, $n=count($rows); $i < $n; $i++) {
					if ( $ac_charbetwcat2 == '<li>' ) echo "<li>\n";
						$row = $rows[$i];
						$linkcateg = $indexSection . "&amp;cat=" . $row->id . "&amp;Itemid=$Itemid";		
						$showCountListItem = "";
						
						// Concat IDs for search tags...
						if ( $i>0 ) $catIdTag .= ",";
						$catIdTag .= $row->id;			
								
						if ( $shownumcatitem ){	
							// State published - archived
							$stateItem = "\nAND state = '1'";
							if ($params->get( 'include_archived' )=='1') $stateItem .= " OR state = '-1'";
							// check version of product for compatibily Mambo/Joomla!
							if ( $_VERSION->PRODUCT == 'Joomla!' ){	
								$nullDate = $database->getNullDate();
								if ( $_VERSION->RELEASE >= '1.5' ) {
									$now = date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );
								} else {
									$now = _CURRENT_SERVER_TIME;		
								}
							} else {
								$nullDate = "0000-00-00 00:00:00";
								$now = date( 'Y-m-d H:i:s', time()+$mosConfig_offset*60*60 );
							}
							// if show num items		
							if ( $section!='com_weblinks' ){	
								$query = "SELECT COUNT(id)"
								. "\nFROM #__content"
								. "\nWHERE catid = '$row->id'"
								. $stateItem
								. "\nAND access <= '$my->gid'"
								. "\n AND ( publish_up = '$nullDate' OR publish_up <= '$now' )"
								. "\n AND ( publish_down = '$nullDate' OR publish_down >= '$now' )";
							}elseif ( $section=='com_weblinks' ) {
								$query = "SELECT COUNT(id)"
								. "\nFROM #__weblinks"
								. "\nWHERE published='1'"
								. "\nAND catid = '$row->id'"
								. "\nAND approved='1'";
							}
							$database->setQuery( $query );
							$listitems = $database->loadResult();
							$showCountListItem = " ($listitems)";		
						} // end if show Count Item	
						if ( $ac_show_pathway ){		
							echo "<a href=\"" . sefRelToAbs($linkcateg) . "\">" . $row->title . "</a>$showCountListItem";		
							if ( $i <= ($n-2) && $ac_charbetwcat2 != '<li>' ) { 
								echo $ac_charbetwcat2 ; 
							}elseif ( $ac_charbetwcat2 == '<li>' ){ 
								echo "\n</li>\n"; 
							}// char between each category
						}
					}// end for
					if ( $ac_show_pathway ){	
						if ( $ac_charbetwcat2 == '<li>' ) echo "</ul>\n";
					}
				}else{
					if ( $ac_show_pathway ){	
						echo "<br />\n";
					}
				}
			}else{
				// one categorie				
				if( $cat > '0' ){
					$catIdTag = $cat;
					if ( $ac_show_pathway ){	
						echo "  $img  "; 	
					}	
					$query = "SELECT id, title FROM #__categories WHERE id = '$cat'";
					$database->setQuery( $query );
					$rows = $database->loadObjectList();
					$row = $rows[0];
					if ( $ac_show_pathway ){	
						echo stripslashes( $row->title );
					}
					if ( $alpha != 'all' && $alpha!='' && $ac_show_pathway ){
						echo "  $img  " . _ALPHACONTENT_LETTER . ": " . strtoupper($alpha); 							
					}	
					if ( !$prov ) {
						$mainframe->SetPageTitle( stripslashes( html_entity_decode ( $directoryNameInstance . " - " . $row->title ) ) );					
					}
					if ( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) {							
						$pathway =& $mainframe->getPathWay();
						$pathway->addItem( stripslashes($row->title), '' );						
					} else {
						$mainframe->appendPathWay( "<span class=\"pathway\">" . stripslashes($row->title) . "</span>&nbsp;");
					}					
				}
			}
			
			// Tags for categories
			if ( $ac_show_tags && $section!='0' && $section!='com_weblinks') {
				ALPHACONTENT::showTags( $catIdTag, $ac_numTags );
			}
			
		}// end switch
		if ( $ac_show_pathway ){
			echo "</td></tr>\n";
			echo  "</table>\n";		
		}		
	}
	
	
	function showTags( $catIdTag, $maxlimitor=10 ) {
		global $database, $option, $Itemid;
	
		$query = "SELECT id, title, metakey FROM #__content WHERE catid IN($catIdTag) AND metakey!=''";
		$database->setQuery( $query );		
		$rows = $database->loadObjectList();
		$tags = "";
		$html = "";

		if ( $rows ) {
			for ($i=0, $n=count($rows); $i < $n; $i++) {
				$row = $rows[$i] ;				
				$row->metakey = trim( $row->metakey ) ;
				if ( $row->metakey!='' ) {
					if ( $i>0 ) $tags .= "," ;
					$tags .= $row->metakey ;
				}			
			}
			$tags = explode(",", $tags, $maxlimitor+1 );
			$tags = array_unique( $tags );
			if ( count( $tags ) ) {
				for ($i=0, $n=count($tags); $i < $n; $i++) {
					if ( $i==($maxlimitor) ) break;
					$metakey = @trim($tags[$i]);
					if ( $metakey!='' ) {
						if ( $i>0 ) $html .= ", ";
						//$html .= "<a href=\"" . sefRelToAbs("index.php?option=com_search&searchword=$metakey&submit=search&searchphrase=any&ordering=newest") . "\">" . $metakey . "</a>";
						/***
						no sefRelToAbs because not works with the SEF component (Sef Advance, OpenSEF etc...)
						***/
						$html .= "<a href=\"index.php?option=com_search&searchword=$metakey&submit=search&searchphrase=any&ordering=newest\">" . $metakey . "</a>";
					}
				}	
			}
		}
		
		if ( $html ) echo "<br /><br /><p>" . _ALPHACONTENT_SEARCH_BY_TAG . " : " . $html . "</p>";
		
	}
} 
?>