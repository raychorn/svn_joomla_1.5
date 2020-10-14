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

	function code2utf($num){
		if ($num < 128) return chr($num);
		if ($num < 2048) return chr(($num >> 6) + 192) . chr(($num & 63) + 128);
		if ($num < 65536) return chr(($num >> 12) + 224) . chr((($num >> 6) &63) + 128) . chr(($num & 63) + 128);
		if ($num < 2097152) return chr(($num >> 18) + 240) . chr((($num >> 12)& 63) + 128) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
		return '';
	}
	
	function encode($str){
		return preg_replace('/&#(\\d+);/e', 'code2utf($1)', utf8_encode($str));
	}

	// UPPER RUSSIAN ALPHABET  UTF-8
	if ( $alpha=='all' ){	
		echo "<strong>".strtoupper(_ALPHACONTENT_ALPHABET_ALL)."</strong>\n";
	}else{
		$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=all&section=$section&cat=$cat&Itemid=$Itemid");			
		echo "<a href='".$seflink."' title='"._ALPHACONTENT_ALPHABET_ALL."'>".strtoupper(_ALPHACONTENT_ALPHABET_ALL)."</a>\n";
	}
	echo $separative;
	if ( $alpha=='0-9' ){		
		echo "<strong>0-9</strong>\n";
	}else{
		$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=0-9&section=$section&cat=$cat&Itemid=$Itemid");	
		echo "<a href='".$seflink."' title='0-9'>0-9</a>\n";
	}	
	for ($char=1040;$char<=1048;$char++){
		echo $separative;
		if (encode("&#".$char.";")==$alpha){			
			echo str_repeat( ' ', $numspace )."<strong>&#".$char.";</strong>\n";
		}else{			
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".encode("&#".($char+32).";")."&section=$section&cat=$cat&Itemid=$Itemid");
			echo "<a href='".$seflink."' title='".encode("&#".($char+32).";")."'>".encode("&#".$char.";")."</a>\n";
		}
	}
	for ($char=1050;$char<=1065;$char++){
		echo $separative;
		if (encode("&#".$char.";")==$alpha){			
			echo str_repeat( ' ', $numspace )."<strong>&#".$char.";</strong>\n";
		}else{			
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".encode("&#".($char+32).";")."&section=$section&cat=$cat&Itemid=$Itemid");
			echo "<a href='".$seflink."' title='".encode("&#".($char+32).";")."'>".encode("&#".$char.";")."</a>\n";
		}
	}
	for ($char=1069;$char<=1071;$char++){
		echo $separative;
		if (encode("&#".$char.";")==$alpha){			
			echo str_repeat( ' ', $numspace )."<strong>&#".$char.";</strong>\n";
		}else{			
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".encode("&#".($char+32).";")."&section=$section&cat=$cat&Itemid=$Itemid");
			echo "<a href='".$seflink."' title='".encode("&#".($char+32).";")."'>".encode("&#".$char.";")."</a>\n";
		}
	}
?>