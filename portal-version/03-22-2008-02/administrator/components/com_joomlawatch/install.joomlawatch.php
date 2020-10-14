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

@ define('_VALID_MOS', 1);

function com_install() {
	global $database, $mosConfig_absolute_path;

	@ set_time_limit(0);

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
	if (!@defined('DS')) define('DS',DIRECTORY_SEPARATOR);

	if (@ file_exists(JPATH_BASE2 . DIRECTORY_SEPARATOR . "globals.php"))
		@ define('JOOMLAWATCH_JOOMLA_15', 0);
	else
		@ define('JOOMLAWATCH_JOOMLA_15', 1);

	if (JOOMLAWATCH_JOOMLA_15) {
		require_once (JPATH_BASE2 . DS . 'includes' . DS . 'defines.php');
		require_once (JPATH_BASE2 . DS . 'includes' . DS . 'framework.php');
		$mainframe = & JFactory :: getApplication('site');
		$mainframe->initialise();
		$database = & JFactory :: getDBO();
	} else {
		// defines for Joomla 1.0
	}
?>
  <center>
  <table width="100%" border="0">
    <tr>
      <td></td>
      <td>
        <strong>JoomlaWatch </strong><br/>
        <font class="small">&copy; Copyright 2007 by Matej Koval<br/>
        This component is copyrighted software. Distribution is prohibited.</font><br/>
      </td>
    </tr>
    <tr>
      <td background="F0F0F0" colspan="2"><br />
      <code>Installation Process :<br />
        <?php

	$query = "UPDATE #__components SET admin_menu_img='../components/com_joomlawatch/icons/joomlawatch-logo-16x16.gif' WHERE admin_menu_link='option=com_joomlawatch'";
	$database->setQuery(trim($query));
	$database->query();

	$rand = rand();
	$query = "INSERT INTO #__joomlawatch_config (id, name, value) values ('', 'rand', '$rand') ";
	$database->setQuery(trim($query));
	$database->query();

	$i = 0;

	for ($j = 1; $j <= 80; $j++) {

		$fileName = JPATH_BASE2 . DS . "components" . DS . "com_joomlawatch" . DS . "sql" . DS . "joomlawatch-$j.sql";
//		echo($fileName."</br>");
		$lines = file($fileName);

		$query = "";
		//echo ("SQL import progress: <br/>");
		foreach ($lines as $line_num => $line) {

			$query .= trim($line);

			if (strstr($line, ");")) {

				if ($j % 10 == 0)
					echo ((floor((($j) / 80) * 100)) . "%");
				else
					echo (".");

				$database->setQuery(trim($query));

				//$myQuery = $database->getQuery();
				//echo("LEN:".strlen($myQuery)."<br/>");

				$result = $database->query();
				if (!$result)
					echo ("Error: " + $database->getQuery());
				flush();

				$query = "";
				$i++;
			}
		//	@ unlink($fileName); //try to delete
		}

	}

	
?>
		<br/><br/>
        <font color="green"><b>Installation finished.</b></font><br /><br />
        <br /> 
        </code>

	<iframe src ="http://www.codegravity.com/joomlawatch-notice.html" width="100%" frameborder="0">
	</iframe>


      </td>
    </tr>
  </table>
  </center>
  <?php


}
?>