<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$size = $params->get('size');
$mapstyle = $params->get('mapstyle');
$pinstyle = $params->get('pinstyle');
$pincolor = $params->get('pincolor');
$key = $params->get('key');

if (strlen($key) == 8)
{
	echo '<embed src="http://maps.amung.us/flash/flashsrv.php?k='. $key .'&type=em';
	if ($size == "large")
	{
		echo 'b';
	}
	echo '.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" allowScriptAccess="always" allowNetworking="all" type="application/x-shockwave-flash" flashvars="wausitehash='. $key .'&map='. $mapstyle .'&pin='. $pinstyle .'-'. $pincolor .'&link=yes" ';
	if ($size == "large")
	{
		echo 'width="420" height="230" />';
	}
	else
	{
		echo 'width="200" height="135" />';
	}
}
else
{
	echo 'You need to provide your 8-character website key from <a href="http://maps.amung.us" target="_blank" title="Get your 8-character website key">http://maps.amung.us</a>.';
}
?>