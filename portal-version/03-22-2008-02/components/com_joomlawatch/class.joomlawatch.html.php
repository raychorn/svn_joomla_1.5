<?php

/**
* JoomlaWatch - A real-time ajax joomla monitor and live stats
* @version 1.2.x
* @package JoomlaWatch
* @license http://www.gnu.org/licenses/gpl-3.0.txt 	GNU General Public License v3
* @copyright (C) 2007 by Matej Koval - All rights reserved! 
* @website http://www.codegravity.com
**/

error_reporting(0);

class JoomlaWatchHTML {

	var $database;
	var $mosConfig_live_site;

	function JoomlaWatchHTML() {
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

	function renderIntValuesByName($name, $date = "", $expanded = false, $limit = 5) {

		if ($date == "")
			$date = floor(time() / 3600 / 24 + JoomlaWatch :: getConfigValue('JOOMLAWATCH_DAY_OFFSET'));

		if (@ $expanded == true)
			$query = "select name, value from #__joomlawatch_info where (`group` = '$name' and `date` = '$date') order by value desc limit 20";
		else
			$query = "select name, value from #__joomlawatch_info where (`group` = '$name' and `date` = '$date') order by value desc limit $limit";

		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();

		$i = 0xFF;

		$output = "";
		foreach ($rows as $row) {

			$count = JoomlaWatch :: getCountByKeyAndDate($name, $date);
			if ($count)
				$percent = floor(($row->value / $count) * 1000) / 10;
			else
				$percent = 0;

			if (@ $name == 'uri' || @ $name == 'uri_total') {
				$nameTruncated = JoomlaWatch :: truncate($row->name, JoomlaWatch :: getConfigValue('JOOMLAWATCH_TRUNCATE_STATS'));
				$row->name = "<a href='$this->mosConfig_live_site$row->name' title='$row->name'>$nameTruncated</a>";
			} else
				if (@ $row->name && ($name == 'browser' || $name == 'os' || $name == 'browser_total' || $name == 'os_total'))
					$icon = "<img src='$this->mosConfig_live_site/components/com_joomlawatch/icons/" . strtolower($row->name) . ".gif' />";
				else
					if ($name == 'country' || $name == 'country_total') {
						if ($row->name) {
							$countryName = JoomlaWatch :: countryCodeToCountryName($row->name);
							$icon = "<img src='$this->mosConfig_live_site/components/com_joomlawatch/flags/" . strtolower($row->name) . ".png' title='$countryName' alt='$countryName'/>";
						}

					}

			if ($name == 'ip') {
				if (@ $row->name) {
					if (JoomlaWatch :: getBlockedIp($row->name))
						$ip = "<s>" . $row->name . "</s>";
					else
						$ip = $row->name;
					$blocked = JoomlaWatch :: getBlockedIp($row->name);
					$country = JoomlaWatch :: countryByIp($row->name);
					$countryName = JoomlaWatch :: countryCodeToCountryName($country);
					if (!$country)
						$country = "none";
					$icon = "<img src='$this->mosConfig_live_site/components/com_joomlawatch/flags/" . strtolower($country) . ".png' title='$countryName' alt='$countryName'/>";
					$row->name = "<a  id='$row->name' href='javascript:blockIpToggle(\"$row->name\");' style='color: black;'>" . $ip . "</a>";

				}
			}

			$progressBarIcon = "$this->mosConfig_live_site/components/com_joomlawatch/icons/progress_bar.gif";

			if (@ $row->name)
				$output .= "<tr><td>" . @ $icon . "&nbsp;" . $row->name . "</td><td align='right'>" . $row->value . "</td><td> <table><tr><td><img src='$progressBarIcon' width='$percent' height='10'/></td><td>$percent%</td></tr></table></td></tr>";
		}
		if (@ $count)
			$output .= "<tr><td colspan='5'><b>Total:</b> " . @ $count . " </td></tr>";

		return $output;
	}

	function renderTotalIntValuesByName($name, $expanded = false, $limit = 5) {

		$date = floor(time() / 3600 / 24 + JoomlaWatch :: getConfigValue('JOOMLAWATCH_DAY_OFFSET'));

		$maxLimit = JoomlaWatch :: getConfigValue('JOOMLAWATCH_STATS_MAX_ROWS');

		if (@ $expanded == true)
			$query = "select name, sum(value) as value from #__joomlawatch_info where (`group` = '$name') group by name order by value desc limit $maxLimit";
		else
			$query = "select name, sum(value) as value from #__joomlawatch_info where (`group` = '$name') group by name order by value desc limit $limit";

		$this->database->setQuery($query);
		$rows = @ $this->database->loadObjectList();

		$i = 0xFF;

		$output = "";
		$count = JoomlaWatch :: getTotalCountByKey($name);

		foreach ($rows as $row) {
			$i -= 3;
			$color = sprintf("%x", $i) . sprintf("%x", $i) . sprintf("%x", $i);

			if ($count)
				$percent = floor(($row->value / $count) * 1000) / 10;
			else
				$percent = 0;

			if (@ $name == 'uri' || @ $name == 'uri_total') {
				$nameTruncated = JoomlaWatch :: truncate($row->name, JoomlaWatch :: getConfigValue('JOOMLAWATCH_TRUNCATE_STATS'));
				$row->name = "<a href='$this->mosConfig_live_site$row->name' title='$row->name'>$nameTruncated</a>";
			} else
				if (@ $row->name && ($name == 'browser' || $name == 'os' || $name == 'browser_total' || $name == 'os_total'))
					$icon = "<img src='$this->mosConfig_live_site/components/com_joomlawatch/icons/" . strtolower($row->name) . ".gif' />";
				else
					if ($name == 'country' || $name == 'country_total') {
						if ($row->name) {
							$countryName = JoomlaWatch :: countryCodeToCountryName($row->name);
							$icon = "<img src='$this->mosConfig_live_site/components/com_joomlawatch/flags/" . strtolower($row->name) . ".png' title='$countryName' alt='$countryName'/>";
						}
					}
			if ($name == 'ip') {
				if (@ $row->name) {
					if (JoomlaWatch :: getBlockedIp($row->name))
						$ip = "<s>" . $row->name . "</s>";
					else
						$ip = $row->name;
					$blocked = JoomlaWatch :: getBlockedIp($row->name);
					$country = JoomlaWatch :: countryByIp($row->name);
					$countryName = JoomlaWatch :: countryCodeToCountryName($country);
					if (!$country)
						$country = "none";
					$icon = "<img src='$this->mosConfig_live_site/components/com_joomlawatch/flags/" . strtolower($country) . ".png' title='$countryName' alt='$countryName'/>";
					$row->name = "<a  id='$row->name' href='javascript:blockIpToggle(\"$row->name\");' style='color: black;'>" . $ip . "</a>";

				}
			}

			$progressBarIcon = "$this->mosConfig_live_site/components/com_joomlawatch/icons/progress_bar.gif";

			$color = "ffffff";
			if (@ $row->name)
				$output .= "<tr><td style='background-color: #$color;'>" . @ $icon . "&nbsp;" . $row->name . "</td><td style='background-color: #$color;' align='right'>" . $row->value . "</td><td style='background-color: #$color;'> <table><tr><td><img src='$progressBarIcon' width='$percent' height='10'/></td><td>$percent%</td></tr></table></td></tr>";
		}
		if (@ $count)
			$output .= "<tr><td colspan='5'><b>Total:</b> " . @ $count . " </td></tr>";

		return $output;
	}

	function renderVisitsGraph($week = 0) {
		$output = "";

		$today = date("d.m.Y", time());

		$dateExploded = explode('.', $today);

		$dayOfWeek = date("w", time());

		$timestamp = ($week + $dayOfWeek) * 24 * 3600 * 7;

		//	$output .= $dayOfWeek;

		$startTimestamp = $timestamp - (24 * 3600 * $dayOfWeek -1);

		$i = 0xFF;

		//	$startTimestamp = $week * 24 * 3600 * 7 - (24 * 3600 * $dayOfWeek -1);

		//		$output .= $dayOfWeek;

		$maxLoads = JoomlaWatch :: getMaxValueInGroupForWeek("loads", "loads", floor((24 * 3600 * (($week * 7) - 3)) / 3600 / 24 + JoomlaWatch :: getConfigValue('JOOMLAWATCH_DAY_OFFSET')));

		for ($sec = 24 * 3600 * (($week * 7) - 3); $sec < 24 * 3600 * (($week * 7) + 4); $sec += 24 * 3600) {
			$i -= 3;
			$color = sprintf("%x", $i) . sprintf("%x", $i) . sprintf("%x", $i);

			if ($i % 2 == 0)
				$color = "#f5f5f5";
			else
				$color = "#fafafa";

			$percent = 0;
			$count = 0;
			$date = floor($sec / 3600 / 24 + JoomlaWatch :: getConfigValue('JOOMLAWATCH_DAY_OFFSET'));

			$stats['unique'] = JoomlaWatch :: getKeyValueInGroupByDate("unique", "unique", $date);
			$stats['loads'] = JoomlaWatch :: getKeyValueInGroupByDate("loads", "loads", $date);
			$stats['hits'] = JoomlaWatch :: getKeyValueInGroupByDate("hits", "hits", $date);

			foreach ($stats as $key => $value) {

				$count = $stats['loads'];
				if ($count)
					$percent = floor(($value / $count) * 100);

				$progressBarIcon = "$this->mosConfig_live_site/components/com_joomlawatch/icons/progress_bar_$key.gif";

				$output .= "<tr><td style='background-color: $color;'>";
				$dow = date("D", $sec);
				if (@ !$once[$dow]) {
					$output .= substr(date("d.m.Y", $sec), 0, 6) . "&nbsp;" . $dow;
					$once[$dow] = 1;
				}
				$output .= "</td>";

				if ($key == "unique")
					$fontColor = "#0000FF";
				else
					if ($key == "loads")
						$fontColor = "#00C000";
					else
						if ($key == "hits")
							$fontColor = "#aaaaaa";
						else
							$fontColor = "black";
				if ($maxLoads)
					$percentWidth = $percent * $value / $maxLoads;
				else
					$percentWidth = $percent;
				if (@ $value) {
					if ($key == "hits")
						$output .= "<td align='right' style='color:$fontColor; background-color: $color;'>" . $value . "</td><td style='background-color: $color;'> <table cellpadding='0' cellspacing='0' ><tr><td style='background-color: $color;'></td><td style='color:$fontColor; background-color: $color;'>&nbsp;</td></tr></table></td>";
					else
						if ($key == "loads")
							$output .= "<td align='right' style='color:$fontColor; background-color: $color;'>" . $value . "</td><td style='background-color: $color;'> <table cellpadding='0' cellspacing='0' ><tr><td style='background-color: $color;'><img src='$progressBarIcon' width='$percentWidth' height='10' /></td><td style='color:$fontColor; background-color: $color;'></td></tr></table></td>";
						else
							$output .= "<td align='right' style='color:$fontColor; background-color: $color;'>" . $value . "</td><td style='background-color: $color;'> <table cellpadding='0' cellspacing='0' ><tr><td style='background-color: $color;'><img src='$progressBarIcon' width='$percentWidth' height='10' /></td><td style='color:$fontColor; background-color: $color;'>&nbsp;$percent%</td></tr></table></td>";
				} else
					$output .= "<td align='right' style='background-color: $color;'></td><td align='right' style='background-color: $color;'></td>";

				$output .= "</tr>";

			}

		}
		$output .= "<tr><td colspan='3' align='right'>* <span style='color:#0000FF;'>unique</span>, <span style='color:#00C000;'>loads</span>, <span style='color:#aaaaaa;'>hits</span></td></tr>";

		return $output;
	}

	function renderTable($rows, $bots = false) {

		$output = "";
		$i = 0xFF;
		foreach ($rows as $row) {
			if ($i > 0x00)
				$i -= 2;
			else
				$i = 0xFF;

			$query2 = "SELECT * FROM #__joomlawatch LEFT JOIN #__joomlawatch_uri ON #__joomlawatch.id = #__joomlawatch_uri.fk where ip = '$row->ip' ORDER BY #__joomlawatch_uri.timestamp desc";
			$this->database->setQuery($query2);
			$rows2 = $this->database->loadObjectList();
			$row2 = $rows2[0];

			$color = sprintf("%x", $i) . sprintf("%x", $i) . sprintf("%x", $i);

			if ($bots == true)
				$color = "ffffff";

			$country = $row2->country;

			if (!$country) {
				$country = JoomlaWatch :: countryByIp($row->ip);
			}

			if (@ $country) {
				$countryName = JoomlaWatch :: countryCodeToCountryName($country);
				$flag = "<img src='$this->mosConfig_live_site/components/com_joomlawatch/flags/$country.png' title='$countryName' alt='$countryName'/>";
				$countryUpper = strtoupper($country);
			}

			$userAgent = JoomlaWatch :: getBrowserByIp($row->ip);

			$browser = "";
			$os = "";
			$browserIcon = "";
			$osIcon = "";

			if (@ $userAgent) {
				$browser = JoomlaWatch :: identifyBrowser(@ $userAgent);
				if (@ $browser)
					$browserIcon = "$this->mosConfig_live_site/components/com_joomlawatch/icons/" . strtolower($browser) . ".gif";

				if (@ $browserIcon)
					$browser = "<img src='$browserIcon' alt='$userAgent' title='$userAgent' />";

				$os = JoomlaWatch :: identifyOs(@ $userAgent);

				if (@ $os)
					$osIcon = "$this->mosConfig_live_site/components/com_joomlawatch/icons/" . strtolower($os) . ".gif";

				if (@ $osIcon)
					$os = "<img src='$osIcon' alt='$userAgent' title='$userAgent'/>";
			}

			if ($bots == true && $osIcon)
				continue; // bot icon fix
			if ($bots == true) {
				$osIcon = "$this->mosConfig_live_site/components/com_joomlawatch/icons/blank.gif";
				$browserIcon = "$this->mosConfig_live_site/components/com_joomlawatch/icons/blank.gif";
				$browser = "<img src='$browserIcon' alt='$userAgent' title='$userAgent' />";
				$os = "<img src='$osIcon' alt='$userAgent' title='$userAgent'/>";
			}

			if (JoomlaWatch :: getBlockedIp($row->ip))
				$ip = "<s>" . $row->ip . "</s>";
			else
				$ip = $row->ip;
			$ip = "<a id='$row->ip' href='javascript:blockIpToggle(\"$row->ip\");' style='color:black;'>" . $ip . "</a>";
			;

			$output .= ("<tr><td valign='top' align='left' style='background-color: #$color'>" . @ $row->id . "</td> 
																																										<td valign='top' align='left' style='background-color: #$color; color: #999999;'>" . @ $countryUpper . "</td>
																																										<td valign='top' align='left'  style='background-color: #$color;'>" . @ $flag . "</td>
																																										<td valign='top' align='left'  style='background-color: #$color;' title='" . @ $row2->browser . "'>$ip</td>
																																										<td valign='top' align='left' style='background-color: #$color;'>" . @ $browser . "</td>
																																										<td valign='top' align='left' style='background-color: #$color;'>" . @ $os . "</td>
																																										<td valign='top' align='left' style='background-color: #$color;' width='100%'>");
			foreach ($rows2 as $row2) {

				$row2->timestamp = date("H:i:s", $row2->timestamp);
				$uriTruncated = JoomlaWatch :: truncate($row2->uri);
				$row2->title = JoomlaWatch :: truncate($row2->title);

				$output .= ("<div id='id$row2->id' style='background-color: #$color'>$row2->timestamp <a href='$row2->uri' target='_blank'>$row2->title</a> $uriTruncated</div>");

			}

			$output .= ("</td></tr>");
		}

		return $output;
	}

	function renderExpand($element) {
		if (@ $_GET[$element] == "false" || !@ $_GET[$element])
			$operation = "expand";
		else
			$operation = "collapse";

		$output = "<a name='$element'></a><a href=\"javascript:expand('$element')\" id='$element'><img src='$this->mosConfig_live_site/components/com_joomlawatch/icons/$operation.gif' border='0' alt='$operation'/>$operation&nbsp;$element</a>";

		return $output;
	}

	function renderVisitors() {

		$limit = 0;
		$limit = JoomlaWatch :: getConfigValue('JOOMLAWATCH_LIMIT_VISITORS');

		$query = "select ip from #__joomlawatch where (browser is not NULL and browser != '') order by id desc limit $limit";
		$this->database->setQuery($query);
		$rows = $this->database->loadObjectList();

		$output = JoomlaWatchHTML :: renderTable($rows);

		return $output;
	}

	function renderBots() {

		$limit = 0;
		$limit = JoomlaWatch :: getConfigValue('JOOMLAWATCH_LIMIT_BOTS');

		$query = "select ip from #__joomlawatch where (browser is NULL) order by id desc limit $limit";
		$this->database->setQuery($query);
		$rows = $this->database->loadObjectList();

		$output = JoomlaWatchHTML :: renderTable($rows, true);

		return $output;
	}

	function getDateByDay($day) {

		$date = date("d.m.Y", $day * 3600 * 24);
		$output = $date;
		if ($date == date("d.m.Y", time()))
			$output .= " (today)";

		return $output;
	}

	function renderSwitched($element, $text, $value) {
		$output = "";
		if ($element != $value) {
			$output .= "<a href=\"javascript:setStatsType('$element');\" id='$element'>$text</a>";
		} else
			$output .= "$text</a>";

		return $output;
	}

	function renderTabClass($name, $value) {
		if ($name == $value)
			return "tab_active";
		else
			return "tab_inactive";
	}

	function renderInputText($key, & $color) {

		if (!@ $color)
			$color = "#f7f7f7";
		else
			$color = "";

		$value = "";
		$value = JoomlaWatch :: getConfigValue($key);
		$defaultValue = @ constant($key);
		if (strcmp($value, $defaultValue))
			$changed = "<i>(Default " . $defaultValue . ")</i>&nbsp;";
		$desc = JoomlaWatch :: getConfigValue("DESC_" . $key);

		$output = "<tr><td style='background-color: $color;' align='left'>$key</td><td style='background-color: $color;'><input type='text' name='$key' value='$value' size='20' style='text-align:center;'/></td style='background-color: $color;'><td style='background-color: $color;' align='left'>" . @ $changed . " $desc</td></tr>";
		return $output;
	}

	function renderBlockedIPs() {

		$query = "select ip,hits from #__joomlawatch_blocked order by hits desc ";
		$this->database->setQuery($query);
		$rows = $this->database->loadObjectList();
		$output = "";
		if (@ $rows)
			$output .= "<tr><th>country</th><th>IP</th><th>bl.hits</th></tr>";
		if (@ $rows)
			foreach ($rows as $row) {
				$icon = "";
				$country = "";
				if (!strstr($row->ip, "*")) {
					$country = JoomlaWatch :: countryByIp($row->ip);
					$countryName = JoomlaWatch :: countryCodeToCountryName($country);
					if (!$country) $country = "none";
					$icon = "<img src='$this->mosConfig_live_site/components/com_joomlawatch/flags/" . @ strtolower($country) . ".png' title='$countryName' alt='$countryName'/>";
				}
				$output .= "<tr><td align='center'>" . $icon . "</td><td align='right'>" . $row->ip . "</td><td align='center'>" . $row->hits . "</td><td>" .
				"<a  id='$row->ip' href='javascript:blockIpToggle(\"$row->ip\");'>unblock</a>";
				"</td></tr>";

			}
		return $output;

	}


}
?>