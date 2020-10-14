<?
include_once "accesscontrol.php";
include_once "navigation2.htm";

$q1 = "delete from job_plan where PlanName = \"$PlanName\"";
$r1 = mysql_query($q1) or die(mysql_error());


?>
<? include_once('../foother.html'); ?>