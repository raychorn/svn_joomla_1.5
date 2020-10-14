<?php
/**
* JoomlaWatch - A real-time ajax joomla monitor and live stats
* @version 1.2.x
* @package JoomlaWatch
* @license http://www.gnu.org/licenses/gpl-3.0.txt 	GNU General Public License v3
* @copyright (C) 2007 by Matej Koval - All rights reserved! 
* @website http://www.codegravity.com
**/

/* This is the main file with basic settings */

define('JOOMLAWATCH_DEBUG', 0);
define('JOOMLAWATCH_STATS_MAX_ROWS','20'); 	define('DESC_JOOMLAWATCH_STATS_MAX_ROWS',"Max rows to show when stats are in expanded mode.");
define('JOOMLAWATCH_STATS_IP_HITS','20'); 	define('DESC_JOOMLAWATCH_STATS_IP_HITS',"All IP addresses that have less hits in previous days than this value will be deleted from IP history.");
 
define('JOOMLAWATCH_VERSION', "1.2.4");
define('JOOMLAWATCH_UPDATE_TIME_VISITS',"2000");	define('DESC_JOOMLAWATCH_UPDATE_TIME_VISITS',"Visitors refresh time in miliseconds, default is 2000, be careful with this. Then reload the JoomlaWatch back-end.");
define('JOOMLAWATCH_UPDATE_TIME_STATS',"4000"); 	define('DESC_JOOMLAWATCH_UPDATE_TIME_STATS',"Stats refresh time in miliseconds, default is 4000, be careful with this. Then reload the JoomlaWatch back-end.");

define('JOOMLAWATCH_MAXID_BOTS',40); 			define('DESC_JOOMLAWATCH_MAXID_BOTS',"How many bot visits to keep in a database.");
define('JOOMLAWATCH_MAXID_VISITORS',40); 		define('DESC_JOOMLAWATCH_MAXID_VISITORS',"How many real visits to keep in a database.");

define('JOOMLAWATCH_LIMIT_BOTS',5); 			define('DESC_JOOMLAWATCH_LIMIT_BOTS',"How many bots you'll see in back-end.");
define('JOOMLAWATCH_LIMIT_VISITORS',10); 		define('DESC_JOOMLAWATCH_LIMIT_VISITORS',"How many real visitors you'll see in back-end."); 


define('JOOMLAWATCH_TRUNCATE_VISITS',40); 		define('DESC_JOOMLAWATCH_TRUNCATE_VISITS',"Maximum characters to be shown in long titles and uris.");
define('JOOMLAWATCH_TRUNCATE_STATS',20); 		define('DESC_JOOMLAWATCH_TRUNCATE_STATS',"Maximum characters to be shown in right statistics panel.");

define('JOOMLAWATCH_STATS_KEEP_DAYS',365);		define('DESC_JOOMLAWATCH_STATS_KEEP_DAYS',"Days to keep statistics in database, 0 = infinite.");

define('JOOMLAWATCH_WEEK_OFFSET', -0.56547619 ); define('DESC_JOOMLAWATCH_WEEK_OFFSET',"Week offset, the timestamp/(3600*24*7) gives the week number from 1.1.1970, this offset is a correction to make it start with monday ");

define('JOOMLAWATCH_DAY_OFFSET', 0.0416667 );		define('DESC_JOOMLAWATCH_DAY_OFFSET',"Day offset, the timestamp/(3600*24) gives the day number from 1.1.1970, this offset is a correction to make it start at 00:00 ");

define('JOOMLAWATCH_BLANK_ICON', 0);			define('DESC_JOOMLAWATCH_BLANK_ICON',"To use a blank 1x1px icon in front-end, set to 1");

define('JOOMLAWATCH_SERVER_URI_KEY', 'REDIRECT_URL');	define('DESC_JOOMLAWATCH_SERVER_URI_KEY',"Default is 'REDIRECT_URL', which is standard if you use url rewriting, can be set to 'SCRIPT_URL' if it logs only index.php"); 

define('JOOMLAWATCH_BLOCKING_MESSAGE','Your IP address was blocked by webmaster using JoomlaWatch'); 	define('DESC_JOOMLAWATCH_BLOCKING_MESSAGE',"Message that's shown to blocked user or further information why you are blocking these users.");
							
?>