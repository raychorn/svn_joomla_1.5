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

				//  UPPER ISO 8859-2   ( Hungarian )
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
				
					if (strtolower(chr(65))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(65)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(65))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(65)."'>".chr(65)."</a>\n";
					}
					
					if (strtolower(chr(193))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(193)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(193))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(193)."'>".chr(193)."</a>\n";
					}
				
					for ($char=66;$char<=69;$char++){
						if (strtolower(chr($char))==$alpha){
							echo $separative;
							echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
						}else{
							echo $separative;
							$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
							echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
						}
					}					
					
					if (strtolower(chr(201))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(201)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(201))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(201)."'>".chr(201)."</a>\n";
					}
					
					for ($char=70;$char<=73;$char++){
						if (strtolower(chr($char))==$alpha){
							echo $separative;
							echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
						}else{
							echo $separative;
							$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
							echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
						}
					}		
								
					if (strtolower(chr(205))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(205)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(205))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(205)."'>".chr(205)."</a>\n";
					}
				
					for ($char=74;$char<=79;$char++){
						if (strtolower(chr($char))==$alpha){
							echo $separative;
							echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
						}else{
							echo $separative;
							$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
							echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
						}
					}		
					
					if (strtolower(chr(211))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(211)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(211))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(211)."'>".chr(211)."</a>\n";
					}
					
					if (strtolower(chr(214))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(214)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(214))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(214)."'>".chr(214)."</a>\n";
					}
				
					if (strtolower(chr(213))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(213)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(213))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(213)."'>".chr(213)."</a>\n";
					}
										
					for ($char=80;$char<=85;$char++){
						if (strtolower(chr($char))==$alpha){
							echo $separative;
							echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
						}else{
							echo $separative;
							$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
							echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
						}
					}		
					
					if (strtolower(chr(218))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(218)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(218))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(218)."'>".chr(218)."</a>\n";
					}
					
					if (strtolower(chr(220))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(220)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(220))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(220)."'>".chr(220)."</a>\n";
					}
					
					if (strtolower(chr(219))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(219)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(219))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(219)."'>".chr(219)."</a>\n";
					}
					
					for ($char=86;$char<=90;$char++){
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