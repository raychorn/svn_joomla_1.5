<?
include "accesscontrol.php";
include_once "navigation2.htm";


$job_id=$_GET[job_id];

$q1 = "delete from job_post where job_id = '$job_id'";
$r1 = mysql_query($q1) or die(mysql_error());

$q2 = "delete from job_aplicants where job_id ='$job_id'";
$r2 = mysql_query($q2) or die(mysql_error());

echo "<table width=446><tr><td><br><br><br><center> All the information about Job Offer# $job_id was deleted successfully.</center></td></tr></table>";
?>
<? include_once('../foother.html'); ?>