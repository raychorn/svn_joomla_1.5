<?

include_once "accesscontrol.php";
include_once "navigation2.htm";

$q1 = "select * from job_story order by story_id";
$r1 = mysql_query($q1) or die(mysql_error());

if(mysql_num_rows($r1) > '0')
{
echo "<table align=center width=400><tr><td>";
while($a1 = mysql_fetch_array($r1))
{
echo "	<table align=center width=400 border=0 style=\"border:1px Solid #e0e7e9;\"  cellspacing=0 bordercolor=black>
	<tr>
	<td>Story ID# $a1[story_id] </td>
	<td><a class=TN href=EditStory.php?story_id=$a1[story_id]>Edit </a> this story </td>
	<td><a class=TN href=DeleteStory.php?story_id=$a1[story_id]> Delete </a> this story </td>
	</tr>
	
	<tr>
	<td colspan=3>$a1[story] </td>
	</tr>
	</table>
	<br>";
}

//echo "</td></tr></table><br><br>";
}
else
{
	echo "<br><br><br><center> There are not approved success stories, yet.</center><br><br>";
}

$q2 = "select * from job_story_waiting order by WS_id";
$r2 = mysql_query($q2) or die(mysql_error());

if(mysql_num_rows($r2) > '0')
{
echo "<table align=center width=400><caption align=center><b> Stories, waiting for approval.</b></caption><tr><td>";
while($a2 = mysql_fetch_array($r2))
{
echo "	<table align=center width=400 border=0 style=\"border:1px Solid #e0e7e9;\"  cellspacing=0 bordercolor=black>
	<tr>
	<td>Waiting Story ID# $a2[WS_id] </td>
	<td><a class=TN href=EditWStory.php?story_id=$a2[WS_id]>Edit </a> this story </td>
	<td><a class=TN href=DeleteWStory.php?story_id=$a2[WS_id]> Delete </a> this story </td>
	<td><a class=TN href=ApprovalWStory.php?story_id=$a2[WS_id]> Approve </a> this story </td>
	</tr>
	
	<tr>
	<td colspan=4>$a2[story] </td>
	</tr>
	</table>
	<br>";
}

echo "</td></tr></table>";
}
else
{
	echo "<br><center> There are no success stories, waiting to be approved.</center>";
}
echo "</td></tr></table><br>";
?>
<? include_once('../foother.html'); ?>