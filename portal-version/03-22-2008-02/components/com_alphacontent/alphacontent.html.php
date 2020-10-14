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

//include( $mosConfig_absolute_path.'/components/com_alphacontent/includes/alphacontent.functions.php' );
	
class HTML_ALPHA_FRONTEND {
	
	function display( &$rows, &$pageNav, $limitstart, $limit, $total, $alpha, $content_typecontent, $section, $cat, $sortitems, &$params, &$searchlistfields, $searchfilter ) {
		global $mainframe, $mosConfig_hideCreateDate, $mosConfig_offset, $mosConfig_lang;
		global $mosConfig_live_site, $mosConfig_absolute_path, $option, $Itemid, $database;
		global $_MAMBOTS, $hide_js, $my, $_VERSION, $mosConfig_sef;
		
		require( $mosConfig_absolute_path.'/administrator/components/com_alphacontent/alphacontent_config.php' );
		
		$checkversion = ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5') ? 1 : 0;

		// insert script for rating
		if ( $ac_show_ac_rating ){
			//if ( ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE < '1.5') || ($_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' && $mosConfig_sef=='0') ) {
			if ( (!$checkversion) || ($checkversion && $mosConfig_sef=='0') ) {
				echo "\n<script type=\"text/javascript\" language=\"javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/behavior.js\"></script>";
				echo "\n<script type=\"text/javascript\" language=\"javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/rating.js\"></script>";	
			}
			$mainframe->addCustomHeadTag( "<link rel=\"stylesheet\" type=\"text/css\" href=\"$mosConfig_live_site/components/com_alphacontent/css/rating.css\" />" );
			require( $mosConfig_absolute_path . "/components/com_alphacontent/alphacontent.drawrating.php" );
		}
		
		$directoryname = $params->get( 'header' );

		$mainframe->SetPageTitle( stripslashes($directoryname) );		
		
		if ( $params->get( 'sec_id' ) ) {
			$secid = $params->get( 'sec_id' );
		}else{
			$secid = $select_section_ID;
		}		
		if ( $params->get( 'cat_id' ) ) {
			$catid = $params->get( 'cat_id' );
		}else{
			$catid = $select_category_ID;
		}
		
		// anchor
		echo "<a name=\"topalpha\"></a>";					
		
		if ( $params->get( 'show_weblinks' ) ) {
			$mainframe->addCustomHeadTag( "<script type='text/javascript' src='$mosConfig_live_site/components/$option/js/arc90_linkthumb.js'></script>" );
			$mainframe->addCustomHeadTag( "<style type='text/css' media=\"screen\">.arc90_linkpic { display: none; position: absolute; left: 0; top: 1.5em; } .arc90_linkpicIMG { padding: 0 4px 4px 0; background: #FFF url($mosConfig_live_site/components/$option/images/linkpic_shadow.gif) no-repeat bottom right; }</style>" );
		}
		
		// mode to display content item -> normal / popup / litbox
		$ac_displayItemMode = (( $ac_displayItemMode !='' ) ? $ac_displayItemMode : '0' );		
					
		if ( $ac_displayItemMode=='2' ){
			echo "\n<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/prototype.js\"></script>\n";
			echo "<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/scriptaculous.js\"></script>\n";
			echo "<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_alphacontent/js/litbox.js\"></script>\n";
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$mosConfig_live_site/components/com_alphacontent/css/litbox.css\" media=\"all\" />\n";
		}		
		
		if ( $showletters=='1' ){ 
			ALPHACONTENT::displaysearchletter( $alpha, $section, $cat, $Itemid );
		}
		
		if(  $alpha=='all' && $section=='all' && $cat=='all' && $ac_display_result_on_run == '0' && $ac_show_position_module != '0' && $ac_posmodule == '0' ) {
			acLoadModule( $ac_show_position_module );
			// show module before the directory			
		}	

		if ( $showcategories=='1' && $params->get( 'content_type' )!='1' ){ 
			if( $section=='all' && $cat='all' ){			
				ALPHACONTENT::displayallcategories( $secid, $catid, $params, $alpha );
			}else{				
				ALPHACONTENT::displaycategorie( $section, $cat, $catid, $alpha, $Itemid, $params );				
				
				// If user can submit
				if ( $ac_showsubmitlink && $my->gid >= $ac_gid_submit) {
					$ac_submitlink = "index.php?option=com_content&amp;task=new&amp;sectionid=$section&amp;Itemid=$Itemid";
					?>
					<p><a href="<?php echo sefRelToAbs( $ac_submitlink ); ?>"><?php echo _ALPHACONTENT_LINK_SUBMIT_IN_SECTION ; ?></a></p>
					<?php
				}
			}
		}elseif( $showcategories=='1' && $params->get( 'content_type' )=='1' ){
				ALPHACONTENT::displaycategorie( '0', '0', '', $alpha, $Itemid, $params );			
		}			 
		
	   if( !( $alpha=='all' && $section=='all' && $cat=='all' && $ac_display_result_on_run == '0' ) ) {  ?>
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function jumpmenu(target,obj,restore){
		  eval(target+".location='"+obj.options[obj.selectedIndex].value+"'");		
		  if (restore) obj.selectedIndex=0;		
		}		
		//-->
		</script>
		<?php if(count($rows)){ ?>		
		<table class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>" width="100%" border="0" cellspacing="2" cellpadding="0">
		  <tr>
		  <td>&nbsp;</td>
		  </tr>
          <tr>
            <td><div align="left">
			<form name="adminForm" action="" method="post">		
			<?php if( $showsearchfilter ){ 
			$labelsearchinput = ( $searchfilter ) ? $searchfilter : _ALPHACONTENT_SEARCH;
			?>
              <input type="text" name="searchfilter" class="inputbox" value="<?php echo $labelsearchinput; ?>" onfocus="this.value='';" />			  
			<?php			
			 	echo $searchlistfields;
			 }
			 if( $ac_showsearchbuttonfilter ){ ?>
            <input type="submit" name="Submit" class="button" value="<?php echo $ac_labelsearchbutton; ?>">			
            <?php } ?>
		<?php
			if($section!='all'){
				$link = "index.php?option=$option&amp;section=".$section;
				if($cat!='all'){ $link .= "&amp;cat=".$cat; }
			}elseif($alpha!='all'){
				$link = "index.php?option=$option&amp;alpha=".$alpha;
				$link .= "&amp;section=".$section."&amp;cat=".$cat;
			}elseif($alpha=='all' && $section=='all' && $cat=='all'){
				$link = "index.php?option=$option";
			}
		
			// for select sort box
			$thelimit = "&amp;limit=".$limit."&amp;limitstart=".$limitstart;						
			$isortitems = $link . '&amp;sort='.$sortitems.$thelimit."&amp;Itemid=$Itemid";
			
			// Build box
			if( $showsortselector ){
				if ( !$content_zone ){
					$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=1".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_ALPHA_TITLE_ASC );
					$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=2".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_ALPHA_TITLE_DESC );
				} else {
					$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=3".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_ALPHA_INTRO_ASC );
					$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=4".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_ALPHA_INTRO_DESC );
				}
				if ( $section!='com_weblinks' ) {
					$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=5".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_CREATED_DESC );
					$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=6".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_CREATED_ASC );
				}
				if ( $section!='com_weblinks' ) {
					$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=7".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_MODIFIED_DESC );		
					$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=8".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_MODIFIED_ASC );
				}
				if ( $showhits ) {
					$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=9".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_HITS_DESC );
					$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=10".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_HITS_ASC );
				}
				if ( $section!='com_weblinks' || ($section=='com_weblinks' && $ac_show_ac_rating) ) {
					if ( $showrating || $ac_show_ac_rating ) {
						$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=11".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_RATING_DESC );
						$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=12".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_RATING_ASC );
					}
				}				
				if ( $section!='com_weblinks' ) {	
					if ( $showauthor ) {
						$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=13".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_AUTHOR_ASC );
						$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=14".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_AUTHOR_DESC );
					}
				}
				$sortalpha[] = mosHTML::makeOption( sefRelToAbs($link."&amp;sort=15".$thelimit."&amp;Itemid=$Itemid"), _ALPHACONTENT_SORT_ITEM_DEFAULT_ORDERING );
				$listsortalpha = mosHTML::selectList( $sortalpha, 'sortalpha', 'class="inputbox" size="1" onchange="jumpmenu(\'parent\',this,1)"', 'value', 'text', sefRelToAbs($isortitems) );
				echo $listsortalpha." ";		
			}

			if ( $showchoicenumlist && !( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) && $_VERSION->PRODUCT != 'Mambo' ) {
				echo "#&nbsp;";
				$link .= "&amp;sort=".$sortitems."&amp;Itemid=$Itemid";
				echo $pageNav->getLimitBox( $link );
			} elseif ( $showchoicenumlist && $checkversion || $_VERSION->PRODUCT == 'Mambo' ) {
				//echo "#&nbsp;";
				//$link .= "&sort=".$sortitems."&amp;Itemid=$Itemid";
				//echo $pageNav->getLimitBox( $link );
				//echo "\n<input type=\"hidden\" name=\"limitstart\" value=\"$limitstart\" />";
			}
			?>
			</form>	
			 </div>
			</td>
          </tr>
		  <?php if( $showresultpagetotal ) { ?>
          <tr>
            <td><br /><?php echo $pageNav->writePagesCounter(); ?></td>
          </tr>
		  <?php } ?>
		</table>		
		<?php }else{
			echo _ALPHACONTENT_NORESULT;
		} ?>
		<table class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>" width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<?php
				$countthelist = 0;
								
				$ac_alignimage = $ac_alignimage;
				$ac_k = (($ac_alignimage == '2') ? 0 : 'none' ); // for alternate image left-right
				
				$line=0; // just using for 2 columns				
				
				for ($i=0, $n=count($rows); $i < $n; $i++) {					
					$row = $rows[$i];
					
					$ac_m = ($line % 2) + 1;	
					
					if ($row->created ) {
						$created = mosFormatDate ($row->created, $ac_formatdate);
					} else {					
						$created = "";						
					}
					$sectioncompleted = '';
					if ( $params->get( 'content_type' )=='2' ){
						if ( $row->section > '0' || $row->section=='com_weblinks' ){

							$query = "SELECT title"
							. "\n FROM #__categories"
							. "\n WHERE id = $row->category";
						
							$database->setQuery( $query );
							$rowCat = $database->loadResult();	
							
							if ( $row->section!='com_weblinks' ) {
								$query = "SELECT title"
								. "\n FROM #__sections"
								. "\n WHERE id = $row->section";
							
								$database->setQuery( $query );
								$rowSec = $database->loadResult();								
							} elseif ( $row->section=='com_weblinks' ){
								$rowSec = stripslashes(_ALPHACONTENT_WEBLINKS);
							}
							
							$sectioncompleted  = $rowSec . " / " . $rowCat;
							
						}elseif( $row->section == '0' ){
							$sectioncompleted = _ALPHACONTENT_NOCATEGORY;
						}					
					}	
					
					// Compliance with mamblog
					if ( $row->text=='' && $row->fulltextmore!='' ) $row->text = $row->fulltextmore;							

					// Prepare show image
					$tdwidth = "";
					$linkIMG   = "";
				
					if ( $showfirstimg !='0' && $ac_intro < 2 ){
						$max_width          = ($ac_maximg !='') ? $ac_maximg : 120 ;
						$max_ac_hspace      = ($ac_hspace !='') ? $ac_hspace : 0 ;
						$max_ac_vspace      = ($ac_vspace !='') ? $ac_vspace : 0 ;							
						$border_image       = ($ac_maxborder !='') ? $ac_maxborder : 0 ;							
						$color_border_image = ($ac_colorborder !='') ? $ac_colorborder : '#000000' ;
						$widthtotal_td      = $max_width + ( $border_image*2 ) + ($max_ac_hspace*2);						
						
						$imagepath = "";
						$nameimg   = "";
						if ( !$ac_nomosimage && !$checkversion ) {
							if ( strpos ( $row->images, "|", 0 ) ){	
								$images = $row->images;
								$image = "";
								$imagesarray[]="";
								if ( $images !='' ){
									$imagesarray = explode( "\n", $images );
									if ( $showfirstimg=='2' ){ 
										$images = end( $imagesarray ); 
									}else{ $images=$imagesarray[0]; }
									$images = explode ( "|", $images );
									$image = $images[0];
								}		
								$imagepath = $mosConfig_absolute_path."/images/stories/".$image;
								$nameimg = $mosConfig_live_site."/images/stories/".$image;	
								$tdwidth = "width=\"".$widthtotal_td."\"";		
							}else{
								$tdwidth       = "";
								$imagepath     = "";
								$nameimg       = "";
								$firstimage    = ""; 
								$image         = "";
								$max_ac_hspace = "";
								$max_ac_vspace = "";
							}			
						} else {
							$linkIMG = findIMG( $row->text, $showfirstimg );
						}									
					}						
					
					// Prepare link
					if ( $row->href ) {
						if ( $row->section!='com_weblinks' ) {
							if (is_callable( array( $mainframe, "getItemid" ) ) ) {
								$itemid = $mainframe->getItemid( $row->id );
							} elseif (is_callable( "JApplicationHelper::getItemid" ) ) {
								$itemid = JApplicationHelper::getItemid( $row->id );
							} else {
								$itemid = null;
							}
							$get_Itemid	= $itemid ? "&amp;Itemid=" . (int) $itemid : "";					
							$row->href .= $get_Itemid;
						}
					}
					
					// using 2 columns
				    if ( $ac_numcolumnslisting && $ac_m=='1' ) echo "\n<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\"><tr><td width=\"50%\">\n";
				    if ( $ac_numcolumnslisting && $ac_m=='2' ) echo "\n<td width=\"50%\">\n";					
					
						if ( $ac_styleblockresult == '0' ){
							echo "\n<fieldset style=\"height:100%;\">\n" ;	
						} 		
						
						?>					
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
						<?php
						// image position left
						if ( (@file_exists($imagepath) || $linkIMG!='') && $showfirstimg != '0' ){
							if ( $ac_alignimage == 0 && $ac_k == 'none' || $ac_alignimage == '2' && $ac_k == 0 ) {
							?>
							<td <?php echo $tdwidth; ?> valign="top">
							   <?php								  								
								reductAlphaIMG( $imagepath, $max_width, $nameimg, $border_image, $color_border_image, $max_ac_hspace, $max_ac_vspace, $row->href, $ac_linktitle, $row->browsernav, $ac_displayItemMode, $ac_nomosimage, $linkIMG );
								?>
						  </td>
							<?php 
							} 
						}	
						?>
						<td width="100%" valign="top">
								<?php							
								//  vars for template
								$num="";
								$title="";
								$icon_new="";
								$icon_hot="";
								$section_category="";
								$author="";
								$content="";
								$date="";
								$hits="";
								$comments="";
								$rating="";
								$print="";
								$pdf="";
								$emailthis="";
								$readmore="";
								$ratingbar="";
								$googlemaps="";
								$id_article="";
								$link_to_article=$row->href;
								
								// Ajax rating bar for AlphaContent
								$component4rating = "";
								if ( $ac_show_ac_rating ) {
									$component4rating = ( $row->section=='com_weblinks' ) ? 'com_weblinks' : 'com_content' ;
									$ratingbar = rating_bar( $row->id, $ac_num_stars, $component4rating, $ac_width_stars );									
								}
								
								// Location Google Maps link								
								if ( $showmap ) {	
									$mapIsDefined = 0;								
									if ( preg_match('#{GMAP=(.*)}#Uis', $row->text, $m) ) {
										$row->text = preg_replace( " |{GMAP=(.*)}| ", "", $row->text );
										$mapIsDefined = 1;
									} elseif ( preg_match('#{GMAP=(.*)}#Uis', $row->fulltextmore, $m) ) {
										$row->fulltextmore = preg_replace( " |{GMAP=(.*)}| ", "", $row->fulltextmore );
										$mapIsDefined = 1;
									}
									$a[] = null;
									if ( $mapIsDefined ) {
										$a = explode("|", $m[1]);
										if ( count($a)==3 ) {
											$thewidthmap  = $ac_googlemaps_width_map + 4;
											$theheightmap = $ac_googlemaps_height_map + 40;
											$status       = "status=no,toolbar=no,scrollbars=no,titlebar=no,menubar=no,resizable=no,width=".$thewidthmap.",height=".$theheightmap.",directories=no,location=no";
											$googlemaps   = "<a href=\"javascript:void window.open('index2.php?option=com_alphacontent&amp;task=viewmap&amp;la=".$a[0]."&amp;lo=".$a[1]."&amp;txt=".$a[2]."', 'win2', '$status');\">" . _ALPHACONTENT_MAP . "</a>";	
										}
									}									
								}
											
								// Display num of result
								if ( $shownumitemresult ){
									$num = $i+1+$pageNav->limitstart;
								}							
								// START TITLE
								if ( !isset($row->title_alias) ) $row->title_alias = $row->title;
								if ( $ac_title_used == 'title_alias' ) {
									$row->title = $row->title_alias;
								}
								$linkItemReadMore = "";							
								if ( $row->href ) {											
									if ( $row->section!='com_weblinks' ) {
										switch ( $ac_displayItemMode ){								
											case '1':
											$status = "status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no";
											$linkItem = "<a href=\"javascript:void window.open('" . sefRelToAbs( $row->href ) . "', 'win2', '$status');\">" . $row->title . "</a>";				
											$linkItemReadMore = "<a href=\"javascript:void window.open('" . sefRelToAbs( $row->href ) . "', 'win2', '$status');\">" . _ALPHACONTENT_READ_MORE . "</a>";				
											if ( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) {
												$linkItemReadMore = "<a href=\"javascript:void window.open('" . $row->href . "', 'win2', '$status');\">" . _ALPHACONTENT_READ_MORE . "</a>";	
											}
											break;									
											case '2':
											$linkIt = $mosConfig_live_site . "/" . $row->href;
											$linkItem = '<a href="javascript:void(0);" onclick="new LITBox(\'' . $linkIt . '\', {type:\'window\', overlay:true, height:600, width:680, resizable:true});">' . $row->title . '</a>';			
											$linkItemReadMore = '<a href="javascript:void(0);" onclick="new LITBox(\'' . $linkIt . '\', {type:\'window\', overlay:true, height:600, width:680, resizable:true});">' . _ALPHACONTENT_READ_MORE . '</a>';			
											if ( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) {
												$linkItemReadMore = '<a href="javascript:void(0);" onclick="new LITBox(\'' . $row->href . '\', {type:\'window\', overlay:true, height:600, width:680, resizable:true});">' . _ALPHACONTENT_READ_MORE . '</a>';
											}
											break;	
											case '0':								
											default:
											if ($row->browsernav == 1 ) {
												$linkItem = "<a href='" . sefRelToAbs( $row->href ) . "' target='_blank'>" . $row->title . "</a>";	
												$linkItemReadMore = "<a href='" . sefRelToAbs( $row->href ) . "' target='_blank'>" . _ALPHACONTENT_READ_MORE . "</a>";	
												if ( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) {
													$linkItemReadMore = "<a href='" . $row->href . "' target='_blank'>" . _ALPHACONTENT_READ_MORE . "</a>";	
												}
											}else{
												$linkItem = "<a href='" . sefRelToAbs( $row->href ) . "'>" . $row->title . "</a>";	
												$linkItemReadMore = "<a href='" . sefRelToAbs( $row->href ) . "'>" . _ALPHACONTENT_READ_MORE . "</a>";
												if ( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) {
													$linkItemReadMore = "<a href='" . $row->href . "'>" . _ALPHACONTENT_READ_MORE . "</a>";
												}
											}
											break;
										}
									} elseif ( $row->section=='com_weblinks' ) {
										$linkItem = stripslashes( $row->title );
										$linkItemReadMore = "";										
									}
								}
								if ( $ac_linktitle ) {							
									$title = $linkItem;
								}else{
									$title = $row->title;
								}
								// END TITLE ARTICLE							
								// Display icons new and icon hot
								$cdate = $row->created;
								$cjour = substr($cdate,8,2); 
								$cmois = substr($cdate,5,2); 
								$cannee = substr($cdate,0,4); 		
								$timestamp = mktime(0,0,0,$cmois,$cjour,$cannee);
								$cmaintenant = time();							
								$ecart_secondes = $cmaintenant - $timestamp;
								$ecart_jours = floor($ecart_secondes / (60*60*24)); 			
								// set default icons
								$new_icon = "new_english.gif";		
								$hot_icon = "hot_english.gif";		
								if ( $showiconnew && $numdaynew > '0' ){ 
									if ($ecart_jours <= $numdaynew){
										// Get icon in right language if exists
										if (file_exists($mosConfig_absolute_path."/components/$option/images/new_".$mosConfig_lang.".gif")){
											$new_icon = "new_".$mosConfig_lang.".gif";
										}
										$icon_new = "<span style=\"vertical-align:middle\"><img src=\"".$mosConfig_live_site."/components/$option/images/".$new_icon."\" alt=\"\" /></span>";
									}
								}
								if ( $showiconhot && $numhitshot > '0' ){ 
									// Get icon in right language if exists
									if (file_exists($mosConfig_absolute_path."/components/$option/images/hot_".$mosConfig_lang.".gif")){
										$hot_icon = "hot_".$mosConfig_lang.".gif";
									}
									if($row->hits >= $numhitshot){
										$icon_hot = "<span style=\"vertical-align:middle\"><img src=\"".$mosConfig_live_site."/components/$option/images/".$hot_icon."\" alt=\"\" /></span>";
									}
								}														
								// Display Section/Category							
								if ( $showsectioncategory ) {
									if ( $params->get( 'content_type' ) != '2') {								
										if ( $row->section ) {								
											if ( $row->state == '-1' ) {		
												$section_category = _ALPHACONTENT_ARCHIVES." / ".$row->section; 
											}else{									
												 $section_category = $row->section;
											}
										}
									} elseif ( $params->get( 'content_type' ) == '2') {
										if ( $row->state == '-1' ) {									
											$section_category = _ALPHACONTENT_ARCHIVES." / ".$sectioncompleted ; 
										}else{
											 $section_category = $sectioncompleted ; 
										}
									}
								}						
								// Display Author
								if ( $showauthor && $row->section!='com_weblinks' ){
									$author = (( $row->created_by_alias == '' ) ? $row->author : $row->created_by_alias );									
									
									if ( $ac_link2CB && acCheckCBcomponent() ) {
										$link_to_CBauthor =	"";				
										$link_to_CBauthor = sefRelToAbs( 'index.php?option=com_comprofiler&amp;task=userProfile&amp;user=' . $row->created_by . acCBAuthorItemid() );
										$author = "<a href='" . $link_to_CBauthor . "'>" . $author . "</a>";
									}
								} 
								
							$addlinkreadmore = "0";							
							
							// Display Introtext 										
							if ( $ac_intro < 3 ){						
								if ( $ac_intro < 2 ) {					
									$tags = (( $ac_intro==1 ) ? '<a></a><strong></strong><em></em><b></b><br /><br />' : '' );							
									if ( $numcharintro=='0' || $numcharintro=='' ){ $numcharintro = 9999999; }
									if ( strlen(acPrepareAlphaContent($row->text, 9999999, ' ', $tags )) > $numcharintro){ 
										$suite = "...";
										$addlinkreadmore = "1";
									}else{
										$suite = "";
										$addlinkreadmore = "0";
									}
									$row->text = acPrepareAlphaContent($row->text, $numcharintro, ' ', $tags );
									$content = ampReplace( $row->text ).$suite;
									
								} elseif ( $ac_intro == 2 ) {
									$addlinkreadmore = "0";
									$params2 = new mosParameters($row->attribs);
									// GC Parameters
									$params2->def( 'link_titles', 	$mainframe->getCfg( 'link_titles' ) );
									$params2->def( 'author', 		!$mainframe->getCfg( 'hideAuthor' ) );
									$params2->def( 'createdate', 	!$mainframe->getCfg( 'hideCreateDate' ) );
									$params2->def( 'modifydate', 	!$mainframe->getCfg( 'hideModifyDate' ) );
									$params2->def( 'print', 		!$mainframe->getCfg( 'hidePrint' ) );
									$params2->def( 'pdf', 			!$mainframe->getCfg( 'hidePdf' ) );
									$params2->def( 'email', 		!$mainframe->getCfg( 'hideEmail' ) );
									$params2->def( 'rating', 		$mainframe->getCfg( 'vote' ) );
									$params2->def( 'icons', 		$mainframe->getCfg( 'icons' ) );
									$params2->def( 'readmore', 		$mainframe->getCfg( 'readmore' ) );
									// Other Params
									$params2->def( 'image', 		1 );
									$params2->def( 'section', 		0 );
									$params2->def( 'section_link', 	0 );
									$params2->def( 'category', 		0 );
									$params2->def( 'category_link', 0 );
									$params2->def( 'introtext', 	1 );
									$params2->def( 'pageclass_sfx', '');
									$params2->def( 'item_title', 	1 );
									$params2->def( 'url', 			1 );
									
									$_MAMBOTS->loadBotGroup( 'content' );
									$result = $_MAMBOTS->trigger( 'onPrepareContent', array( &$row, &$params2, 0 ), true );
									$content = $row->text;
								}
							}
							// if weblink
							if ( $section=='com_weblinks' ) {	
								$suite = "";
								$addlinkreadmore = "0";													
								if ( $ac_showlinkthumbnail ) {
									// link with thumbnail
									$javascript = "window.location.replace('index.php?option=com_weblinks&task=view&catid=". $row->category ."&id=". $row->id . "');";
									$content .= "<br /><a href=\"" . $row->href . "\" class=\"linkthumb\" onclick=\"$javascript\" >" . $row->href . "</a>";	
								} else {
									// link without thumbnail
									$content .= "<br /><a href='" . sefRelToAbs( 'index.php?option=com_weblinks&amp;task=view&amp;catid='. $row->category .'&amp;id='. $row->id ) . "' target='_blank'>" . $row->href . "</a>";
								}
							}
											
							// show date created
							if ( $showdatecreate && $created ) {			
								$date = $created;						
							}						
							// show num hits
							if ( $showhits ) {
								$hits = $row->hits;
							}		
							// show num comments if use a system of comments
							if ( $shownumcomment=='1' && $ac_commentsystem!='') {
								if ( $ac_commentsystem!='combo' && $ac_commentsystem!='mambocomment' ) {
									$database->setQuery( "SELECT count(*) FROM #__".$ac_commentsystem." WHERE contentid='$row->id' AND published='1'" );
									$rowscomment = intval( $database->loadResult() );																		
								} elseif  ( $ac_commentsystem=='combo' ) {								
									$database->setQuery("SELECT COUNT(*) FROM #__content_comments WHERE articleid = '$row->id'");
									$rowscomment = intval( $database->loadResult() );
								} elseif ( $ac_commentsystem=='mambocomment' ) {
									$database->setQuery("SELECT COUNT(*) FROM #__comment WHERE articleid = '$row->id' AND published='1'");
									$rowscomment = intval( $database->loadResult() );			
								}
								echo $database->getErrorMsg();			
								$comments = $rowscomment;
							}	
							
							if ( !$ac_show_ac_rating ) {
								// show rating native joomla
								if ( $showrating && $row->section!='com_weblinks') {
									
									if ( $_VERSION->PRODUCT == 'Joomla!' ){	
										// look for images in template if available						
										$starImageOn = mosAdminMenus::ImageCheck( 'rating_star.png', '/images/M_images/' );
										$starImageOff = mosAdminMenus::ImageCheck( 'rating_star_blank.png', '/images/M_images/' );
									} else {
										// FOR COMPLIANCE WITH MAMBO
										$starImageOn = $mainframe->ImageCheck( 'rating_star.png', '/images/M_images/' );
										$starImageOff = $mainframe->ImageCheck( 'rating_star_blank.png', '/images/M_images/' );
									}									
															
									$img = "<span style=\"vertical-align:middle\">";						
									for ($c=0; $c < $row->rating; $c++) {
										$img .= $starImageOn;
									}
									for ($c=$row->rating; $c < 5; $c++) {
										$img .= $starImageOff;
									}
									$html = $img . "</span>  (";
									$html .= intval( $row->rating_count );
									if( $row->rating_count > 1){
										$rats = _ALPHACONTENT_RATINGS;
									}else{
										$rats = _ALPHACONTENT_RATING;
									}
									$html .= " ".$rats ;
									$html .= ")";
									$rating = $html;
								}
							}
							
							// show print link
							if( $showprint && $row->section!='com_weblink' ){
								$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
								$link   = $mosConfig_live_site ."/index2.php?option=com_content&amp;task=view&amp;id=$row->id&amp;pop=1&amp;page=";								
								if ( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) {
									$link = "index.php?view=article&amp;id=$row->id&amp;tmpl=component&amp;print=1&amp;page=&amp;option=com_content";
								}
								$print  = "<a href=\"" . $link . "\" target=\"_blank\" onclick=\"window.open('" . $link . "','win2','" . $status . "'); return false;\" title=\"";
								$print .= _ALPHACONTENT_PRINT . "\">";
								$print .= stripslashes(_ALPHACONTENT_PRINT) . "</a>";
							}
							
							// show PDF link
							if( $showpdf && $row->section!='com_weblink' ){
								$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
								$link 	= $mosConfig_live_site. '/index2.php?option=com_content&amp;do_pdf=1&amp;id='. $row->id;
								if ( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) {
									$link = 'index.php?option=com_content&amp;view=article&amp;id=' . $row->id . '&amp;format=pdf';
								}
								$pdf  = "<a href=\"". $link . "\" target=\"_blank\" onclick=\"window.open('" . $link . "','win2','" . $status . "'); return false;\" title=\"";
								$pdf .= _ALPHACONTENT_PDF . "\">" . stripslashes(_ALPHACONTENT_PDF) . "</a>";				
							}
							
							// show email link
							if( $showemail && $row->section!='com_weblink' ){	
								$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=400,height=250,directories=no,location=no';						
								$link 	= $mosConfig_live_site .'/index2.php?option=com_content&amp;task=emailform&amp;id='. $row->id;
								if ( $_VERSION->PRODUCT == 'Joomla!' && $_VERSION->RELEASE >= '1.5' ) {
									$url	= JURI::base() . JRoute::_("index.php?view=article&amp;id=" . $row->id, false);
									$link	= 'index.php?option=com_mailto&amp;tmpl=component&amp;link=' . base64_encode( $url );		
								}					
								$emailthis  = "<a href=\"". $link . "\" target=\"_blank\" onclick=\"window.open('" . $link . "','win2','" . $status . "'); return false;\" title=\"";
								$emailthis .= _ALPHACONTENT_EMAIL . "\">" . stripslashes(_ALPHACONTENT_EMAIL) . "</a>";				
							}							
											
							if( $row->fulltextmore!='' && $addlinkreadmore=='1' ){
								 $readmore = $linkItemReadMore;
							}
							
							$id_article = $row->id;
							
							// Load template
							require( $mosConfig_absolute_path.'/components/com_alphacontent/alphacontent.layout.php' );							
							?>					
							</td>
							<?php
							// image position right
							if ( (@file_exists($imagepath) || $linkIMG!='') && $showfirstimg != '0' ){
								if ( $ac_alignimage == 1 && $ac_k == 'none' || $ac_alignimage == '2' && $ac_k == 1 ) {
								?>
								<td <?php echo $tdwidth; ?> valign="top">
								   <?php								    					
									reductAlphaIMG( $imagepath, $max_width, $nameimg, $border_image, $color_border_image, $max_ac_hspace, $max_ac_vspace, $row->href, $ac_linktitle, $row->browsernav, $ac_displayItemMode, $ac_nomosimage, $linkIMG );
									?>
							  </td>
								 <?php 
								 } 
							 }	
							 ?>						 
  </tr>
</table>										
						<?php
						if ( $ac_styleblockresult == '0' ){
							echo "\n</fieldset>\n<br />" ;	
						} elseif ( $ac_styleblockresult == '1' ){
							echo "\n<hr size=\"1\" noshade=\"noshade\" />\n";
						} else {
							echo "<br />";
						}
						// using 2 columns
						if ( $ac_numcolumnslisting && $ac_m=='1' ) echo "\n</td>\n";
						if ( $ac_numcolumnslisting && $ac_m=='1' && $i==$n-1 ) echo "\n<td width=\"50%\">&nbsp;";
						if ( $ac_numcolumnslisting && $ac_m=='2' || $ac_numcolumnslisting && $ac_m=='1' && $i==$n-1 ) echo "\n</td></tr></table>\n";						
						
					$countthelist++;					
					$line++;
					if ( $ac_alignimage == '2' ){ $ac_k = 1 - $ac_k ; }
				}
				?>
		  </td>
		</tr>  
		<tr>
		  <td>		
			<?php
			// Table Navigation
			if ( $total > $limit ){
				echo "\n<table>";				
				echo "\n<tr>";
				echo "\n<td>";
				echo "\n<div align=\"center\">";
				if($section!='all' && $alpha=='all'){
					$link = "index.php?option=com_alphacontent&amp;section=".$section."&amp;sort=".$sortitems."&amp;Itemid=$Itemid";
					if($cat!='all'){
						$link = "index.php?option=com_alphacontent&amp;section=".$section."&amp;cat=".$cat."&amp;sort=".$sortitems."&amp;Itemid=$Itemid";												
					}
				}
				if($alpha!='all'){
					$link = "index.php?option=com_alphacontent&amp;alpha=".$alpha."&amp;section=".$section."&amp;cat=".$cat."&amp;sort=".$sortitems."&amp;Itemid=$Itemid";
				}
				if($alpha=='all' && $section=='all' && $cat=='all'){
					$link = "index.php?option=com_alphacontent&amp;sort=".$sortitems."&amp;Itemid=$Itemid";
				}	
				echo $pageNav->writePagesLinks( $link );			
				echo "\n</div>";
				echo "\n</td>";
				echo "\n</tr>";
				echo "\n</table>";
			}			
			eval(stripslashes(base64_decode("CQkJLy8gVGFibGUgQmFjayBCdXR0b24gYW5kIFRvcCBsaW5rDQoJCSAgICBlY2hvIFwiXFxuPHRhYmxlIGNsYXNzPVxcXCJjb250ZW50cGFuZVxcXCI+XCI7CQkgDQoJCSAgICBlY2hvIFwiXFxuPHRyPjx0ZD4mbmJzcDs8L3RkPjx0ZD4mbmJzcDs8L3RkPjwvdHI+XCI7DQoJCQllY2hvIFwiXFxuPHRyPjx0ZD5cIjsJDQoJCQllY2hvIFwiXFxuPGRpdiBhbGlnbj1cXFwibGVmdFxcXCI+XCI7DQoJCQltb3NIVE1MOjpCYWNrQnV0dG9uICggJHBhcmFtcywgJGhpZGVfanMgKTsNCgkJCWVjaG8gXCJcXG48L2Rpdj5cIjsJCQkNCgkJCWVjaG8gXCJcXG48L3RkPlwiOw0KCQkJZWNobyBcIlxcbjx0ZD5cIjsNCgkJCWVjaG8gXCJcXG48ZGl2IGFsaWduPVxcXCJyaWdodFxcXCI+XCI7CQkJICANCgkJCWlmKCAkY291bnR0aGVsaXN0ID4gNSApeyANCgkJCQkkdGVtcCA9IGV4cGxvZGUoXCJpbmRleC5waHA/b3B0aW9uPWNvbV9hbHBoYWNvbnRlbnRcIiwgJF9TRVJWRVJbXCdSRVFVRVNUX1VSSVwnXSk7DQoJCQkJaWYgKGNvdW50KCR0ZW1wKT09MiApIHsNCgkJCQkJJHRvcCA9IFwiaW5kZXgucGhwP29wdGlvbj1jb21fYWxwaGFjb250ZW50XCIgLiAkdGVtcFsxXSAuIFwiI3RvcGFscGhhXCI7DQoJCQkJCWVjaG8gXCI8YSBocmVmPVxcXCJcIi5zZWZSZWxUb0FicygkdG9wKS5cIlxcXCI+XCI7DQoJCQkJfSBlbHNlIHsgDQoJCQkJCWVjaG8gXCI8YSBocmVmPVxcXCIjdG9wYWxwaGFcXFwiPlwiOw0KCQkJCX0NCgkJCQllY2hvIF9BTFBIQUNPTlRFTlRfVE9QOw0KCQkJCWVjaG8gXCI8L2E+XCI7DQoJCQl9IGVsc2UgZWNobyBcIiBcIjsNCgkJCWVjaG8gXCJcXG48L2Rpdj5cIjsNCgkJCWVjaG8gXCJcXG48L3RkPlwiOw0KCQkJZWNobyBcIlxcbjwvdHI+XCI7DQoJCQllY2hvIFwiXFxuPC90YWJsZT5cIjsNCgkJCV9nZXRBQ0NvcHlyaWdodE5vdGljZSgpOwkJCQ0KCQkJZWNobyBcIlxcbjwvdGQ+XCI7DQoJCQllY2hvIFwiXFxuPC90cj5cIjsNCgkJCWVjaG8gXCJcXG48L3RhYmxlPlwiOw0K")));			
		} elseif ( $alpha=='all' && $section=='all' && $cat=='all' && $ac_display_result_on_run == '0' && $ac_show_position_module != '0' && $ac_posmodule == '1' ) {
			eval(stripslashes(base64_decode("CQkJYWNMb2FkTW9kdWxlKCAkYWNfc2hvd19wb3NpdGlvbl9tb2R1bGUgKTsNCgkJCV9nZXRBQ0NvcHlyaWdodE5vdGljZSgpOw0K")));
		}		
	}	
} // END CLASS
?>