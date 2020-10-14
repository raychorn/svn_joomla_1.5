<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007-2008 by Bernard Gilly   *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function mxcParse($message, $smiley, $mxc_bbcodesupport, $mxc_picturesupport, $mxc_smiliesupport, $mosConfig_live_site) {
	global $mosConfig_absolute_path;
	
	require( $mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php' );
	
	$mxc_bbcodewidthpicture = ( $mxc_bbcodewidthpicture!='' && is_numeric($mxc_bbcodewidthpicture) )? $mxc_bbcodewidthpicture : '100' ;

  # Convert BB Code to HTML commands
  if ($mxc_bbcodesupport) {
    $matchCount = preg_match_all("#\[code\](.*?)\[/code\]#si", $message, $matches);
    for ($i = 0; $i < $matchCount; $i++) {
      $currMatchTextBefore = preg_quote($matches[1][$i]);
      $currMatchTextAfter = htmlspecialchars($matches[1][$i]);
      $message = preg_replace("#\[code\]$currMatchTextBefore\[/code\]#si", "<strong>Code:</strong><HR>$currMatchTextAfter<HR>", $message);
    }
    $message = preg_replace("#\[quote\](.*?)\[/quote]#si", "<strong>" . _MXC_QUOTE . "</strong><table width=\"95%\" cellpadding=\"5\" cellspacing=\"0\" style=\"border: 1px solid #999999;\" align=\"center\"><tr><td bgcolor=\"#FAFAFA\">\\1</td></tr></table>", $message);
    $message = preg_replace("#\[b\](.*?)\[/b\]#si", "<strong>\\1</strong>", $message);
    $message = preg_replace("#\[i\](.*?)\[/i\]#si", "<I>\\1</I>", $message);
    $message = preg_replace("#\[u\](.*?)\[/u\]#si", "<U>\\1</U>", $message);
    $message = preg_replace("#\[url\](http://)?(.*?)\[/url\]#si", "<a href=\"http://\\2\" target=\"_blank\">\\2</A>", $message);
    $message = preg_replace("#\[url=(http://)?(.*?)\](.*?)\[/url\]#si", "<a href=\"http://\\2\" target=\"_blank\">\\3</A>", $message);
    $message = preg_replace("#\[email\](.*?)\[/email\]#si", "<a href=\"mailto:\\1\">\\1</A>", $message);
    if ($mxc_picturesupport){	
		$message = preg_replace("#\[img\](.*?)\[/img\]#si", "<img src=\"\\1\" onLoad=\"if (this.width > ". $mxc_bbcodewidthpicture . " ) {this.width=". $mxc_bbcodewidthpicture . "}\" alt=\"\" />", $message);
	} else $message = preg_replace("#\[img\](.*?)\[/img\]#si", "", $message);
    $matchCount = preg_match_all("#\[list\](.*?)\[/list\]#si", $message, $matches);
    for ($i = 0; $i < $matchCount; $i++) {
      $currMatchTextBefore = preg_quote($matches[1][$i]);
      $currMatchTextAfter = preg_replace("#\[\*\]#si", "<LI>", $matches[1][$i]);
      $message = preg_replace("#\[list\]$currMatchTextBefore\[/list\]#si", "<UL>$currMatchTextAfter</UL>", $message);
    }
    $matchCount = preg_match_all("#\[list=([a1])\](.*?)\[/list\]#si", $message, $matches);
    for ($i = 0; $i < $matchCount; $i++) {
      $currMatchTextBefore = preg_quote($matches[2][$i]);
      $currMatchTextAfter = preg_replace("#\[\*\]#si", "<LI>", $matches[2][$i]);
      $message = preg_replace("#\[list=([a1])\]$currMatchTextBefore\[/list\]#si", "<OL TYPE=\\1>$currMatchTextAfter</OL>", $message);
    }
  }
  # Convert CR and LF to HTML BR command and strip slashes
  $message = preg_replace("/(\015\012)|(\015)|(\012)/","&nbsp;<br />", $message);
  $message = stripslashes($message);
  # Convert smilies to images
  if ($mxc_smiliesupport) {
    foreach ($smiley as $i=>$sm) {
      $message = str_replace ("$i", "<img src='$mosConfig_live_site/components/com_maxcomment/images/smilies/$sm' border='0' alt='$i' />", $message);
    }
  }
  return $message;
}
?>