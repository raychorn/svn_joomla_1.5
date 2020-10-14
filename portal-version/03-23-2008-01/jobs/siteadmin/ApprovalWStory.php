<?

include_once "accesscontrol.php";
include_once "navigation2.htm";


$q1 = "select * from job_story_waiting where WS_id = \"$_GET[story_id]\"";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

$q2 = "select count(*) from job_story";
$r2 = mysql_query($q2) or die(mysql_error());
$a2 = mysql_fetch_array($r2);

$NewID = $a2[0] + 1;
$NewStory = addslashes($a1[story]);

$q3 = "insert into job_story set story_id = \"$NewID\", story = \"$NewStory\"";
$r3 = mysql_query($q3) or die(mysql_error());

$q4 = "delete from job_story_waiting where WS_id = \"$_GET[story_id]\" ";
$r4 = mysql_query($q4) or die(mysql_error());

$q5 = "select * from job_story_waiting order by WS_id";
$r5 = mysql_query($q5) or die(mysql_error());

while($a5 = mysql_fetch_array($r5))
{
	$i = $i + 1;
	$add = addslashes($a5[story]);
	$q6 = "update job_story_waiting set WS_id = \"$i\" where  story = \"$add\" ";
	$r6 = mysql_query($q6) or die(mysql_error());
}

echo "<br><center> The approval was successfull.</center><br>";

include_once("stories.php");
?>
<? include_once('../foother.html'); ?>