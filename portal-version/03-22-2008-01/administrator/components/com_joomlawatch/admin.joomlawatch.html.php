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

class AdminJoomlaWatchHTML {

	var $database;
	var $mosConfig_live_site;

	function AdminJoomlaWatchHTML() {
		global $database, $mosConfig_live_site;
		if (!JOOMLAWATCH_JOOMLA_15) { // if Joomla 1.0
			$this->database = $database;
			$this->mosConfig_live_site = $mosConfig_live_site;
		} else { // if Joomla 1.5
			$this->database = & JFactory :: getDBO();
			$config = & JFactory :: getConfig();
			$this->mosConfig_live_site = $config->getValue('config.live_site');

		}
	}

	function renderHeader() {
?>
		<div align='left'>
	<table>
	<tr><td>
	<a href='http://www.codegravity.com' target='_blank'><img src='<?php echo($this->mosConfig_live_site);?>/components/com_joomlawatch/icons/joomlawatch-logo-32x32.gif' align='center' border='0'/></a>
	</td><td>
	<a href='http://www.codegravity.com' target='_blank' style='font-family: verdana; font-size: 14px; align:top; font-weight: bold; color: black;'>JoomlaWatch <?php echo(JoomlaWatch :: getConfigValue('JOOMLAWATCH_VERSION'));?></a><br/>A real-time AJAX joomla monitor
	</td>
	</tr>
	<tr><td colspan='2'>
				
				<a href='<?php echo($this->mosConfig_live_site);?>/administrator/index2.php?option=com_joomlawatch' >Stats</a> | 
				<a href='<?php echo($this->mosConfig_live_site);?>/administrator/index2.php?option=com_joomlawatch&task=settings' >Settings</a>
	</td>
	</tr>
	</table>
	</div>
	<div align='right'>
			For the latest version, please visit <a href='http://www.codegravity.com' target='_blank'>CodeGravity.com</a>
			</div>
			<?php


	}

	function getRand() {
		$query = "select value from #__joomlawatch_config where name = 'rand' order by id desc limit 1";
		$this->database->setQuery($query);
		$this->database->query();
		$rows = $this->database->loadObjectList();
		$row = @ $rows[0];
		$rand = @ $row->value;

		return $rand;

	}

	function renderBody($option) {

		$dirname = dirname(__FILE__);
		$dirnameExploded = explode(DIRECTORY_SEPARATOR, $dirname);
		$jBasePath = "";
		for ($i = 0; $i < sizeof($dirnameExploded) - 3; $i++)
			$jBasePath .= $dirnameExploded[$i] . DIRECTORY_SEPARATOR;
		require_once ($jBasePath . DS . "components/com_joomlawatch/config.php");
?>
<style type="text/css">
        TR, TD { font-family: verdana, helvetica, arial; font-size:10px;}
        .tab_active { 
        	background-position: top center; 
        	background-image: url(<?php echo($this->mosConfig_live_site);?>/components/com_joomlawatch/icons/tab-on.gif);
        	background-repeat: no-repeat;
        	width:100px;
        }
              .tab_inactive { 
        	background-position: top center; 
        	background-image: url(<?php echo($this->mosConfig_live_site);?>/components/com_joomlawatch/icons/tab-off.gif);
        	background-repeat: no-repeat;
        	width:100px;
        }
              .tab_none { 
        	background-position: bottom center; 
        	background-image: url(<?php echo($this->mosConfig_live_site);?>/components/com_joomlawatch/icons/tab-none.gif);
        	background-repeat: repeat-x;
        }
        
</style>
        
<script src='<?php echo($this->mosConfig_live_site);?>/components/com_joomlawatch/js/fade.js'></script>

<span id='status'></span>



<script type="text/javascript" language="JavaScript">


var last=null;
var http=null;
var day = 0;
var week = 0;
var expanded = new Array();
var statsType = "0";
var rand='<?php echo AdminJoomlaWatchHTML :: getRand(); ?>';

function setDay(_day) {
 day = _day;
 document.getElementById(_day).innerHTML = "loading... please wait";	
 sendStatsReq();
}
function setStatsType(_statsType) {
 statsType = _statsType;
 document.getElementById(_statsType).innerHTML = "loading...";	
 sendStatsReq();
}
function setWeek(_week) {
 week = _week;
 document.getElementById("visits_" + _week).innerHTML = "loading... please wait";	
 sendStatsReq();
}

function createRequestObject() {
    var ro;
    if(window.ActiveXObject){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}

function sendVisitsReq() {
try {
    http = createRequestObject();
    http.onreadystatechange = needVisitsRefresh;
    var newdate = new Date();	
    var url = "<?php echo($this->mosConfig_live_site);?>/components/com_joomlawatch/visits.php?rand=" + rand + "&timeID="+newdate.getTime();
    http.open("GET", url, true);
    http.send(null);
}
catch (err) { 
try {
if ((window.ActiveXObject && err.message.substring(0,17) == "Permission denied") || (!window.ActiveXObject  && err.substring(0,17) == "Permission denied"))
alert("AJAX permission denied: Please view this statistics from domain you specified in configuration.php of joomla - <?php echo($this->mosConfig_live_site);?>. Maybe you just forgotten www. in front of your domain name. Your javascript is trying to access <?php echo($this->mosConfig_live_site);?> from <?php echo(str_replace("www.","",$this->mosConfig_live_site));?> what makes it to think it's a different domain.");
} catch(err2) {
}
}

}

function sendStatsReq() {
try {
    http2 = createRequestObject();
    http2.onreadystatechange = needStatsRefresh;
    var newdate = new Date();	
    var url = "<?php echo($this->mosConfig_live_site);?>/components/com_joomlawatch/stats.php?rand=" + rand + "&timeID="+newdate.getTime();
    if (day != 0) url += "&day="+day;
    if (week != 0) url += "&week="+week;
    if (expand["countries"]) url += "&countries=true";
    if (expand["browser"]) url += "&browser=true";
    if (expand["os"]) url += "&os=true";
    if (expand["uri"]) url += "&uri=true";
    if (expand["ip"]) url += "&ip=true";

    if (expand["all_countries"]) url += "&all_countries=true";
    if (expand["all_browser"]) url += "&all_browser=true";
    if (expand["all_os"]) url += "&all_os=true";
    if (expand["all_uri"]) url += "&all_uri=true";
    if (expand["all_ip"]) url += "&all_ip=true";
    
    url += "&tab="+statsType;
    
    http2.open("GET", url, true);
    http2.send(null);
}
catch (err) {
}
}


function blockIpToggle(_ip) {
try {
	if (confirm("Really toggle blocking of " + _ip + " ?")) {	
    http3 = createRequestObject();
    http3.onreadystatechange = needStatsRefresh;
    var newdate = new Date();	
    var url3 = "<?php echo($this->mosConfig_live_site);?>/components/com_joomlawatch/block.php?ip="+ _ip +"&rand=" + rand + "&timeID="+newdate.getTime();
    http3.open("GET", url3, true);
    http3.send(null);
	sendStatsReq();
	sendVisitsReq();
	}
}
catch (err) {
}
}

function blockIpManually() {
try {
	var ipManual = prompt("Enter IP an address you want to block. \n(eg. 217.242.11.54 or 217.* or 217.242.* to block all IPs matching the wildcard)","");
	if (ipManual) blockIpToggle(ipManual);
	}
catch (err) {
}
}

function expand(_element) {
	if (!expand[_element]) expand[_element] = true;
		else expand[_element] = false;
	document.getElementById(_element).innerHTML = "loading... please wait";	
	sendStatsReq();
}

function needVisitsRefresh()
{
try {
  if (http.readyState == 4) 
  {
     if(http.status == 200)
     {
         document.getElementById("visits").innerHTML = http.responseText;
         
         
         number = "";
         for (i=0 ; i<11; i++ ) {		
         if (http.responseText.charAt(i) == '\n') break;
         if (http.responseText.charAt(i) == '\r') break;
         if (http.responseText.charAt(i) == ' ') break;
         
         number = number + http.responseText.charAt(i);
         }
         
         number = number.replace(/(<([^>]+)>)/ig,"");	
         parsedNumber = parseInt(number);
         
         if (last != parsedNumber) {
         	   last = parsedNumber;
         	fade("id" + last);
         }
     }

	  window.setTimeout("sendVisitsReq()",<?php echo(JoomlaWatch :: getConfigValue('JOOMLAWATCH_UPDATE_TIME_VISITS'));?>);
  }
} catch (err) {
}
}

function needStatsRefresh()
{
try {
  if (http2.readyState == 4) 
  {
     if(http2.status == 200)
     {
         document.getElementById("stats").innerHTML = http2.responseText;
     }
	if(statsType != "2")  window.setTimeout("sendStatsReq()",<?php echo(JoomlaWatch :: getConfigValue('JOOMLAWATCH_UPDATE_TIME_STATS'));?>);
  }
} catch (err) {
}
}

</script>

<script>sendVisitsReq(); sendStatsReq();</script>

	
	<center>
    <table border='0' cellpadding='2' width='100%'>
    <tr>
    <td id="visits" valign='top' align='left' width='80%'>
    Loading visits...
    </td>
    <td id="stats" valign='top'  align='left'>
    Loading stats..
    </td>
	</tr>    
	</table>    
	</center>
 <?php


	}

	function renderSettings($result = "") {
?>
		<div align='left'>
		<a href='<?php echo($this->mosConfig_live_site);?>/administrator/index2.php?option=com_joomlawatch'>&lt;&lt; Back</a>
		</div>
		
		<center>
		<form action='<?php echo($this->mosConfig_live_site);?>/administrator/index2.php?option=com_joomlawatch&task=settingsSave' method='POST'>
		<table>
		<?php 		if (@$result) echo("<tr><td colspan='3'><span style='color: green;'>Settings were saved</span></td></tr>"); ?>
		
		<tr><td colspan='3' align='left'><h3>Appearance</h3></td></tr>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_TRUNCATE_VISITS', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_TRUNCATE_STATS', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_LIMIT_BOTS', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_LIMIT_VISITORS', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_BLANK_ICON', $color); ?>

		<tr><td colspan='3' align='left'><h3>History & performance</h3></td></tr>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_UPDATE_TIME_VISITS', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_UPDATE_TIME_STATS', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_STATS_MAX_ROWS', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_STATS_IP_HITS', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_MAXID_BOTS', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_MAXID_VISITORS', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_STATS_KEEP_DAYS', $color); ?>

		<tr><td colspan='3' align='left'><h3>Advanced</h3></td></tr>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_WEEK_OFFSET', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_DAY_OFFSET', $color); ?>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_SERVER_URI_KEY', $color); ?>

		<tr><td colspan='3' align='left'><h3>Blocking</h3></td></tr>
		<?php echo JoomlaWatchHTML :: renderInputText('JOOMLAWATCH_BLOCKING_MESSAGE', $color); ?>
		
		<tr><td colspan='4' align='left'>
		<br/>
		<input type='submit' name='submit' value='Save'/>
		</td>
		</tr>
		</table>
		</form>
		</center>
		
		<?php


	}

}
?>