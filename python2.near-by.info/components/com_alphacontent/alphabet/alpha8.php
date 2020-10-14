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

	//  ARABIC ALPHABET windows-1256	
		
		if (chr(195)==$alpha){
			echo $separative;
			echo str_repeat( ' ', $numspace )."<strong>".chr(195)."</strong>\n";
		}else{
			echo $separative;
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".chr(195)."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(195)."'>".chr(195)."</a>\n";
		}
		if (chr(200)==$alpha){
			echo $separative;
			echo str_repeat( ' ', $numspace )."<strong>".chr(200)."</strong>\n";
		}else{
			echo $separative;
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".chr(200)."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(200)."'>".chr(200)."</a>\n";
		}	
		for ($char=202;$char<=214;$char++){
			if (chr($char)==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".chr($char)."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
			}
		}
		for ($char=216;$char<=219;$char++){
			if (chr($char)==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".chr($char)."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
			}
		}
		for ($char=221;$char<=223;$char++){
			if (chr($char)==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".chr($char)."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
			}
		}		
		if (chr(225)==$alpha){
			echo $separative;
			echo str_repeat( ' ', $numspace )."<strong>".chr(225)."</strong>\n";
		}else{
			echo $separative;
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".chr(225)."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(225)."'>".chr(225)."</a>\n";
		}		
		for ($char=227;$char<=230;$char++){
			if (chr($char)==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".chr($char)."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
			}
		}
		if (chr(237)==$alpha){
			echo $separative;
			echo str_repeat( ' ', $numspace )."<strong>".chr(237)."</strong>\n";
		}else{
			echo $separative;
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".chr(237)."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(237)."'>".chr(237)."</a>\n";
		}		

?>