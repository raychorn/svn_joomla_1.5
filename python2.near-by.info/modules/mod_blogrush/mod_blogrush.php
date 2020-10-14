<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
$blogRushId = $params->get('blogrushId');
echo "<script type='text/javascript'><!--\r\n";
echo "blogrush_feed = \"" . $blogRushId . "\"\r\n";
echo "//--></script>";
echo "<script type=\"text/javascript\" src=\"http://widget.blogrush.com/show.js\">";
echo "</script>";
?>