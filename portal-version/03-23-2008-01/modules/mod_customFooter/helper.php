<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modCustomFooter
{
	function getFooterCode($sitenameToDisplay,$footerSeparatorToDisplay,$footerTextLine1ToDisplay,$footerTextLine2ToDisplay)
	{
		$part1 = "Copyright &#169; ".date("Y");
		if ($sitenameToDisplay != "")
		{
			$part2 = " ".htmlentities($sitenameToDisplay);
		}
		if ($footerSeparatorToDisplay != "")
		{
			$part3 = " ".$footerSeparatorToDisplay;
		}
		if ($footerTextLine1ToDisplay != "")
		{
			$part4 = " ".htmlentities($footerTextLine1ToDisplay);
		}
		if ($footerTextLine2ToDisplay != "")
		{
			$part5 = "<br />".htmlentities($footerTextLine2ToDisplay);
		}
		$customFooter = $part1.$part2.$part3.$part4.$part5;
		echo($customFooter);
	}
}
