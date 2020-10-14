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
	// iso 8859-1 occidental lower
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
		echo "<a href='".$seflink."' title='0-9'>0-9</a>";
	}				
	for ($char=97;$char<=122;$char++){
		echo $separative;
		if (strtolower(chr($char))==$alpha){			
			echo str_repeat( ' ', $numspace )."<strong>".chr($char)."</strong>\n";
		}else{
			$seflink = sefRelToAbs("index.php?option=com_alphacontent&alpha=".strtolower(chr($char))."&section=$section&cat=$cat&Itemid=$Itemid");
			echo str_repeat( ' ', $numspace )."<a href='".$seflink."' title='".chr($char)."'>".chr($char)."</a>";
		}
	}
?>