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

	//  GREEK ALPHABET UTF-8
	
	if ( $alpha=='all' ){	
		echo "<strong>".strtoupper(_ALPHACONTENT_ALPHABET_ALL)."</strong>\n";
	}else{
		$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=all&section=$section&cat=$cat&Itemid=$Itemid");	
		echo "<a href='".$seflink."' title='"._ALPHACONTENT_ALPHABET_ALL."'>".strtoupper(_ALPHACONTENT_ALPHABET_ALL)."</a>\n";
	}				
	
	if ( $alpha=='0-9' ){	
		echo $separative;
		echo "0-9\n";
	}else{
		echo $separative;
		$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=0-9&Itemid=$Itemid");	
		echo "<a href='".$seflink."' title='0-9'>0-9</a>\n";
	}	
	
	for ($char=945;$char<=961;$char++){	
		$upperchar = $char-32;			
		if (chr(($char>>6)+192).chr(($char&63)+128)==$alpha){
			echo $separative;
			echo str_repeat( ' ', $numspace )."<strong>".chr(($char>>6)+192).chr(($char&63)+128)."</strong>\n";
		}else{
			echo $separative;
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".chr(($char>>6)+192).chr(($char&63)+128)."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(($char>>6)+192).chr(($char&63)+128)."'>".chr(($upperchar>>6)+192).chr(($upperchar&63)+128)."</a>\n";
		}
	}
	for ($char=963;$char<=969;$char++){	
		$upperchar = $char-32;			
		if (chr(($char>>6)+192).chr(($char&63)+128)==$alpha){
			echo $separative;
			echo str_repeat( ' ', $numspace )."<strong>".chr(($char>>6)+192).chr(($char&63)+128)."</strong>\n";
		}else{
			echo $separative;
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".chr(($char>>6)+192).chr(($char&63)+128)."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(($char>>6)+192).chr(($char&63)+128)."'>".chr(($upperchar>>6)+192).chr(($upperchar&63)+128)."</a>\n";
		}
	}

?>