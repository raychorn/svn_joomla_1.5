<?php
/*********************************************
* alphacontent - Mambo/Joomla! Component     *
* Copyright (C) 2005-2007 by Bernard Gilly   *
* Homepage   : www.visualclinic.fr           *
* Version    : 3.0                           *
* License    : DonationWare                  *
* 			 : All Rights Reserved           *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
	//*****************************************************
	
	// OCCIDENTAL + RUSSIAN
	
	//*****************************************************
	// occidental UPPER
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
	for ($char=65;$char<=90;$char++){
		echo $separative;
		if (strtolower(chr($char))==$alpha){			
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
		}else{
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
		}
	}
	echo "<br /><br />";	
	// UPPER RUSSIAN ALPHABET  windows-1251
	for ($char=192;$char<=200;$char++){
		echo $separative;
		if (strtolower(chr($char))==$alpha){			
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
		}else{
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
		}
	}
	for ($char=202;$char<=217;$char++){
		echo $separative;
		if (strtolower(chr($char))==$alpha){
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
		}else{
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
		}
	}
	for ($char=221;$char<=223;$char++){
		echo $separative;
		if (strtolower(chr($char))==$alpha){
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
		}else{
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
		}
	}		
?>