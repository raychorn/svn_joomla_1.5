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
	// iso 8859-1 occidental UPPER image
	if ( $alpha=='0-9' ){					
		echo "<img src=\"".$mosConfig_live_site."/components/com_alphacontent/images/0-9_2.gif\" border=\0\>";
	}else{
		$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=0-9&section=$section&cat=$cat&Itemid=$Itemid");
		echo "<a href='".$seflink."' title=\"0-9\"><img src=\"".$mosConfig_live_site."/components/com_alphacontent/images/0-9.gif\" border=\0\></a>";
	}
	for ($char=65;$char<=90;$char++){
		if (chr($char)==$alpha){
			echo str_repeat( ' ', $numspace )."<img src=\"".$mosConfig_live_site."/components/com_alphacontent/images/".chr($char)."_2.gif\" border=\0\>";
		}else{
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'><img src=\"".$mosConfig_live_site."/components/com_alphacontent/images/".chr($char).".gif\" border=\0\></a>";
		}
	}
?>