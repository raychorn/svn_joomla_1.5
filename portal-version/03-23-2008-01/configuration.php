<?php
$sname = strtolower($_SERVER['SERVER_NAME']);
switch ($sname) {
	case 'localhost':
		include_once('configuration-'.$sname.'.php');
		break;
	case 'python.near-by.info':
	case 'python2.near-by.info':
	case 'raychorn.com':
	case 'www.raychorn.com':
	case 'raychorn.near-by.info':
		include_once('configuration_'.$sname.'.php');
		break;
	default:
		include_once('configuration_near-by.info.php');
		break;
}
?>