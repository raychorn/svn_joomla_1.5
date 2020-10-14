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

	//  HEBREW windows-1255
	
	for ($char=224;$char<=233;$char++){
		if (strtolower(chr($char))==$alpha){
			echo $separative;
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
		}else{
			echo $separative;
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
		}
	}		
	for ($char=235;$char<=236;$char++){
		if (strtolower(chr($char))==$alpha){							
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
			echo $separative;
		}else{							
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
			echo $separative;
		}
	}			
	if (strtolower(chr(238))==$alpha){						
		echo str_repeat( ' ', $numspace )."<strong>".chr(238)."</strong>\n";
		echo $separative;
	}else{						
		$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(238))."&section=$section&cat=$cat&Itemid=$Itemid");
		echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(238)."'>".chr(238)."</a>\n";
		echo $separative;
	}
	for ($char=240;$char<=242;$char++){
		if (strtolower(chr($char))==$alpha){							
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
			echo $separative;
		}else{							
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
			echo $separative;
		}
	}					
	if (strtolower(chr(244))==$alpha){						
		echo str_repeat( ' ', $numspace )."<strong>".chr(244)."</strong>\n";
		echo $separative;
	}else{						
		$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(244))."&section=$section&cat=$cat&Itemid=$Itemid");
		echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(244)."'>".chr(244)."</a>\n";
		echo $separative;
	}
	for ($char=246;$char<=250;$char++){
		if (strtolower(chr($char))==$alpha){							
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
			echo $separative;
		}else{							
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
			echo $separative;
		}
	}
?>