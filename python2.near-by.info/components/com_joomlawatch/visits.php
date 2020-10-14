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
	if ($i <= $omitLast +2)
		$jBasePath .= DIRECTORY_SEPARATOR;
}
define('JPATH_BASE', $jBasePath);
define('DS', DIRECTORY_SEPARATOR);
if (@ file_exists(JPATH_BASE . DIRECTORY_SEPARATOR . "globals.php"))
	@ define('JOOMLAWATCH_JOOMLA_15', 0);
else
	@ define('JOOMLAWATCH_JOOMLA_15', 1);

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
	require_once (JPATH_BASE . DS . 'includes' . DS . 'joomla.php');

}

require_once (JPATH_BASE . DS . "components" . DS . "com_joomlawatch" . DS . "config.php");
require_once (JPATH_BASE . DS . "components" . DS . "com_joomlawatch" . DS . "class.joomlawatch.php");
require_once (JPATH_BASE . DS . "components" . DS . "com_joomlawatch" . DS . "class.joomlawatch.html.php");
require_once (JPATH_BASE . DS . "components" . DS . "com_joomlawatch" . DS . "class.ip2country.php");

//for joomla 1.0 only if (file_exists($mosConfig_absolute_path."/language/english.php")) require_once ("../../language/english.php");

$joomlaWatch = new JoomlaWatch();
$joomlaWatchHTML = new JoomlaWatchHTML();

if (!$joomlaWatch->checkPermissions())
	die("You don't have any permissions to view this !");

$t1 = (time() + microtime());

$last = $joomlaWatch->getLastVisitId();

echo ("$last\n\n");

if (JOOMLAWATCH_JOOMLA_15) {
	require_once (JPATH_BASE . DS . 'administrator' . DS . 'includes' . DS . 'helper.php');
	$params = new JParameter('');
	include (JPATH_BASE . DS . "modules" . DS . "mod_whosonline" . DS . "mod_whosonline.php");
} else {
	if (@ file_exists(JPATH_BASE . DS . "language" . DS . "english.php"))
		require_once (JPATH_BASE . DS . "language" . DS . "english.php");
	$params = new MosParameters('');
	include (JPATH_BASE . DS . "modules" . DS . "mod_whosonline.php");
}

echo ("<br/>");
$today = floor(time() / 24 / 3600);
$thisWeek = floor(time() / 24 / 3600 / 7);
if (@ $_GET['day'])
	$day = @ $_GET['day'];
else
	$day = floor(time() / 24 / 3600);

if (@ $_GET['week'])
	$week = @ $_GET['week'];
else
	$week = floor(time() / 24 / 3600 / 7);

$prev = $day -1;
$next = $day +1;
$prevWeek = $week -1;
$nextWeek = $week +1;
?>

<table cellpadding='2' cellspacing='0' width='100%'>
<tr><td colspan='5'><h3>Latest Visitors</h3></td></tr>
<?php echo ($joomlaWatchHTML->renderVisitors()); ?>
<tr><td>&nbsp;</td></tr>
<tr><td colspan='5'><h3>Bots</h3></td></tr>
<?php echo ($joomlaWatchHTML->renderBots()); ?>
</table>



<!-- rendered in <?php echo((time()+microtime())-$t1); ?>s -->

