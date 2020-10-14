<?php

include_once "accesscontrol.php";

$q1 = "select * from job_seeker_info";
$r1 = mysql_query($q1) or die(mysql_error());

while($a1 = mysql_fetch_array($r1))
{
	echo "$a1[0] $a1[1] $a1[2] $a1[careerlevel] <br>";
}

?>