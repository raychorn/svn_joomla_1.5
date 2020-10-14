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

				//  UPPER OCCIDENTAL ISO 8859-1 + ESTONIAN SPECIFIC CHARACTERS
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
				for ($char=65;$char<=90;$char++){
					if (strtolower(chr($char))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
					}else{
						echo $separative;
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
					}
				}
				// specific Estonian character 
					if (strtolower(chr(213))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(213)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(213))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(213)."'>".chr(213)."</a>\n";
					}
				// specific Estonian character 
					if (strtolower(chr(196))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(196)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(196))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(196)."'>".chr(196)."</a>\n";
					}
				// specific Estonian character 
					if (strtolower(chr(214))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(214)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(214))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(214)."'>".chr(214)."</a>\n";
					}
				// specific Estonian character 
					if (strtolower(chr(220))==$alpha){
						echo $separative;
						echo str_repeat( ' ', $numspace )."<strong>".chr(220)."</strong>\n";
					}else{
						$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(220))."&section=$section&cat=$cat&Itemid=$Itemid");
						echo $separative;
						echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(220)."'>".chr(220)."</a>\n";
						}
?>