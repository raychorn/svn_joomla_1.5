<?php
/*
Page:           db.php
Created:        Aug 2006
Last Mod:       Mar 18 2007
This page handles the database update if the user
does NOT have Javascript enabled.	
--------------------------------------------------------- 
ryan masuga, masugadesign.com
ryan@masugadesign.com 
Licensed under a Creative Commons Attribution 3.0 License.
http://creativecommons.org/licenses/by/3.0/
See readme.txt for full credit details.
--------------------------------------------------------- 
Modified by Bernard Gilly for AlphaContent on 30 Jan 2008
www.visualclinic.fr
contact@visualclinic.fr
Last revision : 22 Feb 2008 for AlphaContent version 3.0.3
*/

if(!defined("_VALID_MOS")) {
   DEFINE( "_VALID_MOS", 1 );
}
if(!defined("_JEXEC")) {
   DEFINE( "_JEXEC", 1 );
}

//header("Cache-Control: no-cache");
//header("Pragma: nocache");

$joomlaversion15 = "0";
$path = str_replace("//components/com_alphacontent/alphacontent.db.php", "", getenv("SCRIPT_FILENAME") );
$path = str_replace("/components/com_alphacontent/alphacontent.db.php", "", getenv("SCRIPT_FILENAME") );

require_once( $path . "/configuration.php" );

if( class_exists( "JConfig" ) ) {
	$config = new JConfig();
	$joomlaversion15 = "1";
	$rating_conn = mysql_connect($config->host, $config->user, $config->password) or die  ('Error connecting to mysql');
	mysql_select_db($config->db, $rating_conn);
	$mosConfig_absolute_path = $path;
	//$mosConfig_lang ="aaaaaa";
	$dbprefix = $config->dbprefix;
} else {	
	require( '../../globals.php' );
	require_once( '../../includes/joomla.php' );
	global $database, $mosConfig_lang;
	$joomlaversion15 = "0";
}

//getting the values
$vote_sent      = preg_replace("/[^0-9]/","",$_REQUEST['j']);
$id_sent        = preg_replace("/[^0-9a-zA-Z]/","",$_REQUEST['q']);
$ip_num         = preg_replace("/[^0-9\.]/","",$_REQUEST['t']);
$units          = preg_replace("/[^0-9]/","",$_REQUEST['c']);
$component      = preg_replace("/[^0-9a-zA-Z_]/","",$_REQUEST['p']);
$mosConfig_lang = preg_replace("/[^0-9a-zA-Z_-]/","",$_REQUEST['lang']);
$userid         = preg_replace("/[^0-9]/","",$_REQUEST['user']);
$ip             = $_SERVER['REMOTE_ADDR'];
$referer        = $_SERVER['HTTP_REFERER'];

if (file_exists($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/".$mosConfig_lang.".php")){
	include_once($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/".$mosConfig_lang.".php");
}else{
	include_once($mosConfig_absolute_path."/administrator/components/com_alphacontent/languages/english.php");
}

if ($vote_sent > $units) die("Sorry, vote appears to be invalid."); // kill the script because normal users will never see this.
if ( !$joomlaversion15 ){
	$query = "SELECT total_votes, total_value, used_ips, component FROM #__alphacontent_rating WHERE id='".$id_sent."' AND component='".$component."'";
	$database->setQuery( $query );	
	$numbers = $database->loadObjectList();
	$checkIP = unserialize($numbers[0]->used_ips);
	$count = $numbers[0]->total_votes; //how many votes total
	$current_rating = $numbers[0]->total_value; //total number of rating added together and stored
} else {
	$query = mysql_query("SELECT total_votes, total_value, used_ips, component FROM ".$dbprefix."alphacontent_rating WHERE id='".$id_sent."' AND component='".$component."'")or die(" Error: ".mysql_error());
	$numbers = mysql_fetch_assoc($query);
	$checkIP = unserialize($numbers['used_ips']);
	$count = $numbers['total_votes']; //how many votes total
	$current_rating = $numbers['total_value']; //total number of rating added together and stored
}

$sum = $vote_sent+$current_rating; // add together the current vote value and the total vote value
$tense = ($count==1) ? _AJAX_ALPHACONTENT_VOTE : _AJAX_ALPHACONTENT_VOTES; //plural form votes/vote

// checking to see if the first vote has been tallied
// or increment the current number of votes
($sum==0 ? $added=0 : $added=$count+1);

// if it is an array i.e. already has entries the push in another value
$useridstring = "uid" . $userid . ";";
((is_array($checkIP)) ? array_push($checkIP,$ip_num,$useridstring) : $checkIP=array($ip_num,$useridstring));
$insertip=serialize($checkIP);

$user_registered = ( $userid > 0 )? " OR used_ips LIKE '%uid".$userid.";%'" : "" ;

if ( !$joomlaversion15 ) {
	//IP check when voting
	$query = "SELECT used_ips FROM #__alphacontent_rating WHERE ( used_ips LIKE '%".$ip."%'".$user_registered." ) AND id='".$id_sent."' AND component='".$component."'";
	$database->setQuery( $query );	
	$voted = $database->loadResult();
} else {
	//IP check when voting
	$voted=mysql_num_rows(mysql_query("SELECT used_ips FROM ".$dbprefix."alphacontent_rating WHERE ( used_ips LIKE '%".$ip."%'".$user_registered." ) AND id='".$id_sent."' AND component='".$component."'"));
}

if(!$voted) {     //if the user hasn't yet voted, then vote normally...
	if (($vote_sent >= 1 && $vote_sent <= $units) && ($ip == $ip_num)) { // keep votes within range
		if ( !$joomlaversion15 ) {
			$database->setQuery("UPDATE #__alphacontent_rating SET total_votes='".$added."', total_value='".$sum."', used_ips='".$insertip."', component='".$component."' WHERE id='".$id_sent."' AND component='".$component."'");
			$database->query();
		} else {
			$update = "UPDATE ".$dbprefix."alphacontent_rating SET total_votes='".$added."', total_value='".$sum."', used_ips='".$insertip."', component='".$component."' WHERE id='".$id_sent."' AND component='".$component."'";
			$result = mysql_query($update);		
		}
	} 
} //end for the "if(!$voted)"

if ( $joomlaversion15 ) {
	@mysql_close($rating_conn);
}

header("Location: $referer"); // go back to the page we came from 
exit;
?>