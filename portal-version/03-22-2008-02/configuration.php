<?php
$sname = strtolower($_SERVER['SERVER_NAME']);
switch ($sname) {
	case 'python.near-by.info':
		include_once('configuration_'.$sname.'.php');
		break;
	case 'python2.near-by.info':
		include_once('configuration_'.$sname.'.php');
		break;
	default:
		include_once('configuration-localhost.php');
		break;
}
?>