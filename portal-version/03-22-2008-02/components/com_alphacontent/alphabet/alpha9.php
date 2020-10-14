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

			// iso 8859-9 Turkish UPPER
			
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
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=0-9&Itemid=$Itemid");	
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
			
			if (strtolower(chr(199))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(199)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(199))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(199)."'>".chr(199)."</a>\n";
			}			
			
			for ($char=68;$char<=71;$char++){
				if (strtolower(chr($char))==$alpha){
					echo $separative;
					echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
				}else{
					echo $separative;
					$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
					echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
				}
			}

			if (strtolower(chr(208))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(208)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(208))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(208)."'>".chr(208)."</a>\n";
			}			

			for ($char=72;$char<=73;$char++){
				if (strtolower(chr($char))==$alpha){
					echo $separative;
					echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
				}else{
					echo $separative;
					$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
					echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
				}
			}
			
			if (strtolower(chr(221))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(221)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(221))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(221)."'>".chr(221)."</a>\n";
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
			
			if (strtolower(chr(214))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(214)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(214))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(214)."'>".chr(214)."</a>\n";
			}			

			if (strtolower(chr(80))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(80)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(80))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(80)."'>".chr(80)."</a>\n";
			}			

			for ($char=82;$char<=83;$char++){
				if (strtolower(chr($char))==$alpha){
					echo $separative;
					echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
				}else{
					echo $separative;
					$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
					echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
				}
			}
			
			if (strtolower(chr(222))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(222)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(222))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(222)."'>".chr(222)."</a>\n";
			}			

			for ($char=84;$char<=85;$char++){
				if (strtolower(chr($char))==$alpha){
					echo $separative;
					echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
				}else{
					echo $separative;
					$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
					echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>\n";
				}
			}
			
			if (strtolower(chr(220))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(220)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(220))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(220)."'>".chr(220)."</a>\n";
			}			
			
			if (strtolower(chr(86))==$alpha){
				echo $separative;
				echo str_repeat( ' ', $numspace )."<strong>".chr(86)."</strong>\n";
			}else{
				echo $separative;
				$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr(86))."&section=$section&cat=$cat&Itemid=$Itemid");
				echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr(86)."'>".chr(86)."</a>\n";
			}			

			for ($char=89;$char<=90;$char++){
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