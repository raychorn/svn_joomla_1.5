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
	// LOWER RUSSIAN ALPHABET windows-1251
	if ( $alpha=='0-9' ){	
		echo "<strong>0-9</strong>\n";
	}else{
		$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=0-9&section=$section&cat=$cat&Itemid=$Itemid");
		echo "<a href='".$seflink."' title='0-9'>0-9</a>\n";
	}
	
	for ($char=224;$char<=232;$char++){
		echo $separative;
		if (strtolower(chr($char))==$alpha){			
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
		}else{
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
		}
	}
	for ($char=234;$char<=249;$char++){
		echo $separative;
		if (strtolower(chr($char))==$alpha){
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
		}else{
			if ( $checkjoomlaversion ) {
				$seflink = JRoute::_("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat");
			} else $seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
		}
	}
	for ($char=253;$char<=255;$char++){
		echo $separative;
		if (strtolower(chr($char))==$alpha){
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
		}else{
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
		}
	}
?>