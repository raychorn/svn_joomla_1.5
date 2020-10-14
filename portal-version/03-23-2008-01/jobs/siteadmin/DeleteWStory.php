<?

include_once "accesscontrol.php";
include_once "navigation2.htm";

$q1 = "delete from job_story_waiting where WS_id = \"$_GET[story_id]\" ";
$r1 = mysql_query($q1) or die(mysql_error());

$q2 = "select * from job_story_waiting order by WS_id";
$r2 = mysql_query($q2) or die(mysql_error());

while($a2 = mysql_fetch_array($r2))
{
	$i = $i + 1;
	$del_st = addslashes($a2[story]);

		$q4 = "update job_story_waiting set WS_id = \"$i\" where  story = \"$del_st\" ";
		$r4 = mysql_query($q4) or die(mysql_error());
	
}

?>

<br><br><br><center> The story was deleted successfully.</center>
<? include_once('../foother.html'); ?>