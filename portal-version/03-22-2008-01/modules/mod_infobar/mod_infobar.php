<?php
/**
* Mod Infobar by MetZ
* The module is released under the GNU.
* Created by http://www.football-supporter.net
* Please link to us if you enjoy this module
* Thanks ;) and Enjoy!
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );
$text	= $params->get( 'infobar', '' );
$link	= $params->get( 'link', '' );
{
		global $my;
		if ($my->id){
		echo '';
		}
		else {
		echo '<link rel="stylesheet" href="modules/mod_infobar/style.css" type="text/css" />';
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
		echo '<tr><td width="100%"><div id="infobar">';
		echo '<a href="'. $link . '">'. $text .'</a>';
		echo '</div>';
		echo '</td></tr></table>';
		} }
		?>

