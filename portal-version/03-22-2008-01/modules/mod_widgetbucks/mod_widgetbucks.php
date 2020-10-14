<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
$container_id = $params->get('containerID');
echo "<!-- START CUSTOM WIDGETBUCKS CODE -->";
echo "<div><script src=\"http://www.widgetbucks.com/script/ads.js?uid=" . $container_id . "\"></script></div>";
echo "<!-- END CUSTOM WIDGETBUCKS CODE -->";
echo "<div style='display:none'><a href='http://www.informationmadness.com/cms'>Information Madness</a></div>";
?>