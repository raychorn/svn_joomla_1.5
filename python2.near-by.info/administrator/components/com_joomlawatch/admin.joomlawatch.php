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

$dirname = dirname(__FILE__);
$dirnameExploded = explode(DIRECTORY_SEPARATOR, $dirname);
$jBasePath = "";
$omitLast = 3;
for ($i = 0; $i < sizeof($dirnameExploded) - $omitLast; $i++) {
	$jBasePath .= $dirnameExploded[$i];
	if ($i <= $omitLast +1)
		$jBasePath .= DIRECTORY_SEPARATOR;
}
define('JPATH_BASE2', $jBasePath);
if (!defined('DS'))
	define('DS', DIRECTORY_SEPARATOR);

if (@ file_exists(JPATH_BASE2 . DIRECTORY_SEPARATOR . "globals.php"))
	@ define('JOOMLAWATCH_JOOMLA_15', 0);
else
	@ define('JOOMLAWATCH_JOOMLA_15', 1);

if (JOOMLAWATCH_JOOMLA_15) {
	require_once (JPATH_BASE2 . DS . 'includes' . DS . 'defines.php');
	require_once (JPATH_BASE2 . DS . 'includes' . DS . 'framework.php');
	$mainframe = & JFactory :: getApplication('site');
	$mainframe->initialise();
} else {
	// defines for Joomla 1.0
}

require_once (JPATH_BASE2 . DS . "components" . DS . "com_joomlawatch" . DS . "config.php");
require_once (JPATH_BASE2 . DS . "components" . DS . "com_joomlawatch" . DS . "class.ip2country.php");
require_once (JPATH_BASE2 . DS . "components" . DS . "com_joomlawatch" . DS . "class.joomlawatch.php");
require_once (JPATH_BASE2 . DS . "components" . DS . "com_joomlawatch" . DS . "class.joomlawatch.html.php");
require_once (JPATH_BASE2 . DS . "administrator" . DS . "components" . DS . "com_joomlawatch" . DS . "admin.joomlawatch.html.php");

$adminJoomlaWatchHTML = new AdminJoomlaWatchHTML();
$joomlaWatch = new JoomlaWatch();

switch ($task) {

	case "settings" :
		{
			$adminJoomlaWatchHTML->renderHeader();
			$adminJoomlaWatchHTML->renderSettings(@ $result);

			break;
		}
	case "settingsSave" :
		{
			$adminJoomlaWatchHTML->renderHeader();
			$result = $joomlaWatch->saveSettings($_POST);
			$adminJoomlaWatchHTML->renderSettings(@ $result);

			break;
		}

	default :
		$adminJoomlaWatchHTML->renderHeader();
		$adminJoomlaWatchHTML->renderBody($option);
		break;
}
?>
