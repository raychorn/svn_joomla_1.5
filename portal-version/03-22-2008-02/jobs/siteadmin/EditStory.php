<?

include_once "accesscontrol.php";
include_once "navigation2.htm";

if(isset($update))
{
	$qu = "update job_story set story = \"$NewStory\" where story_id = \"$story_id\" ";
	$ru = mysql_query($qu) or die(mysql_error());

echo "<br><br><br><center> The story was updated successfully. </center>";
}
else
{
$q1 = "select * from job_story where story_id = \"$story_id\"";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

?>

<form action=<?=$PHP_SELF?> method=post style="background:none;">

	<table align=center width=400  cellspacing=0>
	<tr>
	<td>Story ID# <?=$a1[story_id]?> </td>
	</tr>
	
	<tr>
	<td>
	<textarea name=NewStory cols=40 rows=10> <?=$a1[story]?> </textarea></td>
	</tr>
	
	<tr><td align=center> 
	<input type=hidden name=story_id value=<?=$a1[story_id]?>>
	<input type=submit name=update value=Update></td></tr>
	</table>
</form>
<?
}
?>
<? include_once('../foother.html'); ?>