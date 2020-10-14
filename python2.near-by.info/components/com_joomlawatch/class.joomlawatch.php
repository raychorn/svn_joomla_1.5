<?php


/**
* JoomlaWatch - A real-time ajax joomla monitor and live stats
* @version 1.2.0
* @package JoomlaWatch
* @license http://www.gnu.org/licenses/gpl-3.0.txt 	GNU General Public License v3
* @copyright (C) 2007 by Matej Koval - All rights reserved! 
* @website http://www.codegravity.com
**/

if (JOOMLAWATCH_DEBUG)
	error_reporting(E_ALL);
else
	error_reporting(0);

error_reporting(E_ALL);

class JoomlaWatch {

	var $database;

	function JoomlaWatch() {
		global $database;
		if (!JOOMLAWATCH_JOOMLA_15) // if Joomla 1.0
			$this->database = $database;
		else
			$this->database = & JFactory :: getDBO();

	}

	function checkPermissions() {
		$rand = $this->getRand();
		if ($rand == @ $_GET['rand'])
			return true;
		else
			return false;

	}

	function getRand() {
		$query = "select value from #__joomlawatch_config where name = 'rand' order by id desc limit 1; ";
		$this->database->setQuery($query);
		$rows = $this->database->loadObjectList();
		$row = @ $rows[0];
		$rand = @ $row->value;

		return $rand;

	}

	function getLastVisitId() {
		$query = "select id from #__joomlawatch_uri order by id desc limit 1";
		$this->database->setQuery($query);
		$rows = $this->database->loadObjectList();
		$row = @ $rows[0];

		$last = @ $row->id;

		return $last;
	}

	function deleteOldVisits() {
		$query = "select id as maxid from #__joomlawatch where browser is not NULL order by id desc limit 1";
		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();
		$row = @ $rows[0];
		$maxidvisitors = @ $row->maxid - JoomlaWatch :: getConfigValue('JOOMLAWATCH_MAXID_VISITORS');

		$query = "delete from #__joomlawatch where (browser is not NULL and id < $maxidvisitors) ";
		$this->database->setQuery($query);
		$this->database->query();

		$query = "delete from #__joomlawatch_uri where fk < '$maxidvisitors' ";
		$this->database->setQuery($query);
		$this->database->query();

		$maxidbots = @ $row->maxid - JoomlaWatch :: getConfigValue('JOOMLAWATCH_MAXID_BOTS');

		$query = "select id from #__joomlawatch where (id < $maxidbots and browser is NULL) order by id desc";
		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();

		foreach ($rows as $row) {

			$query = "delete from #__joomlawatch where id = '$row->id' ";
			$this->database->setQuery($query);
			$this->database->query();

			$query = "delete from #__joomlawatch_uri where fk = '$row->id' ";
			$this->database->setQuery($query);
			$this->database->query();

		}

		if (JoomlaWatch :: getConfigValue('JOOMLAWATCH_STATS_KEEP_DAYS') != 0) { // 0 = infinite
			$today = (time() / 3600 / 24 + JoomlaWatch :: getConfigValue('JOOMLAWATCH_DAY_OFFSET'));
			$daysToKeep = $today -JoomlaWatch :: getConfigValue('JOOMLAWATCH_STATS_KEEP_DAYS');

			$query = "delete from #__joomlawatch_info where date < '$daysToKeep' ";
			$this->database->setQuery($query);
			$this->database->query();
		}

		//delete all IP records that are less than 1%
		$value = JoomlaWatch :: getConfigValue('JOOMLAWATCH_STATS_IP_HITS');
		$query = "DELETE FROM `#__joomlawatch_info` where (`group` = 'ip' and date < '$today' and value < '$value')";
		$this->database->setQuery($query);
		$this->database->query();

	}

	function getURI() {
		$redirURI = @ $_SERVER[JoomlaWatch :: getConfigValue('JOOMLAWATCH_SERVER_URI_KEY')];
		$uri = @ $_SERVER['REQUEST_URI'];

		if (@ $redirURI && @ substr($redirURI, -9, 9) != "index.php")
			$uri = $redirURI;

		return $uri;
	}

	function insertVisit() {
		global $mainframe;

		if (time() % JoomlaWatch :: getConfigValue('JOOMLAWATCH_MAXID_BOTS') == 0) {
			$this->deleteOldVisits();
		}

		$uri = $this->getURI();

		$ip = @ $_SERVER['REMOTE_ADDR'];
		$time = time();

		$count = $this->getBlockedIp($ip);
		if (@ $count) {
			$this->increaseHitsForBlockedIp($ip);
			die(JoomlaWatch :: getConfigValue('JOOMLAWATCH_BLOCKING_MESSAGE'));
		}

		$query = "select id from #__joomlawatch where ip = '$ip' limit 1";
		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();
		$row = @ $rows[0];
		$id = @ $row->id;

		$title = $mainframe->getPageTitle();
		if (!@ $id) {

			$query = "insert into #__joomlawatch (id, ip, country, browser) values ('', '$ip',  NULL, NULL) ";
			$this->database->setQuery($query);
			$this->database->query();

			$query = "select id from #__joomlawatch where ip = '$ip' limit 1";
			$this->database->setQuery($query);
			$rows = @ $this->database->loadObjectList();
			$row = @ $rows[0];
			$id = @ $row->id;

			$query = "insert into #__joomlawatch_uri (id, fk, timestamp, uri, title) values ('', '$id', '$time', '$uri', '$title') ";
			$this->database->setQuery($query);
			$this->database->query();
		} else {

			$query = "insert into #__joomlawatch_uri (id, fk, timestamp, uri, title) values ('', '$id', '$time', '$uri', '$title') ";
			$this->database->setQuery($query);
			$this->database->query();

		}

		$this->increaseKeyValueInGroup("ip", $ip); //add ip watching

		$this->increaseKeyValueInGroup("hits", "hits");

	}

	function updateVisitByBrowser($uri) {
		$ip = $_SERVER['REMOTE_ADDR'];
		$userAgent = @ $_SERVER['HTTP_USER_AGENT'];

		$this->updateBrowserStats($ip, $userAgent);

		$query = "select #__joomlawatch_uri.uri from #__joomlawatch left join #__joomlawatch_uri on #__joomlawatch.id = #__joomlawatch_uri.fk  where (#__joomlawatch.ip = '$ip' and #__joomlawatch.browser is not null) order by #__joomlawatch_uri.timestamp desc limit 1";
		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();
		$row = @ $rows[0];
		$uri = @ $row->uri;

		$this->increaseKeyValueInGroup("uri", $uri);
		$this->increaseKeyValueInGroup("loads", "loads");

	}

	function increaseKeyValueInGroup($name, $key) {
		if (!@ $key)
			return;

		$date = floor(time() / 3600 / 24 + JoomlaWatch :: getConfigValue('JOOMLAWATCH_DAY_OFFSET'));

		$query = "select id,value from #__joomlawatch_info where (`group` = '$name' and name = '$key' and date = '$date') ";
		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();
		$row = @ $rows[0];
		$count = @ $row->value;

		if (@ $count) {
			$count++;
			$query = "update #__joomlawatch_info set value = '$count' where (`group` = '$name' and name = '$key' and date = '$date') ";
			$this->database->setQuery($query);
			$this->database->query();
		} else {

			$query = "insert into #__joomlawatch_info (id, `group`, date, name, value) values ('', '$name', '$date', '$key', 1)";
			$this->database->setQuery($query);
			$this->database->query();

		}
	}

	function getMaxValueInGroupForWeek($name, $key, $dateWeekStart) {
		if (!@ $key)
			return;
		$dateWeekEnd = $dateWeekStart +7;

		$query = "select max(value) as value from #__joomlawatch_info where (`group` = '$name' and name = '$key' and `date` >= '$dateWeekStart' and `date` <= '$dateWeekEnd') ";
		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();
		$row = @ $rows[0];
		$value = @ $row->value;

		return $value;
	}

	function getKeyValueInGroupByDate($name, $key, $date) {
		if (!@ $key)
			return;

		$query = "select id,value from #__joomlawatch_info where (`group` = '$name' and name = '$key' and date = '$date') ";
		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();
		$row = @ $rows[0];
		$value = @ $row->value;

		return $value;
	}

	function getCountByKeyAndDate($key, $date) {
		$query = "select sum(value) as value from #__joomlawatch_info where (`group` = '$key' and date = '$date') order by id desc limit 1";
		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();
		$row = @ $rows[0];
		$count = @ $row->value;

		return @ $count;
	}

	function getTotalCountByKey($key) {
		$query = " SELECT sum( value ) AS value FROM #__joomlawatch_info WHERE `group` = '$key' LIMIT 1 ";
		$this->database->setQuery($query);
		//echo ($this->database->getQuery());
		$rows = @ $this->database->loadObjectList();
		$row = @ $rows[0];
		$count = @ $row->value;

		return @ $count;
	}

	function updateHelperCountByKey($key, $value) {
		$count = $this->getCountByKey($key);

		if (@ $count) {
			$query = "update #__joomlawatch_config set value = '$value' where (name = '$key' and date = '$date')";
			$this->database->setQuery($query);
			$this->database->query();
		} else {
			$query = "insert into #__joomlawatch_config values ('', '$key', '$value')";
			$this->database->setQuery($query);
			$this->database->query();
		}
	}

	function updateBrowserStats($ip, $userAgent) {
		$query = "select id,browser from #__joomlawatch where ip = '$ip' order by id asc limit 1";
		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();
		$row = @ $rows[0];
		if (@ $row->browser == '')
			$firstTime = true;

		$country = $this->countryByIp($ip);

		$query = "select browser,country from #__joomlawatch where ip = '$ip' order by browser desc limit 1";
		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();
		$row = @ $rows[0];

		//check if first time visit

		if (@ !$row->browser) {
			$this->increaseKeyValueInGroup("unique", "unique");

			$query = "update #__joomlawatch set browser = '$userAgent' where ip = '$ip'";
			$this->database->setQuery($query);
			$this->database->query();

			$browser = $this->identifyBrowser(@ $userAgent);
			$this->increaseKeyValueInGroup("browser", $browser);

			$os = $this->identifyOs(@ $userAgent);
			$this->increaseKeyValueInGroup("os", $os);

			$this->increaseKeyValueInGroup("country", $country);

		}

	}

	function countryByIp($ip) {
		if ($ip == '127.0.0.1')
			return;

		$query3 = "select ip, country from #__joomlawatch where (ip = '$ip' and country is not NULL) limit 1";
		$this->database->setQuery($query3);
		$this->database->query();
		$rows3 = $this->database->loadObjectList();
		$row3 = @ $rows3[0];

		if (@ !$row3->country) {

			$iplook = new ip2country($ip);
			$iplook->UseDB = true;
			$iplook->db_tablename = "#__joomlawatch_ip2c";

			if (($iplook->LookUp())) {
				$country = strtolower($iplook->Prefix1);
				$query3 = "update #__joomlawatch set country = '$country' where ip = '$ip'";
				$this->database->setQuery($query3);
				$this->database->query();
			}

		} else {
			$country = $row3->country;
		}

		return @ $country;
	}

	function truncate($str, $len = "") {
		if (@ !$len)
			$len = JoomlaWatch :: getConfigValue('JOOMLAWATCH_TRUNCATE_VISITS');

		if (strlen($str) < $len)
			return $str;
		else
			return substr($str, 0, $len) . "...";
	}

	function identifyOs($userAgent) {
		if (stristr($userAgent, "Mac"))
			$os = "Mac";
		else
			if (stristr($userAgent, "Linux"))
				$os = "Linux";
			else
				if (stristr($userAgent, "Windows 95"))
					$os = "Windows98";
				else
					if (stristr($userAgent, "Windows 98"))
						$os = "Windows98";
					else
						if (stristr($userAgent, "Windows ME"))
							$os = "Windows98";
						else
							if (stristr($userAgent, "Windows NT 4.0"))
								$os = "WindowsNT";
							else
								if (stristr($userAgent, "Windows NT 6.0"))
									$os = "WindowsVista";
								else
									if (stristr($userAgent, "Windows NT 5.1"))
										$os = "WindowsXP";
									else
										if (stristr($userAgent, "Windows"))
											$os = "Windows";

		return @ $os;
	}

	function identifyBrowser($userAgent) {
		if (stristr($userAgent, "Safari"))
			$browser = "Safari";
		else
			if (stristr($userAgent, "MSIE"))
				$browser = "Explorer";
			else
				if (stristr($userAgent, "Firefox"))
					$browser = "Firefox";
				else
					if (stristr($userAgent, "Opera"))
						$browser = "Opera";
					else
						if (stristr($userAgent, "Mozilla"))
							$browser = "Mozilla";

		return @ $browser;
	}

	function getBrowserByIp($ip) {
		if ($ip == '127.0.0.1')
			return;

		$query = "select browser from #__joomlawatch where (ip = '$ip' and browser is not NULL) order by browser desc limit 1";
		$this->database->setQuery($query);

		$this->database->query();
		$rows = $this->database->loadObjectList();
		$row = @ $rows[0];

		return @ $row->browser;
	}

	function blockIp($ip) {
		$query = "insert into #__joomlawatch_blocked values ('','$ip','')";
		$this->database->setQuery($query);
		$this->database->query();
	}
	function unblockIp($ip) {
		$query = "delete from #__joomlawatch_blocked where ip = '$ip'";
		$this->database->setQuery($query);
		$this->database->query();
	}

	function blockIpToggle($ip) {

		$count = $this->getBlockedIp($ip);

		if (!$count) {
			$this->blockIp($ip);
		} else {
			$this->unblockIp($ip);
		}

	}
	function searchBlockedIp($ip) {
		$query = "select count(ip) as count from #__joomlawatch_blocked where ip = '$ip' limit 1"; //starting % ommited 
		$this->database->setQuery($query);
		$this->database->query();
		$rows = $this->database->loadObjectList();
		$count = @ $rows[0]->count;

		return $count;
	}
	function searchBlockedIpWildcard($term) {
		$query = "select count(ip) as count from #__joomlawatch_blocked where ip like '$term%' limit 1"; //starting % ommited 
		$this->database->setQuery($query);
		$this->database->query();
		$rows = $this->database->loadObjectList();
		$count = @ $rows[0]->count;

		return $count;
	}

	function getBlockedIp($ip) {

		$ipExploded = explode('.', $ip);

		if (JoomlaWatch :: searchBlockedIp($ip)) {
			return $ip;
		} else {
			$ip = $ipExploded[0] . "." . $ipExploded[1] . "." . $ipExploded[2] . ".*";
			if (JoomlaWatch :: searchBlockedIpWildcard($ip)) {
				return $ip;
			} else {
				$ip = $ipExploded[0] . "." . $ipExploded[1] . ".*";
				if (JoomlaWatch :: searchBlockedIpWildcard($ip)) {
					return $ip;
				} else {
					$ip = $ipExploded[0] . ".*";
					if (JoomlaWatch :: searchBlockedIpWildcard($ip))
						return $ip;
				}

			}

		}

		return "";

	}

	function getConfigValue($key) {

		$query = "select value from #__joomlawatch_config where name = '$key' limit 1";
		$this->database->setQuery($query);
		$this->database->query();
		$rows = $this->database->loadObjectList();
		$value = @ $rows[0]->value;

		if ($value)
			return addslashes($value);
		else
			return @ constant($key);

	}

	function saveConfigValue($key, $value) {
		$query = "select count(name) as count from #__joomlawatch_config where name = '$key' limit 1";
		$this->database->setQuery($query);
		$this->database->query();
		$rows = $this->database->loadObjectList();
		$count = @ $rows[0]->count;

		if ($count) { //update
			$query = "update #__joomlawatch_config set value = '$value' where name = '$key'";
			$this->database->setQuery($query);
			$this->database->query();
		} else { //insert
			$query = "insert into #__joomlawatch_config values ('','$key','$value')";
			$this->database->setQuery($query);
			$this->database->query();

		}

	}
	function saveSettings($post) {

		foreach ($post as $key => $value) {
			if (strstr($key, "JOOMLAWATCH")) {
				$this->saveConfigValue($key, $value);
			}
		}

		return 1;
	}

	function increaseHitsForBlockedIp($ip) {

		$ip = JoomlaWatch :: getBlockedIp($ip);
		$query = "select hits from #__joomlawatch_blocked where ip = '$ip' ";
		$this->database->setQuery($query);
		$this->database->query();
		$rows = $this->database->loadObjectList();
		$hits = @ $rows[0]->hits;

		$hits++;
		if ($hits) { //update
			$query = "update #__joomlawatch_blocked set hits = '$hits' where ip = '$ip'";
			$this->database->setQuery($query);
			$this->database->query();
		}
	}

	function countryCodeToCountryName($code) {
		$query = "select country from #__joomlawatch_ip2c where a2 = '$code' limit 1";
		$this->database->setQuery($query);
		$this->database->query();
		$rows = $this->database->loadObjectList();
		$countryName = @ $rows[0]->country;
		return $countryName;
	}

}
?>