<?php

/**
* JoomlaWatch - A real-time ajax joomla monitor and live stats
* @version 1.2.x
* @package JoomlaWatch
* @license http://www.gnu.org/licenses/gpl-3.0.txt 	GNU General Public License v3
* @copyright (C) 2008 by Matej Koval - All rights reserved! 
* @website http://www.codegravity.com
**/

error_reporting(0);

define('_JEXEC', 1);
$dirname = dirname(__FILE__);
$dirnameExploded = explode(DIRECTORY_SEPARATOR, $dirname);
$jBasePath = "";
$omitLast = 2;
for ($i = 0; $i < sizeof($dirnameExploded) - $omitLast; $i++) {
	$jBasePath .= $dirnameExploded[$i];
	if ($i <= $omitLast+2)
		$jBasePath .= DIRECTORY_SEPARATOR;
}
define('JPATH_BASE', $jBasePath);
define('DS', DIRECTORY_SEPARATOR);
if (@file_exists(JPATH_BASE . DIRECTORY_SEPARATOR . "globals.php"))
	@define('JOOMLAWATCH_JOOMLA_15', 0);
else
	@define('JOOMLAWATCH_JOOMLA_15', 1);

if (JOOMLAWATCH_JOOMLA_15) {
	require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
	require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');
	require_once (JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'application' . DS . 'module' . DS . 'helper.php');
	$mainframe = & JFactory :: getApplication('site');
	$mainframe->initialise();
} else {
	define('_VALID_MOS', 1);
	require_once (JPATH_BASE . DS . 'globals.php');
	require_once (JPATH_BASE . DS . 'configuration.php');
	require_once (JPATH_BASE . DS . 'includes/joomla.php');
}

require_once (JPATH_BASE . DS . "components" . DS . "com_joomlawatch" . DS . "config.php");
require_once (JPATH_BASE . DS . "components" . DS . "com_joomlawatch" . DS . "class.joomlawatch.php");
require_once (JPATH_BASE . DS . "components" . DS . "com_joomlawatch" . DS . "class.joomlawatch.html.php");
require_once (JPATH_BASE . DS . "components" . DS . "com_joomlawatch" . DS . "class.ip2country.php");

$joomlaWatch = new JoomlaWatch();
$joomlaWatchHTML = new JoomlaWatchHTML();

if (!$joomlaWatch->checkPermissions())
	die("You don't have any permissions to view this !");


$joomlaWatch->blockIpToggle(@$_GET['ip']);

