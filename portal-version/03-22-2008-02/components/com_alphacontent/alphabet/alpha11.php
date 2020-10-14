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

			//  UPPER ISO 8859-2  ( slovenian / Croatian / Serbian )
			if ( $alpha=='all' ){	
				echo "<strong>".strtoupper(_ALPHACONTENT_ALPHABET_ALL)."</strong>\n";
			}else{
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=all&section=$section&cat=$cat&Itemid=$Itemid");	
				echo "<a href='".$seflink."' title='"._ALPHACONTENT_ALPHABET_ALL."'>".strtoupper(_ALPHACONTENT_ALPHABET_ALL)."</a>\n";
			}				
			
			if ( $alpha=='0-9' ){	
				echo $separative;
				echo "<strong>0-9</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=0-9&section=$section&cat=$cat&Itemid=$Itemid");	
				echo "<a href='".$seflink."' title='0-9'>0-9</a>\n";
			}				
		
			for ($char=65;$char<=67;$char++){
				if (strtolower(chr($char))==$alpha){
					echo $separative;
					echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
				}else{
					echo $separative;
					$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
					echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
				}
			}					
			
			if (strtolower(chr(200))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(200)."</strong>\n";
			}else{
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(200))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo $separative;
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(200)."'>".chr(200)."</a>\n";
			}
			
			if (strtolower(chr(68))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(68)."</strong>\n";
			}else{
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(68))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo $separative;
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(68)."'>".chr(68)."</a>\n";
			}
			
			if (strtolower(chr(208))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(208)."</strong>\n";
			}else{
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(208))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo $separative;
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(208)."'>".chr(208)."</a>\n";
			}		
			
			for ($char=69;$char<=83;$char++){
				if (strtolower(chr($char))==$alpha){
					echo $separative;
					echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
				}else{
					echo $separative;
					$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
					echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
				}
			}
			
			if (strtolower(chr(169))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(169)."</strong>\n";
			}else{
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(169))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo $separative;
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(169)."'>".chr(169)."</a>\n";
			}		
			
			for ($char=84;$char<=86;$char++){
				if (strtolower(chr($char))==$alpha){
					echo $separative;
					echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
				}else{
					echo $separative;
					$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
					echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
				}
			}			
		
			if (strtolower(chr(90))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(90)."</strong>\n";
			}else{
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(90))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo $separative;
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(90)."'>".chr(90)."</a>\n";
			}		
			
			if (strtolower(chr(174))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(174)."</strong>\n";
			}else{
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(174))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo $separative;
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(174)."'>".chr(174)."</a>\n";
			}					
			
			for ($char=87;$char<=89;$char++){
				if (strtolower(chr($char))==$alpha){
					echo $separative;
					echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
				}else{
					echo $separative;
					$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
					echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
				}
			}				
					
?>
