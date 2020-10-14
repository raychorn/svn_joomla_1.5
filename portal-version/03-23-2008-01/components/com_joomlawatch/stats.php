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

$t1 = (time() + microtime());

$query = "select id from #__joomlawatch order by id desc limit 1";
$joomlaWatch->database->setQuery($query);
$rows = $joomlaWatch->database->loadObjectList();
$row = @ $rows[0];

$last = @ $row->id;

//$params = new MosParameters("");
$today = floor(time() / 24 / 3600 + $joomlaWatch->getConfigValue('JOOMLAWATCH_DAY_OFFSET'));

$thisWeek = ceil(time() / 7 / 24 / 3600 + $joomlaWatch->getConfigValue('JOOMLAWATCH_WEEK_OFFSET'));

if (@ $_GET['day'])
	$day = @ $_GET['day'];
else
	$day = floor(time() / 24 / 3600 + $joomlaWatch->getConfigValue('JOOMLAWATCH_DAY_OFFSET'));

if (@ $_GET['week'])
	$week = @ $_GET['week'];
else
	$week = ceil(time() / 24 / 3600 / 7 + $joomlaWatch->getConfigValue('JOOMLAWATCH_WEEK_OFFSET'));

$prev = $day -1;
$next = $day +1;
$prevWeek = $week -1;
$nextWeek = $week +1;
?>

<table border='0' cellpadding='1' cellspacing='0' width='100%'>

<tr><td colspan='5'><h3>Visit stats for week <?php echo(date("W",$week*3600*24*7)); ?>/<?php echo(date("Y",$week*3600*24*7)); ?></h3></td></tr>
<tr><td colspan='5'>
<table border='0'>
<tr><td align='left' width='10%'><?php echo("<a href='javascript:setWeek($prevWeek)' id='visits_$prevWeek'>&lt;Week&nbsp;".date("W",$prevWeek*3600*24*7)."</a></td><td align='left'><img src='$joomlaWatchHTML->mosConfig_live_site/components/com_joomlawatch/icons/calendar.gif' border='0' align='center' />"); ?></td>
<td align='center' width='20%'><?php if (@$week != $thisWeek)echo("<a href='javascript:setWeek($thisWeek)' id='visits_$thisWeek'>this week</a>"); ?></td>
<td align='right' width='10%'><?php if ($nextWeek <= $thisWeek) echo("<img src='$joomlaWatchHTML->mosConfig_live_site/components/com_joomlawatch/icons/calendar.gif' border='0' align='center' /></td><td width='20%' align='right'><a href='javascript:setWeek($nextWeek)' id='visits_$nextWeek'>Week&nbsp;".date("W",$nextWeek*3600*24*7)."&gt;</a>"); ?></td>
</tr>
</table>

<tr>
<?php echo $joomlaWatchHTML->renderVisitsGraph($week); ?>
<br/>

<tr><td colspan='3'>

<table width='100%'>
	<tr>
	<td align='center' class='<?php echo $joomlaWatchHTML->renderTabClass("0", @$_GET['tab']);?>'>
	<?php echo $joomlaWatchHTML->renderSwitched("0","Daily",@$_GET['tab']); ?>
	</td>
	<td align='center' class='<?php echo $joomlaWatchHTML->renderTabClass("1", @$_GET['tab']);?>'> 
	<?php echo $joomlaWatchHTML->renderSwitched("1","All-time", @$_GET['tab']); ?>
	</td>
	<td align='center' class='tab_none'> 
	</td>
	</tr>
</table>

<?php if (@$_GET['tab'] == "1") { ?>
<tr><td colspan='5'><h3>All-time stats</h3></td>

<tr><td colspan='3'><u>All-time URI</u></td></tr>
<tr><td colspan='3'><?php echo $joomlaWatchHTML->renderExpand("uri"); ?></td></tr>
<tr><td  valign='top'><?php echo $joomlaWatchHTML->renderTotalIntValuesByName("uri", @$_GET['uri']); ?></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
<tr><td colspan='3'><u>All-time Countries</u></td></tr>
<tr><td colspan='3'><?php echo $joomlaWatchHTML->renderExpand("countries"); ?></td></tr>
<tr><td valign='top'><?php echo $joomlaWatchHTML->renderTotalIntValuesByName("country", @$_GET['countries']); ?></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
<tr><td colspan='3'><u>All-time IP</u></td></tr>
<tr><td colspan='3'><?php echo $joomlaWatchHTML->renderExpand("ip"); ?></td></tr>
<tr><td valign='top'><?php echo $joomlaWatchHTML->renderTotalIntValuesByName("ip", @$_GET['ip']); ?></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
<tr><td colspan='3'><u>All-time Browsers</u></td></tr>
<tr><td colspan='3'><?php echo $joomlaWatchHTML->renderExpand("browsers"); ?></td></tr>
<tr><td valign='top'><?php echo $joomlaWatchHTML->renderTotalIntValuesByName("browser", @$_GET['browsers']); ?></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
<tr><td colspan='3'><u>All-time OS</u></td></tr>
<tr><td colspan='3'><?php echo $joomlaWatchHTML->renderExpand("os"); ?></td></tr>
<tr><td valign='top'><?php echo $joomlaWatchHTML->renderTotalIntValuesByName("os", @$_GET['os']); ?></td></tr>

<?php } else { ?>
	
<h3>Daily stats <?php echo $joomlaWatchHTML->getDateByDay($day);?></h3>
<table width='100%'>
<tr><td align='left'><?php echo("<a href='javascript:setDay($prev)' id='$prev'>&lt;".date("d.m.Y",$prev*3600*24)."<img src='$joomlaWatchHTML->mosConfig_live_site/components/com_joomlawatch/icons/calendar.gif' border='0' align='center' /></a>"); ?></td>
<td align='center'><?php if ($day != $today)echo("<a href='javascript:setDay($today)' id='$today'>today</a>"); ?></td>
<td align='right'><?php if ($next <= $today) echo("<a href='javascript:setDay($next)' id='$next'><img src='$joomlaWatchHTML->mosConfig_live_site/components/com_joomlawatch/icons/calendar.gif' border='0' align='center' />".date("d.m.Y",$next*3600*24)."&gt;</a>"); ?></td>
</tr>
</table>

<tr><td colspan='3'><u>URI for <?php echo $joomlaWatchHTML->getDateByDay($day);?></u></td></tr>
<tr><td colspan='3'><?php echo $joomlaWatchHTML->renderExpand("uri"); ?></td></tr>
<tr><td  valign='top'><?php echo $joomlaWatchHTML->renderIntValuesByName("uri", $day, @$_GET['uri']); ?></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
<tr><td colspan='3'><u>Countries for <?php echo $joomlaWatchHTML->getDateByDay($day);?></u></td></tr>
<tr><td colspan='3'><?php echo $joomlaWatchHTML->renderExpand("countries"); ?></td></tr>
<tr><td><?php echo $joomlaWatchHTML->renderIntValuesByName("country", $day, @$_GET['countries']); ?></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
<tr><td colspan='3'><u>IPs for <?php echo $joomlaWatchHTML->getDateByDay($day);?></u></td></tr>
<tr><td colspan='3'><?php echo $joomlaWatchHTML->renderExpand("ip"); ?></td></tr>
<tr><td valign='top'><?php echo $joomlaWatchHTML->renderIntValuesByName("ip", $day, @$_GET['ip']); ?></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
<tr><td colspan='3'><u>Browsers for <?php echo $joomlaWatchHTML->getDateByDay($day);?></u></td></tr>
<tr><td colspan='3'><?php echo $joomlaWatchHTML->renderExpand("browser"); ?></td></tr>
<tr><td valign='top'><?php echo $joomlaWatchHTML->renderIntValuesByName("browser", $day, @$_GET['browser']); ?></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
<tr><td colspan='3'><u>OS for <?php echo $joomlaWatchHTML->getDateByDay($day);?></u></td></tr>
<tr><td colspan='3'><?php echo $joomlaWatchHTML->renderExpand("os"); ?></td></tr>
<tr><td valign='top'><?php echo $joomlaWatchHTML->renderIntValuesByName("os", $day, @$_GET['os']); ?></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
</table>

<?php } ?>

</td>
</tr>
</table>

<hr size='1' width='100%'/>
<h3>IP blocking</h3>
<a href='javascript:blockIpManually();'>Enter IP manually</a><br/>
<table>
<?php echo($joomlaWatchHTML->renderBlockedIPs()); ?>
</table>

<!-- rendered in <?php echo((time()+microtime())-$t1); ?>s -->
