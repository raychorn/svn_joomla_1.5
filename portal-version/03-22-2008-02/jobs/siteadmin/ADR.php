<?
include "accesscontrol.php";
include_once "navigation2.htm";

$q1 = "delete from job_careerlevel where uname = \"$uname\" ";
$r1 = mysql_query($q1) or die(mysql_error());

$q2 = "delete from job_education where uname = \"$uname\" ";
$r2 = mysql_query($q2) or die(mysql_error());

$q3 = "delete from job_work_experience where uname = \"$uname\" ";
$r3 = mysql_query($q3) or die(mysql_error());

$q4 = "delete from job_skills where uname = \"$uname\" ";
$r4 = mysql_query($q4) or die(mysql_error());

$q5 = "update job_seeker_info set rTitle=\"\", rPar = \"\" where uname = \"$uname\" ";
$r5 = mysql_query($q5) or die(mysql_error());

?>
<table width="446"><tr><td>
<center>
<br><br><br>
The <?=$uname?>'s resume was deleted successfully. 
</center></td></tr></table>
<? include_once('../foother.html'); ?>